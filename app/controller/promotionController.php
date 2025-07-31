<?php

class promotionController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

     //NOTE -
    //////////////INVITATION & REFERAL LINK -//////////
    public function userlinkdata($pageNumber, $limit)
    {
        $this->view('exec/promotion_manage', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'userlinkdata']);
        $this->view->render();
    }

    public function  filterUserlinks($username, $startdate, $enddate, $pageNumber, $limit)
    {
        $this->view('exec/promotion_manage', [
            'username' => $username,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'flag' => 'filterUserlinks',
            'page' => $pageNumber,
            'limit' => $limit,
        ]);
        $this->view->render();
    }


}