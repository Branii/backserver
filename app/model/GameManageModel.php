<?php

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Throw an Exception with the error message and details
    throw new \Exception("$errstr in $errfile on line $errline", $errno);
});

class GameManageModel extends MEDOOHelper
{
    public static function getTables()
    {
        $result    = parent::selectAll('gamestable_map', '*');
        $gameTable = [];
        foreach ($result as $value) {
            $gameTable[$value['game_type']] = [
                'draw_table'   => $value['draw_table'],
                'bet_table'    => $value['bet_table'],
                'draw_storage' => $value['draw_storage'],
            ];
        }
        return $gameTable;
    }
    public static function getAllGames()
    {
        return parent::selectAll('game_type', ['gt_id', 'name']);
    }

    public static function getAllGamesLottery()
    {
        return $data = parent::query("SELECT lt_id,name FROM lottery_type WHERE  lt_id != 9 ");
        // return parent::selectAll('lottery_type', ['lt_id', 'name'], "lt_id != 9");
    }

    public static function getLotteryGamesById($lotteryId, $gamemodel, $gametype)
    {
        // $bigData = [];JSON_UNQUOTE(JSON_EXTRACT({$tableName}.standard_odds, CONCAT('$.', :game_types))) AS standardodds

        if (in_array($lotteryId, [1, 2, 3, 5, 6, 8, 10, 11]) && in_array($gamemodel, ['standard', 'twosides', 'longdragon', 'boardgames', 'roadbet'])) {
            $tableMap = [
                'standard'   => 'game_name',
                'twosides'   => 'twosides',
                'longdragon' => 'longdragon',
                'boardgames' => 'boardgames',
                'roadbet'    => 'roadbet',
                'fantan'     => 'fantan',
                'manytables' => 'manytables',
            ];
            $tableName = $tableMap[$gamemodel];
            $jsonKey   = preg_replace('/[^a-zA-Z0-9_]/', '', $gametype);
            $jsonPath  = "$." . $jsonKey;
            $sql       = "
            SELECT
               {$tableName}.gn_id,
               {$tableName}.name,
               {$tableName}.state,
               {$tableName}.modified_odds,
               {$tableName}.group_type,
               {$tableName}.modified_totalbet,
               {$tableName}.gameplay_name,
               {$tableName}.total_bets,
               {$tableName}.model,
               {$tableName}.oddspercentage,
               {$tableName}.totalbetpercentage,
               {$tableName}.odds,{$tableName}.game_group,
               {$tableName}.lottery_type, JSON_UNQUOTE(JSON_EXTRACT({$tableName}.standard_odds, '$jsonPath')) AS standardodds,
               JSON_UNQUOTE(JSON_EXTRACT({$tableName}.standard_total_bets, '$jsonPath')) AS standardtotalbets,
               game_group.state AS group_state,lottery_type.state AS lottery_state
            FROM
               {$tableName}
             JOIN
               game_group
               ON game_group.gp_id = {$tableName}.game_group
               JOIN lottery_type ON lottery_type.lt_id={$tableName}.lottery_type
            WHERE
               {$tableName}.lottery_type = :lotteryId
            ";

            $data = parent::query($sql, ['lotteryId' => $lotteryId]);

            return ['data' => $data];

        }
    }

    public static function UpdateOddsTotalbets($gameId, $gamemodel, $newodds, $oddpercent, $newtotalbet, $totalbetpercent, $gametype)
    {
        if (in_array($gamemodel, ['standard', 'twosides', 'longdragon', 'boardgames', 'roadbet'])) {
            $tableMap = [
                'standard'   => 'game_name',
                'twosides'   => 'twosides',
                'longdragon' => 'longdragon',
                'boardgames' => 'boardgames',
                'roadbet'    => 'roadbet',
                'fantan'     => 'fantan',
                'manytables' => 'manytables',
            ];
            $tableName = $tableMap[$gamemodel];
            // Sanitize
            $jsonKey  = preg_replace('/[^a-zA-Z0-9_]/', '', $gametype);
            $jsonPath = "$.\"$jsonKey\""; // correct MySQL JSON path syntax with quoted key

            $sql = "
            UPDATE {$tableName}
            SET
                modified_odds = :modified_odds,
                oddspercentage = :oddspercentage,
                modified_totalbet = :modified_totalbet,
                totalbetpercentage = :totalbetpercentage, standard_odds = JSON_SET(standard_odds, '{$jsonPath}', :new_standard_odds),
                standard_total_bets = JSON_SET(standard_total_bets, '{$jsonPath}', :new_standard_totalbet)
               WHERE
                gn_id = :gn_id
        ";

            try {
                $data = parent::query($sql, [
                    'modified_odds'         => $newodds,
                    'oddspercentage'        => $oddpercent,
                    'modified_totalbet'     => $newtotalbet,
                    'totalbetpercentage'    => $totalbetpercent,
                    'new_standard_odds'     => $newodds,     // same value as modified_odds
                    'new_standard_totalbet' => $newtotalbet, // same value as modified_totalbet
                    'gn_id'                 => $gameId,
                ]);

                if ($data > 1) {
                    $data = self::getLotteryGamesById($gameId, $gamemodel, $gametype);
                }
                return ['success' => true, 'message' => 'Update successful'];
            } catch (Exception $e) {
                return ['success' => false, 'message' => 'Database update failed', 'error' => $e->getMessage()];
            }
        }
    }

    public static function ResetTotalbets($gameId, $gamemodel, $newtotalbet, $totalbetpercent, $gametype)
    {
        if (in_array($gamemodel, ['standard', 'twosides', 'longdragon', 'boardgames', 'roadbet'])) {
            $tableMap = [
                'standard'   => 'game_name',
                'twosides'   => 'twosides',
                'longdragon' => 'longdragon',
                'boardgames' => 'boardgames',
                'roadbet'    => 'roadbet',
                'fantan'     => 'fantan',
                'manytables' => 'manytables',
            ];
            $tableName = $tableMap[$gamemodel];
            // Sanitize
            $jsonKey  = preg_replace('/[^a-zA-Z0-9_]/', '', $gametype);
            $jsonPath = "$.\"$jsonKey\""; // correct MySQL JSON path syntax with quoted key

            $sql = "UPDATE {$tableName} SET  modified_totalbet = :modified_totalbet,totalbetpercentage = :totalbetpercentage,
             standard_total_bets = JSON_SET(standard_total_bets, '{$jsonPath}', :new_standard_totalbet)
          WHERE gn_id = :gn_id";

            try {
                $data = parent::query($sql, [
                    'modified_totalbet'     => $newtotalbet,
                    'totalbetpercentage'    => $totalbetpercent,
                    'new_standard_totalbet' => $newtotalbet,
                    'gn_id'                 => $gameId,
                ]);

                if ($data > 1) {
                    $data = self::getLotteryGamesById($gameId, $gamemodel, $gametype);
                }

                return ['success' => true, 'message' => 'Update successful'];
            } catch (Exception $e) {
                return ['success' => false, 'message' => 'Database update failed', 'error' => $e->getMessage()];
            }
        }
    }

    public static function UpdateGameStatus($gameId, $gamemodel, $gametate)
    {
        if (in_array($gamemodel, ['standard', 'twosides', 'longdragon', 'boardgames', 'roadbet'])) {
            $tableMap = [
                'standard'   => 'game_name',
                'twosides'   => 'twosides',
                'longdragon' => 'longdragon',
                'boardgames' => 'boardgames',
                'roadbet'    => 'roadbet',
                'fantan'     => 'fantan',
                'manytables' => 'manytables',
            ];
            $tableName = $tableMap[$gamemodel];
            $updated   = parent::query("UPDATE {$tableName} SET  state = :state WHERE gn_id = :gn_id", ["state" => $gametate, "gn_id" => $gameId]);
            if ($updated > 1) {
                return ['success' => true, 'state' => $gametate];
            }
        }
    }

    public static function UpdateGameGroup($gamegroupid, $gametate)
    {
        $update = parent::query("UPDATE game_group SET state = :state WHERE gp_id = :gp_id", ["state" => $gametate, "gp_id" => $gamegroupid]);
        if ($update > 1) {
            return ['success' => true];
        }
    }

    public static function UpdateGameLotteryType($lotteryid, $gametate)
    {
        $update = parent::query("UPDATE lottery_type SET state = :state WHERE lt_id = :lt_id", ["state" => $gametate, "lt_id" => $lotteryid]);
        if ($update > 1) {
            return ['success' => true];
        }
    }

    public static function GetAllGameTypes()
    {
        $formattedGroup = [];
        $gametypes      = parent::query("SELECT gt_id,name,game_group FROM game_type  GROUP BY gt_id,name,game_group ORDER BY name ASC");
        $keys           = ['5d', '3d', 'fast3', 'pk10', '11x5', 'mark6', 'happy8', 'pk6'];
        $arr            = [];
        foreach ($gametypes as $types) {
            if (in_array($types['game_group'], $keys)) {
                $formattedGroup[$types['game_group']][] = ['name' => $types['name'], 'id' => $types['gt_id']];
            }
        }
        return $formattedGroup;
    }

    public static function GetAllGameTabs()
    {
        $formattedGroup = [];
        $gametypes      = parent::query("SELECT gp_id,name,game_group FROM game_group  GROUP BY gt_id,name,game_group ORDER BY name ASC");
        $keys           = ['5d', '3d', 'fast3', 'pk10', '11x5', 'mark6', 'happy8', 'pk6'];
        $arr            = [];
        foreach ($gametypes as $types) {
            if (in_array($types['game_group'], $keys)) {
                $formattedGroup[$types['game_group']][] = ['name' => $types['name'], 'id' => $types['gt_id']];
            }
        }
        return $formattedGroup;
    }

    public static function filterGameDraws($page, $limit, $gameId, $datefrom, $dateto)
    {
        try {
            $startpoint = $page * $limit - $limit;
            $conditions = self::filterConditions($datefrom, $dateto);
            $where      = $conditions['where'];
            $params     = $conditions['params'];
            $drawTable  = self::getTables()[$gameId]['draw_table'];
            $data       = parent::query(
                "SELECT * FROM " .
                $drawTable .
                " " .
                $where .
                "
            ORDER BY draw_id DESC LIMIT :offset, :limit",
                array_merge($params, ['offset' => $startpoint, 'limit' => $limit])
            );

            $totalRecords = parent::query("SELECT * FROM " . $drawTable . " " . $where . "ORDER BY draw_id DESC", array_merge($params));

            return ['data' => $data, 'total' => count($totalRecords)];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function filterConditions($datefrom = '', $dateto = '')
    {
        $where  = '';
        $params = [];
        if ($datefrom && $dateto) {
            $where .= "WHERE date_created >= :datefrom AND date_created <= :dateto";
            $params['datefrom'] = $datefrom; // Set datefrom parameter
            $params['dateto']   = $dateto;   // Set dateto parameter
        } elseif ($datefrom) {
            $where .= "WHERE date_created = :datefrom";
            $params['datefrom'] = $datefrom;
        } elseif ($dateto) {
            $where .= "WHERE date_created = :dateto";
            $params['dateto'] = $dateto;
        }
        return ['where' => $where, 'params' => $params];
    }

    public static function fetchGameTypesForLottery($lottery_id, $current_page = 1, $recordsPerPage = 20)
    {
        try {
            $offset      = ($current_page - 1) * $recordsPerPage;
            $database    = parent::openLink();
            $whereClause = empty($lottery_id) ? "" : " WHERE game_type.lottery_type = :lottery_id ";

            $sql = "SELECT lottery_type.*, game_type.*,
            (SELECT COUNT(*) FROM game_type
             JOIN lottery_type ON game_type.lottery_type = lottery_type.lt_id $whereClause ) AS total_count
            FROM game_type
            JOIN lottery_type ON game_type.lottery_type = lottery_type.lt_id
            $whereClause
            ORDER BY game_type.gt_id  DESC
            LIMIT :offset, :recordsPerPage";

            $params = [":offset" => $offset, ":recordsPerPage" => $recordsPerPage];
            if ($whereClause) {
                $params[":lottery_id"] = $lottery_id;
            }

            $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);

            return ['status' => "success", 'data' => $data];
        } catch (Exception $e) {
            return ['status' => "success", 'data' => "Internal Server Error." . $e->getMessage()];
        }
    }

    public static function fetchBonusTwoSides($lottery_id, $game_group_name)
    {
        try {
            $database   = parent::openLink();
            $table_name = "twosides_group";
            $sql        = "SELECT {$table_name}.odds_group_id AS odds_group_id, {$table_name}.game_play_id, {$table_name}.label AS label, {$table_name}.odds AS odds, {$table_name}.rebate AS rebate, {$table_name}.profit AS profit , twosides.gn_id AS twosides_gn_id, twosides.name AS twosides_name FROM {$table_name} JOIN twosides ON {$table_name}.game_play_id = twosides.gn_id JOIN game_group ON game_group.gp_id = twosides.game_group WHERE game_group.name = :game_group_name AND game_group.lottery_type =:lottery_type";
            $params     = [":lottery_type" => $lottery_id, ":game_group_name" => $game_group_name];
            $data       = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
            return ['status' => "success", 'data' => $data];
        } catch (Exception $e) {
            return ['status' => "success", 'data' => "Internal Server Error." . $e->getMessage()];
        }
    }
    public static function updateGameGroupData($data)
    {
        try {
            $sql        = "";
            $database   = parent::openLink();
            $table_name = "twosides_group";
            foreach ($data as $odds_group_id => $info) {
                $odds_group_id = $info["labelid"];
                if (empty($odds_group_id)) {
                    continue;
                }
                $params[":odds_{$odds_group_id}"]              = empty($info["odds"]) ? 0 : $info["odds"];
                $params[":max_bet_amt_{$odds_group_id}"]       = empty($info["max_amt"]) ? 0 : (int) $info["max_amt"];
                $params[":max_total_bet_amt_{$odds_group_id}"] = empty($info["max_tot_amt"]) ? 0 : (int) $info["max_tot_amt"];
                $params[":odds_group_id_{$odds_group_id}"]     = (int) $odds_group_id;
                $sql .= "UPDATE {$table_name} SET modified_odds=:odds_{$odds_group_id} , max_bet_amount=:max_bet_amt_{$odds_group_id}, total_max_bet_amount=:max_total_bet_amt_{$odds_group_id} WHERE odds_group_id=:odds_group_id_{$odds_group_id};";
            }
            $data = $database->query($sql, $params);
            return ['status' => "success", 'data' => $data->rowCount()];
        } catch (Exception $e) {
            return ['status' => "success", 'data' => "Internal Server Error." . $e->getMessage()];
        }
    }

    public static function toggleTwosidesLotteryState($gameID)
    {
        try {
            $sql        = "";
            $database   = parent::openLink();
            $table_name = "twosides";
            $sql .= "UPDATE {$table_name} SET state = CASE WHEN state = 'active' THEN 'inactive' WHEN state = 'inactive' THEN 'active' ELSE state END WHERE gn_id=:gn_id;";

            $data = $database->query($sql, [":gn_id" => $gameID]);
            return ['status' => "success", 'data' => $data->rowCount()];
        } catch (Exception $e) {
            return ['status' => "success", 'data' => "Internal Server Error." . $e->getMessage()];
        }
    }

    public static function updateLotteryData($maxPrizeAmountPerBet, $maxAmtPerIssue, $maxWinPerPersonPerIssue, $minBetAmtPerIssue, $lockTimeForClsing, $sortingWeight, $lottery_type, $game_type_id): array
    {
        try {
            if ($sortingWeight < 1) {
                return ["status" => "error", "data" => "Sorting Weight must be greater than zero."];
            }

            // return [":maximum_prize_per_bet" => $maxPrizeAmountPerBet, ':maximum_amount_per_issue' => $maxAmtPerIssue,':maximum_win_per_issue' => $maxWinPerPersonPerIssue, ':minimum_amount_per_issue' => $minBetAmtPerIssue, ':closing_time' => $lockTimeForClsing, ':game_type_id' => $game_type_id ];
            $database                 = parent::openLink();
            $swaped_game_ids          = [];
            $stmt                     = $database->query("SELECT sort_weight FROM lottery_type WHERE lt_id=:lt_id", [':lt_id' => $lottery_type]);
            $data                     = $stmt->fetch(PDO::FETCH_OBJ);
            $lottery_type_sort_weight = $data->sort_weight;
            $lottery_type_sort_weight = json_decode($lottery_type_sort_weight, true);
            $sorting_weight_flipped   = array_flip($lottery_type_sort_weight);

            if (empty($sorting_weight_flipped) || ! in_array((int) $sortingWeight, $lottery_type_sort_weight)) {
                $lottery_type_sort_weight[$game_type_id] = $sortingWeight;
            } else {
                $res = self::swapElements($lottery_type_sort_weight, $game_type_id, $sortingWeight, $sorting_weight_flipped[$sortingWeight]);
                if (! $res) {
                    $stmt = self::updateLotteryBasicEdit($maxPrizeAmountPerBet, $maxAmtPerIssue, $maxWinPerPersonPerIssue, $minBetAmtPerIssue, $lockTimeForClsing, $game_type_id);
                    return ['status' => "error", 'data' => "Duplicated Sorting Weight"];
                }

                $swaped_game_ids = $res;
            }

            $sorting_weight = $database->query("UPDATE lottery_type SET sort_weight = :sorting_weight  WHERE lottery_type.lt_id = :lottery_id", [":sorting_weight" => json_encode($lottery_type_sort_weight), ':lottery_id' => (int) $lottery_type]);

            $stmt = self::updateLotteryBasicEdit($maxPrizeAmountPerBet, $maxAmtPerIssue, $maxWinPerPersonPerIssue, $minBetAmtPerIssue, $lockTimeForClsing, $game_type_id);
            return ['status' => "success", 'data' => $stmt->rowCount(), "swapped" => $swaped_game_ids, "sorting_weight" => $sorting_weight->rowCount()];
        } catch (Exception $e) {
            return ['status' => "success", 'data' => "Internal Server Error."];
        }
    }

    public static function updateLotteryBasicEdit($maxPrizeAmountPerBet, $maxAmtPerIssue, $maxWinPerPersonPerIssue, $minBetAmtPerIssue, $lockTimeForClsing, $game_type_id)
    {
        $database = parent::openLink();
        $stmt     = $database->query(
            "UPDATE game_type SET maximum_prize_per_bet = :maximum_prize_per_bet,maximum_win_per_issue = :maximum_win_per_issue,maximum_amount_per_issue = :maximum_amount_per_issue, minimum_amount_per_issue = :minimum_amount_per_issue , closing_time =:closing_time  WHERE game_type.gt_id = :game_type_id
            ",
            [
                ":maximum_prize_per_bet"    => (int) $maxPrizeAmountPerBet,
                ':maximum_amount_per_issue' => (int) $maxAmtPerIssue,
                ':maximum_win_per_issue'    => (int) $maxWinPerPersonPerIssue,
                ':minimum_amount_per_issue' => (int) $minBetAmtPerIssue,
                ':closing_time'             => (int) $lockTimeForClsing,
                ':game_type_id'             => (int) $game_type_id,
            ]
        );

        return $stmt;
    }

    public static function updateLotteryStatus($game_type_id, $status): array
    {
        try {
            $status   = ["gameon" => 1, "gameoff" => -1][$status];
            $database = parent::openLink();
            $stmt     = $database->query(
                "UPDATE game_type SET state = :state  WHERE game_type.gt_id = :game_type_id
            ",
                [":state" => $status, ':game_type_id' => (int) $game_type_id]
            );
            return ['status' => "success", 'data' => $stmt->rowCount()];
        } catch (Exception $e) {
            return ['status' => "success", 'data' => "Internal Server Error." . $e->getMessage()];
        }
    }

    public static function fetch_draw_info_game_type($game_type = 1)
    {
        try {
            $db   = parent::openLink();
            $sql  = "SELECT draw_table,bet_table FROM gamestable_map WHERE game_type = :game_type";
            $stmt = $db->query($sql, [':game_type' => (int) $game_type]);
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            return ['status' => 'success', 'data' => $data];
        } catch (Exception $e) {
            return [
                'status' => "error",
                'data'   => "Internal Server
            Erro",
            ];
        }
    }

    public static function getDrawTableInfo($game_type, $issue_number = 0, $status = "", $startDate = "", $endDate = "", int $currentPage = 1, int $limit = 20)
    {
        $res = self::fetch_draw_info_game_type($game_type);
        if ($res['status'] === "error") {
            return ["status" => 'error', 'data' => "Internal Server error."];
        }
        $db        = parent::openLink();
        $offset    = ($currentPage - 1) * $limit;
        $res       = $res['data'];
        $drawtable = $res->draw_table;
        $bet_table = $res->bet_table;
        $params    = [':offset' => (int) $offset, ':limit' => $limit];

        $whereClause = "";
        if (! empty($game_type)) {
            $params[":game_type"] = $game_type;
            $whereClause          = empty($whereClause) ? " {$drawtable}.lottery_type=:game_type " : " AND {$drawtable}.lottery_type=:game_type ";
        }
        if (! empty($issue_number)) {
            $params[":issue_number"] = $issue_number;
            $whereClause .= empty($whereClause) ? " period=:issue_number " : " AND period=:issue_number ";
        }
        if (! empty($status)) {
            $params[":draw_status"] = $status;
            $whereClause .= empty($whereClause) ? " draw_status=:draw_status " : " AND draw_status=:draw_status ";
        }

        if (! empty($startDate) && empty($endDate)) {
            $whereClause .= empty($whereClause) ? " time_added = :start_date " : " AND time_added = :start_date ";
            $params[':start_date'] = $startDate;
        } elseif (empty($startDate) && ! empty($endDate)) {
            $whereClause .= empty($whereClause) ? " time_added = :end_date " : " AND time_added = :end_date ";
            $params[':end_date'] = $endDate;
        } elseif (! empty($startDate) && ! empty($endDate)) {
            $start = min($startDate, $endDate);
            $end   = max($startDate, $endDate);
            $whereClause .= empty($whereClause) ? " time_added BETWEEN :start_date AND :end_date  " : " AND time_added BETWEEN :start_date AND :end_date ";
            $params[':start_date'] = $start;
            $params[':end_date']   = $end;
        }

        $whereClause = empty($whereClause) ? "" : " WHERE {$whereClause} ";

        $sql    = "SELECT *,{$drawtable}.closing_time as my_closing,(SELECT COUNT(*) FROM  {$drawtable}) as total_records, (SELECT COUNT(*) FROM {$bet_table} WHERE draw_period = {$drawtable}.period) as totalIssueBet, (SELECT SUM(bet_amount) FROM {$bet_table}  WHERE draw_period = {$drawtable}.period) as sumTotalAmount,(SELECT SUM(win_bonus) FROM {$bet_table}  WHERE draw_period = {$drawtable}.period AND bet_status = 2) as total_won_amount,(SELECT SUM(win_bonus) FROM {$bet_table}  WHERE draw_period = {$drawtable}.period AND bet_status = 3) as total_lose_amount FROM {$drawtable} JOIN game_type ON {$drawtable}.lottery_type = game_type.gt_id {$whereClause}  ORDER BY draw_id DESC LIMIT :offset, :limit";
        $stmt   = $db->query($sql, $params);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        $data = [];

        foreach ($result as $key => $value) {
            $data[] = [
                'lottery_type'               => $value->name,
                'lottery_code'               => $value->game_group,
                'issue_number'               => $value->period,
                'winning_numbers'            => implode(',', json_decode($value->draw_number)),
                'total_bet_amount'           => $value->sumTotalAmount ?? 0,
                'total_win_amount'           => $value->total_won_amount ?? 0,
                'draw_time'                  => str_replace(' ', '/', $value->time_added),
                'sales_deadline'             => str_replace(' ', '/', $value->my_closing),
                'actual_draw_time'           => str_replace(' ', '/', $value->time_added),
                'settlement_completion_time' => str_replace(' ', '/', $value->settlement_completion_time ?? 0),
                'status'                     => $value->draw_status,
                'total_records'              => $value->total_records,
                "timezone"                   => $value->timezone,
            ];
        }
        return ['status' => 'success', 'data' => $data];
    }

    public static function swapElements(&$array, $element1 = 0, $element1NewWeight = 0, $element2 = 0)
    {
        try {
            $element1 = (int) $element1;
            $element2 = (int) $element2;

            if (! array_key_exists($element2, $array)) {
                $array[$element1] = $element1NewWeight;
                return true;
            }
            if (! array_key_exists($element1, $array) || ! array_key_exists($element2, $array)) {
                return false; // Ensure elements exist
            }

            $element1OldWeight = $array[$element1];

            if ((int) $element1OldWeight == $element1NewWeight) {
                return false;
            }

            $array[$element1] = $element1NewWeight;
            $array[$element2] = $element1OldWeight;
            return [$element1, $element2]; // Successful swap
        } catch (Exception $e) {
            echo $e->getMessage();
            return ["status" => "error", "data" => $e->getMessage()];
        }
    }

    //  CREATE GAME TABLE STARTS HERE WITH THE UPDATE FOR SPECIFIEDS ODDS 
public static function createNewGame(array $gameData, string $gamesTable)
{
    $pdo = (new Database())->openLink();
    $logo = $gameData['logoFileName'] ?? "";
    $linker = bin2hex(random_bytes(7));
    // Check for existing game name
    if (count(self::checkIfLotteryExist($gameData['name'])) > 0) {
        return ['status' => 'error', 'message' => 'Lottery name already exists'];
    }
    // Insert into game_type
    $sql = self::createNewGameQuery($gamesTable);
    $params = self::addNewLotteryGameParam($gameData, $logo, $linker);
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'Game Insert Error: ' . $e->getMessage()];
    }
    // Retrieve new game's ID
    $lottery = self::getGameByLinker($linker);
    $gameTypeId = $lottery[0]['gt_id'] ?? null;
    if (!$gameTypeId) {
        return ['status' => 'error', 'message' => 'Failed to get inserted lottery ID'];
    }
    // Map game to gamestable_map
    $mapData = [
        'game_type'     => $gameTypeId,
        'draw_table'    => 'dt_' . str_replace(' ', '', $gameData['name']),
        'draw_storage'  => 'ds_' . str_replace(' ', '', $gameData['name']),
        'draw_period'   => 'dp_' . str_replace(' ', '', $gameData['name']),
        'bet_table'     => 'bt_' . str_replace(' ', '', $gameData['name']),
        'lottery_type'  => $gameData['lottery_type'],
        'lottery_name'  => $gameData['game_group']
    ];
    $mapSql = self::addNewGameToMapQuery();
    $mapParams = self::addNewGamesTableMapParam($mapData);
    try {
        $stmt = $pdo->prepare($mapSql);
        $stmt->execute($mapParams);
        // Create game-related tables
        self::execute("CREATE TABLE {$mapData['draw_table']} LIKE dt_1kb5d1m");
        self::execute("CREATE TABLE {$mapData['draw_storage']} LIKE ds_1kb5d1m");
        self::execute("CREATE TABLE {$mapData['draw_period']} LIKE dp_1kb5d1m");
        self::execute("CREATE TABLE {$mapData['bet_table']} LIKE bt_1kb5d1m");
        self::updateSpecificGamePlays($mapData['lottery_type'], $gameTypeId);
        self::updateSpecificGamePlayOddsGroup($mapData['lottery_type'], $gameTypeId);
        return ['status' => 'success', 'message' => 'New game created and odds updated successfully'];
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'Mapping DB Error: ' . $e->getMessage()];
    }
}

public static function updateSpecificGamePlays($lotteryType, $gameTypeId)
    {
        $pdo = (new Database())->openLink();
        $sql = "SELECT gn_id, name, odds, total_bets, lottery_type, standard_odds, standard_total_bets FROM game_name WHERE lottery_type = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$lotteryType]);
        $gamePlay = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sqlUpdate = "UPDATE game_name SET standard_odds = ?, standard_total_bets = ? WHERE gn_id = ?";
        $req = $pdo->prepare($sqlUpdate);

        foreach ($gamePlay as $play) {
            $stdOdds = json_decode($play['standard_odds'], true) ?: [];
            $stdBets = json_decode($play['standard_total_bets'], true) ?: [];

            $stdOdds[$gameTypeId] = trim($play['odds'], '[]');
            $stdBets[$gameTypeId] = trim($play['total_bets'], '[]');

            $req->execute([
                json_encode($stdOdds),
                json_encode($stdBets),
                $play['gn_id']
            ]);
        }
    }
public static function updateSpecificGamePlayOddsGroup($lotteryType, $gameTypeId)
    {
        $pdo = (new Database())->openLink();
        $sql = "SELECT gn.gn_id, gn.lottery_type, ogg.odds, ogg.label, ogg.game_play_id, ogg.odds_group_id, ogg.std_odds
                FROM game_name gn
                JOIN odds_group ogg ON gn.gn_id = ogg.game_play_id
                WHERE gn.lottery_type = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$lotteryType]);
        $oddsGroup = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sqlUpdate = "UPDATE odds_group SET std_odds = ? WHERE odds_group_id = ?";
        $req = $pdo->prepare($sqlUpdate);

        foreach ($oddsGroup as $play) {
            $stdOdds = json_decode($play['std_odds'], true) ?: [];
            $stdOdds[$gameTypeId] = trim($play['odds'], '[]');

            $req->execute([
                json_encode($stdOdds),
                $play['odds_group_id']
            ]);
        }
    }

 public static function checkIfLotteryExist(string $name)
    {
        $pdo = (new Database())->openLink();
        $stmt = $pdo->prepare("SELECT * FROM game_type WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public static function getGameByLinker(string $linker)
    {
        $pdo = (new Database())->openLink();
        $stmt = $pdo->prepare("SELECT gt_id FROM game_type WHERE linker = ?");
        $stmt->execute([$linker]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public static function execute(string $sql)
    {
        $pdo = (new Database())->openLink();
        return $pdo->exec($sql);
    }

public static function createNewGameQuery(string $gamesTable)
    {
        return "INSERT INTO $gamesTable (
            name, logo, alias, starttime, stoptime, state, game_type, draw_type,
            lottery_type, seconds_per_issue, total_num_issue, closing_time,
            num_balls, min_ball, max_ball, lottery_model, game_group,
            last_updated, date_created, linker
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }

public static function addNewLotteryGameParam(array $gameData, string $logo, string $linker)
    {
        return [
            (string) $gameData['name'],
            (string) $logo,
            (string) $gameData['alias'],
            (string) $gameData['starttime'],
            (string) $gameData['stoptime'],
            1, // state
            1, // game_type
            1, // draw_type
            (string) $gameData['lottery_type'],
            (int) $gameData['seconds_per_issue'],
            (int) $gameData['total_num_issue'],
            1, // closing_time
            (int) $gameData['num_of_balls'],
            (int) $gameData['min_ball'],
            (int) $gameData['max_ball'],
            (string) $gameData['lottery_model'],
            (string) $gameData['game_group'],
            date("Y-m-d"),
            date("Y-m-d"),
            (string) $linker
        ];
    }
    public static function addNewGameToMapQuery()
{
    return "INSERT INTO gamestable_map (
        game_type, draw_table, draw_storage, draw_period, bet_table,
        lottery_type, lottery_name
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";
}

public static function addNewGamesTableMapParam(array $gameData)
{
    return [
        (int) $gameData['game_type'],
        (string) $gameData['draw_table'],
        (string) $gameData['draw_storage'],
        (string) $gameData['draw_period'], 
        (string) $gameData['bet_table'],
        (string) $gameData['lottery_type'],
        (string) $gameData['lottery_name'] ?? ''
    ];
}

////  CREATE GAME TABLE ENDS HERE WITH THE UPDATE FOR SPECIFIEDS ODDS 


// Update file image function starts here
public static function UpdateGameimage($gameId, $filename)
{
   
    $file = $_FILES['lottery_logo_file'] ?? null;
    if (!$gameId || !$filename || !$file || $file['error'] !== UPLOAD_ERR_OK) {
        return ['status' => 'error','message' => 'Missing file, filename, or game ID'];
    }
    $safeFileName = basename($filename);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($safeFileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        return [ 'status' => 'error', 'message' => 'Invalid file extension'];
    }
    $uploadDir = '../app/assets/images/';
    $targetPath = $uploadDir . $safeFileName;
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['status' => 'error','message' => 'Failed to move uploaded file'];
    }
    $pdo = (new Database())->openLink();
    $stmt = $pdo->prepare("UPDATE game_type SET logo = ? WHERE gt_id = ?");
    $stmt->execute([$safeFileName, $gameId]);

    return ['status' => 'success','message' => 'Logo updated successfully'];
}

// Update file image function ends here 

//Get game times seconds starts here 
    public static function getTimegames()
    {
        return $data = parent::query("SELECT tid,seconds FROM game_time_set ");
    }
    //Get game times seconds ends here 


       //Get game models  starts here 
     public static function getAllGamesModel(){
        return $data = parent::query("SELECT model_id,model_name FROM game_model");

     }

     //Get game models  ends here 
}
