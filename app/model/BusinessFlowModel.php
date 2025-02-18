<?php

class BusinessFlowModel
{


    public static function FetchTransactionData($offset, $limit): array
    {
        $sql = "SELECT transaction.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.nickname, 'N/A') AS username FROM transaction   
        JOIN users_test ON users_test.uid = transaction.uid  ORDER BY trans_id DESC LIMIT $offset, $limit";
        $result = PDOHelper::selectAll($sql);
        $total_rows = (new Database)::openLink()->query("SELECT COUNT(*) FROM transaction")->fetchColumn();
        return [
            "data" => $result,
            "totalPages" => ceil($total_rows / $limit)
        ];
    }

    public static function FilterTransactionDataSubQuery($offset, int $limit, $params)
    {
        $conditions = [];
        $bind_params = [];
    
        // Filtering Conditions
        if (!empty($params['username'])) {
            $conditions[] = "transaction.uid = ?";
            $bind_params[] = self::getUserIdByUserName($params['username']) ?? 0;
        }
    
        if (!empty($params['transactionid'])) {
            $conditions[] = "transaction.order_id = ?";
            $bind_params[] = $params['transactionid']; // Fixed key name
        }
    
        if (!empty($params['transactiontype'])) {
            $conditions[] = "transaction.order_type = ?";
            $bind_params[] = $params['transactiontype'];
        }
    
        if (!empty($params['datefrom']) && !empty($params['dateto'])) {
            $conditions[] = "transaction.date_created BETWEEN ? AND ?";
            $bind_params[] = $params['datefrom'];
            $bind_params[] = $params['dateto'];
        } elseif (!empty($params['datefrom'])) {
            $conditions[] = "transaction.date_created >= ?";
            $bind_params[] = $params['datefrom'];
        } elseif (!empty($params['dateto'])) {
            $conditions[] = "transaction.date_created <= ?";
            $bind_params[] = $params['dateto'];
        }
    
        // Build Condition String
        $condition_str = $conditions ? "WHERE " . implode(" AND ", $conditions) : "";
    
        // SQL Query for Data
        $sql = "SELECT transaction.*, users_test.email, users_test.contact, users_test.reg_type, 
                       COALESCE(users_test.nickname, 'N/A') AS username 
                FROM transaction 
                JOIN users_test ON users_test.uid = transaction.uid 
                $condition_str 
                ORDER BY transaction.uid ASC 
                LIMIT $offset, $limit";
    
        $stmt = (new Database())->openLink()->prepare($sql);
    
        // Bind Parameters
        $stmt->execute([...$bind_params]);
    
        // SQL Query for Total Count
        $count_sql = "SELECT COUNT(*) FROM transaction JOIN users_test ON users_test.uid = transaction.uid $condition_str";
        $count_stmt = (new Database())->openLink()->prepare($count_sql);
        $count_stmt->execute($bind_params);
        $total_rows = $count_stmt->fetchColumn();
    
        return [
            "data" => $stmt->fetchAll(PDO::FETCH_ASSOC),
            "totalPages" => ceil($total_rows / $limit)
        ];
    }
    

    public static function getUserIdByUserName(string $username): int
    {
        $sql = "SELECT uid FROM users_test WHERE username = ? OR nickname = ? OR uid = ?";
        return PDOHelper::selectOne($sql, [$username, $username, $username])['uid'] ?? 0;
    }

    public static function getLotteryData(string $lotteryCode, string $lotteryId)
    {
        $tableName = Utils::getTables($lotteryId)['bet_table'];
        $sql = "SELECT * FROM $tableName WHERE bet_code = ?";
        return PDOHelper::selectAll($sql,[$lotteryCode])[0];
    }

    public static function getDepositWithdrawalData(string $reference){
        $sql = "SELECT * FROM deposit_new WHERE payment_reference =?";
        return PDOHelper::selectOne($sql,[$reference]);
    }

    // public static function filterusername(string $username)
    // {
    //     $data = parent::query("SELECT uid,username FROM users_test WHERE username LIKE :username ORDER BY username ASC", ['username' => "%{$username}%"]);
    //     return $data;
    // }

    // public static function getUsernameById(mixed $userId)
    // {
    //     $data = parent::query("SELECT username,nickname,email,contact FROM users_test WHERE uid = :uid", ['uid' => $userId])[0];
    //     return $data;
    // }

    // public static function getUserIdByMixedValued(string $mixedValue)
    // {
    //     $data =  parent::query(
    //         "SELECT uid FROM users_test WHERE uid = :uid OR username = :username",
    //         ['uid' => $mixedValue, 'username' => $mixedValue]
    //     );
    //     return !empty($data) ? $data[0]['uid'] : '0';
    // }

    // public static function getBetDataByTransactionBet($betTable, $transactionId)
    // {
    //     return parent::selectAll($betTable, '*', ['bet_code' => $transactionId]);
    // }


    // public static function  getdrawtable($gametype)
    // {
    //     $gametype = 'bt_' . $gametype;

    //     $res = parent::query("SELECT draw_table FROM gamestable_map WHERE bet_table = :bet_table", ["bet_table" => $gametype]);
    //     return  $res;
    //     return $res['draw_table'];
    // }


    // public static function getOpenAndCloseTimesByPeriod(string $period, string $table)
    // {
    //     return parent::selectAll($table, ["opening_time", "closing_time", "draw_number"], ['period' => $period]);
    // }



    // //NOTE -
    // ////////////// LOTTERY BETTING-//////////

    // public static function getAllGameIds(): array
    // {
    //     $res = parent::selectAll("gamestable_map", ["bet_table", "game_type"]);
    //     return $res;
    // }

    // public static function fetchBetRecords($page, $limit): array
    // {
    //     $startpoint = ($page * $limit) - $limit;
    //     $res = self::getAllGameIds();

    //     $data = [];
    //     $totalRecords = 0;

    //     foreach ($res as $tables) {
    //         $gameTable = $tables['bet_table'];
    //         $records = parent::query(
    //             "SELECT $gameTable.*,users_test.email,users_test.contact,users_test.username,game_type.name As game_type ,game_type.gt_id AS gt_id FROM $gameTable 
    //          JOIN users_test ON users_test.uid = $gameTable.uid 
    //          JOIN game_type ON game_type.gt_id = $gameTable.game_type 
    //          ORDER BY $gameTable.bid DESC 
    //          LIMIT :offset, :limit",
    //             ['offset' => $startpoint, 'limit' => $limit]
    //         );

    //         if (!empty($records)) {
    //             $data = array_merge($data, $records);
    //             $totalRecords += parent::count($gameTable); // Count only if there are records
    //         }
    //     }
    //     usort($data, function ($a, $b) {
    //         return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
    //     });

    //     return [
    //         'data' => $data,
    //         'total' => $totalRecords
    //     ];
    // }


    // public static function fetchLotteryname(): array
    // {
    //     return  $res = parent::selectAll("game_type", ["gt_id", "name"], ["ORDER" => ["lottery_type" => "ASC"]]);
    // }

    // public static function getLottery($gameId)
    // {
    //     return  $res =  parent::selectOne("game_type", ["name", "gt_id"], ["gt_id" => $gameId]);
    // }


    // public static function Searchusername(string $username)

    // {
    //     $query = trim($username);  // Clean the input

    //     $data = parent::query(
    //         "SELECT uid, username, email,contact
    //         FROM users_test
    //         WHERE (username LIKE :search OR contact LIKE :search OR email LIKE :search)
    //         ORDER BY 
    //             CASE
    //                 WHEN username LIKE :startsWith THEN 1  -- Prioritize usernames that start with the search term
    //                 WHEN contact LIKE :startsWith THEN 2  -- Prioritize nicknames that start with the search term
    //                 WHEN email LIKE :startsWith THEN 3  -- Prioritize emails that start with the search term
    //                 ELSE 4
    //             END,
    //             username ASC
    //         LIMIT 50",
    //         [
    //             'search' => "%$query%",  // Search anywhere within username, nickname, or email
    //             'startsWith' => "$query%" // Prioritize matches where the field starts with the query
    //         ]
    //     );

    //     return $data;
    // }


    // public static function getAllUserBetByUserId($subquery, $page, $limit)
    // {
    //     $startpoint = ($page * $limit) - $limit;
    //     $bettable = self::getAllGameIds();
    //     $data = [];
    //     $totalRecords = 0;

    //     foreach ($bettable as $tables) {
    //         $tableName = $tables['bet_table'];
    //         $sql = "
    //         SELECT 
    //             temp_table.*, 
    //             users_test.email AS email,
    //             users_test.username AS username,
    //             game_type.name AS game_type,
    //             game_type.gt_id AS gt_id
    //         FROM 
    //             (
    //                 SELECT * 
    //                 FROM $tableName
    //                 WHERE $subquery
    //             ) AS temp_table
    //         JOIN 
    //             users_test ON users_test.uid = temp_table.uid
    //         JOIN 
    //             game_type ON game_type.gt_id = temp_table.game_type
    //         LIMIT :offset, :limit
    //     ";


    //         try {

    //             $result = parent::query($sql, [
    //                 'offset' => $startpoint,
    //                 'limit' => $limit
    //             ]);

    //             if (!empty($result)) {
    //                 $data = array_merge($data, $result);
    //                 $totalRecords += count($result);
    //             }
    //         } catch (Exception $e) {
    //             // Log any exceptions or errors that occur during the query
    //             error_log("Error executing query: " . $e->getMessage());
    //         }
    //     }

    //     return ['data' => $data, 'total' => $totalRecords];
    // }

    // public static function filterBetData($uid, $gametype, $betstate, $betstatus, $enddate, $startdate)
    // {

    //     $filterConditions = [];

    //     // Build filter conditions
    //     if (!empty($uid)) {
    //         $filterConditions[] = "uid = '$uid'";
    //     }

    //     if (!empty($gametype)) {
    //         $filterConditions[] = "game_type = '$gametype'";
    //     }

    //     if (!empty($betstatus)) {
    //         $filterConditions[] = "bet_status = '$betstatus'";
    //     }

    //     if (!empty($betstate)) {
    //         $filterConditions[] = "state = '$betstate'";
    //     }

    //     if (!empty($startdate) && !empty($enddate)) {
    //         $filterConditions[] = "bet_date BETWEEN '$startdate' AND '$enddate'";
    //     } elseif (!empty($startdate)) {
    //         $filterConditions[] = "bet_date = '$startdate'";
    //     } elseif (!empty($enddate)) {
    //         $filterConditions[] = "bet_date = '$enddate'";
    //     }

    //     // Add conditions to subquery (handle WHERE and AND appropriately)
    //     if (!empty($filterConditions)) {
    //         $subQuery = implode(' AND ', $filterConditions);
    //     }
    //     // Add ordering and limit to the query
    //      $subQuery .= " ORDER BY server_date DESC";

    //     return $subQuery;
    // }




    // //NOTE -
    // //////////////TRACK RECORDS-//////////

    // public static function fetchTrackRecords($page, $limit): array
    // {
    //     $startpoint = ($page * $limit) - $limit;
    //     $data = parent::query(
    //         "SELECT trackbet.*, COALESCE(users_test.username, 'N/A') AS username FROM trackbet   
    //         JOIN users_test ON users_test.uid = trackbet.user_id  ORDER BY track_id DESC LIMIT :offset, :limit",
    //         ['offset' => $startpoint, 'limit' => $limit]
    //     );
    //     $totalRecords  = parent::count('trackbet');
    //     return ['data' => $data, 'total' => $totalRecords];
    // }
}
