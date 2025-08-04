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

// function getAllGamesPlayByLotteryType($pdo) {
//     try {
//         $sql = "SELECT gn_id, name, odds, total_bets, lottery_type, standard_odds, standard_total_bets 
//                 FROM game_name";
        
//         $stmt = $pdo->query($sql);
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
//     } catch (\Throwable $th) {
//         return [];
//     }
// }



// function updateAllGamePlays($pdo)
// {
//     $db =$pdo; // PDO instance
//     $gamePlay = getAllGamesPlay($db);

//     // $sql = "UPDATE game_name SET standard_odds = ?, standard_total_bets = ? WHERE gn_id = ?";
//     // $stmt = $db->prepare($sql);

//     foreach ($gamePlay as $play) {
//         $actualGameIds = getGamesByLotteryType($db, $play['lottery_type']);
//         $filteredGameIds = array_column($actualGameIds, 'gt_id');

//         $singleOdds = [];
//         $singleBets = [];

//         foreach ($filteredGameIds as $gameId) {
//             $singleOdds[$gameId] = $play['odds'];
//             $singleBets[$gameId] = $play['total_bets'];
//         }

//    print_r($singleOdds); ///\
//       $jsonOdds =   json_encode($singleOdds);
//         $jsonBets = json_encode($singleBets);

//        $stmt->execute([$jsonOdds, $jsonBets, $play['gn_id']]);
//     }
// }



// function updateAllOddGroup($pdo)
// {
//     $db = $pdo; // PDO instance

//     $oddsGroup = getAllOddsGroup($db);

//     $sql = "UPDATE odds_group SET std_odds = ? WHERE odds_group_id = ?";
//     $stmt = $db->prepare($sql);

//     foreach ($oddsGroup as $group) {
//         $actualGameIds = getGamesByLotteryType($db, $group['lottery_type']);
//         $filteredGameIds = array_column($actualGameIds, 'gt_id');

//         $singleOdds = [];
//         foreach ($filteredGameIds as $gameId) {
//             $singleOdds[$gameId] = $group['odds'];
//         }

//         $jsonOdds = json_encode($singleOdds);
//         $stmt->execute([$jsonOdds, $group['odds_group_id']]);
//     }
// }

// function getAllGamesPlay($pdo)
// {
//     try {
//         $sql = "SELECT gn_id, name, odds, total_bets, lottery_type FROM game_name WHERE lottery_type = ?";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     } catch (Throwable $e) {
//         return [];
//     }
// }

// function getGamesByLotteryType($pdo, $lotteryType)
// {
//    try {
//         $sql = "SELECT gt_id 
//                 FROM game_type 
//                 WHERE lottery_type = ? 
//                 ";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([$lotteryType]);
//         return $stmt->fetchAll(PDO::FETCH_ASSOC); // Use fetch(), not fetchAll(), since we're expecting one row
//     } catch (Throwable $e) {
//         return null;
//     }
// }

// function getAllOddsGroup($pdo)
// {
//     try {
//         $sql = "SELECT gn.gn_id, gn.lottery_type, ogg.odds, ogg.label, ogg.game_play_id, ogg.odds_group_id 
//                 FROM game_name gn
//                 JOIN odds_group ogg ON gn.gn_id = ogg.game_play_id";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     } catch (Throwable $e) {
//         return [];
//     }
// }
// updateAllOddGroup($pdo);
// echo"<pre>";
// print_r(updateAllOddGroup($pdo));








// chapo code below

function getGameFromTable($pdo): array
{
    try {
        $sql = "SELECT gt_id, lottery_type FROM game_type";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetching the first row's gt_id, or an empty array if no rows found
        // return $pdo->selectAll($sql);
    } catch (\Throwable $th) {
        // Optional: Log the error
        // error_log($th->getMessage()); // or use Monolog, etc.
        return [];
    }
}

// echo "<pre>";
//      print_r(getGameFromTable($pdo));
    
//      exit;


     function getAllGamesPlayByLotteryType($pdo, $lotteryType): array    {

        try {
            $sql = "SELECT gn_id, name, odds, total_bets, lottery_type, standard_odds, standard_total_bets FROM game_name WHERE lottery_type = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$lotteryType]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            return [];
        }    }

    // echo "<pre>";
    //  print_r(getAllGamesPlayByLotteryType($pdo, $lotteryType = 1));
    
    //  exit;

function updateSpecificGamePlays($pdo,$lotteryType, $gameTypeId = 100)
{
   //  $gameTypes = getGameFromTable($pdo);
    $gamePlay = getAllGamesPlayByLotteryType($pdo, $lotteryType);
   // $oddsGroup = (new GameModel())->getAllOddsGroup();
    $standardOdds = [];
    // print_r($gamePlay);exit;
      $db = $pdo;
    $sql = "UPDATE game_name SET standard_odds = ?, standard_total_bets = ? WHERE gn_id = ?";
    $req = $db->prepare($sql);

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
        // echo $jsonOdds;
        // echo ',</br>';
        // print_r($jsonTBets);exit;
        $req->execute([$jsonOdds, $jsonTBets, $play['gn_id']]);

        $standardOdds[] = [
            "play_id" => $play['gn_id'],
            "play_name" => $play['name'],
            "lottery_type" => $play['lottery_type'],
            "play_odds" => ['odds' => $singleOdds, 'bets' => $singleTBets],
        ];
    }
    print_r($standardOdds);

}



     echo "<pre>";
      print_r(updateSpecificGamePlays($pdo, $lotteryType = 3));
    
      exit;
echo "hekko";
// print_r(getGameFromTable($pdo));


// // for odds group

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


// post: /api/v1/limvo/processBetSlipIfSkipped
// {
//     "gameIds": array
//     period: string
// }

// ALTER TABLE `ds_royal5draw` 
//   CHANGE `draw_count` `total_count` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
//   CHANGE `draw_date` `draw_period` VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
//   CHANGE `draw_number` `standard` VARCHAR(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
//   CHANGE `draw_time` `twosides` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
//   CHANGE `draw_datetime` `bordgames` VARCHAR(30) NULL DEFAULT NULL,
//   ADD `manytable` VARCHAR(30) NULL DEFAULT NULL AFTER `bordgames`,
//   ADD `trend` VARCHAR(30) NULL DEFAULT NULL AFTER `manytable`,
//   ADD `roadbet` VARCHAR(30) NULL DEFAULT NULL AFTER `trend`,
//   ADD `longdragon` VARCHAR(30) NULL DEFAULT NULL AFTER `roadbet`;
