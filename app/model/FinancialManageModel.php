<?php

class FinancialManageModel extends MEDOOHelper
{

    //NOTE -
    //////////////Financial Records -//////////
    // 
    public static function FinancialDataRecords($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT deposits_and_withdrawals.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.username, 'N/A') AS username 
             FROM deposits_and_withdrawals
             LEFT JOIN users_test ON users_test.uid = deposits_and_withdrawals.user_id
             ORDER BY deposits_and_withdrawals.uid DESC 
             LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );

        $totalRecords  = parent::count('deposits_and_withdrawals');
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function getUserDataByUsername($uid)
    {
        return  $userInfo = parent::query("SELECT balance FROM users_test WHERE uid = :uid", ["uid" => $uid]);
    }

    public static function addMoneyData($desposittype, $uid, $amount, $review)
    {


        $trans_oderId = bin2hex(random_bytes(4));
        $depositid  = ($desposittype == 1) ? 'DEPO' . $trans_oderId : 'WITHD' . $trans_oderId;


        // $usernames = $uid ?? [];
        $success = false; // Initialize a success fla

        // foreach ($usernames as $username) {
        $Data = self::getUserDataByUsername($uid)[0];

        if ($desposittype == 1) {

            $recharge_balance = (float) $Data['balance'] + (float) $amount;
        } else {
            // Check if the withdrawal amount exceeds the available balance
            if ((float) $amount > (float) $Data['balance']) {
                echo "Insufficient balance for user:";
                exit;
                //  continue; // Skip this iteration if balance is insufficient
            }

            // Subtract amount from balance for withdrawal
            $recharge_balance = (float) $Data['balance'] - (float)$amount;
        }

        // Insert into Deposits and Withdrawals
        if (self::insertIntoDepositsAndWithdrawals($desposittype, $uid, $amount, $review, $depositid, $recharge_balance)) {
            // Insert into Transaction table
            if (self::insertIntoTransaction($desposittype, $uid, $amount, $review, $depositid, $recharge_balance, $Data)) {
                // Update user balance
                self::updateBalance($uid, $recharge_balance);
                $success = true; // Set the flag to true if any iteration is successful
            }
        }
        //  }
        if ($success) {
            return "success";
        } else {
            return  "no changes made";
        }
    }

    public static function insertIntoDepositsAndWithdrawals($desposittype, $uid, $amount, $review, $depositid, $recharge_balance)
    {
        $params = [
            'user_id' =>  $uid,
            'partner_uid' => 1,
            'deposit_withdrawal_type' => $desposittype,
            'deposit_order' =>  $depositid,
            'recharge_balance_in_advance' =>  $recharge_balance,
            'deposit_and_withdrawal_amount' =>  $amount,
            'deposit_and_withdrawal_time' =>  date("H:i:s"),
            'date_created' =>  date("Y-m-d"),
            'remark' => $review,
        ];
        return  $inserdata = parent::insert("deposits_and_withdrawals", $params);
    }

    public static function insertIntoTransaction($desposittype, $uid, $amount, $review, $depositid, $recharge_balance, $Data)
    {
        if ($desposittype == 4) {
            $amount = -$amount; // Negate the value of $amount
        }
        
        $params = [
            'uid' =>  $uid,
            'partner_uid' => 1,
            'order_type' => $desposittype,
            'balance_before' =>  $Data['balance'],
            'balance' =>  $recharge_balance,
            'total_income' =>  0,
            'account_change' => $amount,
            'date_created' =>  date("Y-m-d"),
            'dateTime' => date("Y-m-d"),
            'description' => $review,
            'remarks' => $review,
            'transaction_type' => $desposittype,
            'order_id' => $depositid,
            'status' => 1,
        ];

        return  $inserdata = parent::insert("transaction", $params);
    }


    public static function updateBalance($uid, $recharge_balance)
    {
        return $updateuserbalance =  parent::query("UPDATE users_test SET balance = :balance WHERE uid = :uid", ["balance" => $recharge_balance, "uid" => $uid]);
    }



    //NOTE -
    //////////////Deposit Records -//////////
    // 

    public static function DepositDataRecords($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT * FROM deposit_new ORDER BY deposit_id DESC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );

        $totalRecords  = parent::count('deposit_new');
        // $trasationIds = array_column($data, 'order_id');
        return ['data' => $data, 'total' => $totalRecords];
    }



    public static function Depositsubquery($uid, $states, $startdate, $enddate)
    {

        $filterConditions = [];

        if (!empty($uid)) {
            $filterConditions[] = "user_id = '$uid'";
        }

        if (!empty($states)) {
            $filterConditions[] = "deposit_withdrawal_type = '$states'";
        }

        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "date_created BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "date_created = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "date_created = '$enddate'";
        }

        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }
        // Add ordering and limit to the query
        //$subQuery .= "ORDER BY deposits_and_withdrawals.date_created DESC";

        return $subQuery;
    }


   
    public static function FilterDepositData($subQuery, $page, $limit)
    {
        try {
            // Calculate the starting point for pagination
            $startpoint = ($page - 1) * $limit;
        
            // SQL query for fetching paginated data
            $sql = "
                SELECT 
                    temp_table.*, 
                    users_test.email AS email,
                    users_test.reg_type,
                    users_test.username AS username,
                    users_test.contact AS contact
                FROM 
                    (
                        SELECT * 
                        FROM deposits_and_withdrawals
                        WHERE $subQuery
                    ) AS temp_table
                JOIN 
                    users_test ON users_test.uid = temp_table.user_id
                LIMIT :offset, :limit
            ";
        
            // SQL query for counting total records
            $countSql = "
                SELECT 
                    COUNT(*) AS total_count
                FROM 
                    deposits_and_withdrawals
                WHERE
                    $subQuery
            ";
        
            // Execute the main query with parameterized inputs
            $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
        
            $totalRecords = parent::query($countSql);
            $totalRecords =  $totalRecords[0]['total_count'] ;
        
            // Return the data and total record count
            return ['data' => $data, 'total' => $totalRecords];
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());
        }
    }
    

    //NOTE -
    //////////////Withdrawal Records -//////////
    // 
    public static function WithrawalDataRecords($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT * FROM withdrawal_manage ORDER BY withdrawalid DESC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );

        $totalRecords  = parent::count('withdrawal_manage');
        // $trasationIds = array_column($data, 'order_id');
        return ['data' => $data, 'total' => $totalRecords];
    }
}
