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
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT deposits_and_withdrawals.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.username, 'N/A') AS username 
             FROM deposits_and_withdrawals
             LEFT JOIN users_test ON users_test.uid = deposits_and_withdrawals.user_id
             ORDER BY deposits_and_withdrawals.user_id DESC 
             LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );

        $totalRecords  = parent::count('deposits_and_withdrawals');
        return ['data' => $data, 'total' => $totalRecords];
    }


    
    public static function Financialsubquery($username,$states,$startdate,$enddate)
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
        //$subQuery .= "ORDER BY deposits_and_withdrawals.date_created DESC";

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
                JOIN 
                    users_test ON users_test.uid = temp_table.user_id
                LIMIT :offset, :limit
            ";
        
            // SQL query for counting total records
            $countSql = "
                SELECT 
                    COUNT(*) AS total_counts
                FROM 
                    deposits_and_withdrawals
                WHERE
                    $subquery
            ";
        
            // Prepare and execute the main query with parameterized inputs
            $data = parent::query($sql, [ 'offset' => $startpoint, 'limit' => $limit ]);
        
            // Execute the count query
            $totalRecords = parent::query($countSql);
            $totalRecords = $totalRecords[0]['total_counts'];
        
            // Return the data and total record count
            return [
                'data' => $data,
                'total' => $totalRecords
            ];
        
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            error_log("Error executing query: " . $e->getMessage());
        
            // Optionally, return an empty set or error response
            return [
                'data' => [],
                'total' => 0,
                'error' => "Error executing query: " . $e->getMessage()
            ];
        }
    }
    
    public static function getUserDataByUsername($uid)
    {
        return  $userInfo = parent::query("SELECT balance FROM users_test WHERE uid = :uid", ["uid" => $uid]);
    }

    public static function addMoneyData($desposittype, $uid, $amount,$username,$review)
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
            if($depositid == 4){
            self::insertIntoWithrawManage($desposittype, $uid, $amount, $depositid, $username) ;
            }
        if (
            self::insertIntoDepositsAndWithdrawals($desposittype, $uid, $amount, $review, $depositid, $recharge_balance) &&
             self::insertIntoDepositsNew($desposittype, $uid, $amount, $depositid, $username) &&
            self::insertIntoTransaction($desposittype, $uid, $amount, $review, $depositid, $recharge_balance, $Data)
        ) {
            // Update user balance if all operations succeed
            self::updateBalance($uid, $recharge_balance);
            $success = true;
        }
        
        return $success ? "success" : "no changes made";
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

    public static function insertIntoDepositsNew($desposittype, $uid, $amount, $depositid,$username)
    {
         $manualusername = "manual deposit";
         $manualemail    = "manualdeposit@gmail.com";
         $params = [
            'user_id' =>  $uid,
            'user_name' => $manualusername,
            'user_email' =>$manualemail,
            'user_mobile' => "Company Number",
            'amount_paid' =>$amount,
            'amount_recieved' =>$amount,
            'date_created' => date("Y-m-d") ,
            'time_created' => date("H:i:s"),
            'payment_reference' =>  $depositid,
            'provider' =>'MTN',      
            'status' =>'success',
            'approved_by' => $username,
            'desposit_channel' => $desposittype,
        
     
        ];
        return  $inserdata = parent::insert("deposit_new", $params);
    
    }


    public static function insertIntoWithrawManage($desposittype, $uid, $amount, $depositid,$username)
    {
            $manualusername = "manual deposit";
            $manualemail = "manualdeposit@gmail.com";
            $currentDateTime = date('Y-m-d H:i:s');
            $currentTime = date('H:i:s');
            $currentDate = date('Y-m-d');

            $params = [
                'uid' => $uid,
                'withdrawal_id' => $depositid,
                'username' => $manualusername,
                'user_email' => $manualemail,
                'contact' => "MTN",
                'user_level' => 'Vip',
                'bank_type' => 'Company Number',
                'withdrawal_channel' => $desposittype,
                'card_holder' => 'Enzerhub',
                'bank_card_number' => 'Company Number',
                'withdrawal_amount' => $amount,
                'actual_withdrawal_amount' => $amount,
                'withdrawal_application_time' => $currentDateTime,
                'review_completion_time' => $currentDateTime,
                'withdrawal_time' => $currentTime,
                'withdrawal_date' => $currentDate,
                'withdrawal_state' => '2',
                'review' => 'Done',
                'approved_by' => $username,
            ];

            return parent::insert("withdrawal_manage", $params);
    
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
            'dateTime' => date("Y-m-d H:i:s"),
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
            "SELECT deposit_new.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.username, 'N/A') AS username 
             FROM deposit_new
             LEFT JOIN users_test ON users_test.uid = deposit_new.user_id
             ORDER BY deposit_new.deposit_id DESC 
             LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );


        $totalRecords  = parent::count('deposit_new');
        // $trasationIds = array_column($data, 'order_id');
        return ['data' => $data, 'total' => $totalRecords];
    }



    public static function Depositsubquery($username,$states,$depositid,$depostatus,$startdate,$enddate)
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
                JOIN 
                    users_test ON users_test.uid = temp_tables.user_id
                LIMIT :offset, :limit
            ";

        // Define the query to count total records
        $countSqls = "
                SELECT 
                    COUNT(*) AS totalcounts
                FROM 
                    deposit_new
                WHERE 
                    $subQuerys
            ";

        // Execute the main SQL query
        $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecordsResult = parent::query($countSqls);
        $totalRecords = $totalRecordsResult[0]['totalcounts'];
    
        return [ 'data' => $data, 'total' => $totalRecords];
    }
    

    public static function me($userData): array {
        echo "ksldfa";
        return [];
    }

    //NOTE -
    //////////////Withdrawal Records -//////////
    // 
    public static function WithrawalDataRecords($page = 1, $limit = 10): array
    {
        
        try{
      
        $startpoint = ($page - 1) * $limit;
        $table_name = "withdrawal_manage"; 
        $data = parent::query(
            "SELECT *,(SELECT COUNT(*) FROM {$table_name}) AS total_records FROM withdrawal_manage ORDER BY withdrawalid DESC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );
            return ["status" => "success", 'data' => $data];
        }catch(Exception $e){
            return ["status" => "error",'data' => "Internal Server Error."];
       }
        // $totalRecords  = parent::count('withdrawal_manage');
        // // $trasationIds = array_column($data, 'order_id');
        // return ['data' => $data, 'total' => $totalRecords];
    }



    // Muniru

    public static function filterWidrlRecords($userData,$page = 1, $limit = 10): array
    {


        try{
            $offset = ($page - 1) * $limit;
            $table_name = "withdrawal_manage";
            $db = parent::getLink();
            
            $where_clause = "";
            $params = ['offset' => (int) $offset, 'limit' => (int) $limit];
         
            foreach($userData as $key => $value){
               
                if($value === "all" || in_array($key,["start_date","end_date",]) || in_array($key,["start_date","end_date",])) continue;
                $key =  $key == "username" && filter_var($value, FILTER_VALIDATE_EMAIL) ? "user_email" : $key;
                $params[":{$key}"] = $value;
                $where_clause .= empty($where_clause) ? " WHERE {$key}=:{$key}" : " AND {$key}=:{$key}";
            }
    
            
           
            // Handle date conditions
            $startDate = $userData['start_date'];
            $endDate   = $userData['end_date'];
    
            if ($startDate !== "all" && $endDate === "all") {
                $where_clause .= empty($where_clause) ? " WHERE withdrawal_date = :start_date" : " AND withdrawal_date = :start_date " ;
                $params[':start_date'] = $startDate;
            } elseif ($startDate === "all" && $endDate !== "all") {
                $where_clause .= empty($where_clause) ? " WHERE withdrawal_date = :end_date" : " AND withdrawal_date = :end_date " ;
                $params[':end_date'] = $endDate;
            } elseif ($startDate !== "all" && $endDate !== "all") {
             
                $start = min($startDate, $endDate);
                $end   = max($startDate, $endDate);
                $where_clause .= empty($where_clause) ? " WHERE withdrawal_date BETWEEN :start_date AND :end_date " : " AND withdrawal_date BETWEEN :start_date AND :end_date " ;
                $params[':start_date'] = $start;
                $params[':end_date']   = $end;
            }
    
    
    
            
            $sql = "SELECT *, (SELECT COUNT(*) FROM {$table_name} {$where_clause}) AS total_records FROM {$table_name} $where_clause ORDER BY withdrawalid DESC LIMIT :offset, :limit";
            $stmt = $db->query($sql, $params);
    
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            // $trasationIds = array_column($data, 'order_id');
           return ["status" => true, 'data' => $data];
    
        }catch(\Exception $e){
            return ['status' => false, 'data' => "Interval Server Error. ". $e->getMessage()];
        }
      
    }
}
