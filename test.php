<?php


// $dsn = 'mysql:host=192.168.1.51;dbname=lottery_test'; // Fixed variable name and removed extra space
// $pass = "enzerhub";
// $user = "enzerhub";

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


function getSubAgents($agentId) {
  // Connect to the database
  $pdo = new PDO("mysql:host=192.168.1.51;dbname=lottery_test", "enzerhub", "enzerhub");

  // Query to get sub-agents based on agent_id
  $stmt = $pdo->prepare("
      SELECT uid, nickname
      FROM users_test 
      WHERE agent_id = :agent_id
  ");
  $stmt->bindParam(':agent_id', $agentId, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle AJAX request to fetch sub-agents
if (isset($_GET['agent_id'])) {
  $agentId = (int)$_GET['agent_id'];
  $subAgents = getSubAgents($agentId);
  echo json_encode($subAgents);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent and Sub-Agents Table</title>
    <script>
        function viewSubAgents(agentId) {
            fetch(`your_backend_script.php?agent_id=${agentId}`)
                .then(response => response.json())
                .then(data => {
                    const subAgentTable = document.getElementById('sub-agent-table');
                    let rows = '<tr><th>Username</th><th>Age</th></tr>';
                    data.forEach(agent => {
                        rows += `<tr><td>${agent.nickname}</td><td>${agent.uid}</td></tr>`;
                    });
                    subAgentTable.innerHTML = rows;
                })
                .catch(error => console.error('Error fetching sub-agents:', error));
        }
    </script>
</head>
<body>
    <h1>Agents Table</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Age</th>
                <th>View Sub</th>
            </tr>
        </thead>
        <tbody>
            <!-- Static rows for demo purposes; Replace with dynamic PHP rows in production -->
            <tr>
                <td>Alice</td>
                <td>35</td>
                <td><button onclick="viewSubAgents(1)">View Sub</button></td>
            </tr>
            <tr>
                <td>Bob</td>
                <td>40</td>
                <td><button onclick="viewSubAgents(2)">View Sub</button></td>
            </tr>
        </tbody>
    </table>

    <h2>Sub-Agents Table</h2>
    <table id="sub-agent-table" border="1">
        <tr>
            <th>Username</th>
            <th>Age</th>
        </tr>
    </table>
</body>
</html>
