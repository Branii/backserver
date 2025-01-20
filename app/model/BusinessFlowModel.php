<?php

class BusinessFlowModel extends MEDOOHelper
{
   public static function getAllGameIdsWithCondition($condition = ""): array
   {
      return parent::selectAll("gamestable_map", ["bet_table", "game_type"], $condition);
      // $sql = "SELECT bet_table,game_type FROM gamestable_map {$condition} ";
      // $stmt = self::openConnection("lottery")->prepare($sql);
      // $stmt->execute();
      // $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      // return $data;
   }

   public static function FetchTransactionData($page, $limit): array
   {
      $startpoint = $page * $limit - $limit;
      $data = parent::query(
         "SELECT transaction.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.username, 'N/A') AS username FROM transaction   
            JOIN users_test ON users_test.uid = transaction.uid  ORDER BY trans_id DESC LIMIT :offset, :limit",
         ['offset' => $startpoint, 'limit' => $limit]
      );
      $totalRecords = parent::count('transaction');
      // $totalCount = parent::query( "SELECT COUNT(trans_id) AS total FROM transaction")[0];
      // $totalRecords =$totalCount['total'];
      $trasationIds = array_column($data, 'order_id');
      return ['data' => $data, 'total' => $totalRecords, 'transactionIds' => $trasationIds];
   }

   public static function FilterTrsansactionDataSubQuery($username, $orderid, $ordertype, $startdate, $enddate)
   {
      $filterConditions = [];

      // Build filter conditions
      if (!empty($username)) {
         $filterConditions[] = "uid = '$username'";
      }

      if (!empty($orderid)) {
         $filterConditions[] = "order_id ='$orderid'";
      }

      if (!empty($ordertype)) {
         $filterConditions[] = "order_type = '$ordertype'";
      }

      if (!empty($startdate) && !empty($enddate)) {
         $filterConditions[] = "date_created BETWEEN '$startdate' AND '$enddate'";
      } elseif (!empty($startdate)) {
         $filterConditions[] = "date_created = '$startdate'";
      } elseif (!empty($enddate)) {
         $filterConditions[] = "date_created = '$enddate'";
      }

      // Combine conditions into the final query
      if (!empty($filterConditions)) {
         $subQuery = implode(' AND ', $filterConditions);
      }

      // Add ordering and limit to the query (you can also parameterize order if needed)
      $subQuery .= " ORDER BY date_created DESC";

      // Return the final subquery
      return $subQuery;
   }

   public static function FilterTrsansactionData($subQuery, $page, $limit)
   {
      $startpoint = $page * $limit - $limit;
      $sql = "
        SELECT 
            temp_table.*, 
            users_test.email AS email,
            users_test.username AS username,
            users_test.contact AS contact,users_test.reg_type AS reg_type
           
        FROM 
            (
                SELECT * 
                FROM transaction
                WHERE $subQuery
            ) AS temp_table
        JOIN 
            users_test ON users_test.uid = temp_table.uid
         LIMIT :offset, :limit
       
        ";

      $countSql = "
                SELECT 
                    COUNT(*) AS total_count
                FROM 
                    transaction
            WHERE
                $subQuery
                ";

      $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
      $totalRecords = parent::query($countSql);
      $totalRecords = $totalRecords[0]['total_count'];
      $lastQuery = MedooOrm::openLink()->log();
      return ['data' => $data, 'total' => $totalRecords, 'sql' => $lastQuery[0]];
   }

   public static function filterusername(string $username)
   {
      $data = parent::query("SELECT uid,username FROM users_test WHERE username LIKE :username ORDER BY username ASC", ['username' => "%{$username}%"]);
      return $data;
   }

   public static function getUsernameById(mixed $userId)
   {
      $data = parent::query("SELECT username,email,contact,reg_type,uid FROM users_test WHERE uid = :uid", ['uid' => $userId])[0];
      return $data;
   }

   public static function getUserIdByUsername(string $key)
   {
     
      $data = parent::query("SELECT uid FROM users_test WHERE 
      uid = :uid 
      OR email = :email 
      OR username = :username 
      OR contact = :contact", ['uid' => $key, 'email' => $key,'username' => $key, 'contact' => $key]);
      return $data;
    
   }
   public static function getUserIdByMixedValued(string $mixedValue)
   {
      $data = parent::query("SELECT uid FROM users_test WHERE uid = :uid OR username = :username", ['uid' => $mixedValue, 'username' => $mixedValue]);
      return !empty($data) ? $data[0]['uid'] : '0';
   }

   public static function getBetDataByTransactionBet($betTable, $transactionId)
   {
      return parent::selectAll($betTable, '*', ['bet_code' => $transactionId]);
   }

   public static function getTables()
   {
      $res = parent::selectAll("gamestable_map", ["game_type", "draw_table", "bet_table", "draw_storage"]);
      $mainData = [];
      foreach ($res as $data) {
         $mainData[$data['game_type']] = $data;
      }
      return $mainData;
   }

   public static function getdrawtable($gametype)
   {
      $gametype = 'bt_' . $gametype;

      $res = parent::query("SELECT draw_table FROM gamestable_map WHERE bet_table = :bet_table", ["bet_table" => $gametype]);
      return $res;
      return $res['draw_table'];
   }

   public static function getOpenAndCloseTimesByPeriod(string $period, string $table)
   {
      return parent::selectAll($table, ["opening_time", "closing_time", "draw_number"], ['period' => $period]);
   }

   public static function ViewDeposite($orderID)
   {
      return parent::selectAll('deposits_and_withdrawals', '*', ['deposit_order' => $orderID]);
   }

   public static function ViewRedEvenlopes($orderID)
   {
      return parent::selectAll('transaction', '*', ['order_id' => $orderID]);
   }

   //NOTE -
   ////////////// LOTTERY BETTING-//////////

   public static function getAllGameIds(): array
   {
      $res = parent::selectAll("gamestable_map", ["bet_table", "game_type"]);
      return $res;
   }

   public static function fetchBetRecords($page, $limit): array
   {
      $startpoint = $page * $limit - $limit;
      //   $res = self::getAllGameIds();

      $data = [];
      $totalRecords = 0;
      $tableQuery = "
            SELECT table_name 
            FROM information_schema.tables
            WHERE table_schema = 'lottery_test'
            AND table_name LIKE 'bt_%'
        ";
      $tables = parent::query($tableQuery);

      foreach ($tables as $table) {
         $gameTable = $table['table_name'];

         $records = parent::query(
            "SELECT $gameTable.*,users_test.email,users_test.contact,users_test.username,
                users_test.reg_type, game_type.name As game_type ,game_type.gt_id AS gt_id 
                FROM $gameTable 
                JOIN users_test ON users_test.uid = $gameTable.uid 
                JOIN game_type ON game_type.gt_id = $gameTable.game_type 
                ORDER BY $gameTable.bid DESC 
                LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
         );

         if (!empty($records)) {
            $data = array_merge($data, $records);
            $totalRecords += parent::count($gameTable); // Count only if there are records
         }
      }

      usort($data, function ($a, $b) {
         return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
      });

      return ['data' => $data, 'total' => $totalRecords];
   }

   public static function fetchBetRecordsFast($page, $limit): array
   {
      $offset = ($page - 1) * $limit;
      $sql = "
        SELECT GROUP_CONCAT(
            CONCAT(
                'SELECT bt.bet_odds,bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,bt.uid,bt.bet_number,bt.unit_stake,bt.multiplier,bt.bet_amount,bt.win_amount,
                bt.bet_status,bt.state,bt.bet_time,bt.bet_date,bt.server_date,bt.server_time,
                u.username,u.email,u.contact,
                u.reg_type, gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt JOIN users_test u ON bt.uid = u.uid
                     JOIN game_type gt ON gt.gt_id = bt.game_type ') SEPARATOR ' UNION ALL '
        ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";

      $pdo = (new Database())->openLink();
      $pdo->exec("SET SESSION group_concat_max_len = 1000000");
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $mergedQuery = $stmt->fetchColumn();
      $paginatedQuery = "$mergedQuery LIMIT $limit OFFSET $offset";
      $finalStmt = $pdo->prepare($paginatedQuery);
      $finalStmt->execute();
      $data = $finalStmt->fetchAll(PDO::FETCH_ASSOC);

      // usort($data, function ($a, $b) {
      //     return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
      // });
      usort($data, function ($a, $b) {
         return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
      });

      $stmtt = $pdo->prepare($mergedQuery);
      $stmtt->execute();
      $totalcount = $stmtt->fetchAll(PDO::FETCH_ASSOC);

      return ['data' => $data, 'total' => count($totalcount)];
   }

   public static function getAllUserBetByUserId($subquery, $page, $limit)
   {
       $startpoint = $page * $limit - $limit;
       $uid = 3;
       $sql = "
        SELECT GROUP_CONCAT(
            CONCAT(
                'SELECT bt.bet_odds,bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,bt.uid,bt.bet_number,bt.unit_stake,bt.multiplier,bt.bet_amount,bt.win_amount,
                bt.bet_status,bt.state,bt.bet_time,bt.bet_date,bt.server_date,bt.server_time,
                u.username,u.email,u.contact,
                u.reg_type, gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt JOIN users_test u ON bt.uid = u.uid
                     JOIN game_type gt ON gt.gt_id = bt.game_type ') SEPARATOR ' UNION ALL '
        ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";

      $pdo = (new Database())->openLink();
      $pdo->exec("SET SESSION group_concat_max_len = 1000000");
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $mergedQuery = $stmt->fetchColumn();
      $paginatedQuery = "$mergedQuery WHERE {$subquery} LIMIT $limit OFFSET $startpoint";
      $finalStmt = $pdo->prepare($paginatedQuery);
      $finalStmt->execute();
      $data = $finalStmt->fetchAll(PDO::FETCH_ASSOC);

    //   $stmtt = $pdo->prepare($mergedQuery);
    //   $stmtt->execute();
    //   $totalcount = $stmtt->fetchAll(PDO::FETCH_ASSOC);
    $stmt1 = $pdo->prepare($mergedQuery ."WHERE {$subquery}");
    $stmt1->execute();
    $data1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

      return ['data' => $data, 'total' => count($data1)];
    //    $bettable = self::getAllGameIds();
   
    //    $data = [];
    //    $totalRecords = 0;
    //   $tableQuery = "
    //     SELECT table_name 
    //     FROM information_schema.tables
    //     WHERE table_schema = 'lottery_test'
    //         AND table_name LIKE 'bt_%'
    //     ";
    //   $tables = parent::query($tableQuery);

    //   foreach ($tables as $table) {
    //      $tableName = $table['table_name'];
    //        $sql = "
    //             SELECT 
    //                 temp_table.*, 
    //                 users_test.email AS email,
    //                 users_test.username AS username,users_test.contact AS contact,
    //                 users_test.reg_type AS reg_type,
    //                 game_type.name AS game_type,
    //                 game_type.gt_id AS gt_id
    //             FROM 
    //                 (
    //                     SELECT * 
    //                     FROM $tableName
    //                     WHERE $subquery
    //                 ) AS temp_table
    //             JOIN 
    //                 users_test ON users_test.uid = temp_table.uid
    //             JOIN 
    //                 game_type ON game_type.gt_id = temp_table.game_type
    //             LIMIT :offset, :limit
    //         ";

    //         $countSql = "
    //         SELECT 
    //             COUNT(*) AS total_count
    //         FROM 
    //             $tableName
    //     WHERE
    //         $subquery
    //         ";
     
    //      try {
    //         $result = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);
    //         if (!empty($result)) {
    //            $data = array_merge($data, $result);
    //         //   $totalRecords = count($result);
    //         }
    //         $totalResult = parent::query($countSql);
    //         if ($totalResult && isset($totalResult[0]['total_count'])) {
    //             $totalRecords += $totalResult[0]['total_count'];
    //         }
    //         return ['data' => $data, 'total' => $totalRecords];
          
    //      } catch (Exception $e) {
    //         // Log any exceptions or errors that occur during the query
    //         error_log("Error executing query: " . $e->getMessage());
    //      }
    //   }
  
 

   }

   public static function filterBetData($uid, $gametype, $betstate, $betstatus, $enddate, $startdate)
   {
      $filterConditions = [];

      // Build filter conditions
      if (!empty($uid)) {
         $filterConditions[] = "bt.uid = '$uid'";
      }

      if (!empty($gametype)) {
         $filterConditions[] = "bt.game_type = '$gametype'";
      }

      if (!empty($betstatus)) {
         $filterConditions[] = "bt.bet_status = '$betstatus'";
      }

      if (!empty($betstate)) {
         $filterConditions[] = "bt.state = '$betstate'";
      }

      if (!empty($startdate) && !empty($enddate)) {
         $filterConditions[] = "bt.bet_date BETWEEN '$startdate' AND '$enddate'";
      } elseif (!empty($startdate)) {
         $filterConditions[] = "bt.bet_date = '$startdate'";
      } elseif (!empty($enddate)) {
         $filterConditions[] = "bt.bet_date = '$enddate'";
      }

      // Add conditions to subquery (handle WHERE and AND appropriately)
      if (!empty($filterConditions)) {
         $subQuery = implode(' AND ', $filterConditions);
      }
      // Add ordering and limit to the query
      // $subQuery .= " ORDER BY bt.server_date DESC";

      return $subQuery;
   
   }

   public static function fetchLotteryname(): array
   {
      return $res = parent::selectAll("game_type", ["gt_id", "name"], ["ORDER" => ["lottery_type" => "ASC"]]);
   }

   public static function getLottery($gameId)
   {
      return $res = parent::selectOne("game_type", ["name", "gt_id"], ["gt_id" => $gameId]);
   }

   public static function Searchusername(string $username)
   {
      $query = trim($username); // Clean the input

      $data = parent::query(
         "SELECT uid, username, email,contact,reg_type
            FROM users_test
            WHERE (username LIKE :search OR contact LIKE :search OR email LIKE :search)
            ORDER BY 
                CASE
                    WHEN username LIKE :startsWith THEN 1  -- Prioritize usernames that start with the search term
                    WHEN contact LIKE :startsWith THEN 2  -- Prioritize nicknames that start with the search term
                    WHEN email LIKE :startsWith THEN 3  -- Prioritize emails that start with the search term
                    ELSE 4
                END,
                username ASC
            LIMIT 50",
         [
            'search' => "%$query%", // Search anywhere within username, nickname, or email
            'startsWith' => "$query%", // Prioritize matches where the field starts with the query
         ]
      );

      return $data;
   }

   //NOTE -
   //////////////TRACK RECORDS-//////////

   public static function fetchTrackRecords($page, $limit): array
   {
      $startpoint = $page * $limit - $limit;
      $data = parent::query(
         "SELECT trackbet.*,users_test.email,users_test.contact,COALESCE(users_test.username, 'N/A') AS username FROM trackbet   
            JOIN users_test ON users_test.uid = trackbet.user_id  ORDER BY track_id DESC LIMIT :offset, :limit",
         ['offset' => $startpoint, 'limit' => $limit]
      );
      $totalRecords = parent::count('trackbet');
      foreach ($data as &$record) {
         $record['total_prize'] = self::GetTrackWins($record['track_token']);
      }

      return ['data' => $data, 'total' => $totalRecords];
   }

   public static function GetTrackWins($token)
   {
      $bettable = self::getAllGameIds();
      $totalPrize = 0;

      foreach ($bettable as $tables) {
         $tableName = $tables['bet_table'];

         $sql = "SELECT SUM(win_bonus) AS total_prize FROM {$tableName} 
                    WHERE token = :token AND bet_status = 2 AND state = 1";

         try {
            // Execute the query and fetch the data
            $data = parent::query($sql, ['token' => $token]);

            // If data is returned and total_prize exists, add it to the accumulator
            if ($data && isset($data[0]['total_prize'])) {
               $totalPrize += $data[0]['total_prize'];
            }
         } catch (Exception $e) {
            // Log any exceptions or errors that occur during the query
            error_log("Error executing query for table {$tableName}: " . $e->getMessage());
         }
      }

      // Return the total prize accumulated from all tables
      return $totalPrize;
   }
}
