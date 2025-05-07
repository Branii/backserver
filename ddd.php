<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// include "app/database/Database.php";

// // $sql = "
// //     SELECT GROUP_CONCAT(CONCAT('SELECT user_selection FROM ', table_name, ' WHERE uid = :uid') SEPARATOR ' UNION ALL ') AS query
// //     FROM information_schema.tables
// //     WHERE table_schema = 'lottery'
// //     AND table_name LIKE 'bt_%'
// // ";

// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
// $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50; // Items per page
// $offset = ($page - 1) * $limit; // Calculate offset

// $sql = "
// SELECT GROUP_CONCAT(
//     CONCAT(
//         'SELECT bt.bet_odds,bt.draw_period,bt.bet_code,bt.game_label,bt.game_type,bt.uid,bt.bet_number,bt.unit_stake,bt.multiplier,bt.bet_amount,bt.win_amount,bt.bet_status,bt.state,bt.bet_time,bt.bet_date, 
//         u.username, gt.name As game_type,gt.gt_id AS gt_id FROM ', table_name, ' bt JOIN users_test u ON bt.uid = u.uid
//              JOIN game_type gt ON gt.gt_id = bt.game_type ') SEPARATOR ' UNION ALL '
// ) AS query FROM information_schema.tables WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'";

// $pdo = (new Database)->openLink();
// $pdo->exec("SET SESSION group_concat_max_len = 1000000");
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $mergedQuery = $stmt->fetchColumn();
// $paginatedQuery = "$mergedQuery LIMIT $limit OFFSET $offset";
// $finalStmt = $pdo->prepare($paginatedQuery);
// $finalStmt->execute();
// $data = $finalStmt->fetchAll(PDO::FETCH_ASSOC);

// $stmtt = $pdo->prepare($mergedQuery);
// $stmtt->execute();
// $totalcount = $stmtt->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode([
//     'data' => $data,
//     'total' => count($totalcount)
// ]);
?>
<form id="loginForm">
    <input type="text" name="username" placeholder="Username" required /><br>
    <input type="password" name="password" placeholder="Password" required /><br>
    <button type="submit">Login</button>
</form>

<div id="2faSection" style="display:none;">
    <form id="verify2faForm">
        <input type="text" name="code" placeholder="Enter 2FA code" required /><br>
        <button type="submit">Verify</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="login.js"></script>
<script src="2fa.js"></script>

