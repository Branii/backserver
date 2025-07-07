<?php

class agentController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }
//NOTE -
    //////////////QUOTA SETTINGS FUNCTIONS -//////////
        public function updatequota($rebateid, $quota)
    {
        $this->view('exec/agentmanage', ['rebateid' => $rebateid, 'quota' => $quota, 'flag' => 'updatequota']);
        $this->view->render();
    }

      public function fetchquota($pageNumber, $limit)
    {
        $this->view('exec/agentmanage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchquota']);
        $this->view->render();
    }
    
      public function UpdateAllquota($quota)
    {
        $this->view('exec/agentmanage', ['quota' => $quota, 'flag' => 'UpdateAllquota']);
        $this->view->render();
    }


    public function filterRebate($rebate)
    {
        $this->view('exec/agentmanage', ['rebate' => $rebate, 'flag' => 'filterRebate']);
        $this->view->render();
    }

}