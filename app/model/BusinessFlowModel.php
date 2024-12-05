<?php 

class BusinessFlowModel extends MEDOOHelper{


    public static function FetchTransactionData($page, $limit): array 
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
        $data = parent::query("SELECT uid,username FROM users_test WHERE username LIKE :username ORDER BY username ASC",['username' => "%{$username}%"]);
        return $data;
    }

    public static function getUsernameById(mixed $userId){
        $data = parent::query("SELECT username,nickname FROM users_test WHERE uid = :uid",['uid' => $userId])[0];
        return $data;
    }

    public static function getUserIdByMixedValued(string $mixedValue){
        $data =  parent::query(
            "SELECT uid FROM users_test WHERE uid = :uid OR username = :username",
            ['uid' => $mixedValue, 'username' => $mixedValue]
        );
        return !empty($data) ? $data[0]['uid'] : '0';
    }

    public static function getBetDataByTransactionBet($betTable,$transactionId){
        return parent::selectAll($betTable,'*',['bet_code'=> $transactionId]);
    }

    public static function getTables(){
        $res = parent::selectAll("gamestable_map", ["game_type", "draw_table", "bet_table", "draw_storage"]); 
        $mainData = []; 
        foreach ($res as $data) { 
            $mainData[$data['game_type']] = $data; 
        } 
        return $mainData; 
    }

    public static function  getdrawtable($gametype){
        $gametype = 'bt_'.$gametype;
        
        $res = parent::query("SELECT draw_table FROM gamestable_map WHERE bet_table = :bet_table", ["bet_table" => $gametype]);
       return  $res;
        return $res['draw_table']; 
    }
 

    public static function getOpenAndCloseTimesByPeriod(string $period, string $table){
        return parent::selectAll($table, ["opening_time", "closing_time","draw_number"],['period' => $period]); 
    }


    
    //NOTE -
    ////////////// LOTTERY BETTING-//////////

    public static function getAllGameIds(): array
    {
        $res = parent::selectAll("gamestable_map", ["bet_table","game_type"]);
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
                "SELECT $gameTable.*,users_test.nickname, users_test.username,game_type.name As game_type ,game_type.gt_id AS gt_id FROM $gameTable 
             JOIN users_test ON users_test.uid = $gameTable.uid 
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
        return  $res =  parent::selectOne("game_type", ["name","gt_id"], ["gt_id" => $gameId]);
    }

    
    public static function Searchusername(string $username)
    {
        $data = parent::query(
            "SELECT uid, username, nickname
            FROM users_test 
            WHERE username LIKE :search OR nickname LIKE :search
            ORDER BY 
                CASE 
                    WHEN username LIKE :startsWith THEN 1  -- Prioritize usernames that start with the search term
                    WHEN nickname LIKE :startsWith THEN 1  -- Prioritize nicknames that start with the search term
                    ELSE 2
                END, 
                username ASC 
            LIMIT 50",
            ['search' => "%$username%", 'startsWith' => "$username%"]
        );
        return $data; 
    }


    public static function getAllUserBetByUserId($subquery,$page,$limit)
    {
        $startpoint = ($page * $limit) - $limit; 
        $bettable = self::getAllGameIds();
        $data = [];
        $totalRecords = 0;
        
        foreach ($bettable as $tables) {
            $tableName = $tables['bet_table'];
        
            // Prepare the query with proper table aliases and JOINs
            $sql = "SELECT * FROM $tableName WHERE $subquery LIMIT :offset, :limit";
        
            try {
      
                $result = parent::query($sql, [
                    'offset' => $startpoint, 
                    'limit' => $limit
                ]);
        
                if (!empty($result)) {
                    $data = array_merge($data, $result);
                    $totalRecords += count($result);
                }
            } catch (Exception $e) {
                // Log any exceptions or errors that occur during the query
                error_log("Error executing query: " . $e->getMessage());
            }
        }
        
        return ['data' => $data, 'total' => $totalRecords];
        
    }
    
    public static function filterBetData($uid, $gametype, $betstate, $betstatus, $enddate, $startdate )
    {
      
        $filterConditions = [];
    
        // Build filter conditions
        if (!empty($uid)) {
            $filterConditions[] = "uid = '$uid'";
        }
    
        if (!empty($gametype)) {
            $filterConditions[] = "game_type = '$gametype'";
        }
    
        if (!empty($betstatus)) {
            $filterConditions[] = "bet_status = '$betstatus'";
        }
    
        if (!empty($betstate)) {
            $filterConditions[] = "state = '$betstate'";
        }
    
        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "bet_date BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "bet_date = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "bet_date = '$enddate'";
        }
    
        // Add conditions to subquery (handle WHERE and AND appropriately)
        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        } 
        // Add ordering and limit to the query
        // $subQuery .= " ORDER BY server_date DESC";
    
        return $subQuery;
    }
    


    
    //NOTE -
    //////////////TRACK RECORDS-//////////

    public static function fetchTrackRecords($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit; 
        $data = parent::query( 
            "SELECT trackbet.*, COALESCE(users_test.username, 'N/A') AS username FROM trackbet   
            JOIN users_test ON users_test.uid = trackbet.user_id  ORDER BY track_id DESC LIMIT :offset, :limit", 
            ['offset' => $startpoint, 'limit' => $limit] 
        ); 
        $totalRecords  = parent::count('trackbet');
        return ['data' => $data, 'total' => $totalRecords];
    }

    
 
}
