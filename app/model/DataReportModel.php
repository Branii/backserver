<?php


set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

use Medoo\Medoo;

class DataReportModel extends MedooOrm
{


    public static function fetch_users_win_loss_report(int $currentPage = 1,$limit = 10, String $orderColumn = "uid"):array{
      
        try{
        $table_name = "users_test";
        $offset = ($currentPage - 1) * 10;
        $db = parent::getLink();
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

    public static function FiltertLotteryNames($lottery_name = ""): Mixed{

        $res = parent::openLink()->query("SELECT gt_id,name  FROM game_type WHERE name LIKE :search ORDER BY  CASE 
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
public static function filterGetBetTicketsNum($user_id, $bet_tables, $userData)
    {

        try{

        //$bet_tables = BusinessFlow::getAllGameIds();
        $summed_results = [];


        // // Get all sub-user IDs
        // $num_subs = self::allSubs($user_id, 1, 1000);
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

            $database = parent::openLink();

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


public static function v2($user_id,$bet_tables,$userData):array{

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

    $database = parent::openLink();
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

    public static function filter_total_valid_amount_v2($user_id,$bet_tables,$userData):array{
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
        
            $summedResults = array_map(function($betTableQuery) {
                $database = parent::openLink();
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
    public static function filter_total_valid_amount($user_id, $bet_tables, $userData)
    {

        try {
            //  $bet_tables = BusinessFlow::getAllGameIds();
            $summed_results = [];



            // // Get all sub-user IDs
            // $num_subs = self::allSubs($user_id, 1, 1000);
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

            $database = parent::openLink();

           
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

/////-----------------------------------------------------------
// <?php


// set_error_handler(function ($errno, $errstr, $errfile, $errline) {
//     // Throw an Exception with the error message and details
//     throw new \Exception("$errstr in $errfile on line $errline", $errno);
// });

// use Medoo\Medoo;

// class DataReportModel extends MedooOrm
// {











//     public static function fetch_user_hierarchy($user_id)
//     {

//         return parent::openLink()->query(
//             "SELECT agent_level FROM users WHERE uid = :user_id",
//             [
//                 ':user_id' => $user_id
//             ]
//         )->fetch(PDO::FETCH_OBJ);
//     }

//     public static function fetch_user_rel($user_id): array
//     {


//         $agent_level_res = self::fetch_user_hierarchy($user_id)->agent_level ?? "";
//         $unserialized_hierarchy  = unserialize($agent_level_res);
//         $conditions = [];
//         $params = [];

//         foreach ($unserialized_hierarchy as $agent_id => $agent_rebate) {
//             $place_holder = ":uid{$agent_id}";
//             $conditions[] = "uid = $place_holder";
//             $params[$place_holder] = $agent_id;
//         }

//         $sql = "SELECT uid, username FROM users_test WHERE " . implode(" OR ", $conditions);

//         return parent::openLink()->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
//     }

//     public static function getBetTicketsNumForUser($user, $bet_tables = [], $userData): array
//     {


//         $database = parent::getLink();
//         $params = [];
//         $queryParts = [];

//         $user_id = $user->uid;


//         foreach ($bet_tables as $bet_table_array) {
//             $betTable = $bet_table_array['bet_table'];
//             $lottery_id = $bet_table_array['game_type'];
//             $params[":user_id_{$lottery_id}"] = $user_id;

//             // Prepare conditions
//             $conditions = $condition_user_rebate = $condition_self_rebate = "";

//             if (($userData['datecreated'] != "all") || ($userData['enddate'] != "all")) {
//                 if (($userData['enddate'] == "all")) {
//                     $conditions = "bet_table.server_date = :datecreated_{$lottery_id}";
//                     $params[":datecreated_{$lottery_id}"] = $userData['datecreated'];
//                 } elseif (($userData['datecreated'] == "all")) {
//                     $conditions = "bet_table.server_date = :enddate_{$lottery_id}";
//                     $params[":enddate_{$lottery_id}"] = $userData['enddate'];
//                 } else {
//                     $conditions = "bet_table.server_date BETWEEN :datecreated_{$lottery_id} AND :enddate_{$lottery_id}";
//                     $params[":datecreated_{$lottery_id}"] = min($userData['datecreated'], $userData['enddate']);
//                     $params[":enddate_{$lottery_id}"] = max($userData['datecreated'], $userData['enddate']);
//                 }
//             }

//             // Build the SQL query
//             $sql = "SELECT COUNT(*) AS num_bet_tickets, SUM(bet_amount) AS total_bet_amount, SUM(win_amount) AS total_win_amount,
//                     (SELECT SUM(amount) FROM user_rebate WHERE agent_id = :user_id_{$lottery_id} AND game_type_id = {$lottery_id} " .
//                 ($conditions ? " AND $conditions" : "") . ") AS user_rebate_amount,
//                     (SELECT SUM(rebate_amount) FROM $betTable WHERE uid = :user_id_{$lottery_id} " .
//                 ($conditions ? " AND $conditions" : "") . ") AS self_rebate_amount
//                     FROM $betTable AS bet_table WHERE bet_table.uid = :user_id_{$lottery_id}";

//             if ($conditions) {
//                 $sql .= " AND ($conditions)";
//             }

//             $queryParts[] = $sql;
//         }

//         $finalQuery = implode(' UNION ', $queryParts);
//         $data = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

//         // Summing results
//         $summed_results = [
//             'num_bet_tickets' => array_sum(array_column($data, 'num_bet_tickets')),
//             'total_bet_amount' => array_sum(array_column($data, 'total_bet_amount')),
//             'user_rebate_amount' => array_sum(array_column($data, 'user_rebate_amount')),
//             'self_rebate_amount' => array_sum(array_column($data, 'self_rebate_amount')),
//             'total_win_amount' => array_sum(array_column($data, 'total_win_amount'))
//         ];

//         $subs_count      =  self::subs_and_agent_subs_count($user_id);
//         $num_subs        =  $subs_count->sub_count;
//         $agent_sub_count =  $subs_count->agent_sub_count;

//         $view_btn               = $user->account_type == 1 || ($num_subs == 0) ? "" : "<button class='btn tag get-subs-btn' data-bs-target='#' data-bs-toggle='' id=''>Subs</button>";
//         $view_btn               =  $user->account_type == 1 ? "" : "<i class='bx bxs-user-account' style='font-size:20px'></i>";
//         $relationship           =  $user->account_type == 2 ? "<button class='btn tag' > Top Agent </button>" : "<button class='btn tag user-rel'  data-bs-target='#user-rel-modal' data-bs-toggle='modal'> " .  (empty(trim($user->agent_username)) ? "" : ($agent_sub_count == 1 ? "{$user->agent_username}>$user->username" : "{$user->agent_username}>$user->username...")) . " </button>";

//         $total_valid_amount  = self::total_valid_amount_for_user($user_id, $bet_tables, $userData);
//         $total_win_amount    = $summed_results['total_win_amount'];
//         $total_rebate_amount = $summed_results['user_rebate_amount'] + $summed_results['self_rebate_amount'];
//         $win_loss = ($total_valid_amount + $total_rebate_amount) - $total_win_amount;
//         return ['uid' => $user->uid, "username" => $user->username, "account_type" => $user->account_type, "user_rebate" => $user->rebate, 'num_bet_tickets' => $summed_results['num_bet_tickets'], 'total_bet_amount' => $summed_results['total_bet_amount'],   'total_rebate_amount' => $total_rebate_amount, 'total_win_amount' => $total_win_amount, 'total_valid_amount' =>  $total_valid_amount, 'num_bettors' => self::num_bettors_for_user($user_id, $bet_tables, $userData), "rel" => $relationship, 'num_subs' => $num_subs, 'win_loss' => $win_loss, 'view_btn' =>  $view_btn];
//     }

//     public static function filter_total_valid_amount($user_id, $bet_tables, $userData)
//     {

//         try {
//             //  $bet_tables = BusinessFlow::getAllGameIds();
//             $summed_results = [];



//             // // Get all sub-user IDs
//             // $num_subs = self::allSubs($user_id, 1, 1000);
//             $summed_results = [];


//             foreach ($bet_tables as $betTable_array) {
//                 $betTable = $betTable_array['bet_table'];

//                 $dateConditionSQL = "";
//                 $queryParams = [":sub_id" => $user_id];

//                 if ($userData['datecreated'] != "all" || $userData['enddate'] != "all") {
//                     if ($userData['enddate'] == "all") {
//                         $dateConditionSQL = " AND server_date = :datecreated ";
//                         $queryParams[':datecreated'] = $userData['datecreated'];
//                     } elseif ($userData['datecreated'] == "all") {
//                         $dateConditionSQL = " AND server_date = :enddate ";
//                         $queryParams[':enddate'] = $userData['enddate'];
//                     } else {
//                         $dateConditionSQL = " AND server_date BETWEEN :datecreated AND :enddate ";
//                         $queryParams[':datecreated'] = min($userData['datecreated'], $userData['enddate']);
//                         $queryParams[':enddate'] = max($userData['datecreated'], $userData['enddate']);
//                     }
//                 }

//                 $database = parent::openLink();

//                 // Execute query using Medoo's query method
//                 $results = $database->query(
//                     "SELECT 
//                 SUM(bet_amount) AS sba, 
//                 (
//                     SELECT SUM(bet_amount) 
//                     FROM {$betTable} 
//                     WHERE bettype = 2 AND state = 1 
//                     AND uid=:sub_id 
//                     {$dateConditionSQL}
//                 ) AS tba 
//             FROM {$betTable} 
//             WHERE bettype = 1 AND state = 1 
//             AND uid=:sub_id 
//             {$dateConditionSQL}",
//                     $queryParams
//                 )->fetch(PDO::FETCH_ASSOC);

//                 $summed_results[] = ($results) ? ($results['sba'] + $results['tba']) : 0;
//             }

//             // Aggregate Final Results
//             return  array_sum($summed_results);
//         } catch (PDOException $m) {
//         }
//     }

//     public static function num_bettors($user_id, $bet_tables, $userData = [])
//     {

//         try {


//             // $bet_tables = BusinessFlow::getAllGameIdsWithCondition();
//             $summed_results = [];
//             $database = parent::getLink();

//             // Initialize query parts
//             $queryParts = [];
//             $params = [];
//             $index = 0;


//             foreach ($bet_tables as $bet_table_array) {
//                 $betTable = $bet_table_array['bet_table'];
//                 $lottery_id = $bet_table_array['game_type'];

//                 $params[":sub_id"] = $user_id;
//                 $whereClause = "uid = :sub_id";

//                 $sql = "SELECT DISTINCT uid FROM $betTable AS bet_table ";
//                 $dateConditions = "";
//                 if (($userData["datecreated"] != "all") || ($userData['enddate'] != "all")) {
//                     if (($userData['enddate'] == "all")) {
//                         $dateConditions = " bet_table.server_date = :datecreated_$lottery_id ";
//                         $params[":datecreated_$lottery_id"] = $userData['datecreated'];
//                     } elseif (($userData['datecreated'] == "all")) {
//                         $dateConditions = " bet_table.server_date = :enddate_$lottery_id ";
//                         $params[":enddate_$lottery_id"] = $userData['enddate'];
//                     } else {
//                         $dateConditions = " bet_table.server_date BETWEEN :datecreated_$lottery_id AND :enddate_$lottery_id ";
//                         $params[":datecreated_$lottery_id"] = min($userData['datecreated'], $userData['enddate']);
//                         $params[":enddate_$lottery_id"] = max($userData['datecreated'], $userData['enddate']);
//                     }
//                 }

//                 $sql .= " WHERE bet_table.state=1 " . (empty($whereClause) ? "" : " AND ($whereClause)") . (empty($dateConditions) ? "" : " AND $dateConditions") . " GROUP BY bet_table.uid ";
//                 $queryParts[] = $sql;
//                 $index++;
//             }

//             $finalQuery = implode(" UNION ", $queryParts);

//             $query_res = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

//             foreach ($query_res as $row) {
//                 $summed_results[] = $row->uid;
//             }


//             return count(array_unique($summed_results));
//         } catch (PDOException $m) {

//             echo $m->getMessage();
//         }
//         //  = empty($data) ? 0 : COUNT($data);


//     }

//     public static function num_bettors_for_user($user_id, $bet_tables, $userData)
//     {

//         $params = [];
//         $queryParts = [];
//         $database  = parent::getLink();

//         foreach ($bet_tables as $bet_table) {
//             $betTable = $bet_table['bet_table'];
//             $lottery_id = $bet_table['game_type'];
//             $params[":user_id_{$lottery_id}"] = $user_id;

//             $dateConditions = "";

//             if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
//                 if (empty($userData['enddate'])) {
//                     $dateConditions = "bet_table.server_date = :datecreated{$lottery_id}";
//                     $params[":datecreated{$lottery_id}"] = $userData['datecreated'];
//                 } elseif (empty($userData['datecreated'])) {
//                     $dateConditions = "bet_table.server_date = :enddate{$lottery_id}";
//                     $params[":enddate{$lottery_id}"] = $userData['enddate'];
//                 } else {
//                     $dateConditions = "bet_table.server_date BETWEEN :datecreated{$lottery_id} AND :enddate{$lottery_id}";
//                     $params[":datecreated{$lottery_id}"] = min($userData['datecreated'], $userData['enddate']);
//                     $params[":enddate{$lottery_id}"] = max($userData['datecreated'], $userData['enddate']);
//                 }
//             }

//             $sql = "SELECT uid FROM $betTable AS bet_table ";
//             $sql .= " WHERE bet_table.state=1 AND bet_table.uid=:user_id_{$lottery_id} " . ($dateConditions ? " AND $dateConditions" : "") . " GROUP BY bet_table.uid";
//             $queryParts[] = $sql;
//         }

//         $finalQuery = implode(' UNION ', $queryParts);
//         $data = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

//         return count($data) > 0 ? 1 : 0;
//     }

//     public static function total_valid_amount_for_user($user_id, $bet_tables = [], $userData)
//     {

//         try {
//             $params = [];
//             $queryParts = [];
//             $database = parent::getLink();

//             foreach ($bet_tables as $bet_table) {
//                 $betTable = $bet_table['bet_table'];
//                 $lottery_id = $bet_table['game_type'];
//                 $params[":user_id_{$lottery_id}"] = $user_id;

//                 $dateConditions = "";
//                 $inner_date_conditions = "";

//                 if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
//                     if (empty($userData['enddate'])) {
//                         $dateConditions = "bet_table.server_date = :datecreated{$lottery_id}";
//                         $inner_date_conditions = "$betTable.server_date = :datecreated{$lottery_id}";
//                         $params[":datecreated{$lottery_id}"] = $userData['datecreated'];
//                     } elseif (empty($userData['datecreated'])) {
//                         $dateConditions = "bet_table.server_date = :enddate{$lottery_id}";
//                         $inner_date_conditions = "$betTable.server_date = :enddate{$lottery_id}";
//                         $params[":enddate{$lottery_id}"] = $userData['enddate'];
//                     } else {
//                         $dateConditions = "bet_table.server_date BETWEEN :datecreated{$lottery_id} AND :enddate{$lottery_id}";
//                         $inner_date_conditions = "$betTable.server_date BETWEEN :datecreated{$lottery_id} AND :enddate{$lottery_id}";
//                         $params[":datecreated{$lottery_id}"] = min($userData['datecreated'], $userData['enddate']);
//                         $params[":enddate{$lottery_id}"] = max($userData['datecreated'], $userData['enddate']);
//                     }
//                 }

//                 $sql = "SELECT SUM(bet_amount) as sba, 
//                 (SELECT SUM(bet_amount) FROM $betTable WHERE bettype = 2 AND state = 1 AND uid = :user_id_{$lottery_id} " .
//                     ($inner_date_conditions ? " AND $inner_date_conditions" : "") . ") AS tba 
//                 FROM $betTable AS bet_table ";

//                 $sql .= " WHERE bet_table.bettype = 1 AND bet_table.state = 1 AND bet_table.uid = :user_id_{$lottery_id} " .
//                     ($dateConditions ? " AND $dateConditions" : "");

//                 $queryParts[] = $sql;
//             }

//             $finalQuery = implode(' UNION ', $queryParts);
//             $data = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

//             return array_sum(array_column($data, 'sba')) + array_sum(array_column($data, 'tba'));
//         } catch (PDOException $m) {
//         }
//     }



//     

// }
