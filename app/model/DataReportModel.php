<?php


set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

use Medoo\Medoo;

class DataReportModel extends MedooOrm
{


    public static function fetch_users_win_loss_report($partnerID,int $currentPage = 1,$limit = 10, String $orderColumn = "uid"):array{
      
        try{
        $table_name = "users_test";
        $offset = ($currentPage - 1) * 10;
        $db = parent::openLink($partnerID);
        $stmt = $db->query(
            "SELECT *,(SELECT COUNT(*) FROM {$table_name}) AS num_users FROM {$table_name} ORDER BY {$orderColumn} DESC LIMIT :offset, :limit",
            [
                ':offset' => $offset,
                ':limit'  => $limit
            ]
        );
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return self::response($data);
    }catch(Exception $e){
        echo $e->getMessage();
        return self::response("Internal Server Error.",false,);
    }

   
    }

    public static function FiltertLotteryNames($partnerID,$lottery_name = ""): Mixed{

        $res = parent::openLink($partnerID)->query("SELECT gt_id,name  FROM game_type WHERE name LIKE :search ORDER BY  CASE 
                WHEN name LIKE :startsWith THEN 1  -- Prioritize lottery names that start with the search term
                ELSE 2                                -- Other matches come next
                END, lottery_type ASC LIMIT 50", [
            'search' => "%$lottery_name%",       // Matches usernames containing the search term
            'startsWith' => "$lottery_name%"     // Prioritizes usernames starting with the search term
        ])->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public static function fetchUser($user_id)
    {
        // Execute query using Medoo's query method with pagination
        return parent::getLink()->query(
            "SELECT * FROM users_test WHERE uid = :uid LIMIT 1",
            [
                ':uid' => $user_id
            ]
        )->fetch(PDO::FETCH_OBJ);
    }



    public static function filter_fetch_users_for_win_loss_report($userData, int $currentPage = 1, int $recordsPerPage = 10, string $tblid = "uid"){
        try{
           

        $table_name = "users_test";
        $service = parent::getLink();
        $results =  $service->query(
            "SELECT *,(SELECT COUNT(*) FROM {$table_name}) as num_users FROM {$table_name} WHERE uid= :uid ORDER BY $tblid DESC",
            ["uid" => is_object($userData) ? $userData->uid : $userData]
        )->fetch(PDO::FETCH_OBJ);
       return self::response($results);
        
    }catch(Exception $e){
        return self::response("Internal Server Error.",false,);
    }
    }

    public static function fetchUserByID($partnerID,$user_id):array{

        try{
            $table_name = "users_test";
            $service = parent::openLink($partnerID);
            $sql     = "SELECT * FROM {$table_name} WHERE uid=:uid";
            $data =  $service->query( $sql, [":uid" => intval($user_id)] )->fetchAll(PDO::FETCH_OBJ);
            return self::response($data);
        }catch(Exception $e){
            return self::response("Internal Server Error.",false);
        }

    }

    public static function filterWinLossRecordsForUser($partnerID,$user_id,$filters = [],bool $isForOnlyUser = false,bool $addAgent = true){
        try{

        $table_name = "transaction";
        $user_and_subs =  !$isForOnlyUser ? self::fetchFullHierarchyV2($partnerID,$user_id,) : self::fetchUserByID( $partnerID,$user_id);

        if($user_and_subs["status"] === "error") return $user_and_subs;
        $place_holders = [];
        $params = [];
        $track_bet_params = [];
        $track_place_holder_uids = [];
        $track_where_clause = "";
        $rebate = 0;
        $username = "";
        $account_type = 0;
        $user_key = 0;
        $subs_uids = [];
        $subs_data = $user_and_subs['data'];

        foreach ($subs_data as $key => $data) {
            # code...
            if($data->uid === intval($user_id)) {
                $username = $data->username;
                $rebate   = $data->rebate;
                $account_type = $data->account_type;
                $user_key = $key;
            }
            $subs_uids[] = $data->uid;
            $place_holder     = ":uid{$key}" ; 
            $track_place_holder_uids[] = $place_holder;
            $place_holders [] = $place_holder;
            $params[$place_holder] = $data->uid;
            $track_bet_params[$place_holder] = $data->uid;
        }

           // Handle date conditions
           $startDate = $filters['start_date'];
           $endDate   = $filters['end_date'];

           $where_clause = "";
   
           if ($startDate !== "all" && $endDate === "all") {
               $where_clause .=  " AND date_created = :start_date " ;
               $where_clause .=  " AND server_date  = :start_date " ;
               $params[':start_date'] = $startDate;
               $track_bet_params[":start_date"] = " AND server_date = :start_date";
           } elseif ($startDate === "all" && $endDate !== "all") {
               $where_clause .= " AND date_created = :end_date " ;
               $track_where_clause .= " AND server_date = :end_date " ;
               $params[':end_date'] = $endDate;
               $track_bet_params[":end_date"] = " AND server_date = :end_date";
           } elseif ($startDate !== "all" && $endDate !== "all") {
            
               $start = min($startDate, $endDate);
               $end   = max($startDate, $endDate);
               $where_clause .= " AND date_created BETWEEN :start_date AND :end_date " ;
               $track_where_clause .= " AND server_date BETWEEN :start_date AND :end_date " ;
               $params[':start_date'] = $start;
               $params[':end_date']   = $end;
               $track_bet_params[":start_date"] =  $start ;
               $track_bet_params[":end_date"]   = $end ;

           }

           if($filters["game_type"] != "all") {
            $where_clause .= " AND game_type = :lottery_id";
            $track_where_clause .= " AND game_type_id = :lottery_id ";
            $params[":lottery_id"] = intval($filters["game_type"]);
            $track_bet_params[":lottery_id"] = intval($filters["game_type"]); 
           }
          

           
       $service = parent::openLink($partnerID);
       if(!$isForOnlyUser){
           unset($subs_uids[array_search($user_id,$subs_uids)]);
       } 
       

       $query = "SELECT    (SELECT SUM(expenditure_amount) FROM {$table_name} WHERE uid IN (".implode(',',$place_holders).") AND bet_type = 1 AND order_type != 11 {$where_clause}) AS total_normal_bet_amount, 
       (SELECT SUM(expenditure_amount) FROM {$table_name} WHERE uid IN (".implode(',',$place_holders).") AND bet_type = 1 AND order_type = 12 {$where_clause}) AS total_loss_amount,
       (SELECT SUM(account_change) FROM {$table_name} WHERE uid IN (".implode(',',$place_holders).") AND bet_type = 1 {$where_clause} AND order_type = 3)  AS total_win_amount,(SELECT SUM(expenditure_amount) FROM {$table_name} WHERE uid IN (".implode(',',$place_holders).") AND bet_type = 1 AND order_type = 11 {$where_clause}) AS total_direct_refund_amount,(SELECT SUM(expenditure_amount) FROM {$table_name} WHERE uid IN (".implode(',',$place_holders).") AND (order_type = 2 || order_type = 10)   {$where_clause}) AS total_promotions_and_bonus, 
       (SELECT SUM(account_change) FROM {$table_name} WHERE uid IN(".implode(',',$place_holders).") AND (order_type = 7 || order_type = 8) {$where_clause}) AS total_rebate_amount,
       SUM(CASE WHEN order_type = 2 THEN account_change ELSE 0 END) AS win_bonus, 
       SUM(CASE WHEN order_type = 3 THEN account_change ELSE 0 END) AS bet_awarded, 
       SUM(CASE WHEN order_type = 5 THEN account_change ELSE 0 END) AS bet_deduct, 
       (SELECT COUNT(DISTINCT(uid)) FROM {$table_name} WHERE uid IN(".implode(',',$place_holders).") AND (order_type = 3 || order_type = 12) {$where_clause}) AS num_bettors,
       (SELECT COUNT(trans_id) FROM {$table_name} WHERE uid IN(".implode(',',$place_holders).") AND (order_type = 3 || order_type = 12) AND bet_type = 1 {$where_clause}) AS num_bet_tickets 
       FROM {$table_name} WHERE uid IN (".implode(',',$place_holders).")  {$where_clause}";

       // execute the dynamic query
       $results =  $service->query( $query, $params )->fetch(PDO::FETCH_OBJ);
       

        // get all combne both the total bet amounts for the games won and the total bet amounts for the games lost

        $total_normal_bet_amount = $results->total_normal_bet_amount ?? 0;
        $total_win_amount = $results->total_win_amount ?? 0;
        $total_rebate_amount  = $results->total_rebate_amount ?? 0 ;
        $total_promotions_and_bonus  = $results->total_promotions_and_bonus ?? 0;
        $total_direct_refund_amount  = $results->total_direct_refund_amount ?? 0;

        $query = "SELECT SUM(done_amount) as total_done_amount, SUM(win_amount) AS total_win_amount, SUM(lost_amount) AS total_loss_amount,SUM(total_amount) as total_track_amount,SUM(refund_amount) as total_refund_amount, SUM(tracked) as track_num_bets FROM trackbet WHERE user_id IN (".implode(',',$track_place_holder_uids).") {$track_where_clause}";
        $track_results  = $service->query( $query, $track_bet_params )->fetch(PDO::FETCH_OBJ);
        $total_valid_amount  = ($track_results->total_done_amount ?? 0) + $total_normal_bet_amount;
        $track_num_bets = ($track_results->track_num_bets ?? 0);
        $total_track_refund_amount = ($track_results->total_refund_amount ?? 0);
        $total_refund_amount       = $total_track_refund_amount + $total_direct_refund_amount;
        $total_fee_amount = 0;

        $total_bet_amount = ($results->total_normal_bet_amount ?? 0) + ($track_results->total_track_amount ?? 0);
       
        $win_loss = $isForOnlyUser ? ($total_bet_amount === 0 ? self::formatNumber($total_rebate_amount) : self::formatNumber(($total_valid_amount + $total_fee_amount) - ($total_win_amount + $total_rebate_amount + $total_promotions_and_bonus + $total_refund_amount) )) : self::formatNumber(($total_valid_amount + $total_fee_amount) - ($total_win_amount + $total_rebate_amount + $total_promotions_and_bonus + $total_refund_amount) );
        $results = ["user_id" => $user_id,"username" => $username,"account_type" => $account_type, "num_bettors" => $results->num_bettors,"num_bet_tickets" => $results->num_bet_tickets + $track_num_bets,"rebate" => $rebate, "total_bet_amount" =>  self::formatNumber($total_bet_amount), "total_rebate_amount" => self::formatNumber($total_rebate_amount), 'total_win_amount' => self::formatNumber($total_win_amount + ($results->win_bonus ?? 0)), "total_valid_amount" =>  self::formatNumber($total_valid_amount), 'win_loss' =>  $win_loss, "num_subs" => max((count($subs_data) - 1),0),"fees"=> self::formatNumber($total_fee_amount) ,"total_promotions_and_bonus" => self::formatNumber($total_promotions_and_bonus),'total_refund_amount' => self::formatNumber($total_refund_amount)];

       return self::response($results);
        
    }catch(Exception $e){
        echo $e->getMessage();
        return self::response("Internal Server Error.".$e->getMessage(),false,);
    }
    }

   

public static function allSubs($partnerID,$agent_id, int $currentPage = 1, int $limit = 10, bool $addAgent = false) {
    try{
        $table_name = "users_test";
        $db = parent::openLink($partnerID);
        $offset = ($currentPage - 1) * $limit;
        $include_agent = $addAgent ? " || uid=:agent_id " : " AND uid !=:agent_id " ;
        // Construct raw SQL query
         $sql = "SELECT *,(SELECT COUNT(*) FROM {$table_name} WHERE {$table_name}.agent_id=:agent_id AND uid !=:agent_id) AS total_records FROM {$table_name} WHERE {$table_name}.agent_id = :agent_id {$include_agent} ORDER BY uid DESC 
                LIMIT :offset, :limit ";

        // Execute the query using Medoo's `query` method
        $stmt = $db->query($sql, [
            ':agent_id' => $agent_id,
            ':offset' => $offset,
            ':limit' => $limit
        ]);

        // Fetch results
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return self::response($data);
    }catch(Exception $e){
        
        return self::response("Internal Server Error.". $e->getMessage(),false);
    }
    }
   

public static function fetchFullHierarchy($agent_id) {
    try{
        $table_name = "user_rebate";
        $db = parent::getLink();
        // Construct raw SQL query
        $sql = "SELECT DISTINCT user_id as uid FROM {$table_name}  WHERE {$table_name}.agent_id = :agent_id  ";
         

        // Execute the query using Medoo's `query` method
        $stmt = $db->query($sql, [':agent_id' => $agent_id]);

         // Fetch results
         $data = $stmt->fetchAll(PDO::FETCH_OBJ);

         $uids = array_column($data,"uid");
         $agent_id = intval($agent_id);
         if(empty($agent_id))  return self::response("Internal Server Error.",false);

         $table_name = "users_test";
         $uids[] = $agent_id;

         $sql = "SELECT *  FROM  {$table_name}   WHERE uid IN (".implode(",",$uids).") ";

        // Execute the query using Medoo's `query` method
        $stmt = $db->query($sql);

        // Fetch results
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return self::response($data);
    }catch(Exception $e){
        return self::response("Internal Server Error.". $e->getMessage(),false);
    }
    }



    public static function getActiveSubs($agent_id, int $currentPage = 1, int $limit = 10, bool $addAgent = false) {
        try{
            $table_name = "users_test";
            $db = parent::getLink();
            $offset = ($currentPage - 1) * $limit;

            // Construct raw SQL query
            $sql = "SELECT *,(SELECT COUNT(*) FROM {$table_name} WHERE {$table_name}.agent_id=:agent_id AND uid !=:agent_id) AS total_records FROM {$table_name} JOIN transaction ON transaction.uid = {$table_name}.uid WHERE {$table_name}.agent_id =:agent_id AND transaction.order_type IN (3,12)  AND {$table_name}.uid !=:agent_id GROUP BY {$table_name}.uid ORDER BY {$table_name}.uid DESC LIMIT :offset, :limit ";
    
            // Execute the query using Medoo's `query` method
            $stmt = $db->query($sql, [
                ':agent_id' => $agent_id,
                ':offset' => $offset,
                ':limit' => $limit
            ]);
    
            // Fetch results
            return $stmt->fetchAll(PDO::FETCH_OBJ);
           
        }catch(Exception $e){
            // log the error msg and return an empty array
            return ["status" => "error", "data" => "Internal Server Error."];
        }
        }

    public static function fetchFullHierarchyV2($partnerID,$agent_id) {
        try{



            $db = parent::openLink($partnerID);


            // Construct query for all active bettors
            $sql = "SELECT DISTINCT user_id FROM user_rebate WHERE agent_id=:agent_id ";
            // execute the query to get the results for all active bettors
            $stmt = $db->query($sql, [':agent_id' => $agent_id]);
            // Fetch results
            $active_downlines = $stmt->fetchAll(PDO::FETCH_OBJ);

            if(empty($active_downlines))  {
                $sql = "SELECT *,(SELECT COUNT(*) FROM users_test WHERE uid =:agent_id) AS total_records FROM users_test WHERE uid =:agent_id ORDER BY uid DESC ";

                // Execute the query using Medoo's `query` method
                $stmt = $db->query($sql,[":agent_id" => $agent_id]);
    
                // Fetch results
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);
                return ["status" => "success", "data"=> $data];
            }

            $active_downlines_uids = array_column($active_downlines,"user_id");

            // Construct raw SQL query
             $sql = "SELECT DISTINCT agent_id,user_id FROM user_rebate WHERE user_id IN (".implode(',',$active_downlines_uids).") ";

             // Execute the query using Medoo's `query` method
             $stmt = $db->query($sql);

             // Fetch results
            $active_tree_res = $stmt->fetchAll(PDO::FETCH_OBJ);


            $active_agent_tree = array_column($active_tree_res,"agent_id");
            $unique_ids =   array_unique(array_merge($active_downlines_uids,$active_agent_tree));

            sort($unique_ids);
            $unique_ids = array_slice($unique_ids,array_search($agent_id,$unique_ids));


            

              // Construct raw SQL query
         $sql = "SELECT *,(SELECT COUNT(*) FROM users_test WHERE uid IN (".implode(',',$unique_ids).")) AS total_records FROM users_test WHERE uid IN (".implode(',',$unique_ids).") ORDER BY uid DESC ";

            // Execute the query using Medoo's `query` method
            $stmt = $db->query($sql);

            // Fetch results
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ["status" => "success", "data"=> $data];
           
        }catch(Exception $e){
           
            // log the error msg and return an empty array
            return ["status" => "error", "data" => "Internal Server Error."];
        }
        }



    public static function fetch_top_agents($partnerID,$currentPage = 1, $limit = 10 , string $tblid = "uid"):array {
        try{
            $database = parent::openLink($partnerID);

            // Pagination setup
            $offset = ($currentPage - 1) * $limit;
            $params = [];
            $table_name = "users_test";
            // Build the query
            $sql = "SELECT *,(SELECT COUNT(*) FROM users_test WHERE {$table_name}.account_type=2) as total_records FROM users_test WHERE {$table_name}.account_type=2  ORDER BY {$table_name}.$tblid DESC LIMIT :offset, :limit";
    
            // Add binding parameters
            $params = [':offset' => intval($offset), ':limit' => intval($limit)];
    
            // Execute query using Medoo's query method
            $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
            return self::response($data);
        }catch(Exception $e){
            echo $e->getMessage();
            return self::response("Internal Server Error.". $e->getMessage(),false);
        }
    }

    public static function filter_only_top_agents($userData, int $currentPage = 1, int $recordsPerPage = 10, string $tblid = "uid"): array
    {


        // get medoo instance
        $database = parent::getLink();

        // Pagination setup
        $offset = ($currentPage - 1) * $recordsPerPage;
        $params = [];

        // Build the query
        $sql = "SELECT u.*, 
                    (SELECT COUNT(*) FROM users_test AS sub WHERE sub.agent_id = u.agent_id ) AS agent_sub_count, 
                    (SELECT COUNT(*) FROM users_test AS sub WHERE sub.agent_id = u.uid ) AS sub_count, 
                    (SELECT sub.username FROM users_test AS sub WHERE sub.uid = u.agent_id LIMIT 1) AS agent_username
                FROM users_test AS u 
                WHERE u.account_type=2  
                ORDER BY u.$tblid DESC LIMIT :offset, :recordsPerPage";

        // Add binding parameters
        $params = [':offset' => intval($offset), ':recordsPerPage' => intval($recordsPerPage)];

        // Execute query using Medoo's query method
        $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function subs_and_agent_subs_count($user_id, $currentPage = 1, $recordsPerPage = 10, $tblid = 'uid'): mixed{

        $database     = parent::getLink();
        $data = $database->query(
            "SELECT COUNT(*) AS sub_count, 
                        (SELECT COUNT(*) FROM users_test AS sub WHERE sub.agent_id = users_test.agent_id) AS agent_sub_count 
                FROM users_test 
                WHERE users_test.agent_id = :user_id 
                ORDER BY users_test.$tblid DESC",
            [":user_id" => $user_id]
        )->fetch(PDO::FETCH_OBJ);

        return $data;
    }


    public static function updatedFilterGetBetTicketsNum($user_id,$bet_tables,$userData): array {
        try{

        //     $sql = "SELECT GROUP_CONCAT( 
        //     CONCAT( 
        //         'SELECT  
        //             bt.bet_odds, bt.draw_period, bt.bet_code, bt.game_label, bt.game_type, bt.uid,  
        //             bt.bet_number, bt.unit_stake, bt.multiplier, bt.bet_amount, bt.win_amount,  
        //             bt.bet_status, bt.state, bt.bet_time, bt.bet_date, bt.server_date, bt.server_time,  
        //             u.username, u.email, u.contact, u.reg_type,  
        //             gt.name AS game_type, gt.gt_id AS gt_id,  
        //             SUM(bt.bet_amount) AS total_bet_amount,  
        //             SUM(bt.win_amount) AS total_win_amount  
        //         FROM ', table_name, ' bt  
        //         JOIN users_test u ON bt.uid = u.uid  
        //         JOIN game_type gt ON gt.gt_id = bt.game_type  
        //         GROUP BY bt.draw_period')  
        //     SEPARATOR ' UNION ALL ' 
        // ) AS query  
        // FROM information_schema.tables  
        // WHERE table_schema = 'lottery_test'  
        // AND table_name LIKE 'bt_%'";
        // Initialize query conditions
    $dateCondition = "";
    $params = [
        ':user_id' => $user_id,
    ];

    // Handle date conditions
    $startDate = $userData['datecreated'];
    $endDate = $userData['enddate'];

    if ($startDate !== "all" && $endDate === "all") {
        $dateCondition = "AND server_date = :start_date";
        $params[':start_date'] = $startDate;
    } elseif ($startDate === "all" && $endDate !== "all") {
        $dateCondition = "AND server_date = :end_date";
        $params[':end_date'] = $endDate;
    } elseif ($startDate !== "all" && $endDate !== "all") {
        $start = min($startDate, $endDate);
        $end = max($startDate, $endDate);
        $dateCondition = "AND server_date BETWEEN :start_date AND :end_date";
        $params[':start_date'] = $start;
        $params[':end_date'] = $end;
    }

    // Build the query dynamically to include all bet tables
    $query = "SELECT GROUP_CONCAT( 
                CONCAT( 
                    'SELECT 
                        \'' , table_name, '\' AS bet_table_name,   
                        COUNT(bt.bet_amount) AS num_bet_tickets,
                        SUM(bt.bet_amount) AS total_bet_amount,  
                        SUM(bt.win_amount) AS total_win_amount, 
                        ( 
                            SELECT SUM(amount) 
                            FROM user_rebate 
                            WHERE agent_id = :user_id 
                            AND game_type_id = bt.game_type 
                            $dateCondition 
                        ) AS user_rebate_amount, 
                        ( 
                            SELECT SUM(rebate_amount) 
                            FROM ', table_name, ' 
                            WHERE uid = :user_id 
                            $dateCondition 
                        ) AS self_rebate_amount, 
                        ( 
                            SELECT SUM(bet_amount) 
                            FROM ', table_name, ' 
                            WHERE bettype = 1 
                            AND state = 1 
                            AND uid = :user_id 
                        ) AS sba 
                    FROM ', table_name, ' bt   
                    WHERE bt.uid = :user_id  
                    $dateCondition 
                   ')  
                SEPARATOR ' UNION ALL ' 
            ) AS query  
            FROM information_schema.tables  
            WHERE table_schema = 'lottery_test'  
            AND table_name LIKE 'bt_%'";

    $database = parent::openLink();
    $result = $database->query($query, $params)->fetch(PDO::FETCH_ASSOC);

    $finalResults = [];
    // Execute the dynamic query
    if (!empty($result['query'])) {
        $finalQuery = $result['query'];
        $finalResults = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
        // print_r($finalResults);
        return    self::response($finalResults);
        }catch(Exception $e){
        return    self::response("Internal Server Error",false);
        }
    }
public static function filterGetBetTicketsNum($partnerID,$user_id, $bet_tables, $userData)
    {

        try{

        $summed_results = [];
        $summed_results = [];
        $params = [];
            $betTable_array  = $bet_tables[0];
            $betTable = $betTable_array['bet_table'];
            $lottery_id = $betTable_array['game_type'];

            // Initialize query conditions
            $dateCondition = "";
            $params = [
                ':betTable'   => $betTable,
                ':user_id'    => $user_id,
                ':lottery_id' => $lottery_id,
            ];

            // Handle date conditions
            $startDate = $userData['datecreated'];
            $endDate = $userData['enddate'];

            if ($startDate !== "all" && $endDate === "all") {
                $dateCondition = "AND server_date = :start_date";
                $params[':start_date'] = $startDate;
            } elseif ($startDate === "all" && $endDate !== "all") {
                $dateCondition = "AND server_date = :end_date";
                $params[':end_date'] = $endDate;
            } elseif ($startDate !== "all" && $endDate !== "all") {
                $start = min($startDate, $endDate);
                $end   = max($startDate, $endDate);
                $dateCondition = "AND server_date BETWEEN :start_date AND :end_date";
                $params[':start_date'] = $start;
                $params[':end_date']   = $end;
            }

            $database = parent::openLink($partnerID);

            $query = "
        SELECT 
            COUNT(*) AS num_bet_tickets,
            SUM(bet_amount) AS total_bet_amount,
            SUM(win_amount) AS total_win_amount,
            (
                SELECT SUM(amount)
                FROM user_rebate
                WHERE agent_id=:user_id
                AND game_type_id=:lottery_id
                $dateCondition
            ) AS user_rebate_amount,
            (
                SELECT COUNT(*)
                FROM users_test
                WHERE account_type = 2
            ) AS num_top_agents,
            (
                SELECT SUM(rebate_amount)
                FROM {$betTable}
                WHERE uid =:user_id
                $dateCondition
            ) AS self_rebate_amount,
            (
                SELECT SUM(bet_amount)
                FROM {$betTable}
                WHERE bettype = 1 
                AND state = 1 
                AND uid=:user_id
            ) AS sba
        FROM {$betTable}
        WHERE uid=:user_id
        $dateCondition
    ";

            $results = $database->query($query, $params)->fetch(PDO::FETCH_ASSOC);

            $summed_results[] = $results;
            $num_bet_tickets  = array_sum(array_column($summed_results, 'num_bet_tickets'));
            $total_bet_amount  = array_sum(array_column($summed_results, 'total_bet_amount'));
            $user_rebate_amount = array_sum(array_column($summed_results, 'user_rebate_amount'));
            $self_rebate_amount = array_sum(array_column($summed_results, 'self_rebate_amount'));
            $total_rebate_amount = $user_rebate_amount + $self_rebate_amount;
            $total_win_amount   = array_sum(array_column($summed_results, 'total_win_amount'));

        // Aggregate Results
        $results =  [
            'num_bet_tickets' => self::formatNumber( $num_bet_tickets === null ? 0 : $num_bet_tickets ),
            'total_bet_amount' => self::formatNumber($total_bet_amount === null ? 0 : $total_bet_amount),
            'user_rebate_amount' => self::formatNumber( $user_rebate_amount === null ? 0 : $user_rebate_amount ),
            'self_rebate_amount' => self::formatNumber($self_rebate_amount === null ? 0 : $self_rebate_amount),
            'total_win_amount' => self::formatNumber( $total_win_amount === null ? 0 : $total_win_amount),
            'total_rebate_amount' => self::formatNumber($total_rebate_amount == null ? 0 : $total_rebate_amount),
        ];

        return self::response($results);
    }catch(Exception $e) {

        return self::response(false, "Internval Server Error");
    }
    }


public static function v2($partnerID,$user_id,$bet_tables,$userData):array{

    try{
        $params = [
            ':user_id' => $user_id
        ];
            // Dynamically construct the query without loops
        $betTableConditions = array_map(function($betTable_array) use ($user_id, $userData) {
        $betTable = $betTable_array['bet_table'];
        $lottery_id = $betTable_array['game_type'];

        // Handle date conditions
        $dateCondition = "";
    
        $startDate = $userData['datecreated'];
        $endDate = $userData['enddate'];

        if ($startDate !== "all" && $endDate === "all") {
            $dateCondition = "AND server_date = :start_date";
            $params[':start_date'] = $startDate;
        } elseif ($startDate === "all" && $endDate !== "all") {
            $dateCondition = "AND server_date = :end_date";
            $params[':end_date'] = $endDate;
        } elseif ($startDate !== "all" && $endDate !== "all") {
            $start = min($startDate, $endDate);
            $end = max($startDate, $endDate);
            $dateCondition = "AND server_date BETWEEN :start_date AND :end_date";
            $params[':start_date'] = $start;
            $params[':end_date'] = $end;
        }

        return "
            SELECT 
                '$betTable' AS bet_table_name,
                COUNT(*) AS num_bet_tickets,
                SUM(bet_amount) AS total_bet_amount,
                SUM(win_amount) AS total_win_amount,
                (
                    SELECT SUM(amount) 
                    FROM user_rebate 
                    WHERE agent_id = :user_id 
                    AND game_type_id = $lottery_id 
                    $dateCondition
                ) AS user_rebate_amount,
                (
                    SELECT COUNT(*) 
                    FROM users_test 
                    WHERE account_type = 2
                ) AS num_top_agents,
                (
                    SELECT SUM(rebate_amount) 
                    FROM $betTable 
                    WHERE uid = :user_id 
                    $dateCondition
                ) AS self_rebate_amount,
                (
                    SELECT SUM(bet_amount) 
                    FROM $betTable 
                    WHERE bettype = 1 
                    AND state = 1 
                    AND uid = :user_id
                ) AS sba
            FROM $betTable 
            WHERE uid = :user_id
            $dateCondition
        ";
    }, $bet_tables);

    $query = implode(" UNION ALL ", $betTableConditions);

    $finalQuery = "
        SELECT 
            SUM(num_bet_tickets) AS num_bet_tickets,
            SUM(total_bet_amount) AS total_bet_amount,
            SUM(total_win_amount) AS total_win_amount,
            SUM(user_rebate_amount) AS user_rebate_amount,
            MAX(num_top_agents) AS num_top_agents,
            SUM(self_rebate_amount) AS self_rebate_amount,
            SUM(user_rebate_amount + self_rebate_amount) AS total_rebate_amount
        FROM (
            $query
        ) AS aggregated_results;
    ";

    $database = parent::openLink($partnerID);
    $results = $database->query($finalQuery, $params)->fetch(PDO::FETCH_ASSOC);

    $res =  [
        'num_bet_tickets' => self::formatNumber($results['num_bet_tickets'] == null ? 0 : $results['num_bet_tickets']),
        'total_bet_amount' => self::formatNumber($results['total_bet_amount'] == null ? 0 : $results['total_bet_amount']),
        'user_rebate_amount' => self::formatNumber($results['user_rebate_amount'] == null ? 0 : $results['user_rebate_amount']),
        'num_top_agents' => self::formatNumber($results['num_top_agents'] == null ? 0 : $results['num_top_agents']),
        'self_rebate_amount' => self::formatNumber($results['self_rebate_amount'] == null ? 0 : $results['self_rebate_amount']),
        'total_win_amount' => self::formatNumber($results['total_win_amount'] == null ? 0 : $results['total_win_amount']),
        'total_rebate_amount' => self::formatNumber($results['total_rebate_amount'] == null ? 0 : $results['total_rebate_amount']),
    ];


    return self::response($res);

    }catch(Exception $e){

        return self::response("Internal Server Error.",false);
    }

    }

    public static function filter_total_valid_amount_v2($partnerID,$user_id,$bet_tables,$userData):array{
        try{

            $betTableConditions = array_map(function($betTable_array) use ($user_id, $userData) {
                $betTable = $betTable_array['bet_table'];
        
                $dateConditionSQL = "";
                $queryParams = [":sub_id" => $user_id];
        
                if ($userData['datecreated'] != "all" || $userData['enddate'] != "all") {
                    if ($userData['enddate'] == "all") {
                        $dateConditionSQL = " AND server_date = :datecreated ";
                        $queryParams[':datecreated'] = $userData['datecreated'];
                    } elseif ($userData['datecreated'] == "all") {
                        $dateConditionSQL = " AND server_date = :enddate ";
                        $queryParams[':enddate'] = $userData['enddate'];
                    } else {
                        $dateConditionSQL = " AND server_date BETWEEN :datecreated AND :enddate ";
                        $queryParams[':datecreated'] = min($userData['datecreated'], $userData['enddate']);
                        $queryParams[':enddate'] = max($userData['datecreated'], $userData['enddate']);
                    }
                }
        
                return [
                    "query" => "
                        SELECT 
                            SUM(bet_amount) AS sba, 
                            (
                                SELECT SUM(bet_amount) 
                                FROM {$betTable} 
                                WHERE bettype = 2 AND state = 1 
                                AND uid=:sub_id 
                                {$dateConditionSQL}
                            ) AS tba 
                        FROM {$betTable} 
                        WHERE bettype = 1 AND state = 1 
                        AND uid=:sub_id 
                        {$dateConditionSQL}",
                    "params" => $queryParams
                ];
            }, $bet_tables);
        
            $summedResults = array_map(function($betTableQuery) use ($partnerID) {
                $database = parent::openLink($partnerID);
                $results = $database->query($betTableQuery['query'], $betTableQuery['params'])->fetch(PDO::FETCH_ASSOC);
                return ($results) ? ($results['sba'] + $results['tba']) : 0;
            }, $betTableConditions);

            $results = self::formatNumber(array_sum($summedResults));
            // Aggregate Final Results
            return self::response($results);
        }catch(Exception $e){

            return self::response("Interval Server Error",false);
        }
    }
    public static function filter_total_valid_amount($partnerID,$user_id, $bet_tables, $userData)
    {

        try {

            $summed_results = [];

            $summed_results = [];


            $betTable_array = $bet_tables[0];
            $betTable = $betTable_array['bet_table'];

            $dateConditionSQL = "";
            $queryParams = [":sub_id" => $user_id];

            if ($userData['datecreated'] != "all" || $userData['enddate'] != "all") {
                if ($userData['enddate'] == "all") {
                    $dateConditionSQL = " AND server_date = :datecreated ";
                    $queryParams[':datecreated'] = $userData['datecreated'];
                } elseif ($userData['datecreated'] == "all") {
                    $dateConditionSQL = " AND server_date = :enddate ";
                    $queryParams[':enddate'] = $userData['enddate'];
                } else {
                    $dateConditionSQL = " AND server_date BETWEEN :datecreated AND :enddate ";
                    $queryParams[':datecreated'] = min($userData['datecreated'], $userData['enddate']);
                    $queryParams[':enddate'] = max($userData['datecreated'], $userData['enddate']);
                }
            }

            $database = parent::openLink($partnerID);

           
            // Execute query using Medoo's query method
            $results = $database->query(
                "SELECT SUM(bet_amount) AS sba, ( SELECT SUM(bet_amount) FROM {$betTable} 
                WHERE bettype = 2 AND state = 1 
                AND uid=:sub_id 
                {$dateConditionSQL}
            ) AS tba 
        FROM {$betTable} 
        WHERE bettype = 1 AND state = 1 
        AND uid=:sub_id 
        {$dateConditionSQL}",
                $queryParams
            )->fetch(PDO::FETCH_ASSOC);

            $summed_results[] = ($results) ? ($results['sba'] + $results['tba']) : 0;
        

        // Aggregate Final Results
        return  self::response(self::formatNumber(array_sum($summed_results)));
    } catch (Exception $e) {
        return self::response(false,"Internal Server");
    }


    }

    public static function num_bettors($user_id, $bet_tables, $userData = [])
    {

        try {


            // $bet_tables = BusinessFlow::getAllGameIdsWithCondition();
            $summed_results = [];
            $database = parent::getLink();

            // Initialize query parts
            $queryParts = [];
            $params = [];
            $index = 0;


            foreach ($bet_tables as $bet_table_array) {
                $betTable = $bet_table_array['bet_table'];
                $lottery_id = $bet_table_array['game_type'];

                $params[":sub_id"] = $user_id;
                $whereClause = "uid = :sub_id";

                $sql = "SELECT DISTINCT uid FROM $betTable AS bet_table ";
                $dateConditions = "";
                if (($userData["datecreated"] != "all") || ($userData['enddate'] != "all")) {
                    if (($userData['enddate'] == "all")) {
                        $dateConditions = " bet_table.server_date = :datecreated_$lottery_id ";
                        $params[":datecreated_$lottery_id"] = $userData['datecreated'];
                    } elseif (($userData['datecreated'] == "all")) {
                        $dateConditions = " bet_table.server_date = :enddate_$lottery_id ";
                        $params[":enddate_$lottery_id"] = $userData['enddate'];
                    } else {
                        $dateConditions = " bet_table.server_date BETWEEN :datecreated_$lottery_id AND :enddate_$lottery_id ";
                        $params[":datecreated_$lottery_id"] = min($userData['datecreated'], $userData['enddate']);
                        $params[":enddate_$lottery_id"] = max($userData['datecreated'], $userData['enddate']);
                    }
                }

                $sql .= " WHERE bet_table.state=1 " . (empty($whereClause) ? "" : " AND ($whereClause)") . (empty($dateConditions) ? "" : " AND $dateConditions") . " GROUP BY bet_table.uid ";
                $queryParts[] = $sql;
                $index++;
            }

            $finalQuery = implode(" UNION ", $queryParts);

            $query_res = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

            foreach ($query_res as $row) {
                $summed_results[] = $row->uid;
            }


            return count(array_unique($summed_results));
        } catch (PDOException $m) {

            echo $m->getMessage();
        }
        //  = empty($data) ? 0 : COUNT($data);


    }


    public static function formatNumber($number){
   
    // 1) Format to exactly four decimal places (no thousands separators).
    $formatted = number_format($number, 4, '.', '');
    
    // 2) Remove trailing zeros after the decimal point.
    $formatted = rtrim($formatted, '0');
    
    // 3) If the last character is now just a decimal point, remove it as well.
    $formatted = rtrim($formatted, '.');
    
    return $formatted;
}
    public static function response($data,$type = true) {  return ["status" => $type ? "success" : "error" , "data" => $data];  }

}


