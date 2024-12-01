<?php 

class BusinessFlowModel extends MEDOOHelper{


    public static function FetchTrsansactionData($page, $limit): array 
    { 
        $startpoint = ($page * $limit) - $limit; 
        $data = parent::query( 
            "SELECT transaction.*, COALESCE(users.username, 'N/A') AS username FROM transaction   
            JOIN users ON users.uid = transaction.uid  ORDER BY trans_id DESC LIMIT :offset, :limit", 
            ['offset' => $startpoint, 'limit' => $limit] 
        ); 
        $totalRecords  = parent::count('transaction');
        return ['data' => $data, 'total' => $totalRecords];
    } 

    public static function FilterTrsansactionDataSubQuery($username ='', $orderid='', $ordertype='', $from='', $to=''){
        $conditions = [];

        if (!empty($username) && $username != 'all') {
            $conditions['transaction.uid'] = $username;
        }
    
        if (!empty($orderid) && $orderid != 'all') {
            $conditions['transaction.order_id'] = $orderid;
        }
    
        if (!empty($ordertype) && $ordertype != 'all') {
            $conditions['transaction.order_type'] = $ordertype;
        }
    
        if ($from != '' && $to != '') {
            $conditions['transaction.date_created[<>]'] = [$from, $to];
        } elseif ($from != '') {
            $conditions['transaction.date_created[>=]'] = $from;
        } elseif ($to != '') {
            $conditions['transaction.date_created[<=]'] = $to;
        }
    
        return $conditions;
    }

    public static function FilterTrsansactionData($page, $limit, $username, $orderid, $ordertype, $startdate, $enddate) 
    { 

        $whereConditions = self::FilterTrsansactionDataSubQuery($username, $orderid, $ordertype, $startdate,$enddate);
        $startpoint = ($page * $limit) - $limit; 
        $data = parent::selectAll("transaction",'*',[
            "AND" => $whereConditions,
            "ORDER" => ["transaction.trans_id" => "DESC"],
            "LIMIT" => [$startpoint, $limit]
        ]); 
        $lastQuery = MedooOrm::openLink()->log();
        $totalRecords  = parent::selectAll('transaction','*',     [
            'AND' => $whereConditions]);
        return ['data' => $data, 'total' => count($totalRecords), 'sql' => $lastQuery[0]];
    } 

    public static function filterusername(string $username){
        $data = parent::query("SELECT uid,username FROM users WHERE username LIKE :username ORDER BY username ASC",['username' => "%{$username}%"]);
        return $data;
    }

    public static function getUsernameById(mixed $userId){
        $data = parent::query("SELECT username FROM users WHERE uid = :uid",['uid' => $userId])[0]['username'];
        return $data;
    }

    public static function getUserIdByMixedValued(string $mixedValue){
        $data =  parent::query(
            "SELECT uid FROM users WHERE uid = :uid OR username = :username",
            ['uid' => $mixedValue, 'username' => $mixedValue]
        );
        return !empty($data) ? $data[0]['uid'] : '0';
    }

    public static function getBetDataByTransactionBet($betTable,$transactionId){
        return parent::selectAll($betTable,'*',['bet_code'=>$transactionId]);
    }

    public static function getTables(){
        $res = parent::selectAll("gamestable_map", ["game_type", "draw_table", "bet_table", "draw_storage"]); 
        $mainData = []; 
        foreach ($res as $data) { 
            $mainData[$data['game_type']] = $data; 
        } 
        return $mainData; 
    }

    public static function getOpenAndCloseTimesByPeriod(string $period, string $table){
        return parent::selectAll($table, ["opening_time", "closing_time","draw_number"],['period' => $period]); 
    }


    
    //NOTE -
    ////////////// LOTTERY BETTING-//////////

    public static function getAllGameIds(): array
    {
        $res = parent::selectAll("gamestable_map", ["bet_table"]);
        return $res;
    }

    public static function fetchBetRecords($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $res = self::getAllGameIds();
         $data = [];
         $totalRecords = 0;

        foreach ($res as $tables) {
            $gameTable = $tables['bet_table'];
            $records = parent::query(
                "SELECT $gameTable.*, users.username,game_type.name As game_type FROM $gameTable 
             JOIN users ON users.uid = $gameTable.uid 
             JOIN game_type ON game_type.gt_id = $gameTable.game_type 
             ORDER BY $gameTable.bid DESC 
             LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]
            );

            if (!empty($records)) {
                $data = array_merge($data, $records);
                $totalRecords += parent::count($gameTable); // Count only if there are records
            }
        }
        usort($data, function ($a, $b) {
            return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
        });

        return [
            'data' =>$data ,
            'total' => $totalRecords
         ];
    }


    public static function fetchLotteryname(): array
    {
        return  $res = parent::selectAll("game_type", ["gt_id", "name"], ["ORDER" => ["lottery_type" => "ASC"]]);
    }

    public static function getLottery($gameId)
    {
        return  $res =  parent::selectOne("game_type", ["name"], ["gt_id" => $gameId])['name'];
    }



    
    //NOTE -
    //////////////TRACK RECORDS-//////////

    public static function fetchTrackRecords($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit; 
        $data = parent::query( 
            "SELECT trackbet.*, COALESCE(users.username, 'N/A') AS username FROM trackbet   
            JOIN users ON users.uid = trackbet.user_id  ORDER BY track_id DESC LIMIT :offset, :limit", 
            ['offset' => $startpoint, 'limit' => $limit] 
        ); 
        $totalRecords  = parent::count('trackbet');
        return ['data' => $data, 'total' => $totalRecords];
    }

    
 
}
