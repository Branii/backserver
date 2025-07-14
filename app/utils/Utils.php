

<?php

class Utils extends MEDOOHelper
{

    public static function getGameIdsByGameType(): array
    {
        return parent::getTables();
    }

    public static function getAllGamesPlay()
    {
        try {
            $sql  = "SELECT gn_id, name, odds, total_bets, lottery_type FROM game_name";
            $data = parent::query($sql);
            return $data;
        } catch (Throwable $e) {
            return [];
        }
    }

    public static function getGamesByLotteryType($lotteryType)
    {
        try {
            $sql  = "SELECT gt_id FROM game_type WHERE lottery_type = :lottery_type";
            $data = parent::query($sql, ["lottery_type" => $lotteryType]);
            return $data;
        } catch (Throwable $e) {
            return null;
        }
    }

    public static function getAllOddsGroup()
    {
        try {
            $sql = "SELECT gn.gn_id, gn.lottery_type, ogg.odds, ogg.label, ogg.game_play_id, ogg.odds_group_id
            FROM game_name gn JOIN odds_group ogg ON gn.gn_id = ogg.game_play_id";
            $data = parent::query($sql);
            return $data;
        } catch (Throwable $e) {
            return [];
        }
    }

    public static function updateAllGamePlays()
    {

        $gamePlay = self::getAllGamesPlay();

        $sql = "UPDATE game_name SET standard_odds = ?, standard_total_bets = ? WHERE gn_id = ?";
        foreach ($gamePlay as $play) {
            $actualGameIds   = getGamesByLotteryType($play['lottery_type']);
            $filteredGameIds = array_column($actualGameIds, 'gt_id');

            $singleOdds = [];
            $singleBets = [];

            foreach ($filteredGameIds as $gameId) {
                $singleOdds[$gameId] = $play['odds'];
                $singleBets[$gameId] = $play['total_bets'];
            }

            ///print_r($singleOdds); ///\
            $jsonOdds = json_encode($singleOdds);
            $jsonBets = json_encode($singleBets);
            //  $data     = parent::query($sql, [$jsonOdds, $jsonBets, $play['gn_id']]);
            parent::query($sql, [$jsonOdds, $jsonBets, $play['gn_id']]);
            //  $stmt->execute([$jsonOdds, $jsonBets, $play['gn_id']]);
        }
    }

    public static function updateAllOddGroup()
    {

        $oddsGroup = getAllOddsGroup();

        $sql = "UPDATE odds_group SET std_odds = ? WHERE odds_group_id = ?";

        foreach ($oddsGroup as $group) {
            $actualGameIds   = getGamesByLotteryType($group['lottery_type']);
            $filteredGameIds = array_column($actualGameIds, 'gt_id');

            $singleOdds = [];
            foreach ($filteredGameIds as $gameId) {
                $singleOdds[$gameId] = $group['odds'];
            }

            $jsonOdds = json_encode($singleOdds);
            $data     = parent::query($sql, [$jsonOdds, $group['odds_group_id']]);

        }
    }
}