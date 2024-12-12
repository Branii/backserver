<?php


$dsn = 'mysql:host=192.168.1.51;dbname=lottery_test'; // Fixed variable name and removed extra space
$pass = "enzerhub";
$user = "enzerhub";
try {
    $pdo = new PDO($dsn, $user, $pass);
    //  echo "Connected";
} catch (\Throwable $th) {
    echo $th->getMessage();
}
$sql = "SELECT game_group.name AS gameplay, game_name.name, game_name.odds, game_name.state, game_name.group_type, game_name.gn_id
        FROM game_group
        JOIN game_name ON game_name.game_group = game_group.gp_id
        WHERE game_group.lottery_type = 1";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$gamename = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $finalData = [];
// foreach ($gamename as $lottery) {
//     $game = $lottery['gn_id']; // Get the game ID
    
//     // Prepare the second query to fetch game types (odds_group)
//     $sql1 = "SELECT label, odds FROM odds_group WHERE game_play_id = :game_play_id";
//     $stmt1 = $pdo->prepare($sql1);
//     $stmt1->bindValue(':game_play_id', $game, PDO::PARAM_INT); // Bind the game ID safely
//     $stmt1->execute();
//     $gameTypes = $stmt1->fetchAll(PDO::FETCH_ASSOC);

//     // Add the game types to the lottery data
//     $lottery['game_types'] = $gameTypes; 

//     // Store the final result
//     $finalData[] = $lottery;
// }

// You can now work with $finalData which contains all the lottery data and their associated game types



 echo "<pre>";
  print_r($gamename);
