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



     function getAllGamesPlayByLotteryType($pdo)   {
      
        try {  
                    $sql = "SELECT gn_id, name, odds, total_bets, lottery_type, standard_odds, standard_total_bets FROM game_name WHERE lottery_type = 6";
            return $pdo->selectAll($sql);        } catch (\Throwable $th) {
                 return [];
        }    }


        print_r(getAllGamesPlayByLotteryType($pdo));
        exit;

function updateSpecificGamePlays($pdo,$lotteryType)
{
    $gameTypes = getGameFromTable($pdo);
    $gamePlay = getAllGamesPlayByLotteryType($lotteryType);
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

        // print


 function getGameFromTable($pdo)
    {
        try {
            $sql = "SELECT gt_id,lottery_type FROM game_type";
            return $pdo->selectAll($sql);
        } catch (\Throwable $th) {
       
            return [];
        }
    }


// public function getAllGamesPlay(): array
//     {
//         try {
//             $sql = "SELECT gn_id,name,odds, total_bets, lottery_type, standard_odds FROM game_name";
//             return $this->Helper->selectAll($sql);
//         } catch (\Throwable $th) {
//             Monolog::log($th);
//             return [];
//         }
//     }

// public function getGamesByLotteryType($lotteryTypeId): array
//     {
//         try {
//             $sql = "SELECT * FROM game_type Where lottery_type = ?";   //i modified
//             return $this->Helper->selectAll($sql, [$lotteryTypeId]);
//         } catch (\Throwable $th) {
//             Monolog::log($th);
//             return [];
//         }
//     }

// public function getAllOddsGroup(): array
//     {
//         try {
//             $sql = "SELECT gn.gn_id, gn.lottery_type, ogg.odds, ogg.label, ogg.game_play_id, ogg.odds_group_id FROM game_name gn
//                     JOIN odds_group ogg ON gn.gn_id = ogg.game_play_id";
//             return $this->Helper->selectAll($sql);
//         } catch (\Throwable $th) {
//             Monolog::log($th);
//             return [];
//         }
//     }