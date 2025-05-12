<?php

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

class UserBankManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// Bank Card  LIST -//////////

    public static function FetchBankcardlistData(array $filters = [], $page = 1, $limit = 20): array
    {

        try {

        $db = parent::openLink();
        $offset = ($page - 1) * $limit;
        $whereClause = "";
        $table_name = "user_bank";
        $params  = [":offset" => $offset,":limit" => $limit];
        foreach ($filters as $db_column => $value) {
            if(!empty($value)){
                $whereClause .= empty($whereClause) ? " {$table_name}.{$db_column}=:{$db_column} " : " AND  {$table_name}.{$db_column}=:{$db_column}" ;
                $params[":{$db_column}"]      = $value;
            }

            $whereClause = empty($whereClause) ? " " : " WHERE {$whereClause} ";
            $sql = "SELECT user_bank.*,(SELECT COUNT(*) FROM user_bank {$whereClause} ) AS total_records, users_test.username, users_test.nickname, users_test.email
            FROM user_bank
            JOIN users_test ON user_bank.uid = users_test.uid 
            {$whereClause} 
            ORDER BY bank_id DESC
            LIMIT :offset, :limit";

            $stmt = $db->query(
                $sql,
                $params
            );

            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success", "data" => $data];
        } catch (Exception $e) {
            return ["status" => "error", "data" => "Internal Server Error."];
        }
    }

    public static function fetchBankTypes($bank_type): array
    {

        try {
            $db = parent::getLink();
            $stmt = $db->query(
                "SELECT bank_type FROM user_bank WHERE bank_type LIKE :bank_type GROUP BY bank_type ORDER BY bank_type DESC ",
                [":bank_type" => "%{$bank_type}%"]
            );

            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success", "data" => $data];
        } catch (Exception $e) {
            return ["status" => "error", "data" => "Internal Server Error." . $e->getMessage()];
        }
    }



    public static function FetchuserpaymentData($page, $limit)
    {
        try {
            $startpoint = ($page - 1) * $limit;

            $sql = "
            SELECT 
                u.uid,
                u.username,upm.bkid,
                (
                    SELECT COUNT(b.bankid)
                    FROM banks b
                    WHERE FIND_IN_SET(b.bankid, REPLACE(REPLACE(upm.bank_ids, '[', ''), ']', ''))
                ) AS bank_name_count,
                (
                    SELECT COUNT(b.bank_type)
                    FROM banks b
                    WHERE FIND_IN_SET(b.bankid, REPLACE(REPLACE(upm.bank_ids, '[', ''), ']', ''))
                ) AS bank_type_count
            FROM users_test u
            INNER JOIN user_payment_methods upm ON u.uid = upm.uid
            GROUP BY u.uid
            LIMIT :offset, :limit
        ";

            $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
            $totalRecords = parent::count('user_payment_methods');

            return ['data' => $data, 'total' => $totalRecords];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }





    public static function fetchUserPaymentByUid($uid)
    {
        try {
            $sql = "SELECT bank_ids, uid FROM user_payment_methods WHERE bkid = :bkid";
            $result = parent::query($sql, ['bkid' => $uid]);
            $bankids = $result[0]['bank_ids']; // "1,2,23"
            $userid = $result[0]['uid']; // user id

            $bankids = json_decode($bankids);
            $bankids = implode(',', $bankids);

            $sql = "SELECT name, bank_type, bank_status, bankid FROM banks WHERE bankid IN ($bankids)";
            $banks = parent::query($sql);

            // Now attach uid to every bank record
            foreach ($banks as &$bank) {
                $bank['uid'] = $userid;
            }

            return $banks;
        } catch (Exception $e) {
            // return error if needed
        }
    }


    //fetchUserPaymentInactiveByUid
    public static function DeleteUserPaymentInactiveByUid($uid, $bank_id)
    {
        // Fetch the bank_ids as a JSON array for the given uid
        $sql = "SELECT bank_ids FROM user_payment_methods WHERE uid = :uid";
        $params = ['uid' => $uid];
        $result = parent::query($sql, $params);

        // If no records are found, return false
        if (!$result || !isset($result[0]['bank_ids'])) {
            return false;
        }

        // Decode the bank_ids, remove the bank_id, and re-encode it
        $bank_ids = json_decode($result[0]['bank_ids'], true);
        $bank_ids = array_values(array_diff($bank_ids, [$bank_id])); // Remove the bank_id and re-index

        // Update the database with the new bank_ids
        $updateSql = "UPDATE user_payment_methods SET bank_ids = :bank_ids WHERE uid = :uid";
        $updateParams = ['bank_ids' => json_encode($bank_ids), 'uid' => $uid];
        return parent::query($updateSql, $updateParams); // Return the result (affected rows)
    }
}
