<?php

class BusinessFlowModel extends MEDOOHelper
{
   public static function FetchTransactionData($page, $limit): array
   {
      $startpoint = $page * $limit - $limit;
      $data = parent::query(
         "SELECT transaction.trans_id,transaction.account_change,transaction.balance,transaction.dateTime,
            transaction.game_type,transaction.order_id,transaction.order_type,transaction.date_created,
            users_test.email,users_test.contact,users_test.reg_type,users_test.username FROM transaction 
          INNER JOIN users_test ON users_test.uid = transaction.uid ORDER BY transaction.trans_id DESC LIMIT :offset, :limit",
         ['offset' => $startpoint, 'limit' => $limit]
      );
      $totalRecords = parent::count('transaction');
      $trasationIds = array_column($data, 'order_id');
      return ['data' => $data, 'total' => $totalRecords, 'transactionIds' => $trasationIds];
   }
   public static function FilterTrsansactionDataSubQuery($username, $orderid, $ordertype, $startdate, $enddate)
   {
      $filterConditions = [];

      if (!empty($username)) {
         $filterConditions[] = "transaction.uid = '$username'";
      }

      if (!empty($orderid)) {
         $filterConditions[] = "transaction.order_id ='$orderid'";
      }

      if (!empty($ordertype)) {
         $filterConditions[] = "transaction.order_type = '$ordertype'";
      }

      if (!empty($startdate) && !empty($enddate)) {
         $filterConditions[] = "DATE(transaction.dateTime) BETWEEN '$startdate' AND '$enddate'";
      } elseif (!empty($startdate)) {
         $filterConditions[] = "DATE(transaction.dateTime) = '$startdate'";
      } elseif (!empty($enddate)) {
         $filterConditions[] = "DATE(transaction.dateTime) = '$enddate'";
      }

      // Combine conditions into the final query
      if (!empty($filterConditions)) {
         $subQuery = implode(' AND ', $filterConditions);
      }

      $subQuery .= "ORDER BY transaction.trans_id DESC";
      return $subQuery;
   }
   public static function FilterTrsansactionData($subQuery, $page, $limit)
   {
      $startpoint = $page * $limit - $limit;
      $sql = "SELECT transaction.trans_id,transaction.account_change,transaction.balance,transaction.dateTime,
               transaction.game_type,transaction.order_id,transaction.order_type,transaction.date_created,
               users_test.email,users_test.contact,users_test.reg_type,users_test.username FROM transaction 
             INNER JOIN users_test ON users_test.uid = transaction.uid WHERE $subQuery LIMIT :offset, :limit";
       
      $countSql = "SELECT COUNT(*) AS total_count FROM  transaction WHERE $subQuery";
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
      if (empty($key)) {
         return []; // Return empty if no key is provided
     }
      $data = parent::query(
            "SELECT uid FROM users_test WHERE 
               uid = :key 
               OR email = :key 
               OR username = :key 
               OR contact = :key 
               OR nickname = :key",
            ['key' => $key]
      );
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
      $offset = ($page - 1) * $limit;
      $sql = "
        SELECT GROUP_CONCAT(
            CONCAT(
                'SELECT bt.bet_odds,bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,
                bt.uid,bt.bet_number,bt.unit_stake,bt.multiplier,bt.bet_amount,bt.win_amount,
                bt.win_bonus,bt.bet_status,bt.state,bt.bet_time,bt.bet_date,bt.game_model,
                bt.server_date,bt.server_time,
                u.username,u.email,u.contact,u.reg_type, gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt INNER JOIN  users_test u ON bt.uid = u.uid
                INNER JOIN  game_type gt ON gt.gt_id = bt.game_type') SEPARATOR ' UNION ALL '
        ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";

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

   public static function getAllUserBetByUserId($uid, $betOrderID, $gametype, $betstate, $betstatus, $enddate, $startdate, $page, $limit)
   {
      $offset = ($page - 1) * $limit;

      $pdo = (new Database())->openLink();
      $pdo->exec("SET SESSION group_concat_max_len = 1000000");

      // Generate the filter query using the filterBetData method
      $subquery = self::filterBetData($uid, $betOrderID, $gametype, $betstate, $betstatus, $enddate, $startdate);
      $whereClause = $subquery['query'];

       $sql = "
        SELECT GROUP_CONCAT(
            CONCAT(
                'SELECT bt.bet_odds, bt.draw_period, bt.bet_code, bt.game_label, bt.uid, bt.bet_number, 
                 bt.unit_stake, bt.multiplier, bt.bet_amount, bt.win_amount, bt.win_bonus, bt.bet_status, bt.state, 
                 bt.bet_time, bt.bet_date, bt.game_model, bt.server_date, bt.server_time, 
                 u.username, u.email, u.contact, u.reg_type, gt.name AS game_type, gt.gt_id AS gt_id 
                 FROM ', table_name, ' bt INNER JOIN users_test u ON bt.uid = u.uid
                 INNER  JOIN game_type gt ON gt.gt_id = bt.game_type $whereClause') SEPARATOR ' UNION ALL ') 
                 AS query FROM information_schema.tables  WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'
               ";

      $mergedQuery = $pdo->query($sql)->fetchColumn();

      // Prepare to count the total number of records (without pagination)
      $countStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM ($mergedQuery) AS subquery");
      $countStmt->execute($subquery['params']);
      $totalRecords = $countStmt->fetchColumn();

      // Prepare to fetch paginated data
      $dataStmt = $pdo->prepare("$mergedQuery LIMIT $limit OFFSET $offset");
      // $dataStmt->execute();
      $dataStmt->execute($subquery['params']);

      return ['data' => $dataStmt->fetchAll(PDO::FETCH_ASSOC), 'total' => $totalRecords];
   }

   public static function filterBetData($uid, $betOrderID, $gametype, $betstate, $betstatus, $enddate, $startdate)
   {
      $filterConditions = [];
      $params = [];

      if (!empty($uid)) {
         $filterConditions[] = "bt.uid = :username";
         $params['username'] = $uid;
      }
      if (!empty($betOrderID)) {
         $filterConditions[] = "bt.bet_code = :bet_code";
         $params['bet_code'] = $betOrderID;
      }

      if (!empty($gametype)) {
         $filterConditions[] = "bt.game_type = :game_type";
         $params['game_type'] = $gametype;
      }

      if (!empty($betstate)) {
         $filterConditions[] = "bt.state = :state";
         $params['state'] = $betstate;
      }

      if (!empty($betstatus)) {
         $filterConditions[] = "bt.bet_status = :bet_status";
         $params['bet_status'] = $betstatus;
      }

      if (!empty($startdate) && !empty($enddate)) {
         $filterConditions[] = "bt.bet_date BETWEEN :startdate AND :enddate";
         $params['startdate'] = $startdate;
         $params['enddate'] = $enddate;
      } elseif (!empty($startdate)) {
         $filterConditions[] = "bt.bet_date = :startdate";
         $params['startdate'] = $startdate;
      } elseif (!empty($enddate)) {
         $filterConditions[] = "bt.bet_date = :enddate";
         $params['enddate'] = $enddate;
      }

      $whereClause = !empty($filterConditions) ? 'WHERE ' . implode(' AND ', $filterConditions) : '';

      return [
         'query' => $whereClause,
         'params' => $params,
      ];
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
         "SELECT trackbet.*,users_test.email,users_test.contact,users_test.reg_type,COALESCE(users_test.username, 'N/A') AS username FROM trackbet   
           LEFT  JOIN users_test ON users_test.uid = trackbet.user_id  ORDER BY track_id DESC LIMIT :offset, :limit",
         ['offset' => $startpoint, 'limit' => $limit]
      );
      $totalRecords = parent::count('trackbet');
      return ['data' => $data, 'total' => $totalRecords];
   }

   //filtertrack
   public static function FilterSubQuery($username, $trackstatus, $tracklotery,$trackcode, $enddate, $startdate)
   {
      $filterConditions = [];

      // Build filter conditions
      if (!empty($username)) {
         $filterConditions[] = "trackbet.user_id = '$username'";
      }

      if (!empty($trackstatus)) {
         $filterConditions[] = "trackbet.track_status = '$trackstatus'";
      }
      
      if (!empty($trackcode)) {
         $filterConditions[] = "trackbet.track_token = '$trackcode'";
      }

      if (!empty($tracklotery)) {
         $filterConditions[] = "trackbet.game_type_id = '$tracklotery'";
      }

      if (!empty($startdate) && !empty($enddate)) {
         $filterConditions[] = "trackbet.server_date BETWEEN '$startdate' AND '$enddate'";
      } elseif (!empty($startdate)) {
         $filterConditions[] = "trackbet.server_date = '$startdate'";
      } elseif (!empty($enddate)) {
         $filterConditions[] = "trackbet.server_date = '$enddate'";
      }

      // Add conditions to subquery (handle WHERE and AND appropriately)
      if (!empty($filterConditions)) {
         $subQuery = implode(' AND ', $filterConditions);
      }
      // Add ordering and limit to the query
       $subQuery .= " ORDER BY trackbet.server_date DESC";

      return $subQuery;
   }

   public static function FilterTrackData($subQuery, $page, $limit)
   {
      $startpoint = ($page - 1) * $limit;

            $sql = "
            SELECT 
               trackbet.*, 
               users_test.email AS email, 
               users_test.reg_type,
               users_test.username AS username, 
               users_test.contact
            FROM trackbet
            LEFT JOIN users_test ON users_test.uid = trackbet.user_id
            WHERE $subQuery
            LIMIT :offset, :limit
      ";

      // Define the query to count total records
      $countSqls = "
                SELECT 
                    COUNT(*) AS total_counts
                FROM 
                    trackbet
                WHERE 
                    $subQuery
            ";

      // Execute the main SQL query
      $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);

      // Execute the count query
      $totalRecordsResult = parent::query($countSqls);
      $totalRecords = $totalRecordsResult[0]['total_counts'];

      // Log the last executed query (for debugging purposes)
      $lastQuery = MedooOrm::openLink()->log();

      // Return the results
      return [ 'data' => $data, 'total' => $totalRecords, 'sql' => $lastQuery[0]];
   }

   public static function getTrackData($betTable, $tracktoken)
   {
      return parent::selectAll($betTable, '*', ['token' => $tracktoken]);
   }

   public static function getTrackStatus($tracktoken)
   {
      return parent::selectAll('trackbet', '*', ['track_token' => $tracktoken]);
   }
}
