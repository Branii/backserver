<?php

$dsn = 'mysql:host=192.168.1.51;dbname=lottery_test';
$user = 'enzerhub';
$pass = 'enzerhub';

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Throwable $th) {
    die("Connection failed: " . $th->getMessage());
}

// Helper function to run SELECT queries
function selectAll(PDO $pdo, string $sql, array $params = []): array
{
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        return [];
    }
}



public static function updateSpecificGamePlays($lotteryType, $gameTypeId)
{
    $pdo = (new Database())->openLink();
    $sql = "SELECT gn_id, name, odds, total_bets, lottery_type, standard_odds, standard_total_bets FROM game_name WHERE lottery_type = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lotteryType]);
    $gamePlay = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlUpdate = "UPDATE game_name SET standard_odds = ?, standard_total_bets = ? WHERE gn_id = ?";
    $req = $pdo->prepare($sqlUpdate);

    foreach ($gamePlay as $play) {
        $stdOdds = json_decode($play['standard_odds'], true) ?: [];
        $stdBets = json_decode($play['standard_total_bets'], true) ?: [];

        $stdOdds[$gameTypeId] = trim($play['odds'], '[]');
        $stdBets[$gameTypeId] = trim($play['total_bets'], '[]');

        $req->execute([
            json_encode($stdOdds),
            json_encode($stdBets),
            $play['gn_id']
        ]);
    }
}

public static function updateSpecificGamePlayOddsGroup($lotteryType, $gameTypeId)
{
    $pdo = (new Database())->openLink();
    $sql = "SELECT gn.gn_id, gn.lottery_type, ogg.odds, ogg.label, ogg.game_play_id, ogg.odds_group_id, ogg.std_odds
            FROM game_name gn
            JOIN odds_group ogg ON gn.gn_id = ogg.game_play_id
            WHERE gn.lottery_type = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lotteryType]);
    $oddsGroup = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlUpdate = "UPDATE odds_group SET std_odds = ? WHERE odds_group_id = ?";
    $req = $pdo->prepare($sqlUpdate);

    foreach ($oddsGroup as $play) {
        $stdOdds = json_decode($play['std_odds'], true) ?: [];
        $stdOdds[$gameTypeId] = trim($play['odds'], '[]');

        $req->execute([
            json_encode($stdOdds),
            $play['odds_group_id']
        ]);
    }
}

