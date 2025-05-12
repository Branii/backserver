<?php

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
<!DOCTYPE html>
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
</html>

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

echo  diffFromServerTz();


// use MaxMind\Db\Reader;
// // open the local MMDB file
// $reader = new Reader('/path/to/GeoLite2-City.mmdb');
// $record = $reader->get('8.8.8.8');

// // record['location']['time_zone'] holds the tz string
// echo $record['location']['time_zone'];  // e.g. "America/Chicago"