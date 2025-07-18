<?php
date_default_timezone_set('Asia/Singapore');
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

            $sql = "SELECT
                  gn.gn_id AS gn_id,
                  gn.name AS name,
                  gn.modified_odds,
                  gn.isSpecial As isSpecial,
                  gn.oddspercentage AS oddspercentage,
                  gn.totalbetpercentage AS totalbetpercentage,
                  gn.gameplay_name AS gameplay_name,gn.model AS model,
                  gn.game_group AS game_group,gn.lottery_type AS lottery_type,
                  gn.total_bets AS total_bets,
                  JSON_UNQUOTE(JSON_EXTRACT(gn.standard_total_bets, CONCAT('$.\"',$jsonKey, '\"'))) AS standardtotalbets,
                  gn.state AS state,
                  gn.group_type AS group_type,
                  gg.state AS group_state,
                  og.odds_group_id AS subgame_id,
                  og.label AS label,
                  gn.odds AS mainOdds,
                  og.odds AS mainSubOdds, og.oddspercentage AS subOddsPercentage,
                  JSON_UNQUOTE(JSON_EXTRACT(gn.standard_odds, CONCAT('$.\"',$jsonKey, '\"'))) AS standardodds,
                  IF(
                     og.odds IS NOT NULL,
                     JSON_UNQUOTE(JSON_EXTRACT(og.std_odds, CONCAT('$.\"',$jsonKey, '\"'))),
                  JSON_UNQUOTE(JSON_EXTRACT(gn.standard_odds, CONCAT('$.\"',$jsonKey, '\"')))
                  ) AS currentodds,
                  IF(og.odds IS NOT NULL, true,false) AS isSubOdds,
                  lottery_type.state AS lottery_state

            FROM
                  $tableName gn
            JOIN
                  game_group gg ON gn.game_group = gg.gp_id

            LEFT JOIN
                  odds_group og ON gn.gn_id = og.game_play_id
            JOIN lottery_type ON lottery_type.lt_id= gn.lottery_type
            WHERE
                  gn.lottery_type = :lotteryId
            ";

            $data = parent::query($sql, ['lotteryId' => $lotteryId]);

            return ['data' => $data];

        }
    }

    public static function UpdateOddsTotalbets($gameId, $gamemodel, $newodds, $oddpercent, $newtotalbet, $totalbetpercent, $gametype, $isSpecial)
    {
        $jsonKey  = preg_replace('/[^a-zA-Z0-9_]/', '', $gametype);
        $jsonPath = "$.\"$jsonKey\""; 
        if ($isSpecial === "true") {
            $data = self::UpdateOddsGroupTable($gameId, $newodds, $oddpercent, $jsonPath);
            if ($data > 1) {
                self::getLotteryGamesById($gameId, $gamemodel, $gametype);
            }
            return ['success' => true, 'message' => 'Update successful'];
        } else {
            self::UpdateGameNameTable($gameId, $gamemodel, $newodds, $oddpercent, $newtotalbet, $totalbetpercent, $jsonPath);
        }

    }

    public static function UpdateGameNameTable($gameId, $gamemodel, $newodds, $oddpercent, $newtotalbet, $totalbetpercent, $jsonPath)
    {
        if (in_array($gamemodel, ['standard', 'twosides', 'longdragon', 'boardgames', 'roadbet'])) {
            // Sanitize
            $tableMap = [
                'standard'   => 'game_name',
                'twosides'   => 'twosides',
                'longdragon' => 'longdragon',
                'boardgames' => 'boardgames',
                'roadbet'    => 'roadbet',
                'fantan'     => 'fantan',
                'manytables' => 'manytables',
            ];
        }

        // Check if model exists in map
        if (! isset($tableMap[$gamemodel])) {
            return "Invalid game model";
        }

        $tableName = $tableMap[$gamemodel];

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
                self::getLotteryGamesById($gameId, $gamemodel, $gametype);
            }
            return ['success' => true, 'message' => 'Update successful'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database update failed', 'error' => $e->getMessage()];
        }
    }

    public static function UpdateOddsGroupTable($gameId, $newodds, $oddpercent, $jsonPath)
    {

        $formate = number_format(round((float) json_decode($newodds)[0], 5), 5, '.', ''); // Output: 1.00000
        $sql     = "
                UPDATE odds_group
                SET std_odds = JSON_SET(std_odds, '{$jsonPath}',:subodds), oddspercentage = :oddspercentage
                WHERE odds_group_id = :odds_group_id
            ";

        $data = parent::query($sql, ['subodds' => $formate, 'oddspercentage' => $oddpercent,
            'odds_group_id'                        => $gameId]);

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

    //reset all odds
   public static function resetAllOdds()
   {
      $gameNameReset  = Utils::updateAllGamePlays();
      $oddGroupReset  = Utils::updateAllOddGroup();
      if ($gameNameReset && $oddGroupReset) {
         return ['status' => "success"];
      } else {
         return ['status' => "faliled"];
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


    //lottery exception
    public static function GamesMapIdTable($gametype)
    {
        $gametype = (int) ($gametype ?? 1); // Ensure it's an integer
        $data = parent::selectAll('gamestable_map', '*', ['game_type' => $gametype]);
        return $data ?? ''; // return as string
    }

    public static function getSingleLottery($gametypeid)
    {
         $sql = 'SELECT name,seconds_per_issue,closing_time FROM game_type WHERE gt_id = :gt_id';
         $data= parent::query($sql,['gt_id'=> $gametypeid]);
        return $data[0];
    }
      //# get totalbet  
      public static function getBetCounts($table): array
        {
            $sql = "
                 SELECT timezone,draw_period,
                    COUNT(*) AS total_count,
                    COUNT(CASE WHEN state = 1 THEN 1 END) AS settled_count,
                    COUNT(CASE WHEN state = 2 THEN 1 END) AS unsettled_count
                FROM `$table`
                 ORDER BY draw_period DESC
            ";
            $data = parent::query($sql);
             return $data[0] ?? ['total_count' => 0, 'settled_count' => 0, 'unsettled_count' => 0];
        }
    public static function getBetTotalCount($drawPeriod, $table)
    {
        $sql = "SELECT COUNT(*) AS TOTALCOUNT FROM $table WHERE draw_period = :draw_period ";
        $data= parent::query($sql,['draw_period'=> $drawPeriod]);
        return (int) $data[0]['TOTALCOUNT'];
    }

     //# settled bet
    public static function getBetStatusCount($drawPeriod, $table): int
    {
        $drawstates = 1;
        $sql = "SELECT COUNT(*) AS TOTALCOUNT FROM $table WHERE draw_period = :draw_period AND state = :state";
        $data= parent::query($sql,['draw_period'=> $drawPeriod,'state' =>$drawstates]);
        return (int) $data[0]['TOTALCOUNT'];
    }
       //# unsettled bet
     public static function getBetUsettledCount($drawPeriod, $table): int
    {
        $drawstates = 2;
        $sql = "SELECT COUNT(*) AS TOTALCOUNT FROM $table WHERE draw_period = :draw_period AND state = :state";
        $data= parent::query($sql,['draw_period'=> $drawPeriod,'state' =>$drawstates]);
        return (int) $data[0]['TOTALCOUNT'];
    }

     public static function getBetState($drawPeriod, $table)
    {
        $drawstates = 4;  $drawstatess = 7;
        $sql = "SELECT COUNT(*) AS TOTALCOUNT FROM $table WHERE draw_period = :draw_period AND state IN (:state1, :state2";
        $data= parent::query($sql,['draw_period'=> $drawPeriod,'state1' =>$drawstates,'state2'=>$drawstatess]);
        return (int) $data[0]['TOTALCOUNT'];
    }


    public static function lotteryExceptionData($page,$limit)
    {
        // $gametype = 1; // Default to 1 if not provided
        // $drawtable = self::GamesMapIdTable($gametype)[0]['draw_table'];
        // $startpoint = $page * $limit - $limit;
        // $sql  = "SELECT period FROM $drawtable ORDER BY draw_id DESC LIMIT :offset, :limit";
        // $data = parent::query($sql, [':offset' => $startpoint, ':limit' => $limit]);
        // return ["data" =>$data , "total" => count($data)]; 

         $offset = ($page - 1) * $limit;
    //   $sql = "
    //     SELECT GROUP_CONCAT(
    //         CONCAT(
    //             'SELECT bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,
    //              bt.bet_status,bt.state,bt.bet_time,bt.bet_date,bt.game_model,
    //             bt.server_date,bt.server_time,bt.timezone,
    //              gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt
    //             INNER JOIN  game_type gt ON gt.gt_id = bt.game_type') SEPARATOR ' UNION ALL '
    //     ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";
            $sql = "
            SELECT GROUP_CONCAT(
                CONCAT(
                    'SELECT bt.draw_period,bt.server_date,bt.server_time,bt.timezone,
                     bt.game_label,gt.name As game_type,gt.gt_id AS gt_id ,bt.game_model,
                     bt.draw_number,
                        COUNT(*) AS total_bets,
                        COUNT(CASE WHEN bt.state = 1 THEN 1 END) AS settled_bets,
                        COUNT(CASE WHEN bt.state = 2 THEN 1 END) AS unsettled_bets,
                        COUNT(CASE WHEN bt.state IN (4, 7) THEN 1 END) AS cancelled_bets
                    FROM ', table_name, ' bt
                    INNER JOIN game_type gt ON gt.gt_id = bt.game_type
                     WHERE bt.state = 2 GROUP BY bt.draw_period'
                ) SEPARATOR ' UNION ALL '
            ) AS query
            FROM information_schema.tables
            WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";


      $pdo = (new Database())->openLink();
      $pdo->exec("SET SESSION group_concat_max_len = 1000000");
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $mergedQuery = $stmt->fetchColumn();
      $paginatedQuery = "$mergedQuery ORDER BY server_date DESC, server_time DESC LIMIT $limit OFFSET $offset";
      $finalStmt = $pdo->prepare($paginatedQuery);
      $finalStmt->execute();
      $data = $finalStmt->fetchAll(PDO::FETCH_ASSOC);
      $stmtt = $pdo->prepare($mergedQuery);
      $stmtt->execute();
      $totalcount = $stmtt->fetchAll(PDO::FETCH_ASSOC);
      return ['data' => $data, 'total' => count($totalcount)];
    }
}