<?php


use Medoo\Medoo;
class GameManageModel extends MEDOOHelper{ 

    public static function getTables() {
        $result = parent::selectAll('gamestable_map','*');
        $gameTable = [];
        foreach ($result as $value) {
            $gameTable[$value['game_type']] = [
                'draw_table' => $value['draw_table'],
                'bet_table' => $value['bet_table'],
                'draw_storage' => $value['draw_storage']
            ];
        }
        return $gameTable;
    }
    public static function getAllGames() {
            return parent::selectAll('game_type',['gt_id','name']);
    }

    public static function getAllGamesLottery() {
        return parent::selectAll('lottery_type', ['lt_id','name']);
    }

    public static function getLotteryGamesById(string $lotteryId, array $tables){
        $bigData = [];

        foreach($tables as $table){ 
            $sql = "SELECT name, modified_odds, state, group_type, modified_totalbet, gameplay_name,total_bets
            FROM {$table} WHERE lottery_type = :lotteryId";
    
           $data = parent::query($sql, ['lotteryId' => $lotteryId]);
    
          $bigData[$table] = $data;

        }
        return  $bigData;
    }

    

    public static function filterGameDraws($page, $limit, $gameId, $datefrom, $dateto) {
        try {
            $startpoint = ($page * $limit) - $limit;
            $conditions = self::filterConditions( $datefrom, $dateto);
            $where = $conditions['where'];
            $params = $conditions['params'];
            $drawTable = self::getTables()[$gameId]['draw_table'];
            $data = parent::query("SELECT * FROM " . $drawTable . " " . $where . "
            ORDER BY draw_id DESC LIMIT :offset, :limit"
            ,array_merge($params,['offset' => $startpoint, 'limit' => $limit]));

            $totalRecords = parent::query("SELECT * FROM " . $drawTable . " " . $where . "ORDER BY draw_id DESC"
            ,array_merge($params));
            
            return ['data' => $data, 'total' => count($totalRecords)];
    
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public static function filterConditions($datefrom = '', $dateto = '') {
        $where = '';
        $params = [];
        if ($datefrom && $dateto) {
            $where .= "WHERE date_created >= :datefrom AND date_created <= :dateto";
            $params['datefrom'] = $datefrom;  // Set datefrom parameter
            $params['dateto'] = $dateto;      // Set dateto parameter
        } elseif ($datefrom) {
            $where .= "WHERE date_created = :datefrom";
            $params['datefrom'] = $datefrom;
        } elseif ($dateto) {
            $where .= "WHERE date_created = :dateto";
            $params['dateto'] = $dateto;
        }
        return ['where'=> $where, 'params'=> $params];
    }


    public static function fetchGameTypesForLottery($lottery_id, $current_page = 1, $recordsPerPage = 10) {
    $offset = ($current_page - 1) * $recordsPerPage;
    $database = parent::openLink();
    $whereClause = trim($lottery_id) === 'all' ? "" : "WHERE game_type.lottery_type = :lottery_id";

    $sql = "SELECT lottery_type.*, game_type.*, 
            (SELECT COUNT(*) FROM game_type 
             JOIN lottery_type ON game_type.lottery_type = lottery_type.lt_id $whereClause) AS total_count 
            FROM game_type 
            JOIN lottery_type ON game_type.lottery_type = lottery_type.lt_id 
            $whereClause 
            GROUP BY game_type.gt_id 
            ORDER BY game_type.gt_id DESC 
            LIMIT :offset, :recordsPerPage";

    $params = [":offset" => $offset, ":recordsPerPage" => $recordsPerPage];
    if ($whereClause) {
        $params[":lottery_id"] = $lottery_id;
    }

    $data = $database->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);

    return $data;

}


}
