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
            $params  = [":offset" => $offset, ":limit" => $limit];

            foreach ($filters as $db_column => $value) {
                if (!empty($value)) {
                    $whereClause .= empty($whereClause) ?
                        " {$table_name}.{$db_column} = :{$db_column} " :
                        " AND {$table_name}.{$db_column} = :{$db_column}";
                    $params[":{$db_column}"] = $value;
                }
            }

            $whereClause = empty($whereClause) ? "" : " WHERE {$whereClause}";

            $sql = "
            SELECT 
                user_bank.*,
                (SELECT COUNT(*) FROM user_bank {$whereClause}) AS total_records,
                users_test.username, 
                users_test.nickname, 
                users_test.email
            FROM user_bank
            JOIN users_test ON user_bank.uid = users_test.uid 
            {$whereClause} 
            ORDER BY bank_id DESC
            LIMIT :offset, :limit
        ";

            $stmt = $db->query($sql, $params);
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
    //search usernames
    public static function Searchusername(string $username){
    $query = trim($username); // Clean input
    $data = parent::query(
        "SELECT uid, username, email, contact, reg_type
         FROM users_test
         WHERE 
            (LOWER(username) LIKE LOWER(:search) 
            OR LOWER(contact) LIKE LOWER(:search) 
            OR LOWER(email) LIKE LOWER(:search))
         ORDER BY 
            CASE
                WHEN LOWER(username) = LOWER(:exactMatch) THEN 1
                WHEN LOWER(contact) = LOWER(:exactMatch) THEN 2
                WHEN LOWER(email) = LOWER(:exactMatch) THEN 3
                WHEN LOWER(username) LIKE LOWER(:startsWith) THEN 4
                WHEN LOWER(contact) LIKE LOWER(:startsWith) THEN 5
                WHEN LOWER(email) LIKE LOWER(:startsWith) THEN 6
                ELSE 7
            END,
            username ASC
         LIMIT 50",
        [
            'search' => "%$query%",
            'startsWith' => "$query%",
            'exactMatch' => $query
        ]
    );

    return $data;
}
    //GET USERNAME
    public static function getUserIdByUsername(string $key)
    {
        if (empty($key)) return [];
        $db = parent::openLink();
        return parent::query(
            "SELECT uid, username FROM users_test WHERE 
           uid = :key OR email = :key OR username = :key OR contact = :key OR nickname = :key",
            ['key' => $key]
        );
    }
    //filter search 
    public static function FilterpaymentDataSubQuery($uid)
    {
        $filterConditions = [];

        if (!empty($uid)) {
            $filterConditions[] = "u.uid = '$uid'";
        }

        $subQuery = implode(' AND ', $filterConditions);
        $subQuery .= " ORDER BY u.uid DESC"; // Fixed space before ORDER
        return $subQuery;
    }
    //filter data in table 
    public static function filterpaymentdata($uid, $page, $limit)
    {
        try {
            $startpoint = (int)(($page - 1) * $limit);
            $limit = (int)$limit;

            $sql = "
            SELECT 
                u.uid,
                u.username,
                upm.bkid,
                (
                    SELECT COUNT(b.bankid)
                    FROM banks b
                    WHERE FIND_IN_SET(b.bankid, 
                        REPLACE(REPLACE(REPLACE(REPLACE(upm.bank_ids, '[', ''), ']', ''), '\"', ''), '\"', '')
                    )
                ) AS bank_name_count,
                (
                    SELECT COUNT(b.bank_type)
                    FROM banks b
                    WHERE FIND_IN_SET(b.bankid, 
                        REPLACE(REPLACE(REPLACE(REPLACE(upm.bank_ids, '[', ''), ']', ''), '\"', ''), '\"', '')
                    )
                ) AS bank_type_count
            FROM users_test u
            INNER JOIN user_payment_methods upm ON u.uid = upm.uid
            WHERE u.uid = :uid
            GROUP BY u.uid, upm.bkid
            LIMIT {$startpoint}, {$limit}
        ";

            $params = [
                'uid' => $uid
            ];

            $data = parent::query($sql, $params);

            // Count query
            $countSql = "
            SELECT COUNT(DISTINCT upm.bkid) AS total
            FROM users_test u
            INNER JOIN user_payment_methods upm ON u.uid = upm.uid
            WHERE u.uid = :uid
        ";
            $totalResult = parent::query($countSql, ['uid' => $uid]);
            $totalRecords = $totalResult[0]['total'] ?? 0;

            return ['data' => $data, 'total' => $totalRecords];
        } catch (Exception $e) {
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
}
