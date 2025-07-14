<?php

class gameController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

    ////////////// LOTTERY DRAW GAMES FUNCTIONS  - //////////

    public function getAllgames()
    {
        $this->view('exec/game_management', ['flag' => 'getAllgames']);
        $this->view->render();
    }

    public function getSpecificDraws($partnerID, $gameId, $issue_number, $status, $start_date, $end_date, $pageNumber, $limit)
    {

        $this->view('exec/game_management', [
            'partner_id'   => $partnerID,
            'page'         => $pageNumber,
            'limit'        => $limit,
            'flag'         => 'getDraws',
            'status'       => $status,
            'gameId'       => $gameId,
            'start_date'   => $start_date,
            'end_date'     => $end_date,
            'issue_number' => $issue_number,
        ]);
        $this->view->render();
    }

    ////////////// LOTTERY BASIC PARAM FUNCTIONS  - //////////
    public function fetch_lottery_basic_params($partnerID, $lottery_id, $page)
    {

        $this->view('exec/lottery_basic_params', ['partner_id' => $partnerID, 'lottery_id' => $lottery_id, 'page' => $page, 'flag' => 'fetch-lottery-basic-params']);
        $this->view->render();
    }

    public function updateLottery($maxPrizeAmountPerBet, $maxAmtPerIssue, $maxWinPerPersonPerIssue, $minBetAmtPerIssue, $lockTimeForClsing, $sortingWeight, $lotteryType, $game_type_id)
    {
        $this->view('exec/lottery_basic_params', ['maxPrizeAmountPerBet' => $maxPrizeAmountPerBet, 'maxAmtPerIssue' => $maxAmtPerIssue, 'maxWinPerPersonPerIssue' => $maxWinPerPersonPerIssue, 'minBetAmtPerIssue' => $minBetAmtPerIssue, 'lockTimeForClsing' => $lockTimeForClsing, 'sortingWeight' => $sortingWeight, 'lottery_type' => $lotteryType, 'game_type_id' => $game_type_id, 'flag' => 'updateLottery']);
        $this->view->render();
    }

    public function updateLotteryStatus($partnerID, $game_type_id, $status)
    {
        $this->view('exec/lottery_basic_params', ['partner_id' => $partnerID, 'status' => $status, 'game_type_id' => $game_type_id, 'flag' => 'updateLotteryStatus']);
        $this->view->render();
    }

    public function searchLotteryName($partnerID, $lottery_name)
    {
        $this->view('exec/win_loss', ['partner_id' => $partnerID, 'lottery_name' => $lottery_name, 'flag' => 'filter-lotteries']);
        $this->view->render();
    }

    ////////////// LOTTERY BONUS  PARAMETERS FUNCTIONS  - //////////
    public function getAllGamesLottery()
    {
        $this->view('exec/game_management', ['flag' => 'getAllGamesLottery']);
        $this->view->render();
    }

    public function getLotteryGames(string $lotterId, string $tables, string $gametypes)
    {
        $this->view('exec/game_management', [
            'flag'   => 'getLotteryGames',
            'gameId' => $lotterId,
            'tables' => $tables,
            'gametypes'   => $gametypes
        ]);
        $this->view->render();
    }

    public function resettotalbet($lotterId, $gamemodel, $totalbetpercent, $newtotalbet)
    {
        $this->view('exec/game_management', [

            'flag'            => 'resettotalbet',
            'gameId'          => $lotterId,
            'models'          => $gamemodel,
            'totalbetpercent' => $totalbetpercent,
            'newtotalbet'     => $newtotalbet,
        ]);
        $this->view->render();
    }

    public function updateoddstotalbets($lotterId, $gamemodel, $oddpercent, $newodds, $totalbetpercent, $newtotalbet,$gametype, $isSpecial)
    {
        $this->view('exec/game_management', [
            'flag'            => 'updateoddstotalbets',
            'gameId'          => $lotterId,
            'models'          => $gamemodel,
            'oddpercent'      => $oddpercent,
            'newodds'         => $newodds,
            'totalbetpercent' => $totalbetpercent,
            'newtotalbet'     => $newtotalbet,
            'gametype'        => $gametype,
            'isSpecial'       => $isSpecial

        ]);
        $this->view->render();
    }

    public function updategamelottery($lotteryid, $gametate)
    {
        $this->view('exec/game_management', ['flag' => 'updategamelottery', 'lotteryid' => $lotteryid, 'gametate' => $gametate]);
        $this->view->render();
    }

    public function updategamestatus($lotterId, $gamemodel, $gametate)
    {
        $this->view('exec/game_management', [
            'flag'     => 'updategamestatus',
            'gameId'   => $lotterId,
            'models'   => $gamemodel,
            'gametate' => $gametate,

        ]);
        $this->view->render();
    }

    public function updategamegroup($gamegroupid, $gametate)
    {
        $this->view('exec/game_management', ['flag' => 'updategamegroup', 'gamegroupid' => $gamegroupid, 'gametate' => $gametate]);
        $this->view->render();
    }

    public function updateGameGroupData($data)
    {
        $this->view('exec/lottery_bonus_parameters', ["data" => $data, 'flag' => 'updateGameGroupData']);
        $this->view->render();
    }

    public function toggleTwosidesLotteryState($gameID)
    {
        $this->view('exec/lottery_bonus_parameters', ["gameID" => $gameID, 'flag' => 'toggleTwosidesLotteryState']);
        $this->view->render();
    }

    //reset all odds
    public function resetAllOdds()
    {
        $this->view('exec/game_management', ['flag' => 'resetAllOdds']);
        $this->view->render();
    }

}
