

<?php

class Utils extends MEDOOHelper
{

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
         $oddpercentage = 100;
        $gamePlay = self::getAllGamesPlay();

        $sql = "UPDATE game_name SET standard_odds = :standard_odds, standard_total_bets = :standard_total_bets,
         oddspercentage = :oddspercentage,totalbetpercentage = :totalbetpercentage WHERE gn_id = :gn_id";
        foreach ($gamePlay as $play) {
            $actualGameIds   = self::getGamesByLotteryType($play['lottery_type']);
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
            parent::query($sql, [
                "standard_odds" => $jsonOdds,
                "standard_total_bets" => $jsonBets,
                "oddspercentage" => $oddpercentage,
                "totalbetpercentage" => $oddpercentage,
                "gn_id" => $play['gn_id']
            ]);
            //  $stmt->execute([$jsonOdds, $jsonBets, $play['gn_id']]);
        }
    }

    public static function updateAllOddGroup()
    {

         $oddpercentage = 100;
        $oddsGroup = self::getAllOddsGroup();

        $sql = "UPDATE odds_group SET std_odds =:std_odds, oddspercentage = :oddspercentage WHERE odds_group_id = :odds_group_id";

        foreach ($oddsGroup as $group) {
            $actualGameIds   = self::getGamesByLotteryType($group['lottery_type']);
            $filteredGameIds = array_column($actualGameIds, 'gt_id');

            $singleOdds = [];
            foreach ($filteredGameIds as $gameId) {
                $singleOdds[$gameId] = $group['odds'];
            }

            $jsonOdds = json_encode($singleOdds);
            parent::query($sql, [
                "std_odds" => $jsonOdds,
                "oddspercentage" => $oddpercentage,
                "odds_group_id" => $group['odds_group_id']
            ]);

        }
    }
    
}