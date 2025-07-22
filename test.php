<?php
ini_set("display errors_errors",1);
$dsn = 'mysql:host=192.168.1.51;dbname=lottery_test'; // Fixed variable name and removed extra space
$pass = "enzerhub";
$user = "enzerhub";

try {
    $pdo = new PDO($dsn, $user, $pass);
 //    echo "Connected";
} catch (\Throwable $th) {
    echo $th->getMessage();
    
}


// $str = [1,2,3,3,4,7,5,9,10];

// unset($str[array_search(1,$str)]);
// echo implode(",",$str);

// return;
// $limit = 50;
// $offset = 1;
// $uid = 3;
// $sql = "
//         SELECT GROUP_CONCAT(
//             CONCAT(
//                 'SELECT bt.bet_odds,bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,bt.uid,bt.bet_number,bt.unit_stake,bt.multiplier,bt.bet_amount,bt.win_amount,
//                 bt.bet_status,bt.state,bt.bet_time,bt.bet_date,bt.server_date,bt.server_time,
//                 u.username,u.email,u.contact,
//                 u.reg_type, gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt JOIN users_test u ON bt.uid = u.uid
//                      JOIN game_type gt ON gt.gt_id = bt.game_type ') SEPARATOR ' UNION ALL '
//         ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";


        // $sqll = "
        // SELECT GROUP_CONCAT(
        //     CONCAT(
        //         'SELECT bt.bet_odds,bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,bt.uid,bt.bet_number,bt.unit_stake,bt.multiplier,bt.bet_amount,bt.win_amount,
        //         bt.bet_status,bt.state,bt.bet_time,bt.bet_date,bt.server_date,bt.server_time,
        //         u.username,u.email,u.contact,
        //         u.reg_type, gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt JOIN users_test u ON bt.uid = u.uid
        //              JOIN game_type gt ON gt.gt_id = bt.game_type ') SEPARATOR ' UNION ALL '
        // ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";

//         $sql2 = "
//         SELECT GROUP_CONCAT(
//             CONCAT(
//                 'SELECT 
//                     bt.bet_odds, bt.draw_period, bt.bet_code, bt.game_label, bt.game_type, bt.uid, 
//                     bt.bet_number, bt.unit_stake, bt.multiplier, bt.bet_amount, bt.win_amount, 
//                     bt.bet_status, bt.state, bt.bet_time, bt.bet_date, bt.server_date, bt.server_time, 
//                     u.username, u.email, u.contact, u.reg_type, 
//                     gt.name AS game_type, gt.gt_id AS gt_id, 
//                     SUM(bt.bet_amount) AS total_bet_amount, 
//                     SUM(bt.win_amount) AS total_win_amount 
//                 FROM ', table_name, ' bt 
//                 JOIN users_test u ON bt.uid = u.uid 
//                 JOIN game_type gt ON gt.gt_id = bt.game_type 
//                 WHERE bt.uid = 3 
//                 GROUP BY bt.draw_period') 
//             SEPARATOR ' UNION ALL '
//         ) AS query 
//         FROM information_schema.tables 
//         WHERE table_schema = 'lottery_test' 
//         AND table_name LIKE 'bt_%'";
//     //   $pdo = (new Database())->openLink();
//       $pdo->exec("SET SESSION group_concat_max_len = 1000000");
//       $stmt = $pdo->prepare($sql2);
//       $stmt->execute();
//       $mergedQuery = $stmt->fetchColumn();
//     //   $paginatedQuery = "$mergedQuery WHERE bt.uid = '1' LIMIT $limit OFFSET $offset";
//     //   $finalStmt = $pdo->prepare($paginatedQuery);
//     //   $finalStmt->execute();
//     //   $data = $finalStmt->fetchAll(PDO::FETCH_ASSOC);

//    //   echo json_encode(count($data));
//       echo json_encode($mergedQuery );exit;

//       $bbb = $pdo->prepare($sqll);
//       $bbb->execute();
//       $mergedQuery1 = $bbb->fetchColumn();
//       $countQ = "$mergedQuery1 WHERE bt.uid = '3'";
//       $ccc = $pdo->prepare($countQ);
//       $ccc->execute();
//       $datac = $ccc->fetchAll(PDO::FETCH_ASSOC);
//       $result = [
//         'data' => $countQ,
//         'count'  =>  count($datac)
//       ];
//       echo json_encode($result);
//       $sqll = "
//       SELECT GROUP_CONCAT(CONCAT('SELECT COUNT(*) AS total FROM ', table_name, ' WHERE uid = :uid') SEPARATOR ' UNION ALL ') AS query
//       FROM information_schema.tables
//       WHERE table_schema = 'lottery'
//       AND table_name LIKE 'bt_%'
//   ";
//   //$pdo->exec("SET SESSION group_concat_max_len = 1000000");
//   $stmt = $pdo->prepare($sqll);
//   $stmt->execute();
//   $mergedQuery = $stmt->fetchColumn();
//   $stmt = $pdo->prepare($mergedQuery);
//   $stmt->execute(['uid' => 197]);
//   $count = $stmt->fetchAll(PDO::FETCH_ASSOC);
//   $totalcount = array_sum(array_column($count,'total'));
//   echo json_encode([
//       'data' => $rows,
//       'total' => ceil($totalcount / $limit)
//   ]);
  
//   $sql = "
//     SELECT GROUP_CONCAT(CONCAT('SELECT * FROM ', table_name, ' WHERE uid = :uid') SEPARATOR ' UNION ALL ') AS query
//     FROM information_schema.tables
//     WHERE table_schema = 'lottery_test'
//     AND table_name LIKE 'bt_%'
// ";

//  //$pdo = (new Database)->connect();
// $pdo->exec("SET SESSION group_concat_max_len = 1000000");
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $mergedQuery = $stmt->fetch();

// // Update the merged query to include pagination
// $paginatedQuery = "$mergedQuery";

// $stmt = $pdo->prepare($paginatedQuery);
// $stmt->execute(['uid' => 2]);
// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r(value: count($rows));



// try {
//     $pdo = new PDO($dsn, $user, $pass);
//  //    echo "Connected";
// } catch (\Throwable $th) {
//     echo $th->getMessage();
// }
// $sql = "
//     SELECT GROUP_CONCAT(CONCAT('SELECT * FROM ', table_name, ' WHERE uid = 1') SEPARATOR ' UNION ALL ') AS query
//     FROM information_schema.tables
//     WHERE table_schema = 'lottery_test'
//     AND table_name LIKE 'bt_%'
// ";
// $page = $_GET['page'] ?? 1;
// $limit = $_GET['limit'] ?? 5;
// $keyword = $_GET['keyword'] ?? "default";
// $offset = ($page - 1) * $limit;
// //$userId = getUserIdByUserName($pdo, $keyword);
// // $userId = "3";
//  $where = " WHERE bettype = 1 AND uid = 3"; // your sub query here ok


// $pdo->exec("SET SESSION group_concat_max_len = 1000000");

// // Get query froma all tables
// $sql = "
//     SELECT GROUP_CONCAT('SELECT uid,bettype,bet_amount,game_label,user_selection FROM ', table_name, '$where' SEPARATOR ' UNION ALL ') 
//     AS query FROM information_schema.tables 
//     WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'
// ";
// $mergedQuery = $pdo->query($sql)->fetchColumn();

// // Get the total count
// $countStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM ($mergedQuery) AS subquery");
// // $countStmt->execute(['uid' => $userId]);
// $total = $countStmt->fetchColumn();

// // Fetch paginated data
// $dataStmt = $pdo->prepare("$mergedQuery LIMIT $limit OFFSET $offset");
// // $dataStmt->execute(['uid' => $userId]);

// echo json_encode([
//     'total' => ceil($total/$limit),
//      'data' => $dataStmt->fetchAll(PDO::FETCH_ASSOC),
//     'count' => $mergedQuery
// ]);

// //helper function, you can put this in a separate file
// // function getUserIdByUserName($pdo, $keyword) {
// //     $sql = "SELECT uid FROM users_test WHERE username = :keyword OR email = :keyword OR uid = :keyword";
// //     $stmt = $pdo->prepare($sql);
// //     $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
// //     $stmt->execute();
// //     return $stmt->fetchColumn();
// // }


// $page = $_GET['page'] ?? 1;
// $limit = $_GET['limit'] ?? 5;
// $keyword = $_GET['keyword'] ?? "default"; // You can sanitize the keyword later if needed
// $offset = ($page - 1) * $limit;

// // Your base query (adjusted to your needs)
// $where = " WHERE bt.bet_status = 2 AND bt.uid = 3"; // Adjust this where clause if necessary

// // Set session for group_concat_max_len
// $pdo->exec("SET SESSION group_concat_max_len = 1000000");

// // Generate dynamic query to get the SELECT statements from all tables
// // $sql = "
// //     SELECT GROUP_CONCAT(
// //         'SELECT uid, bettype,bet_status, bet_amount, game_label, user_selection FROM ', table_name, '$where' 
// //         SEPARATOR ' UNION ALL '
// //     ) AS query
// //     FROM information_schema.tables 
// //     WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'
// // ";
// $sql = "
//     SELECT GROUP_CONCAT(
//         CONCAT(
//             'SELECT bt.bet_odds, bt.draw_period, bt.bet_code, bt.game_label,bt.uid, bt.bet_number, 
//              bt.unit_stake, bt.multiplier, bt.bet_amount, bt.win_amount, bt.win_bonus, bt.bet_status, bt.state, 
//              bt.bet_time, bt.bet_date, bt.game_model, bt.server_date, bt.server_time, 
//              u.username, u.email, u.contact, u.reg_type, 
//              gt.name AS game_type, gt.gt_id AS gt_id 
//              FROM ', table_name, ' bt 
//              JOIN users_test u ON bt.uid = u.uid
//              JOIN game_type gt ON gt.gt_id = bt.game_type
//              $where'
//         ) SEPARATOR ' UNION ALL '
//     ) AS query 
//     FROM information_schema.tables 
//     WHERE table_schema = 'lottery_test' 
//     AND table_name LIKE 'bt_%'
// ";
// // Execute the query to get the merged query string
// $mergedQuery = $pdo->query($sql)->fetchColumn();

// // Prepare to count the total number of records (without pagination)
// $countStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM ($mergedQuery) AS subquery");
// $countStmt->execute();
// $total = $countStmt->fetchColumn();

// // Prepare to fetch paginated data
// $dataStmt = $pdo->prepare("$mergedQuery LIMIT $limit OFFSET $offset");
// $dataStmt->execute();

// Return the response as a JSON
// echo json_encode([
//     'total' => ceil($total / $limit), // Calculate the total pages
//     'data' => $dataStmt->fetchAll(PDO::FETCH_ASSOC), // The paginated data
//     'count' => $total // Total count of records
// ]);

// Set the timezone for the server (Berlin time)

?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Testnet Bitcoin Payment</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      text-align: center;
    }
    #wallet-box {
      margin: 20px auto;
      width: 320px;
    }
    input[type="text"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      text-align: center;
    }
    button {
      margin-top: 10px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }
    #qrcode {
      margin-top: 30px;
      position: relative;
      left: 42%;
    }
  </style>
</head>
<body>

  <h2>Send or Scan to Pay (Testnet)</h2>
  <p>Scan the QR code or copy the testnet wallet address below</p>

  <div id="wallet-box">
    <input type="text" id="wallet-address" readonly>
    <button onclick="copyWallet()">Copy Wallet Address</button>
  </div>

  <div id="qrcode">

  </div>

  <script>
    // Replace this with your own Bitcoin testnet address
    const walletAddress = "bc1q3dvptrtjvt9807875wvsnej2spvw07r9g8kwd7";

    window.onload = function () {
      document.getElementById("wallet-address").value = walletAddress;

      new QRCode(document.getElementById("qrcode"), {
        text: `bitcoin:${walletAddress}?amount=0.001`,
        width: 256,
        height: 256
      });
    };

    function copyWallet() {
      const input = document.getElementById("wallet-address");
      input.select();
      input.setSelectionRange(0, 99999); // Mobile
      document.execCommand("copy");
      alert("Wallet address copied!");
    }
  </script>

</body>
</html> -->

<?php
// 1. What timezone is the server set to?
// $serverTzName = date_default_timezone_get();  
// $serverTz     = new DateTimeZone($serverTzName);

// // 2. Create a DateTime “now” in the server’s timezone
// $now = new DateTime('now', $serverTz);

// // 3. How many seconds is server-time ahead of (or behind) UTC?
// $serverOffsetSeconds = $serverTz->getOffset($now);

// // Convert to hours/minutes
// $hours   = intdiv($serverOffsetSeconds, 3600);
// $minutes = abs(($serverOffsetSeconds % 3600) / 60);

// // Build a nice string like “+02:00” or “-05:30”
// $sign = $serverOffsetSeconds >= 0 ? '+' : '-';
// $offsetFormatted = sprintf('%s%02d', $sign, abs($hours));

// 4. (Optional) Compare to another timezone, e.g. “America/New_York”
// function diffFromServerTz(string $otherTzName = ""): string {
//     date_default_timezone_set("Africa/Accra");  
//     $serverZone = new DateTimeZone(date_default_timezone_get());
//     $otherTzName  = "Asia/Shanghai";
//     $otherZone  = new DateTimeZone($otherTzName);
//     $now        = new DateTime('now', $serverZone);

//     $serverOffset = $serverZone->getOffset($now);
//     $otherOffset  = $otherZone->getOffset($now);
//     $diffSeconds  = $otherOffset - $serverOffset;

//     $h = intdiv(abs($diffSeconds), 3600);
//     $m = abs(($diffSeconds % 3600) / 60);
//     $s = $diffSeconds >= 0 ? '+' : '-';

//     return  $otherTzName."  ".sprintf('%s%02d', $s, $h, );
// }

// echo  diffFromServerTz();


// use MaxMind\Db\Reader;
// // open the local MMDB file
// $reader = new Reader('/path/to/GeoLite2-City.mmdb');
// $record = $reader->get('8.8.8.8');

// // record['location']['time_zone'] holds the tz string
// echo $record['location']['time_zone'];  // e.g. "America/Chicago"



    // public function createNewGame(array $gameData, string $gamesTable)
    // {
    //     $logo = "logo911699540141axesdfd654cecad3c4c7.webp";
    //     $sql = Query::createNewGameQuery($gamesTable);
    //     $linker = bin2hex(random_bytes(7));
    //     //file_put_contents('./log.txt',json_encode($this->checkIfLotteryExist($gameData['name']),JSON_PRETTY_PRINT));
    //     if (count($this->checkIfLotteryExist($gameData['name'])) > 0) {
    //         return ['type' => 'error', 'message' => 'Lottery name already exist'];
    //     }
    //     $result = $this->Helper->insert($sql, (new Params())->addNewLotteryGameParam($gameData, $logo, $linker));
    //     //file_put_contents('./log.txt',json_encode($result));

    //     if ($result >= 1) {
    //         $lotteryId = $this->getGameByLinker($linker)[0]['gt_id'];
    //         //file_put_contents('./log.txt',json_encode($lotteryId));

    //         $mapData = [
    //             'game_type' => $lotteryId,
    //             'draw_table' => 'dt_' . str_replace(' ', '', $gameData['name']),
    //             'draw_storage' => 'ds_' . str_replace(' ', '', $gameData['name']),
    //             'bet_table' => 'bt_' . str_replace(' ', '', $gameData['name']),
    //             'lottery_type' => $gameData['lottery_type'],
    //             'game_group' => $gameData['game_group']
    //         ];
    //         $sqlMap = Query::addNewGameToMapQuery();
    //         $yes = $this->Helper->insert($sqlMap, (new Params())->addNewGamesTableMapParam($mapData));
    //         //file_put_contents('./log.txt',json_encode($yes,JSON_PRETTY_PRINT));
    //         if ($yes >= 1) {
    //             $sql1 = "CREATE TABLE " . $mapData['draw_table'] . " LIKE dt_1kb5d1m";
    //             $sql2 = "CREATE TABLE " . $mapData['draw_storage'] . " LIKE ds_1kb5d1m";
    //             $sql3 = "CREATE TABLE " . $mapData['bet_table'] . " LIKE bt_1kb5d1m";
    //             (new Helper())->Executequery($sql1);
    //             (new Helper())->Executequery($sql2);
    //             (new Helper())->Executequery($sql3);
    //             return ['type' => 'success', 'message' => 'New game created successfully'];
    //         }

    //     } else {
    //         return ['type' => 'error', 'message' => 'Lottery game could not be created'];
    //     }
    // }




    // public static function createNewGameQuery(string $gamesTable)
    // {

    //     $sql = "INSERT INTO $gamesTable (
    //     name,logo,alias,starttime,stoptime,state,game_type,draw_type,lottery_type,seconds_per_issue,
    //     total_num_issue,closing_time,num_balls,min_ball,max_ball,lottery_model,game_group,last_updated,date_created,linker)VALUES
    //     (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
    //     return $sql;
    // }


    // public function checkIfLotteryExist(string $lotteryName)
    // {
    //     $sql = "SELECT * FROM game_type WHERE name = ? ";
    //     return $this->Helper->selectAll($sql, [$lotteryName]);
    // }


    // public function addNewLotteryGameParam(array $gameData, string $logo, string $linker){
    //     return [
    //         (string) $gameData['name'],
    //         (string) $logo,
    //         (string) $gameData['name'] . $gameData['seconds_per_issue'], //alias
    //         (string) $gameData['starttime'],
    //         (string) $gameData['stoptime'], 
    //         (string) 1, // lottery state 1
    //         (string) 1, // game type
    //         (string) 1, // draw type
    //         (string) $gameData['lottery_type'],
    //         (string) $gameData['seconds_per_issue'],
    //         (string) $gameData['total_num_issue'], 
    //         (string) 1, // closing time
    //         (string) $gameData['num_of_balls'],
    //         (string) $gameData['min_ball'],
    //         (string) $gameData['max_ball'],
    //         (string) $gameData['lottery_model'],
    //         (string) $gameData['game_group'], 
    //         (string) date("Y-m-d"),
    //         (string) date("Y-m-d"),
    //         $linker
    //     ];
    // }



    // public function getGameByLinker(string $linker)
    // {
    //     $sql = "SELECT gt_id FROM game_type WHERE linker  = ? ";
    //     return $this->Helper->selectAll($sql, [$linker]);
    // }


    // public function addNewGamesTableMapParam(array $gameData){
    //     return [
    //         (string) $gameData['game_type'],
    //         (string) $gameData['draw_table'],
    //         (string) $gameData['draw_storage'],
    //         (string) $gameData['bet_table'],
    //         (string) $gameData['lottery_type'],
    //         (string) $gameData['game_group']
    //     ];
    // }




    //  function getAllGamesPlayByLotteryType($pdo, $lotteryType=6)  {
      
    //     try {  
    //                 $sql = "SELECT gn_id, name, odds, total_bets, lottery_type, standard_odds, standard_total_bets FROM game_name WHERE lottery_type = ?";
    //         return $pdo->selectAll($sql, [$lotteryType]);        } catch (\Throwable $th) {
    //              return [];
    //     }    }

    //     print_r(getAllGamesPlayByLotteryType($pdo));
    //     exit;

function getAllGamesPlayByLotteryType($pdo,$lotteryType) {
    try {
        $sql = "SELECT gn_id, name, odds, total_bets, lottery_type, standard_odds, standard_total_bets FROM game_name WHERE lottery_type = ?";
         $stmt = $pdo->prepare($sql); // ✅ Correct
        $stmt->execute([$lotteryType]); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();
        return [];
    }
}

// echo"<pre>";
// print_r(getAllGamesPlayByLotteryType($pdo));
// exit;



function updateSpecificGamePlays($pdo,$lotteryType, $gameTypeId)
{
    // $gameTypes = (new GameModel())->getGameFromTable();
    $gamePlay = getAllGamesPlayByLotteryType($pdo,$lotteryType);

    // $oddsGroup = (new GameModel())->getAllOddsGroup();
    $standardOdds = [];
    // print_r($gamePlay);exit;
    // $db = (new DBUtils)->openLink(); // Get PDO instance
    // $sql = "UPDATE game_name SET standard_odds = ?, standard_total_bets = ? WHERE gn_id = ?";
    // $req = $db->prepare($sql);

    foreach ($gamePlay as $play) {
        $singleOdds = [];
        $singleTBets = [];
            $newAppendStandardOdds = json_decode($play['standard_odds'], true);
            $newAppendStandardTotalBets = json_decode($play['standard_total_bets'], true);
            $newAppendStandardOdds[$gameTypeId] = $play['odds'];
            $newAppendStandardTotalBets[$gameTypeId] = $play['total_bets'];


            $singleOdds = $newAppendStandardOdds;
            $singleTBets = $newAppendStandardTotalBets;

        $jsonOdds = json_encode($singleOdds); // Convert array to JSON string
        $jsonTBets = json_encode($singleTBets); // Convert array to JSON string
        $req->execute([$jsonOdds, $jsonTBets, $play['gn_id']]);

        // $standardOdds[] = [
        //     "play_id" => $play['gn_id'],
        //     "play_name" => $play['name'],
        //     "lottery_type" => $play['lottery_type'],
        //     "play_odds" => ['odds' => $singleOdds, 'bets' => $singleTBets],
        // ];
    }
    print_r($standardOdds);

}

$gamelotteries = updateSpecificGamePlays($pdo,$lotteryType="3",$gameTypeId="97");
echo"<pre>";
print_r($gamelotteries);
// echo $gamelotteries;


// for odds group

// public function getAllOddsGroupByLotteryType(string $lotteryType): array
//     {
//         try {
//             $sql = "SELECT gn.gn_id, gn.lottery_type, ogg.odds, ogg.label, ogg.game_play_id, ogg.odds_group_id, ogg.std_odds FROM game_name gn
//                     JOIN odds_group ogg ON gn.gn_id = ogg.game_play_id WHERE gn.lottery_type = ?";
//             return $this->Helper->selectAll($sql, [$lotteryType]);
//         } catch (\Throwable $th) {
//             Monolog::log($th);
//             return [];
//         }
//     }


// function updateSpecificGamePlayOddsGroup($lotteryType, $gameTypeId)
// {
//     $oddsGroup = (new GameModel())->getAllOddsGroupByLotteryType($lotteryType);
//     $standardOdds = [];
//     // print_r($oddsGroup);
//     // exit;
//     $db = (new DBUtils)->openLink(); // Get PDO instance
//     // $sql = "UPDATE game_name SET standard_odds = ?, standard_total_bets = ? WHERE gn_id = ?";
//     $sql = "UPDATE odds_group SET std_odds = ? WHERE odds_group_id = ?";

//     $req = $db->prepare($sql);

//     foreach ($oddsGroup as $play) {
//         $singleOdds = [];
//         $newAppendStandardOdds = json_decode($play['std_odds'], true);
//         $newAppendStandardOdds[$gameTypeId] = $play['odds'];
//         $singleOdds = $newAppendStandardOdds;

//         $jsonOdds = json_encode($singleOdds); // Convert array to JSON string
//         // echo $jsonOdds;
//         // echo ',</br>';
//         // print_r($jsonTBets);exit;
//         $req->execute([$jsonOdds, $play['odds_group_id']]);

//         $standardOdds[] = [
//             "play_id" => $play['gn_id'],
//             "play_name" => $play['label'],
//             "lottery_type" => $play['lottery_type'],
//             "play_odds" => ['odds' => $singleOdds],
//         ];
//     }
//     print_r($standardOdds);

// }




{"monday":["12:00:00","04:00:00","08:00:00"],"tuesday":["12:00:00","04:00:00","08:00:00"],"evening":["08:00:00"]},"wednesday":{"daytime":["12:00:00","04:00:00"],"evening":["08:00:00"]},"thursday":{"daytime":["12:00:00","04:00:00"],"evening":["08:00:00"]},"friday":{"daytime":["12:00:00","04:00:00"],"evening":["08:00:00"]},"saturday":{"daytime":["12:00:00","04:00:00"],"evening":["08:00:00"]},"sunday":{"daytime":["12:00:00","04:00:00"],"evening":["08:00:00"]}}