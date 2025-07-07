<?php

class reportController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

    //NOTE -
    //////////////GPP/WIN/LOSS REPORT FUNCTIONS -//////////
    public function searchWinLossUser($partnerID, $user_id, $lottery_id, $start_date, $end_date)
    {

        $this->view('exec/win_loss', ['partner_id' => $partnerID, 'user_id' => $user_id, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'flag' => 'search-user-win-loss']);
        $this->view->render();
    }

    public function fetchTopAgents($partnerID, $lottery_id, $start_date, $end_date, $page, $limit)
    {

        $this->view('exec/win_loss', ['partner_id' => $partnerID, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'limit' => $limit, 'flag' => 'get-top-agents']);
        $this->view->render();
    }

    public function getUserDetails($partnerID, $user_id, $lottery_id, $start_date, $end_date, )
    {
        $this->view('exec/win_loss', ['partner_id' => $partnerID, 'user_id' => $user_id, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'flag' => 'get-user-details']);
        $this->view->render();
    }
    public function fetchAgentSubs($partnerID, $agent_id, $lottery_id, $start_date, $end_date, $flag, $page, $limit)
    {
        $this->view('exec/win_loss', ['partner_id' => $partnerID, "agent_id" => $agent_id, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'limit' => $limit, 'flag' => $flag]);
        $this->view->render();
    }
}
