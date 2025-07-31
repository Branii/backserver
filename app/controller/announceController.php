<?php

class announceController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }
//NOTE -
    //////////////ANNOUNCEMENTLIST FUNCTIONS -//////////
 public function filtermessage($username, $messagestype, $startdepo, $enddepo, $page, $pageLimit)
    {
        $this->view('exec/annoucement_management', [

            'username' => $username,
            'messagestype' => $messagestype,
            'startdate' => $startdepo,
            'enddate' => $enddepo,
            'page' => $page,
            'limit' => $pageLimit,
            'flag' => 'filtermessage'
        ]);
        $this->view->render();
    }

     function createannoucement($messagetype, $messagetitle, $usernames, $description, $startdate, $enddate, $sendby)
    {
        $this->view('exec/annoucement_management', [

            'flag' => 'message',
            'messagetype' => $messagetype,
            'messagetitle' => $messagetitle,
            'usernames' => $usernames,
            'description' => $description,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'sendby' => $sendby

        ]);
        $this->view->render();
    }

   public function fetchmessage($pageNumber, $limit)
    {
        $this->view('exec/annoucement_management', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'fetchmessage']);
        $this->view->render();
    }

     public function deleteannoucement($messageid)
    {
        $this->view('exec/annoucement_management', ['messageid' => $messageid, 'flag' => 'deleteannoucement']);
        $this->view->render();
    }

    
    public function editannoucement($msgid)
    {
        $this->view('exec/annoucement_management', [

            'msgid' => $msgid,
            'flag' => 'editannoucement'
        ]);
        $this->view->render();
    }

       public function updateannoucement($msgtitle, $msgcontent, $msgid)
    {
        $this->view('exec/annoucement_management', [

            'msgtitle' => $msgtitle,
            'msgcontent' => $msgcontent,
            'msgid' => $msgid,
            'flag' => 'updateannoucement'
        ]);
        $this->view->render();
    }

//////////////USER NOTIFICATION FUNCTIONS -//////////


     public function fetchusernotification($pageNumber, $limit)
    {
        $this->view('exec/annoucement_management', [
            'flag' => 'viewnotification',
            'page' => $pageNumber,
            'limit' => $limit
        ]);
        $this->view->render();
    }

         public function filteruserNotifys($username, $messagestype, $startdepo, $enddepo, $page, $pageLimit)
    {
        $this->view('exec/annoucement_management', [ 'username' => $username, 'messagestype' => $messagestype,'startdate' => $startdepo, 'enddate' => $enddepo,'page' => $page, 'limit' => $pageLimit,'flag' => 'filterusernotfys' ]);
        $this->view->render();
    }



}