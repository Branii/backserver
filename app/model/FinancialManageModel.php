<?php

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

class FinancialManageModel extends MEDOOHelper
{
    //NOTE -
    //////////////Financial Records -//////////
    //
    public static function FinancialDataRecords($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
        $data = parent::query(
            "SELECT deposits_and_withdrawals.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.username, 'N/A') AS username 
             FROM deposits_and_withdrawals
             LEFT JOIN users_test ON users_test.uid = deposits_and_withdrawals.user_id
             ORDER BY deposits_and_withdrawals.uid DESC 
             LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );

        $totalRecords = parent::count('deposits_and_withdrawals');
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function Financialsubquery($username, $states, $startdate, $enddate)
    {
        $filterConditions = [];

        if (!empty($username)) {
            $filterConditions[] = "user_id = '$username'";
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
        $subQuery .= "ORDER BY deposits_and_withdrawals.date_created DESC";

        return $subQuery;
    }

    public static function FilterFinancialData($subquery, $page, $limit)
    {
        try {
            // Calculate the starting point for pagination
            $startpoint = ($page - 1) * $limit;

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
                        WHERE $subquery
                    ) AS temp_table
                 LEFT JOIN 
                    users_test ON users_test.uid = temp_table.user_id
                LIMIT :offset, :limit
            ";

            // SQL query for counting total records
            $countSql1 = "
                SELECT 
                    COUNT(*) AS total_results
                FROM 
                    deposits_and_withdrawals
                WHERE $subquery
            ";

            // Prepare and execute the main query with parameterized inputs
            $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);

            // Execute the count query
            $totalRecords = parent::query($countSql1);
            $totalRecords = $totalRecords[0]['total_results'];

            // Return the data and total record count
            return [
                'data' => $data,
                'total' => $totalRecords,
            ];
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());

            // Optionally, return an empty set or error response
            return [
                'data' => [],
                'total' => 0,
                'error' => "Error executing query: " . $e->getMessage(),
            ];
        }
    }

    public static function getUserDataByUsername($uid)
    {
        return $userInfo = parent::query("SELECT balance FROM users_test WHERE uid = :uid", ["uid" => $uid]);
    }

    public static function addMoneyData($desposittype, $uid, $amount, $username, $review)
    {
        //return  $amount;
        $trans_oderId = bin2hex(random_bytes(4));
        $depositid = $desposittype == 1 ? 'DEPO' . $trans_oderId : 'WITHD' . $trans_oderId;

        // $usernames = $uid ?? [];

        // foreach ($usernames as $username) {
        $Data = self::getUserDataByUsername($uid)[0];

        if ($desposittype == 1) {
            if ($amount <= 0) {
                return "Invalid deposit amount"; // Stops negative or zero deposits
            }
            $recharge_balance = (float) $Data['balance'] + (float) $amount;
        } else {
            if ($amount <= 0) {
                return "Invalid withdrawal amount"; // Stops negative or zero withdrawals
            }
            // Check if the withdrawal amount exceeds the available balance
            if ($amount > $Data['balance']) {
                return "Insufficient balance";
                exit();
                //  continue; // Skip this iteration if balance is insufficient
            }

            // Subtract amount from balance for withdrawal
            $recharge_balance = (float) $Data['balance'] - (float) $amount;
        }

        $success = false; // Initialize a success fla

        if ($desposittype == 1) {
            if (
                self::insertIntoDepositsAndWithdrawals($desposittype, $uid, $amount, $review, $depositid, $recharge_balance) &&
                self::insertIntoDepositsNew($uid, $amount, $username) &&
                self::insertIntoTransaction($desposittype, $uid, $amount, $review, $depositid, $recharge_balance, $Data)
            ) {
                // Update user balance if all operations succeed
                self::updateBalance($uid, $recharge_balance);
                $success = true;
            }
        } elseif ($desposittype == 4) {
            if (
                self::insertIntoDepositsAndWithdrawals($desposittype, $uid, $amount, $review, $depositid, $recharge_balance) &&
                self::insertIntoTransaction($desposittype, $uid, $amount, $review, $depositid, $recharge_balance, $Data) &&
                self::insertIntoWithrawManage($uid, $amount, $username)
            ) {
                // Update user balance if all operations succeed
                self::updateBalance($uid, $recharge_balance);
                $success = true;
            }
        }

        return $success ? "transaction success" : "transaction failed";
    }

    public static function insertIntoDepositsAndWithdrawals($desposittype, $uid, $amount, $review, $depositid, $recharge_balance)
    {
        $params = [
            'user_id' => $uid,
            'partner_uid' => 1,
            'deposit_withdrawal_type' => $desposittype,
            'deposit_order' => $depositid,
            'recharge_balance_in_advance' => $recharge_balance,
            'deposit_and_withdrawal_amount' => $amount,
            'deposit_and_withdrawal_time' => date("H:i:s"),
            'date_created' => date("Y-m-d"),
            'remark' => $review,
        ];
        return $inserdata = parent::insert("deposits_and_withdrawals", $params);
    }

    public static function insertIntoDepositsNew($uid, $amount, $username)
    {
        $trans_oderId = bin2hex(random_bytes(4));
        $depositid = 'DEPO' . $trans_oderId;
        $manualusername = "Enzerhub";
        $manualemail = "enzerhub@gmail.com";
        $params = [
            'user_id' => $uid,
            'user_name' => $manualusername,
            'user_email' => $manualemail,
            'user_mobile' => "Company Number",
            'amount_paid' => $amount,
            'amount_recieved' => $amount,
            'date_created' => date("Y-m-d"),
            'time_created' => date("H:i:s"),
            'payment_reference' => $depositid,
            'provider' => 'MTN',
            'status' => 'success',
            'charges' => '0',
            'approved_by' => $username,
            'desposit_channel' => '1',
        ];
        return $inserdata = parent::insert("deposit_new", $params);
    }

    public static function insertIntoWithrawManage($uid, $amount, $username)
    {
        $manualusername = "Enzerhub";
        $manualemail = "enzerhub@gmail.com";
        $currentDateTime = date('Y-m-d H:i:s');
        $currentTime = date('H:i:s');
        $currentDate = date('Y-m-d');
        $trans_oderId = bin2hex(random_bytes(4));
        $depositid = 'WITHD' . $trans_oderId;
        $params = [
            'uid' => $uid,
            'withdrawal_id' => $depositid,
            'username' => $manualusername,
            'user_email' => $manualemail,
            'contact' => "Company Number",
            'user_level' => 'Vip',
            'bank_type' => 'MTN',
            'withdrawal_channel' => '4',
            'card_holder' => 'Enzerhub',
            'bank_card_number' => 'Company Number',
            'withdrawal_amount' => $amount,
            'actual_withdrawal_amount' => $amount,
            'withdrawal_application_time' => $currentDateTime,
            'review_completion_time' => $currentDateTime,
            'withdrawal_time' => $currentTime,
            'withdrawal_date' => $currentDate,
            'withdrawal_timezone' => self::timezoneConverter(),
            'withdrawal_state' => '2',
            'review' => 'Done',
            'approved_by' => $username,
        ];

        return parent::insert("withdrawal_manage", $params);
    }



    public static function timezoneConverter(string $otherTzName = ""){
        date_default_timezone_set("Africa/Accra");  
        $serverZone = new DateTimeZone(date_default_timezone_get());
        $otherTzName  = "Asia/Shanghai";
        $otherZone  = new DateTimeZone($otherTzName);
        $now        = new DateTime('now', $serverZone);
    
        $serverOffset = $serverZone->getOffset($now);
        $otherOffset  = $otherZone->getOffset($now);
        $diffSeconds  = $otherOffset - $serverOffset;
    
        $h = intdiv(abs($diffSeconds), 3600);
        $m = abs(($diffSeconds % 3600) / 60);
        $s = $diffSeconds >= 0 ? '+' : '-';
    
        return  $otherTzName."  ".sprintf('%s%02d', $s, $h, );
        
    }
    public static function insertIntoTransaction($desposittype, $uid, $amount, $review, $depositid, $recharge_balance, $Data)
    {
        if ($desposittype == 4) {
            $amount = -$amount; // Negate the value of $amount
        }

        $params = [
            'uid' => $uid,
            'partner_uid' => 1,
            'order_type' => $desposittype,
            'balance_before' => $Data['balance'],
            'balance' => $recharge_balance,
            'total_income' => 0,
            'account_change' => $amount,
            'date_created' => date("Y-m-d H:i:s"),
            'dateTime' => date("Y-m-d H:i:s"),
            'description' => $review,
            'remarks' => $review,
            'transaction_type' => $desposittype,
            'order_id' => $depositid,
            'status' => 1,
            'rebate_level' => $uid,
        ];

        return $inserdata = parent::insert("transaction", $params);
    }

    public static function updateBalance($uid, $recharge_balance)
    {
        return $updateuserbalance = parent::query("UPDATE users_test SET balance = :balance WHERE uid = :uid", ["balance" => $recharge_balance, "uid" => $uid]);
    }

    //NOTE -
    //////////////Deposit Records -//////////
    //

    public static function DepositDataRecords($page, $limit): array
    {
        $startpoint = $page * $limit - $limit;
        $data = parent::query(
            "SELECT deposit_new.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.username, 'N/A') AS username 
             FROM deposit_new
             LEFT JOIN users_test ON users_test.uid = deposit_new.user_id
             ORDER BY deposit_new.deposit_id DESC 
             LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );

        $totalRecords = parent::count('deposit_new');
        // $trasationIds = array_column($data, 'order_id');
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function Depositsubquery($username, $states, $depositid, $depostatus, $startdate, $enddate)
    {
        $filterConditions = [];

        if (!empty($username)) {
            $filterConditions[] = "user_id = '$username'";
        }

        if (!empty($states)) {
            $filterConditions[] = "desposit_channel = '$states'";
        }
        if (!empty($depositid)) {
            $filterConditions[] = "payment_reference = '$depositid'";
        }

        if (!empty($depostatus)) {
            $filterConditions[] = "status = '$depostatus'";
        }

        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "DATE(date_created) BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "DATE(date_created) = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "DATE(date_created) = '$enddate'";
        }

        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }
        // Add ordering and limit to the query
        $subQuery .= "ORDER BY deposit_new.date_created DESC";

        return $subQuery;
    }

    public static function FilterDepositData($subQuerys, $page, $limit)
    {
        $startpoint = ($page - 1) * $limit;

        $sql = "
                SELECT 
                    temp_tables.*, 
                    users_test.email AS email, 
                    users_test.reg_type,
                    users_test.username AS username, 
                    users_test.contact
                FROM 
                    (
                        SELECT * 
                        FROM deposit_new
                        WHERE $subQuerys
                    ) AS temp_tables
                 LEFT JOIN 
                    users_test ON users_test.uid = temp_tables.user_id
                LIMIT :offset, :limit
            ";

        // Define the query to count total records
        $countSqlss = "
                SELECT 
                    COUNT(*) AS totals_count
                FROM 
                    deposit_new
                WHERE 
                    $subQuerys
            ";

        // Execute the main SQL query
        $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecordsResults = parent::query($countSqlss);
        $totalRecords = $totalRecordsResults[0]['totals_count'];

        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function me($userData): array
    {
        echo "ksldfa";
        return [];
    }

    //NOTE -
    //////////////Withdrawal Records -//////////
    //
    public static function WithrawalDataRecords($partnerID = 0,$page = 1, $limit = 10): array
    {
        try {
            $startpoint = ($page - 1) * $limit;
            $table_name = "withdrawal_manage";
            $db = parent::openLink($partnerID);
            // $data = parent::query("SELECT *,(SELECT COUNT(*) FROM {$table_name}) AS total_records FROM withdrawal_manage ORDER BY withdrawalid DESC LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]);
            $stmt = $db->query("SELECT *,(SELECT COUNT(*) FROM {$table_name}) AS total_records FROM withdrawal_manage ORDER BY withdrawalid DESC LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]);

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ["status" => "success", 'data' => $data];
        } catch (Exception $e) {
            return ["status" => "error", 'data' => "Internal Server Error."];
        }
        // $totalRecords  = parent::count('withdrawal_manage');
        // // $trasationIds = array_column($data, 'order_id');
        // return ['data' => $data, 'total' => $totalRecords];
    }

    // Muniru

    public static function filterWidrlRecords($partnerID,$userData, $page = 1, $limit = 10): array
    {
        try {
            $offset = ($page - 1) * $limit;
            $table_name = "withdrawal_manage";
            $db = parent::openLink($partnerID);

            $where_clause = "";
            $params = ['offset' => (int) $offset, 'limit' => (int) $limit];

            foreach ($userData as $key => $value) {
                if ($value === "all" || in_array($key, ["start_date", "end_date"]) || in_array($key, ["start_date", "end_date"])) {
                    continue;
                }
                $key = $key == "username" && filter_var($value, FILTER_VALIDATE_EMAIL) ? "user_email" : $key;
                $params[":{$key}"] = $value;
                $where_clause .= empty($where_clause) ? " WHERE {$key}=:{$key}" : " AND {$key}=:{$key}";
            }

            // Handle date conditions
            $startDate = $userData['start_date'];
            $endDate = $userData['end_date'];

            if ($startDate !== "all" && $endDate === "all") {
                $where_clause .= empty($where_clause) ? " WHERE withdrawal_date = :start_date" : " AND withdrawal_date = :start_date ";
                $params[':start_date'] = $startDate;
            } elseif ($startDate === "all" && $endDate !== "all") {
                $where_clause .= empty($where_clause) ? " WHERE withdrawal_date = :end_date" : " AND withdrawal_date = :end_date ";
                $params[':end_date'] = $endDate;
            } elseif ($startDate !== "all" && $endDate !== "all") {
                $start = min($startDate, $endDate);
                $end = max($startDate, $endDate);
                $where_clause .= empty($where_clause) ? " WHERE withdrawal_date BETWEEN :start_date AND :end_date " : " AND withdrawal_date BETWEEN :start_date AND :end_date ";
                $params[':start_date'] = $start;
                $params[':end_date'] = $end;
            }

            $sql = "SELECT *, (SELECT COUNT(*) FROM {$table_name} {$where_clause}) AS total_records FROM {$table_name} $where_clause ORDER BY withdrawalid DESC LIMIT :offset, :limit";
            $stmt = $db->query($sql, $params);

            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            // $trasationIds = array_column($data, 'order_id');
            return ["status" => true, 'data' => $data];
        } catch (\Exception $e) {
            return ['status' => false, 'data' => "Interval Server Error. " . $e->getMessage()];
        }
    }
}
