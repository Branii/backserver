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
$limit = 50;
$offset = 1;
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


        // $sqll = "
        // SELECT GROUP_CONCAT(
        //     CONCAT(
        //         'SELECT bt.bet_odds,bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,bt.uid,bt.bet_number,bt.unit_stake,bt.multiplier,bt.bet_amount,bt.win_amount,
        //         bt.bet_status,bt.state,bt.bet_time,bt.bet_date,bt.server_date,bt.server_time,
        //         u.username,u.email,u.contact,
        //         u.reg_type, gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt JOIN users_test u ON bt.uid = u.uid
        //              JOIN game_type gt ON gt.gt_id = bt.game_type ') SEPARATOR ' UNION ALL '
        // ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";

        $sql2 = "
        SELECT GROUP_CONCAT(
            CONCAT(
                'SELECT 
                    bt.bet_odds, bt.draw_period, bt.bet_code, bt.game_label, bt.game_type, bt.uid, 
                    bt.bet_number, bt.unit_stake, bt.multiplier, bt.bet_amount, bt.win_amount, 
                    bt.bet_status, bt.state, bt.bet_time, bt.bet_date, bt.server_date, bt.server_time, 
                    u.username, u.email, u.contact, u.reg_type, 
                    gt.name AS game_type, gt.gt_id AS gt_id, 
                    SUM(bt.bet_amount) AS total_bet_amount, 
                    SUM(bt.win_amount) AS total_win_amount 
                FROM ', table_name, ' bt 
                JOIN users_test u ON bt.uid = u.uid 
                JOIN game_type gt ON gt.gt_id = bt.game_type 
                WHERE bt.uid = 3 
                GROUP BY bt.draw_period') 
            SEPARATOR ' UNION ALL '
        ) AS query 
        FROM information_schema.tables 
        WHERE table_schema = 'lottery_test' 
        AND table_name LIKE 'bt_%'";
    //   $pdo = (new Database())->openLink();
      $pdo->exec("SET SESSION group_concat_max_len = 1000000");
      $stmt = $pdo->prepare($sql2);
      $stmt->execute();
      $mergedQuery = $stmt->fetchColumn();
    //   $paginatedQuery = "$mergedQuery WHERE bt.uid = '1' LIMIT $limit OFFSET $offset";
    //   $finalStmt = $pdo->prepare($paginatedQuery);
    //   $finalStmt->execute();
    //   $data = $finalStmt->fetchAll(PDO::FETCH_ASSOC);

   //   echo json_encode(count($data));
      echo json_encode($mergedQuery );exit;

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


$sql = "
    SELECT GROUP_CONCAT(CONCAT('SELECT * FROM ', table_name, ' WHERE uid = 1') SEPARATOR ' UNION ALL ') AS query
    FROM information_schema.tables
    WHERE table_schema = 'lottery_test'
    AND table_name LIKE 'bt_%'
";
