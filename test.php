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

 
?>
<!-- <input type="range" id="rangeSlider" min="0" max="100" value="100">
<span id="rangeValue">100%</span>

<input type="text" id="valueList" class="form-control" readonly>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let originalValues = [10, 20, 30];
        
        // Function to update values based on the percentage
        function updateValues(percentage) {
            let scaledValues = originalValues.map(value => (value * percentage / 100));
            $("#valueList").val(`[${scaledValues.join(", ")}]`);
        }

        // Initial load
        updateValues(100);

        // Update values on slider change
        $("#rangeSlider").on("input", function() {
            let percentage = $(this).val();
            $("#rangeValue").text(percentage + "%");
            updateValues(percentage);
        });
    });
</script> -->

<!-- 
<input type='text' class='form-control oddsone' value='[10, 20, 30]' readonly>
<input type="range" id="rangeSliderone" min="0" max="100" value="100">
<span id="rangeValue">100%</span>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Get the initial values from the input box
    let originalValues = JSON.parse($(".oddsone").val());

    // Function to update values based on the percentage
    function updateValues(percentage) {
        let scaledValues = originalValues.map(value => (value * percentage / 100).toFixed(0));
        $(".oddsone").val(`[${scaledValues.join(", ")}]`);
    }

    // Initial load
    updateValues(100);

    // Update values on slider change
    $("#rangeSliderone").on("input", function() {
        let percentage = $(this).val();
        $("#rangeValue").text(percentage + "%");
        updateValues(percentage);
    });
});
</script> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Switch Controlled Percentage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table { width: 60%; margin: 20px auto; text-align: center; }
        .form-check-input { width: 50px; margin-left: 10px; }
    </style>
</head>
<body>

<!-- First Dropdown -->
<select id="gameDropdown1">
    <option value="1">Game 1</option>
    <option value="2">Game 2</option>
    <option value="3">Game 3</option>
</select>

<!-- Second Dropdown (to be dynamically updated) -->
<select id="gameDropdown2">
    <option>Select an option</option>
</select>

<script>
$(document).on("change", "#gameDropdown1", function() {
    let selectedValue = $(this).val(); // Get selected value

    // Define mapping for each option in the first dropdown
    let optionsMap = {
        "1": ["Standard", "Twosides", "Logdragion"],
        "2": ["Long", "Fourside", "Logdragn"],
        "3": ["Option A", "Option B", "Option C"] // Example for third option
    };

    let options = optionsMap[selectedValue] || []; // Get corresponding options or empty

    // Populate second dropdown
    let secondDropdown = $("#gameDropdown2");
    secondDropdown.empty(); // Clear existing options

    $.each(options, function(index, value) {
        secondDropdown.append(new Option(value, value.toLowerCase())); // Add new options
    });
});

</script>

</body>
</html>
