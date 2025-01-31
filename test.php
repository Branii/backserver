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


$page = $_GET['page'] ?? 1;
$limit = $_GET['limit'] ?? 5;
$keyword = $_GET['keyword'] ?? "default"; // You can sanitize the keyword later if needed
$offset = ($page - 1) * $limit;

// Your base query (adjusted to your needs)
$where = " WHERE bt.bet_status = 2 AND bt.uid = 3"; // Adjust this where clause if necessary

// Set session for group_concat_max_len
$pdo->exec("SET SESSION group_concat_max_len = 1000000");

// Generate dynamic query to get the SELECT statements from all tables
// $sql = "
//     SELECT GROUP_CONCAT(
//         'SELECT uid, bettype,bet_status, bet_amount, game_label, user_selection FROM ', table_name, '$where' 
//         SEPARATOR ' UNION ALL '
//     ) AS query
//     FROM information_schema.tables 
//     WHERE table_schema = 'lottery_test' AND table_name LIKE 'bt_%'
// ";
$sql = "
    SELECT GROUP_CONCAT(
        CONCAT(
            'SELECT bt.bet_odds, bt.draw_period, bt.bet_code, bt.game_label,bt.uid, bt.bet_number, 
             bt.unit_stake, bt.multiplier, bt.bet_amount, bt.win_amount, bt.win_bonus, bt.bet_status, bt.state, 
             bt.bet_time, bt.bet_date, bt.game_model, bt.server_date, bt.server_time, 
             u.username, u.email, u.contact, u.reg_type, 
             gt.name AS game_type, gt.gt_id AS gt_id 
             FROM ', table_name, ' bt 
             JOIN users_test u ON bt.uid = u.uid
             JOIN game_type gt ON gt.gt_id = bt.game_type
             $where'
        ) SEPARATOR ' UNION ALL '
    ) AS query 
    FROM information_schema.tables 
    WHERE table_schema = 'lottery_test' 
    AND table_name LIKE 'bt_%'
";
// Execute the query to get the merged query string
$mergedQuery = $pdo->query($sql)->fetchColumn();

// Prepare to count the total number of records (without pagination)
$countStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM ($mergedQuery) AS subquery");
$countStmt->execute();
$total = $countStmt->fetchColumn();

// Prepare to fetch paginated data
$dataStmt = $pdo->prepare("$mergedQuery LIMIT $limit OFFSET $offset");
$dataStmt->execute();

// Return the response as a JSON
// echo json_encode([
//     'total' => ceil($total / $limit), // Calculate the total pages
//     'data' => $dataStmt->fetchAll(PDO::FETCH_ASSOC), // The paginated data
//     'count' => $total // Total count of records
// ]);
$serializedData = 'a:2:{i:1;s:4:"15.0";i:9;s:4:"10.7";}';

// Unserialize the data
$userTreeData = unserialize($serializedData);

// Example function to fetch user details and build the tree
function getUserTree($userId, $allUsers) {
    $children = array_filter($allUsers, fn($parent) => $parent['parent_id'] === $userId);
    $tree = [];

    foreach ($children as $child) {
        $tree[] = [
            'user' => $child,
            'children' => getUserTree($child['id'], $allUsers)
        ];
    }
    return $tree;
}

// Mock database query result
$allUsers = [
    ['id' => 1, 'name' => 'Alice', 'parent_id' => 0],
    ['id' => 2, 'name' => 'Bob', 'parent_id' => 1],
    ['id' => 3, 'name' => 'Charlie', 'parent_id' => 1],
    ['id' => 4, 'name' => 'David', 'parent_id' => 2],
];

// Build the tree starting from the root user (parent_id = 0)
$tree = getUserTree(0, $allUsers);

// Function to render the tree as HTML
function renderTree($tree) {
    if (empty($tree)) return '';
    $html = '<ul>';
    foreach ($tree as $node) {
        $html .= '<li>' . $node['user']['name'];
        $html .= renderTree($node['children']);
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

echo renderTree($tree);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hover to Show Tree List</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      padding: 20px;
    }
    
    ul.tree-list {
      list-style: none;
      padding-left: 20px;
    }

    ul.tree-list ul {
      margin-left: 15px;
      border-left: 1px dashed #aaa;
    }

    .tree-node {
      cursor: pointer;
      padding: 5px 10px;
      border: 1px solid #ddd;
      display: inline-block;
      background-color: #f9f9f9;
      margin-top: 5px;
      border-radius: 8px;
      transition: background-color 0.3s;
    }

    .tree-node:hover {
      background-color: #e6f7ff;
    }

    /* Hide child nodes by default */
    .child-nodes {
      display: none;
    }

    /* Show child nodes when hovering over the parent */
    li:hover > .child-nodes {
      display: block;
    }
  </style>
</head>
<body>

<h2>Hover to Show Tree List</h2>

<ul id="userTree" class="tree-list"></ul>

<script>
  const userData = [
    { id: 1, name: 'Alice', parent_id: 0 },
    { id: 2, name: 'Bob', parent_id: 1 },
    { id: 3, name: 'Charlie', parent_id: 1 },
    { id: 4, name: 'David', parent_id: 2 },
    { id: 5, name: 'Eva', parent_id: 3 },
  ];

  // Helper to build hierarchical tree data
  function buildTree(users, parentId = 0) {
    return users
      .filter(user => user.parent_id === parentId)
      .map(user => ({
        ...user,
        children: buildTree(users, user.id)
      }));
  }

  // Render the tree into HTML
  function renderTree(tree, container) {
    if (!tree.length) return;
    const ul = document.createElement('ul');
    container.appendChild(ul);

    tree.forEach(node => {
      const li = document.createElement('li');
      const nodeDiv = document.createElement('div');
      nodeDiv.textContent = node.name;
      nodeDiv.classList.add('tree-node');
      li.appendChild(nodeDiv);

      if (node.children.length) {
        const childContainer = document.createElement('div');
        childContainer.classList.add('child-nodes');
        li.appendChild(childContainer);
        renderTree(node.children, childContainer);
      }
      ul.appendChild(li);
    });
  }

  const treeData = buildTree(userData);
  const userTreeContainer = document.getElementById('userTree');
  renderTree(treeData, userTreeContainer);
</script>
</body>
</html>




