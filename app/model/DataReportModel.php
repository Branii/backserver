<?php

Use Medoo\Medoo;
class DataReportModel extends MedooOrm {


     public static function FiltertLotteryNames($lottery_name = ""): Mixed
    {

    $res = parent::openLink()->query("SELECT gt_id,name  FROM game_type WHERE name LIKE :search ORDER BY  CASE 
                WHEN name LIKE :startsWith THEN 1  -- Prioritize lottery names that start with the search term
                ELSE 2                                -- Other matches come next
                END, lottery_type ASC LIMIT 50", [
            'search' => "%$lottery_name%",       // Matches usernames containing the search term
            'startsWith' => "$lottery_name%"     // Prioritizes usernames starting with the search term
        ])->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }


    public static function allSubs($agent_id,$currentPage = 1, $recordsPerPage = 10)
    {
         $offset = ($currentPage - 1) * $recordsPerPage;

    // Execute query using Medoo's query method with pagination
    return parent::getLink()->query(
        "SELECT * FROM users_test 
         WHERE users_test.agent_id = :agent_id 
         ORDER BY users_test.uid DESC 
         LIMIT :offset, :recordsPerPage",
        [
            ':agent_id' => $agent_id,
            ':offset' => $offset,
            ':recordsPerPage' => $recordsPerPage
        ]
    )->fetchAll(PDO::FETCH_OBJ);
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

     //SECTION user ranking model

    public static function FetchRecords(string $tableName, int $currentPage, int $recordsPerPage, string $tblid): array
    {
        $offset = ($currentPage - 1) * $recordsPerPage;
        $sql = "SELECT $tableName.*, users_test.username,users_test.account_type FROM  $tableName  JOIN users_test ON users_test.uid = $tableName.user_id  ORDER BY $tblid DESC LIMIT :offset, :limit";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }


    # //SECTION user ranking end model


    # //!SECTION play stattistis model
    public static function fetchPlayStatistics(string $tableName, int $currentPage, int $recordsPerPage, string $tblid): array
    {
        $offset = ($currentPage - 1) * $recordsPerPage;
        $sql    = "SELECT $tableName.bet_table,game_type.name FROM  $tableName  JOIN game_type ON $tableName.game_type = game_type.gt_id   ORDER BY $tblid DESC LIMIT :offset, :limit";
        $stmt   = self::openConnection("lottery")->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    // get all the statistic
    public static function getStatistics($table_name)
    {
        $sql  = "SELECT  COUNT(DISTINCT uid) AS num_persons, SUM(bet_number) AS num_tickets,SUM(bet_amount) AS amount, SUM(balance_before) AS balance_before,SUM(balance_after) AS balance_after, CAST(SUM(balance_after - balance_before) AS DECIMAL) AS profit_and_loss FROM  $table_name";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data[0];
    }

    # //!SECTION play stattistis model


    //# //!SECTION operational model

    public static function fetchOperationData(string $tableName, int $currentPage, int $recordsPerPage, string $tblid): array
    {
        $offset = ($currentPage - 1) * $recordsPerPage;
        //   $sql    = "SELECT $tableName.bet_table,game_type.name FROM  $tableName  JOIN game_type ON $tableName.game_type = game_type.gt_id   ORDER BY $tblid DESC LIMIT :offset, :limit";
        $sql = "SELECT $tableName.*, users_test.username,users_test.account_type FROM  $tableName  JOIN users_test ON users_test.uid = $tableName.user_id  ORDER BY $tblid DESC LIMIT :offset, :limit";
        $stmt   = self::openConnection("lottery")->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }


    //# //SECTION operational model

    //# //SECTION win and lost report

    public static function fetchWinLossData(string $tableName, int $currentPage, int $recordsPerPage, string $tblid): array
    {
        $offset = ($currentPage - 1) * $recordsPerPage;
        //   $sql    = "SELECT $tableName.bet_table,game_type.name FROM  $tableName  JOIN game_type ON $tableName.game_type = game_type.gt_id   ORDER BY $tblid DESC LIMIT :offset, :limit";
        $sql = "SELECT * FROM $tableName ORDER BY $tblid  DESC LIMIT :offset, :limit";
        $stmt   = self::openConnection("lottery")->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public static function fetch_users_for_win_loss_report(int $currentPage, int $recordsPerPage, string $tblid): array
    {
        $offset = ($currentPage - 1) * $recordsPerPage;
        //   $sql    = "SELECT $tableName.bet_table,game_type.name FROM  $tableName  JOIN game_type ON $tableName.game_type = game_type.gt_id   ORDER BY $tblid DESC LIMIT :offset, :limit";
        $sql = "SELECT * , (SELECT COUNT(*) FROM users_test AS sub WHERE sub.agent = users_test.agent) AS agent_sub_count, (SELECT COUNT(*) FROM users_test AS sub WHERE sub.agent = users_test.uid) AS sub_count, (SELECT sub.username FROM users_test AS sub WHERE sub.uid = users_test.agent) AS agent_username FROM users_test ORDER BY $tblid  DESC LIMIT :offset, :limit";
        $stmt   = self::openConnection("lottery")->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public static function filter_fetch_users_for_win_loss_report($usersData, int $currentPage = 1, int $recordsPerPage = 10, string $tblid = "uid")
    {
      
        $table_name = "users_test";
        $uids_placeholders = [];
        foreach ($usersData as $key => $userData) {
            $uids_placeholders[":uid$key"] = is_object($userData) ? $userData->uid : $userData;
        }
        
       
         $placeholders = implode(',',array_keys($uids_placeholders));
         $service = parent::getLink();
       
         return  $service->query("SELECT {$table_name}.*, 
        (SELECT COUNT(*) FROM {$table_name} AS sub WHERE sub.agent_id = {$table_name}.agent_id) AS agent_sub_count, 
        (SELECT COUNT(*) FROM {$table_name} AS sub WHERE sub.agent_id = {$table_name}.uid) AS sub_count, 
        (SELECT sub.username FROM {$table_name} AS sub WHERE sub.uid = {$table_name}.agent_id) AS agent_username 
    FROM {$table_name} 
    WHERE uid IN ($placeholders)
    ORDER BY $tblid DESC",
    $uids_placeholders)->fetchAll(PDO::FETCH_OBJ);
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
        $params = [':offset' => intval($offset),':recordsPerPage' => intval($recordsPerPage)];

        // Execute query using Medoo's query method
        $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
        return $data;

    }

    public static function subs_and_agent_subs_count($user_id,$currentPage = 1, $recordsPerPage = 10,$tblid = 'uid'): mixed
    {

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



    public static function TotalBetStake($userid, $betable)
    {
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        // $total_bet_stake = [];
        // foreach ((new Helper)::getGameTableMap() as $betTable){
        //     $sql = "SELECT  Count(*) AS numberbet FROM  {$betTable['bet_table']} WHERE uid = :uid";
        //     $stmt = self::openConnection("lottery")->prepare($sql);
        //     $stmt->execute([":uid" => $userid]);
        //     $total_bet_stake[] = $stmt->fetch(PDO::FETCH_OBJ)->numberbet;
        // }
        // return array_sum($total_bet_stake);
        $sql = "SELECT  Count(*) AS numberbet FROM  $betTable WHERE uid = :uid";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute([":uid" => $userid]);
        $data = $stmt->fetch(PDO::FETCH_OBJ)->numberbet;
        return $data ?? 0;
    }
    public static function getBetTicketsNum($user_id, $bet_tables = []): array
    {


        $db = self::openConnection("lottery");
        $summed_results = [];
        // Get all sub-user IDs for the current user
        $query_data = AgentDataAnalysis::allSubs($user_id);
        $params[":sub_id0"] = $user_id;  // Include the main user ID as the first placeholder
        $conditions[] = "bet_table.uid = :sub_id0";  // Initial condition for the main user

        // Iterate over the sub-users_test and add to placeholders and parameters
        foreach ($query_data as $index => $sub) {
            $place_holder = ":sub_id" . ($index + 1);  // Create unique placeholders (e.g., :sub_id1, :sub_id2, etc.)
            $params[$place_holder] = $sub->uid;         // Map the placeholder to the sub-user ID
            $conditions[] = "bet_table.uid = $place_holder";  // Build the OR condition dynamically
        }
        foreach ($bet_tables as $betTable) {
            try {
                $betTable = $betTable['bet_table'];
                // $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];  // Mapping the bet table based on the lottery type
                // return $userData;
                // Start building the SQL query
                $sql = "SELECT COUNT(*) as num_bet_tickets, SUM(bet_amount) AS total_bet_amount,  SUM(win_amount) AS total_win_amount, 
                            (SELECT  COUNT(*) as total_lost_tickets FROM  $betTable WHERE $betTable.state=3) AS total_lost_amount,
                            (SELECT COUNT(*) FROM users_test WHERE account_type=2) AS num_top_agents,
                            (SELECT SUM(amount) FROM user_rebate  WHERE agent_id = $user_id) AS user_rebate_amount, (SELECT SUM(rebate_amount) FROM $betTable WHERE uid = $user_id) AS self_rebate_amount  FROM $betTable AS bet_table ";



                // Create the WHERE clause using OR for all user IDs
                $whereClause = implode(" OR ", $conditions);

                // Additional conditions based on date range
                $dateConditions = [];

                // Combine the WHERE clause and date conditions
                $sql .= " WHERE ({$whereClause})";  // Wrap OR conditions in parentheses
                if (!empty($dateConditions)) {
                    $sql .= " AND " . implode(' AND ', $dateConditions);
                }
                $stmt = $db->prepare($sql);
                $stmt->execute($params);

                // Fetch the results as an array of objects
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                $summed_results['num_bet_tickets'][]      = empty($data->num_bet_tickets) ? 0 : $data->num_bet_tickets;
                $summed_results['total_bet_amount'][]     = empty($data->total_bet_amount) ? 0 : $data->total_bet_amount;
                $summed_results['user_rebate_amount']     = empty($data->user_rebate_amount) ? 0 : $data->user_rebate_amount;
                $summed_results['num_top_agents']         = empty($data->num_top_agents) ? 0 : $data->num_top_agents;
                $summed_results['self_rebate_amount'][]   = empty($data->self_rebate_amount) ? 0 : $data->self_rebate_amount;
                $summed_results['total_win_amount'][]     = empty($data->total_win_amount) ? 0 : $data->total_win_amount;
            } catch (PDOException $e) {
            }
        }
        return ['num_bet_tickets' => array_sum($summed_results['num_bet_tickets']), 'total_bet_amount' => array_sum($summed_results['total_bet_amount']), 'total_rebate_amount' => $summed_results['user_rebate_amount'] + array_sum($summed_results['self_rebate_amount']), 'total_win_amount' => array_sum($summed_results['total_win_amount']), 'num_subs' => count($query_data), 'num_top_agents' => $summed_results['num_top_agents']];

        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $query_data = AgentDataAnalysis::allSubs($user_id);
        $pdo_params[":sub_id0"] = $user_id;
        $placeholders[] = ":sub_id0";
        foreach ($query_data as $index => $sub) {

            $place_holder = ":sub_id" . ($index + 1);
            $placeholders[] = $place_holder;
            $pdo_params[$place_holder] = $sub->uid;
        }

        // Create the WHERE clause dynamically
        $whereClause = " uid = ";
        $whereClause .= implode(" OR ", $placeholders);
        // $total_bet_stake = [];
        // foreach ((new Helper)::getGameTableMap() as $betTable){
        //     $sql = "SELECT  Count(*) AS numberbet FROM  {$betTable['bet_table']} WHERE uid = :uid";
        //     $stmt = self::openConnection("lottery")->prepare($sql);
        //     $stmt->execute([":uid" => $userid]);
        //     $total_bet_stake[] = $stmt->fetch(PDO::FETCH_OBJ)->numberbet;
        // }
        // return array_sum($total_bet_stake);
        $sql = "SELECT  COUNT(*) as num_bet_tickets, SUM(bet_amount) AS total_bet_amount,SUM(win_amount) AS total_win_amount , SUM(rebate_amount) AS total_rebate_amount FROM  $betTable WHERE {$whereClause}";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->execute($pdo_params);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public static function fetch_user_hierarchy($user_id)
    {

        return parent::openLink()->query(
        "SELECT agent_level FROM users WHERE uid = :user_id",
        [
            ':user_id' => $user_id
        ]
    )->fetch(PDO::FETCH_OBJ);
    }

    public static function fetch_user_rel($user_id): array
    {


        $agent_level_res = self::fetch_user_hierarchy($user_id)->agent_level ?? "";
        $unserialized_hierarchy  = unserialize($agent_level_res);
        $conditions = [];
        $params = [];

        foreach ($unserialized_hierarchy as $agent_id => $agent_rebate) {
            $place_holder = ":uid{$agent_id}";
            $conditions[] = "uid = $place_holder";
            $params[$place_holder] = $agent_id;
        }

        $sql = "SELECT uid, username FROM users_test WHERE " . implode(" OR ", $conditions);

    return parent::openLink()->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getBetTicketsNumForTeam($users_data, $bet_tables = [], $userData): array
    {


        $db = self::openConnection("lottery");
        $final_results = [];
        $params = [];
        // Iterate over the sub-users_test and add to placeholders and parameters
        foreach ($users_data as $user) {
            $user_id = $user->uid;
            $summed_results = [];

            foreach ($bet_tables as $bet_table_array) {
                try {
                    $betTable   = $bet_table_array['bet_table'];
                    $lottery_id = $bet_table_array['game_type'];

                    if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
                        // echo "Entered here...."
                        if (empty($userData['enddate'])) {
                            $conditions                =  " bet_table.server_date = :datecreated ";
                            $params[":datecreated"]    = $userData['datecreated'];
                        } else if (empty($userData['datecreated'])) {
                            $conditions             = " bet_table.server_date = :enddate ";
                            $condition_user_rebate    = " user_rebate.date_created = :enddate ";
                            $condition_self_rebate  = " $betTable.server_date = :enddate ";
                            $top_agents_conditions  = " users_test.date_created = :enddate ";

                            $params[":enddate"] = $userData['enddate'];
                        } else {

                            $conditions =  " bet_table.server_date BETWEEN :datecreated AND :enddate ";
                            $condition_user_rebate =  " user_rebate.date_created BETWEEN :datecreated AND :enddate ";
                            $condition_self_rebate =  " $betTable.server_date BETWEEN :datecreated AND :enddate ";
                            $top_agents_conditions =  " users_test.date_created BETWEEN :datecreated AND :enddate ";
                            $params[":datecreated"] = $userData['datecreated'] < $userData['enddate'] ? $userData['datecreated'] : $userData['enddate'];
                            $params[":enddate"]     = $userData['enddate'] > $userData['datecreated'] ? $userData['enddate']   : $userData['datecreated'];
                        }
                    }

                    // Start building the SQL query
                    $sql = "SELECT COUNT(*) as num_bet_tickets, SUM(bet_amount) AS total_bet_amount,  SUM(win_amount) AS total_win_amount,
                            (SELECT SUM(amount) FROM user_rebate  WHERE agent_id = $user_id) AS user_rebate_amount, (SELECT SUM(rebate_amount) FROM $betTable WHERE uid = $user_id) AS self_rebate_amount  FROM $betTable AS bet_table WHERE bet_table.uid=$user_id";

                    $sql = "SELECT  COUNT(*) as num_bet_tickets, SUM(bet_amount) AS total_bet_amount,  SUM(win_amount) AS total_win_amount, 
                            (SELECT SUM(amount) FROM user_rebate  WHERE agent_id = $user_id AND lottery_id={$lottery_id} " . (empty($condition_user_rebate)  ? "" : " AND {$condition_user_rebate} ") . ") AS user_rebate_amount, (SELECT COUNT(*) FROM users_test WHERE account_type=2 " . (empty($top_agents_conditions)  ? "" : " AND {$top_agents_conditions} ") . ") AS num_top_agents, (SELECT SUM(rebate_amount) FROM $betTable  WHERE uid= $user_id " . (empty($condition_self_rebate)  ? "" : " AND {$condition_self_rebate}") . ") AS self_rebate_amount  FROM $betTable AS bet_table ";

                    // Combine the WHERE clause and date conditions
                    $sql .= " WHERE uid={$user_id} ";  // Wrap OR conditions in parentheses
                    if (!empty($conditions)) {
                        $sql .= " AND ({$conditions})";
                    }

                    $stmt = $db->prepare($sql);
                    $stmt->execute($params);

                    // Fetch the results as an array of objects
                    $data = $stmt->fetch(PDO::FETCH_OBJ);
                    $summed_results['num_bet_tickets'][]      = empty($data->num_bet_tickets)    ? 0 : $data->num_bet_tickets;
                    $summed_results['total_bet_amount'][]     = empty($data->total_bet_amount)   ? 0 : $data->total_bet_amount;
                    $summed_results['user_rebate_amount'][]   = empty($data->user_rebate_amount) ? 0 : $data->user_rebate_amount;
                    $summed_results['self_rebate_amount'][]   = empty($data->self_rebate_amount) ? 0 : $data->self_rebate_amount;
                    $summed_results['total_win_amount'][]     = empty($data->total_win_amount)   ? 0 : $data->total_win_amount;
                } catch (PDOException $m) {
                }
            }
            $final_results["user_{$user_id}"] = ["username" => $user->username, "account_type" => $user->account_type, "rebate" => $user->rebate, 'num_bet_tickets' => array_sum($summed_results['num_bet_tickets']), 'total_bet_amount' => array_sum($summed_results['total_bet_amount']),   'total_rebate_amount' => array_sum($summed_results['user_rebate_amount']) + array_sum($summed_results['self_rebate_amount']), 'total_win_amount' => array_sum($summed_results['total_win_amount']), 'total_valid_amount' => self::total_valid_amount_for_user($user_id, $bet_tables, $userData), 'num_bettors' => self::num_bettors_for_user($user_id, $bet_tables, $userData), "rel" => self::num_parent_and_parent_subs($user_id), 'num_subs' => count(AgentDataAnalysis::allSubs($user_id))];
        }
        return $final_results;

        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $query_data = AgentDataAnalysis::allSubs($user_id);
        $pdo_params[":sub_id0"] = $user_id;
        $placeholders[] = ":sub_id0";
        foreach ($query_data as $index => $sub) {

            $place_holder = ":sub_id" . ($index + 1);
            $placeholders[] = $place_holder;
            $pdo_params[$place_holder] = $sub->uid;
        }

        // Create the WHERE clause dynamically
        $whereClause = " uid = ";
        $whereClause .= implode(" OR ", $placeholders);
        // $total_bet_stake = [];
        // foreach ((new Helper)::getGameTableMap() as $betTable){
        //     $sql = "SELECT  Count(*) AS numberbet FROM  {$betTable['bet_table']} WHERE uid = :uid";
        //     $stmt = self::openConnection("lottery")->prepare($sql);
        //     $stmt->execute([":uid" => $userid]);
        //     $total_bet_stake[] = $stmt->fetch(PDO::FETCH_OBJ)->numberbet;
        // }
        // return array_sum($total_bet_stake);
        $sql = "SELECT  COUNT(*) as num_bet_tickets, SUM(bet_amount) AS total_bet_amount,SUM(win_amount) AS total_win_amount , SUM(rebate_amount) AS total_rebate_amount FROM  $betTable WHERE {$whereClause}";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->execute($pdo_params);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
    }
    public static function getBetTicketsNumForUser($user, $bet_tables = [], $userData): array
    {


            $database = parent::getLink();
            $params = [];
            $queryParts = [];

            $user_id = $user->uid;

           
            foreach ($bet_tables as $bet_table_array) {
                $betTable = $bet_table_array['bet_table'];
                $lottery_id = $bet_table_array['game_type'];
                $params[":user_id_{$lottery_id}"] = $user_id;

                // Prepare conditions
                $conditions = $condition_user_rebate = $condition_self_rebate = "";

                if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
                    if (empty($userData['enddate'])) {
                        $conditions = "bet_table.server_date = :datecreated_{$lottery_id}";
                        $params[":datecreated_{$lottery_id}"] = $userData['datecreated'];
                    } elseif (empty($userData['datecreated'])) {
                        $conditions = "bet_table.server_date = :enddate_{$lottery_id}";
                        $params[":enddate_{$lottery_id}"] = $userData['enddate'];
                    } else {
                        $conditions = "bet_table.server_date BETWEEN :datecreated_{$lottery_id} AND :enddate_{$lottery_id}";
                        $params[":datecreated_{$lottery_id}"] = min($userData['datecreated'], $userData['enddate']);
                        $params[":enddate_{$lottery_id}"] = max($userData['datecreated'], $userData['enddate']);
                    }
                }

                // Build the SQL query
                $sql = "SELECT COUNT(*) AS num_bet_tickets, SUM(bet_amount) AS total_bet_amount, SUM(win_amount) AS total_win_amount,
                    (SELECT SUM(amount) FROM user_rebate WHERE agent_id = :user_id_{$lottery_id} AND game_type_id = {$lottery_id} " .
                    ($conditions ? " AND $conditions" : "") . ") AS user_rebate_amount,
                    (SELECT SUM(rebate_amount) FROM $betTable WHERE uid = :user_id_{$lottery_id} " .
                    ($conditions ? " AND $conditions" : "") . ") AS self_rebate_amount
                    FROM $betTable AS bet_table WHERE bet_table.uid = :user_id_{$lottery_id}";

                if ($conditions) {
                    $sql .= " AND ($conditions)";
                }

                $queryParts[] = $sql;
            }

            $finalQuery = implode(' UNION ', $queryParts);
            $data = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

            // Summing results
            $summed_results = [
                'num_bet_tickets' => array_sum(array_column($data, 'num_bet_tickets')),
                'total_bet_amount' => array_sum(array_column($data, 'total_bet_amount')),
                'user_rebate_amount' => array_sum(array_column($data, 'user_rebate_amount')),
                'self_rebate_amount' => array_sum(array_column($data, 'self_rebate_amount')),
                'total_win_amount' => array_sum(array_column($data, 'total_win_amount'))
            ];

            // $total_valid_amount = self::total_valid_amount_for_user($user_id, $bet_tables, $userData);
            // $total_rebate_amount = $summed_results['user_rebate_amount'] + $summed_results['self_rebate_amount'];
            // $win_loss = ($total_valid_amount + $total_rebate_amount) - $summed_results['total_win_amount'];

            

        $subs_count      =  self::subs_and_agent_subs_count($user_id);
        $num_subs        =  $subs_count->sub_count;
        $agent_sub_count =  $subs_count->agent_sub_count;
       
        $view_btn               = $user->account_type == 1 || ($num_subs == 0) ? "" : "<button class='btn tag get-subs-btn' data-bs-target='#' data-bs-toggle='' id=''>Subs</button>";
        $view_btn               =  $user->account_type == 1 ? "" : "<i class='bx bxs-user-account' style='font-size:20px'></i>";
        $relationship           =  $user->account_type == 2 ? "<button class='btn tag' > Top Agent </button>" : "<button class='btn tag user-rel'  data-bs-target='#user-rel-modal' data-bs-toggle='modal'> " .  (empty(trim($user->agent_username)) ? "" : ($agent_sub_count == 1 ? "{$user->agent_username}>$user->username" : "{$user->agent_username}>$user->username...")) . " </button>";

        $total_valid_amount  = self::total_valid_amount_for_user($user_id, $bet_tables, $userData);
        $total_win_amount    = $summed_results['total_win_amount'];
        $total_rebate_amount = $summed_results['user_rebate_amount'] + $summed_results['self_rebate_amount'];
        $win_loss = ($total_valid_amount + $total_rebate_amount) - $total_win_amount;
        return ['uid' => $user->uid, "username" => $user->username, "account_type" => $user->account_type, "user_rebate" => $user->rebate, 'num_bet_tickets' => $summed_results['num_bet_tickets'], 'total_bet_amount' => $summed_results['total_bet_amount'],   'total_rebate_amount' => $total_rebate_amount, 'total_win_amount' => $total_win_amount, 'total_valid_amount' =>  $total_valid_amount, 'num_bettors' => self::num_bettors_for_user($user_id, $bet_tables, $userData), "rel" => $relationship, 'num_subs' => $num_subs, 'win_loss' => $win_loss, 'view_btn' =>  $view_btn  ];

        // return [
        //         'uid' => $user->uid,
        //         'username' => $user->username,
        //         'account_type' => $user->account_type,
        //         'user_rebate' => $user->rebate,
        //         'num_bet_tickets' => $summed_results['num_bet_tickets'],
        //         'total_bet_amount' => $summed_results['total_bet_amount'],
        //         'total_rebate_amount' => $total_rebate_amount,
        //         'total_win_amount' => $summed_results['total_win_amount'],
        //         'total_valid_amount' => $total_valid_amount,
        //         'win_loss' => $win_loss
        //     ];
    
    }

    public static function num_parent_and_parent_subs($user_id)
    {


        $sql = "SELECT  username,  (SELECT agent_username FROM users_test WHERE users_test.uid = $user_id) AS agent_username, (SELECT agent FROM users_test WHERE users_test.uid = $user_id) AS agent, (SELECT COUNT(*) FROM users_test WHERE users_test.agent = (SELECT agent FROM users_test WHERE users_test.uid = $user_id)) AS num_parent_subs FROM users_test";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        self::free_resources($stmt);
        return $data;
    }

    public static function filterGetBetTicketsNum($user_id, $bet_tables, $userData)
    {


       
     
        
        //$bet_tables = BusinessFlow::getAllGameIds();
        $summed_results = [];
       
                
        // Get all sub-user IDs
        $num_subs = self::allSubs($user_id,1,1000);
        $summed_results = [];
        $params = [];
foreach ($bet_tables as $betTable_array) {
    $betTable = $betTable_array['bet_table'];
    $lottery_id = $betTable_array['game_type'];

    // Prepare sub_ids
    $sub_ids = array_map(fn($sub) => $sub->uid, $num_subs);
    array_unshift($sub_ids, $user_id);
    $sub_ids_list = implode(',', array_map('intval', $sub_ids)); // Ensure integers only

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
            :betTable AS bet_table_name,
            COUNT(*) AS num_bet_tickets,
            SUM(bet_amount) AS total_bet_amount,
            SUM(win_amount) AS total_win_amount,
            (
                SELECT SUM(amount)
                FROM user_rebate
                WHERE agent_id = :user_id
                AND game_type_id = :lottery_id
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
                WHERE uid = :user_id
                $dateCondition
            ) AS self_rebate_amount,
            (
                SELECT SUM(bet_amount)
                FROM {$betTable}
                WHERE bettype = 1 
                AND state = 1 
                AND uid IN ($sub_ids_list)
            ) AS sba
        FROM {$betTable}
        WHERE uid IN ($sub_ids_list)
        $dateCondition
    ";

    $results = $database->query($query, $params)->fetch(PDO::FETCH_ASSOC);

    $summed_results[] = $results;
}





// return $summed_results;
      
    // Aggregate Results
    return  [
        'num_bet_tickets' => array_sum(array_column($summed_results, 'num_bet_tickets')),
        'total_bet_amount' => array_sum(array_column($summed_results, 'total_bet_amount')),
        'user_rebate_amount' => array_sum(array_column($summed_results, 'user_rebate_amount')),
        'num_top_agents' => max(array_column($summed_results, 'num_top_agents')),
        'self_rebate_amount' => array_sum(array_column($summed_results, 'self_rebate_amount')),
        'total_win_amount' => array_sum(array_column($summed_results, 'total_win_amount')),
        'total_rebate_amount' => array_sum(array_column($summed_results, 'user_rebate_amount')) + array_sum(array_column($summed_results, 'self_rebate_amount')),
        'num_subs' => count($num_subs)
    ];


    }
    public static function filter_total_valid_amount($user_id, $bet_tables, $userData)
    {

      try{
        //  $bet_tables = BusinessFlow::getAllGameIds();
        $summed_results = [];

             

        // Get all sub-user IDs
$num_subs = self::allSubs($user_id,1,1000);
$summed_results = [];


foreach ($bet_tables as $betTable_array) {
    $betTable = $betTable_array['bet_table'];
    $lottery_id = $betTable_array['game_type'];

    $sub_ids = array_map(fn($sub) => $sub->uid, $num_subs);
    array_unshift($sub_ids, $user_id);

    $whereClause = ["uid" => $sub_ids];

    $dateConditionSQL = "";
    $queryParams = [":sub_ids" => implode(',', $sub_ids)];

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
        "SELECT 
            SUM(bet_amount) AS sba, 
            (
                SELECT SUM(bet_amount) 
                FROM {$betTable} 
                WHERE bettype = 2 AND state = 1 
                AND uid IN (:sub_ids) 
                {$dateConditionSQL}
            ) AS tba 
        FROM {$betTable} 
        WHERE bettype = 1 AND state = 1 
        AND uid IN (:sub_ids) 
        {$dateConditionSQL}",
        $queryParams
    )->fetch(PDO::FETCH_ASSOC);

    $summed_results[] = ($results) ? ($results['sba'] + $results['tba']) : 0;
}

           // Aggregate Final Results
            return  array_sum($summed_results);
            } catch (PDOException $m) {

            }
          
      
    }
    public static function filter_total_valid_amount_update($user_id, $bet_tables, $userData)
    {

        $db = self::openConnection("lottery");
        //  $bet_tables = BusinessFlow::getAllGameIds();
        $summed_results = [];

        // Get all sub-user IDs for the current user
        // Get all sub-user IDs for the current user
        $query_data = AgentDataAnalysis::allSubs($user_id,);
        $params[":sub_id0"] = $user_id;  // Include the main user ID as the first placeholder
        $params[':bettype'] = 1;
        $params[':state'] = 1;
        $conditions[] = "uid = :sub_id0";  // Initial condition for the main user

        // Iterate over the sub-users_test and add to placeholders and parameters
        foreach ($query_data as $index => $sub) {
            $place_holder = ":sub_id" . ($index + 1);  // Create unique placeholders (e.g., :sub_id1, :sub_id2, etc.)
            $params[$place_holder] = $sub->uid;         // Map the placeholder to the sub-user ID
            $conditions[] = "uid = $place_holder";  // Build the OR condition dynamically
        }

        foreach ($bet_tables as $betTable) {
            try {
                $betTable = $betTable['bet_table'];

                // Create the WHERE clause using OR for all user IDs
                $whereClause = implode(" OR ", $conditions);

                // Additional conditions based on date range
                $dateConditions = "";
                $innerDateConditions = "";
                // if (!empty($userData['datecreated']) && !empty($userData['enddate'])) {
                //     $dateConditions[] = " bet_table.server_date BETWEEN :datecreated AND :enddate ";
                //     $params[":datecreated"] = $userData['datecreated'];
                //     $params[":enddate"]     = $userData['enddate'];
                // }
                if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
                    // echo "Entered here...."
                    if (empty($userData['enddate'])) {
                        $dateConditions             =  " bet_table.server_date = :datecreated ";
                        $innerDateConditions        =  " server_date = :datecreated ";
                        $params[":datecreated"]     = $userData['datecreated'];
                    } else if (empty($userData['datecreated'])) {
                        $dateConditions             = " bet_table.server_date = :enddate ";
                        $innerDateConditions        = " server_date = :enddate ";
                        $params[":enddate"] = $userData['enddate'];
                    } else {

                        $dateConditions        =  " bet_table.server_date BETWEEN :datecreated AND :enddate ";
                        $innerDateConditions   =  " server_date BETWEEN :datecreated AND :enddate ";
                        $params[":datecreated"] = $userData['datecreated'] < $userData['enddate'] ? $userData['datecreated'] : $userData['enddate'];
                        $params[":enddate"]     = $userData['enddate'] > $userData['datecreated'] ? $userData['enddate']   : $userData['datecreated'];
                    }
                }

                $sql = "SELECT SUM(bet_amount) as sba,(SELECT SUM(bet_amount) AS tba FROM $betTable  WHERE bettype = 2 AND state = 1 " . (empty($whereClause) ? "" : " AND ({$whereClause}) ") . (empty($innerDateConditions) ? " " : " AND " . $innerDateConditions) . " ) AS tba FROM $betTable AS bet_table ";

                // Combine the WHERE clause and date conditions
                $sql .= " WHERE bet_table.bettype=:bettype AND bet_table.state=:state " . (empty($whereClause) ? " " : " AND ({$whereClause}) ") . (empty($dateConditions) ? " " : " AND {$dateConditions} ");  // Wrap OR 


                // SELECT SUM(bet_amount) as sba,(SELECT SUM(bet_amount) AS tba FROM bt_royal5draw WHERE bettype = 2 AND bt_royal5draw.state = 1  AND (uid = 323 OR uid =327)  AND  bet_table.server_date BETWEEN '2022-01-23' AND '2024-10-25'  ) AS tba FROM bt_royal5draw AS bet_table  WHERE bet_table.bettype=1 AND bet_table.state=1  AND (uid = 323 OR uid =327)  AND  bet_table.server_date BETWEEN '2022-01-23' AND '2024-10-25'
                // echo $sql;
                //conditions in parentheses
                // if (!empty($dateConditions)) {
                //     $sql .= " AND " . implode(' AND ', $dateConditions);
                // }

                // Prepare and execute the statement
                $stmt = $db->prepare($sql);
                $stmt->execute($params);

                // Fetch the results as an array of objects
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                $summed_results[]  = ($data) ? ($data->sba + $data->tba) : 0;
            } catch (PDOException $m) {
            }
        }
        return array_sum($summed_results);
    }




    public static function allSubsWithoutConds($agent_id, $userData, int $currentPage = 1, int $recordsPerPage = 10, string $tblid = "uid")
    {

        $offset = ($currentPage - 1) * $recordsPerPage;
        $sql = "SELECT * FROM users_test ";
        $conditions = "";
        $params     = [];

        if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
            if (empty($userData['enddate'])) {
                $conditions =  " users_test.date_created = :datecreated ";
                $params[":datecreated"] = $userData['datecreated'];
            } else if (empty($userData['datecreated'])) {
                $conditions = " users_test.date_created = :enddate ";
                $params[":enddate"] = $userData['enddate'];
            } else {

                $conditions =  " users_test.date_created BETWEEN :datecreated AND :enddate ";
                $params[":datecreated"] = $userData['datecreated'] < $userData['enddate'] ? $userData['datecreated'] : $userData['enddate'];
                $params[":enddate"]     = $userData['enddate'] > $userData['datecreated'] ? $userData['enddate']   : $userData['datecreated'];
            }
        }

        $sql .= " WHERE users_test.agent = $agent_id " . (empty($conditions) ? " " : " AND {$conditions}");

        $sql .= " ORDER BY {$tblid} DESC LIMIT $offset, $recordsPerPage ";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        self::free_resources($stmt);
        return $data;
    }

    public static function num_bettors($user_id, $bet_tables, $userData = [])
    {

        try{

          
        // $bet_tables = BusinessFlow::getAllGameIdsWithCondition();
        $summed_results = [];
        $database = parent::getLink();
        

        $query_data = self::allSubs($user_id,1,1000);

        // Initialize query parts
        $queryParts = [];
        $params = [];
        $index = 0;

       
            foreach ($bet_tables as $bet_table_array) {
                $betTable = $bet_table_array['bet_table'];
                $lottery_id = $bet_table_array['game_type'];

                $params[":sub_id_{$lottery_id}_0"] = $user_id;
                $conditions[] = "uid = :sub_id_{$lottery_id}_0";

                foreach ($query_data as $index => $sub) {
                    $place_holder = ":sub_id_{$lottery_id}_" . ($index + 1);
                    $params[$place_holder] = $sub->uid;
                    $conditions[] = "uid = $place_holder";
                }

                $whereClause = implode(" OR ", $conditions);

                $sql = "SELECT DISTINCT uid FROM $betTable AS bet_table ";
                $dateConditions = "";
                if (($userData[":datecreated_{$lottery_id}"] != "all") || ($userData['enddate'] != "all")) {
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

    

    public static function num_bettors_for_user($user_id, $bet_tables, $userData)
    {

     $params = [];
     $queryParts = [];
     $database  = parent::getLink();

    foreach ($bet_tables as $bet_table) {
        $betTable = $bet_table['bet_table'];
        $lottery_id = $bet_table['game_type'];
        $params[":user_id_{$lottery_id}"] = $user_id;

        $dateConditions = "";

        if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
            if (empty($userData['enddate'])) {
                $dateConditions = "bet_table.server_date = :datecreated{$lottery_id}";
                $params[":datecreated{$lottery_id}"] = $userData['datecreated'];
            } elseif (empty($userData['datecreated'])) {
                $dateConditions = "bet_table.server_date = :enddate{$lottery_id}";
                $params[":enddate{$lottery_id}"] = $userData['enddate'];
            } else {
                $dateConditions = "bet_table.server_date BETWEEN :datecreated{$lottery_id} AND :enddate{$lottery_id}";
                $params[":datecreated{$lottery_id}"] = min($userData['datecreated'], $userData['enddate']);
                $params[":enddate{$lottery_id}"] = max($userData['datecreated'], $userData['enddate']);
            }
        }

        $sql = "SELECT uid FROM $betTable AS bet_table ";
        $sql .= " WHERE bet_table.state=1 AND bet_table.uid=:user_id_{$lottery_id} " . ($dateConditions ? " AND $dateConditions" : "") . " GROUP BY bet_table.uid";
        $queryParts[] = $sql;
    }

    $finalQuery = implode(' UNION ', $queryParts);
    $data = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

    return count($data) > 0 ? 1 : 0;
    }


    public static function total_valid_amount($user_id, $bet_tables = [])
    {


        $db = self::openConnection("lottery");
        $summed_results = [];

        // Get all sub-user IDs for the current user
        $query_data = AgentDataAnalysis::allSubs($user_id);
        $params[":sub_id0"] = $user_id;  // Include the main user ID as the first placeholder
        $params[':bettype'] = 1;
        $params[':state'] = 1;
        $conditions[] = "uid = :sub_id0";  // Initial condition for the main user

        // Iterate over the sub-users_test and add to placeholders and parameters
        foreach ($query_data as $index => $sub) {
            $place_holder = ":sub_id" . ($index + 1);  // Create unique placeholders (e.g., :sub_id1, :sub_id2, etc.)
            $params[$place_holder] = $sub->uid;         // Map the placeholder to the sub-user ID
            $conditions[] = "uid = $place_holder";  // Build the OR condition dynamically
        }
        foreach ($bet_tables as $betTable) {
            try {
                $betTable = $betTable['bet_table'];


                // Create the WHERE clause using OR for all user IDs
                $whereClause = implode(" OR ", $conditions);



                $sql = "SELECT SUM(bet_amount) as sba,(SELECT SUM(bet_amount) AS tba FROM $betTable WHERE bettype = 2 AND $betTable.state = 1 " . (empty($whereClause) ? "" : " AND ") . " ({$whereClause})  ) AS tba FROM $betTable AS bet_table ";

                // Combine the WHERE clause and date conditions
                $sql .= " WHERE bet_table.bettype=:bettype AND bet_table.state=:state " . (empty($whereClause) ? "" : " AND ") . " ({$whereClause})";  // Wrap OR 

                //conditions in parentheses
                if (!empty($dateConditions)) {
                    $sql .= " AND " . implode(' AND ', $dateConditions);
                }


                // Prepare and execute the statement
                $stmt = $db->prepare($sql);
                $stmt->execute($params);

                // Fetch the results as an array of objects
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                $summed_results[]  = ($data) ? ($data->sba + $data->tba) : 0;
            } catch (PDOException $m) {
            }
        }
        return array_sum($summed_results);
    }

    public static function total_valid_amount_for_user($user_id, $bet_tables = [], $userData)
    {

   try{
    $params = [];
    $queryParts = [];
    $database = parent::getLink();

    foreach ($bet_tables as $bet_table) {
        $betTable = $bet_table['bet_table'];
        $lottery_id = $bet_table['game_type'];
        $params[":user_id_{$lottery_id}"] = $user_id;

        $dateConditions = "";
        $inner_date_conditions = "";

        if (!empty($userData['datecreated']) || !empty($userData['enddate'])) {
            if (empty($userData['enddate'])) {
                $dateConditions = "bet_table.server_date = :datecreated{$lottery_id}";
                $inner_date_conditions = "$betTable.server_date = :datecreated{$lottery_id}";
                $params[":datecreated{$lottery_id}"] = $userData['datecreated'];
            } elseif (empty($userData['datecreated'])) {
                $dateConditions = "bet_table.server_date = :enddate{$lottery_id}";
                $inner_date_conditions = "$betTable.server_date = :enddate{$lottery_id}";
                $params[":enddate{$lottery_id}"] = $userData['enddate'];
            } else {
                $dateConditions = "bet_table.server_date BETWEEN :datecreated{$lottery_id} AND :enddate{$lottery_id}";
                $inner_date_conditions = "$betTable.server_date BETWEEN :datecreated{$lottery_id} AND :enddate{$lottery_id}";
                $params[":datecreated{$lottery_id}"] = min($userData['datecreated'], $userData['enddate']);
                $params[":enddate{$lottery_id}"] = max($userData['datecreated'], $userData['enddate']);
            }
        }

        $sql = "SELECT SUM(bet_amount) as sba, 
                (SELECT SUM(bet_amount) FROM $betTable WHERE bettype = 2 AND state = 1 AND uid = :user_id_{$lottery_id} " . 
                ($inner_date_conditions ? " AND $inner_date_conditions" : "") . ") AS tba 
                FROM $betTable AS bet_table ";

        $sql .= " WHERE bet_table.bettype = 1 AND bet_table.state = 1 AND bet_table.uid = :user_id_{$lottery_id} " .
                ($dateConditions ? " AND $dateConditions" : "");

        $queryParts[] = $sql;
    }

    $finalQuery = implode(' UNION ', $queryParts);
    $data = $database->query($finalQuery, $params)->fetchAll(PDO::FETCH_OBJ);

    return array_sum(array_column($data, 'sba')) + array_sum(array_column($data, 'tba'));
               
            } catch (PDOException $m) {
            }
        

     
    }


    // public static function getTotalLostAmount($user_id,$betable)
    // {
    //     $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
    //     $query_data = AgentDataAnalysis::allSubs($user_id);
    //     $pdo_params[":sub_id0"] = $user_id;
    //     $placeholders[] = ":sub_id0";
    //     foreach ($query_data as $index => $sub) {

    //         $place_holder = ":sub_id" . ($index + 1);
    //         $placeholders[] = $place_holder;
    //         $pdo_params[$place_holder] = $sub->uid;
    //     }

    //     // Create the WHERE clause dynamically
    //     $whereClause = " uid = ";
    //     $whereClause .= implode(" OR ", $placeholders); 
    //     // $total_bet_stake = [];
    //     // foreach ((new Helper)::getGameTableMap() as $betTable){
    //     //     $sql = "SELECT  Count(*) AS numberbet FROM  {$betTable['bet_table']} WHERE uid = :uid";
    //     //     $stmt = self::openConnection("lottery")->prepare($sql);
    //     //     $stmt->execute([":uid" => $userid]);
    //     //     $total_bet_stake[] = $stmt->fetch(PDO::FETCH_OBJ)->numberbet;
    //     // }
    //     // return array_sum($total_bet_stake);
    //     $sql = "SELECT  COUNT(*) as total_lost_tickets FROM  $betTable WHERE bet_status=3 AND {$whereClause}";
    //     $stmt = self::openConnection("lottery")->prepare($sql);
    //     $stmt->execute($pdo_params);
    //     $data = $stmt->fetch(PDO::FETCH_OBJ)->total_lost_tickets;
    //     return $data ?? 0;
    // }



    public static function filterGetTotalLostAmount($data, $betable, $userData)
    {

        $user_id = $data->uid;
        // Get all sub-user IDs for the current user
        $sql = "SELECT  COUNT(*) as total_lost_tickets FROM  $betable ";
        $query_data = AgentDataAnalysis::allSubs($user_id);
        $params[":sub_id0"] = $user_id;  // Include the main user ID as the first placeholder
        $conditions[] = "{$betable}.uid = :sub_id0";  // Initial condition for the main user

        // Iterate over the sub-users_test and add to placeholders and parameters
        foreach ($query_data as $index => $sub) {
            $place_holder = ":sub_id" . ($index + 1);  // Create unique placeholders (e.g., :sub_id1, :sub_id2, etc.)
            $params[$place_holder] = $sub->uid;         // Map the placeholder to the sub-user ID
            $conditions[] = "{$betable}.uid = $place_holder";  // Build the OR condition dynamically
        }

        // Create the WHERE clause using OR for all user IDs
        $whereClause = implode(" OR ", $conditions);

        // Additional conditions based on date range
        $dateConditions = [];
        if (!empty($userData['datecreated']) && !empty($userData['enddate'])) {
            $dateConditions[] = " {$betable}.server_date BETWEEN :datecreated AND :enddate";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"] = $userData['enddate'];
        }

        $and_condition = empty(trim($whereClause)) ? " " : " AND ";
        // Combine the WHERE clause and date conditions
        $sql .= " WHERE bet_status =3 {$and_condition}  ({$whereClause})";  // Wrap OR conditions in parentheses
        if (!empty($dateConditions)) {
            $sql .= " AND " . implode(' AND ', $dateConditions);
        }

        // Use GROUP BY users_test.uid to get separate results for each user
        $sql .= " GROUP BY {$betable}.uid";

        // Prepare and execute the statement
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->execute($params);

        // Fetch the results as an array of objects
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $data = isset($result->total_lost_tickets) ? $result->total_lost_tickets : 0;
        return $data;

        //     $user_id = $userData['username'];
        //     $betable = $userData['lottery'];
        //     $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        //     $sql = "SELECT  COUNT(*) as total_lost_tickets FROM  $betTable ";
        //     $query_data = AgentDataAnalysis::allSubs($user_id);
        //     $params[":sub_id0"] = $user_id;
        //     $placeholders[] = ":sub_id0";
        //     foreach ($query_data as $index => $sub) {

        //         $place_holder = ":sub_id" . ($index + 1);
        //         $placeholders[] = $place_holder;
        //         $params[$place_holder] = $sub->uid;
        //     }

        //     // Create the WHERE clause dynamically
        //     $whereClause = implode(" OR ", $placeholders);
        //     $conditions = [];

        //     if (
        //         !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        //     ) {
        //         $conditions[]           = " $betTable.draw_time BETWEEN :datecreated AND :enddate ";
        //         $params[":datecreated"] = $userData['datecreated'];
        //         $params[":enddate"]     = $userData['enddate'];
        //     }

        //    $sql .= " WHERE bet_status=3 " . (empty($conditions) ? " AND " : " " ) . $whereClause . " " . implode(' AND ', $conditions);

        //     // $sql .= " LIMIT 20";
        //     $stmt = self::openConnection("lottery")->prepare($sql);
        //     // foreach ($params as $key => &$val) {
        //     //     $stmt->bindValue($key, $val);
        //     // }
        //     $stmt->execute($params);
        //     $data = $stmt->fetch(PDO::FETCH_OBJ)->total_lost_tickets;
        //     return $data ?? 0;
    }
    public static function getTotalLostAmount($user_id, $betable)
    {

        $db = self::openConnection("lottery");

        //  $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        // Get all sub-user IDs for the current user
        $sql = "SELECT  COUNT(*) as total_lost_tickets FROM  $betable ";
        $query_data = AgentDataAnalysis::allSubs($user_id);
        $params[":sub_id0"] = $user_id;  // Include the main user ID as the first placeholder
        $conditions[] = "{$betable}.uid = :sub_id0";  // Initial condition for the main user

        // Iterate over the sub-users_test and add to placeholders and parameters
        foreach ($query_data as $index => $sub) {
            $place_holder = ":sub_id" . ($index + 1);  // Create unique placeholders (e.g., :sub_id1, :sub_id2, etc.)
            $params[$place_holder] = $sub->uid;         // Map the placeholder to the sub-user ID
            $conditions[] = "{$betable}.uid = $place_holder";  // Build the OR condition dynamically
        }

        // Create the WHERE clause using OR for all user IDs
        $whereClause = implode(" OR ", $conditions);

        $and_condition = empty(trim($whereClause)) ? " " : " AND ";
        // Combine the WHERE clause and date conditions
        $sql .= " WHERE bet_status =3 {$and_condition}  ({$whereClause})";  // Wrap OR conditions in parentheses
        if (!empty($dateConditions)) {
            $sql .= " AND " . implode(' AND ', $dateConditions);
        }

        // Prepare and execute the statement
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        // Fetch the results as an array of objects
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $data = isset($result->total_lost_tickets) ? $result->total_lost_tickets : 0;
        return $data;
    }





    public static function FilterTotalBetStake($user_id, $userData, $betable)
    {
        $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT  Count(*) AS numberbet FROM  $betable ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " $betable.draw_time BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY $betable.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->numberbet;
        return $data ?? 0;
    }

    public static function TotalTransaction($userid)
    {
        $sql = "SELECT  Count(*) AS transactions  FROM  transaction WHERE uid =:uid";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->transactions;
        return $data ?? 0;
    }
    public static function filterTotalTransaction($user_id, $userData)
    {

        $sql = "SELECT  Count(*) AS transactions  FROM  transaction ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " transaction.date_created BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY transaction.date_created DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->transactions;
        return $data ?? 0;
    }


    public static function TotalGamesBetAmount($userid, $betable)
    {
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(bet_amount) as TotalAmount FROM  $betTable WHERE uid= :uid";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->TotalAmount;
        return $data ?? 0;
    }

    public static function filterTotalGamesBetAmount($user_id, $userData, $betable)
    {
        $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(bet_amount) as totalAmount FROM $betable ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " $betable.draw_time BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY $betable.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->totalAmount;
        return $data ?? 0;
    }

    public static function TotalRebateAmont($userid, $betable)
    {
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(rebate_amount) as rebateAmount FROM  $betTable WHERE uid= :uid";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->rebateAmount;
        return $data ?? 0;
    }
    public static function filterTotalRebateAmont($user_id, $userData, $betable)
    {
        $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(rebate_amount) as rebateAmount FROM  $betable ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " $betable.draw_time BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY $betable.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->rebateAmount;
        return $data ?? 0;
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(rebate_amount) as rebateAmount FROM  $betTable WHERE uid= :uid";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->rebateAmount;
        return $data ?? 0;
    }


    public static function TotalGamesWinAmount($userid, $betable)
    {
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(win_amount) as winamount FROM $betTable WHERE uid= :uid";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->winamount;
        return $data ?? 0;
    }
    public static function filterTotalGamesWinAmount($user_id, $userData, $betable)
    {
        $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(win_amount) as winamount FROM $betable ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " $betable.draw_time BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY $betable.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->winamount;
        return $data ?? 0;
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(win_amount) as winamount FROM $betTable WHERE uid= :uid";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->winamount;
        return $data ?? 0;
    }

    public static function TotalGamesLostAmount($userid, $betable)
    {
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(bet_amount) as TotalAmount FROM  $betTable WHERE uid= :uid  AND bet_status = 3";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->TotalAmount;
        return $data ?? 0;
    }
    public static function filterTotalGamesLostAmount($user_id, $userData, $betable)
    {
        $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT SUM(bet_amount) as totalAmount FROM  $betable ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " $betable.draw_time BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid AND bet_status = 3 " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY $betable.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->totalAmount;
        return $data ?? 0;
    }


    public static function TotalCountLost($userid, $betable)
    {
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT  Count(*) AS countlost FROM  $betTable WHERE uid = :uid AND bet_status = 3";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->countlost;
        return $data ?? 0;
    }
    public static function filterTotalCountLost($user_id, $userData, $betable)
    {
        $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT  Count(*) AS countlost FROM  $betable ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " $betable.draw_time BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid AND bet_status = 3 " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY $betable.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->countlost;
        return $data ?? 0;
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT  Count(*) AS countlost FROM  $betTable WHERE uid = :uid AND bet_status = 3";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->countlost;
        return $data ?? 0;
    }

    public static function TotalCountWin($userid, $betable)
    {
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT  Count(*) AS countwin FROM  $betTable WHERE uid = :uid AND bet_status = 2";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->countwin;
        return $data ?? 0;
    }
    public static function filterTotalCountWin($user_id, $userData, $betable)
    {
        $betable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT  Count(*) AS countwin FROM  $betable ";
        $conditions = [];
        $params[":uid"] = $user_id;

        if (
            !empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== ''
        ) {
            $conditions[]           = " $betable.draw_time BETWEEN :datecreated AND :enddate ";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"]     = $userData['enddate'];
        }

        $sql .= " WHERE uid=:uid AND bet_status = 2 " . (!empty($conditions) ? " AND " : "") . implode(' AND ', $conditions);
        $sql .= " ORDER BY $betable.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->countwin;
        return $data ?? 0;
        $betTable = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT  Count(*) AS countwin FROM  $betTable WHERE uid = :uid AND bet_status = 2";
        $stmt = self::openConnection("lottery")->prepare($sql);
        $stmt->bindValue(":uid", $userid);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ)->countwin;
        return $data ?? 0;
    }


    public static function WinLossFilterRecords($userData)
    {
        $betable = isset($userData['lottery']) && trim($userData['lottery']) == "all" ? 1 : $userData['lottery'];
        $betTableName = (new Helper)::getGameTableMap()[$betable]['bet_table'];
        $sql = "SELECT DISTINCT uid,rebate FROM $betTableName";
        $conditions = [];
        $params = [];
        if (!empty($userData["username"]) && trim($userData['username']) != 'all') {
            $conditions[] = "$betTableName.uid = :username";
            $params[':username'] = $userData["username"];
        }
        // if (!empty($lotteryId) && trim($lotteryId) != 'all') {
        //     $conditions[] = "$betTableName.game_type = :lottery";
        //     $params[':lottery'] = $lotteryId;
        // }

        // if (!empty($userData["betstatus"]) && trim($userData['betstatus']) != 'all') {
        //     $conditions[] = "$betTableName.bet_status = :betstatus";
        //     $params[':betstatus'] = $userData["betstatus"];
        // }

        // if (!empty($userData["betsate"]) && trim($userData['betsate']) != 'all') {
        //     $conditions[] = "$betTableName.state = :betsate";
        //     $params[':betsate'] = $userData["betsate"];
        // }

        if (!empty($userData['datecreated']) && trim($userData['datecreated']) !== '' && !empty($userData['enddate']) && trim($userData['enddate']) !== '') {
            $conditions[] = "$betTableName.draw_time BETWEEN :datecreated AND :enddate";
            $params[":datecreated"] = $userData['datecreated'];
            $params[":enddate"] = $userData['enddate'];
        } elseif (!empty($userData['datecreated']) && trim($userData['datecreated']) !== '') {
            $conditions[] = "$betTableName.draw_time = :datecreated";
            $params[":datecreated"] = $userData['datecreated'];
        } elseif (!empty($userData['enddate']) && trim($userData['enddate']) !== '') {
            $conditions[] = "$betTableName.draw_time = :enddate";
            $params[":enddate"] = $userData['enddate'];
        }


        if ($conditions) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " ORDER BY $betTableName.draw_time DESC"; // Add ORDER BY clause
        // $sql .= " LIMIT 20";
        $stmt = self::openConnection("lottery")->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return  $data;
    }





    //# //!SECTION win and lost report




    // MUNIRU
    public static function fetch_total_bets_by_subs(array $subs)
    {
        if (empty($subs)) {

            return 0;
        }
        $bet_tables = ["bt_royal5draw", "bt_royal10", "bt_1kb5d1m", "bt_luckypick5", "bt_1kball1min", "bt_speedy1min", "bt_speedy5d3min", "bt_Lucky5D15mins", "bt_Fast31min", "bt_SpeedyFast315mins", "bt_LuckyFast33mins", "bt_1kballPc281mins", "bt_SpeedyPc2815mins", "bt_Luckypc283mins", "bt_Lucky3D", "bt_SpeedyPK1015min", "bt_LuckyPK103m", "bt_rapidmark6", "bt_mark65min", "bt_rapid11x5", "bt_lucky11x55min", "bt_rapidhappy8", "bt_Hanoi3D", "bt_Fast3_BG_1min", "bt_Mark6_BG1min", "bt_11x5BG1min", "bt_Pk10BG1min", "bt_Happy8_BG1min", "bt_5dboardgames", "bt_5dFantan1min", "bt_Pk10Fantan1min", "bt_Fast3Fantan1min", "bt_11x5Fantan1min", "bt_Mark6Fantan1min", "bt_Happy8Fantan1min", "bt_chappo_1min"];

        // return 0;
        // $bet_tables = ["bt_royal5draw"];


        // $pdo = self::openConnection("lottery");
        // $pdo->beginTransaction();
        // $total_bets = 0;
        // $pdo_params = [];
        // foreach ($sub_ids as $index => $uid) {
        //     $place_holder = ":sub_id" . $index;
        //     $placeholders[] = $place_holder;
        //     $pdo_params[$place_holder] = $uid; 

        // }

        // $whereClause = implode(" OR uid = ", $placeholders);
        // foreach($bet_tables as $bet_table){
        //     $stmt = $pdo->prepare("SELECT COUNT(*) as total_bets FROM {$bet_table} WHERE uid=$whereClause");
        //     $stmt->execute($pdo_params);
        //     while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        //         // Do something with the data if necessary
        //         $total_bets =+ $row->total_bets;
        //     }
        // }

        $pdo = self::openConnection("lottery");
        // $pdo->beginTransaction();

        $total_bets = [];
        $pdo_params = [];
        $placeholders = [];

        // Build dynamic placeholders for each sub_id
        foreach ($subs as $index => $sub) {

            $place_holder = ":sub_id" . $index;
            $placeholders[] = $place_holder;
            $pdo_params[$place_holder] = $sub->uid;
        }

        // Create the WHERE clause dynamically
        $whereClause = implode(" OR uid = ", $placeholders);

        // Iterate through each bet table and execute the query
        foreach ($bet_tables as $bet_table) {
            // Build the final query for each table with dynamic placeholders
            $sql = "SELECT COUNT(*) as total_bets FROM {$bet_table} WHERE uid = {$whereClause}";
            //  echo $sql."\n";
            // Prepare and execute the query
            $stmt = $pdo->prepare($sql);
            $stmt->execute($pdo_params);

            // Fetch the total number of bets for the current table
            $results = $stmt->fetch(PDO::FETCH_OBJ);
            $total_bets[] = $results->total_bets; // Corrected += operator

        }

        //$pdo->commit();
        self::free_resources($stmt);
        return array_sum($total_bets);
    }


    public static function free_resources(PDOStatement $stmt)
    {
        $stmt->closeCursor();
        $stmt = null;
        self::closeConnection();
    }



}