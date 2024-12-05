<?php

class GameManageModel extends MEDOOHelper{ 

    public static function getTables() {
        $result = parent::selectAll('gamestable_map',columns: '*');
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



}
