<?php

use Medoo\Medoo;

class DataReportModel extends MedooOrm
{


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


    public static function allSubs($agent_id, $currentPage = 1, $recordsPerPage = 10)
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


    public static function filter_fetch_users_for_win_loss_report($usersData, int $currentPage = 1, int $recordsPerPage = 10, string $tblid = "uid")
    {

        $table_name = "users_test";
        $uids_placeholders = [];
        foreach ($usersData as $key => $userData) {
            $uids_placeholders[":uid$key"] = is_object($userData) ? $userData->uid : $userData;
        }


        $placeholders = implode(',', array_keys($uids_placeholders));
        $service = parent::getLink();

        return  $service->query(
            "SELECT {$table_name}.*, 
        (SELECT COUNT(*) FROM {$table_name} AS sub WHERE sub.agent_id = {$table_name}.agent_id) AS agent_sub_count, 
        (SELECT COUNT(*) FROM {$table_name} AS sub WHERE sub.agent_id = {$table_name}.uid) AS sub_count, 
        (SELECT sub.username FROM {$table_name} AS sub WHERE sub.uid = {$table_name}.agent_id) AS agent_username 
    FROM {$table_name} 
    WHERE uid IN ($placeholders)
    ORDER BY $tblid DESC",
            $uids_placeholders
        )->fetchAll(PDO::FETCH_OBJ);
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

    public static function subs_and_agent_subs_count($user_id, $currentPage = 1, $recordsPerPage = 10, $tblid = 'uid'): mixed
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

            if (($userData['datecreated'] != "all") || ($userData['enddate'] != "all")) {
                if (($userData['enddate'] == "all")) {
                    $conditions = "bet_table.server_date = :datecreated_{$lottery_id}";
                    $params[":datecreated_{$lottery_id}"] = $userData['datecreated'];
                } elseif (($userData['datecreated'] == "all")) {
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
        return ['uid' => $user->uid, "username" => $user->username, "account_type" => $user->account_type, "user_rebate" => $user->rebate, 'num_bet_tickets' => $summed_results['num_bet_tickets'], 'total_bet_amount' => $summed_results['total_bet_amount'],   'total_rebate_amount' => $total_rebate_amount, 'total_win_amount' => $total_win_amount, 'total_valid_amount' =>  $total_valid_amount, 'num_bettors' => self::num_bettors_for_user($user_id, $bet_tables, $userData), "rel" => $relationship, 'num_subs' => $num_subs, 'win_loss' => $win_loss, 'view_btn' =>  $view_btn];
    }


    public static function filterGetBetTicketsNum($user_id, $bet_tables, $userData)
    {





        //$bet_tables = BusinessFlow::getAllGameIds();
        $summed_results = [];


        // Get all sub-user IDs
        $num_subs = self::allSubs($user_id, 1, 1000);
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

        try {
            //  $bet_tables = BusinessFlow::getAllGameIds();
            $summed_results = [];



            // Get all sub-user IDs
            $num_subs = self::allSubs($user_id, 1, 1000);
            $summed_results = [];


            foreach ($bet_tables as $betTable_array) {
                $betTable = $betTable_array['bet_table'];

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





    public static function num_bettors($user_id, $bet_tables, $userData = [])
    {

        try {


            // $bet_tables = BusinessFlow::getAllGameIdsWithCondition();
            $summed_results = [];
            $database = parent::getLink();


            $query_data = self::allSubs($user_id, 1, 1000);

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



    public static function total_valid_amount_for_user($user_id, $bet_tables = [], $userData)
    {

        try {
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






    //# //!SECTION win and lost report






}
