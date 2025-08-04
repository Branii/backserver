<?php


class adminController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

    public function index()
    {
        $this->view('html/signin');
        $this->view->render();
    }

    public function home()
    {
        $this->view('html/home');
        $this->view->render();
    }

    public function signin()
    {
        $this->view('exec/signin');
        $this->view->render();
    }

    public function signout()
    {
        $this->view('exec/signout');
        $this->view->render();
    }

  
    public function admins($data)
    {
        $view = $this->view('exec/admins_exec', [
            'flag' => 'addNewAdmin',
            'data' => $data
        ]);
        $view->render();
    }


    public function alladmins($pageNumber, $limit)
    {
        $this->view('exec/admins_exec', ['flag' => 'viewAdmins', 'page' => $pageNumber, 'limit' => $limit,]);
        $this->view->render();
    }

    // update permissions
    public function permissions($data, $adminId)
    {
        // Decode the JSON from the URL
        $decodedData = urldecode($data);
        $this->view('exec/admins_exec', ['flag' => 'permissions', 'permissionsData' => $decodedData, 'userId' => $adminId]);
        $this->view->render();
    }



    public function adminlogs($pageNumber, $limit, $adminId)
    {
        $this->view('exec/admins_exec', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'adminlogs', 'userId' => $adminId]);
        $this->view->render();
    }

    public function searchlogs($pageNumber, $limit, $adminId, $query)
    {
        $this->view(
            'exec/admins_exec',
            [
                'page' => $pageNumber,
                'limit' => $limit,
                'flag' => 'searchlogs',
                'userId' => $adminId,
                'query' => $query,
            ]
        );
        $this->view->render();
    }

    public function filterAdminLogs($pageNumber, $limit, $adminId, $datefrom, $dateto)
    {
        $this->view('exec/admins_exec', [
            'page' => $pageNumber,
            'limit' => $limit,
            'flag' => 'filterAdminLogs',
            'userId' => $adminId,
            'datefrom' => $datefrom,
            'dateto' => $dateto
        ]);
        $this->view->render();
    }

    public function getAllBackups($pageNumber, $limit)
    {
        $this->view('exec/admins_exec', data: ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'getAllBackups']);
        $this->view->render();
    }

    public function backup()
    {
        $this->view('exec/admins_exec', ['flag' => 'backup']);
        $this->view->render();
    }

    public function gamebetdata($pageNumber, $limit)
    {
        $this->view('exec/businessflow', ['page' => $pageNumber, 'limit' => $limit, 'flag' => 'gamebetdata']);
        $this->view->render();
    }


    public function searchusername($username)
    {
        $this->view('exec/businessflow', ['username' => $username, 'flag' => 'searchusername']);
        $this->view->render();
    }

    public function searchPlatformNames($partnerID, $platformName)
    {
        $this->view('exec/payment_platform', ['partner_id' => $partnerID, 'platformName' => $platformName, 'flag' => 'searchPlatformNames']);
        $this->view->render();
    }



    public function fetchDifferentCurrency($partnerID)
    {
        $this->view('exec/payment_platform', ['partner_id' => $partnerID, 'flag' => 'fetchDifferentCurrency']);
        $this->view->render();
    }
   

    public function fetchLotteryname()
    {
        $this->view('exec/businessflow', ['flag' => 'fetchLotteryname']);
        $this->view->render();
    }

    public function  fetchPartnername()
    {
        $this->view('exec/businessflow', ['flag' => 'partnernames']);
        $this->view->render();
    }

    /// ----- WIN LOSS REPORT --------------------------------
    // public function users_win_loss($partnerID, $lottery_id, $start_date, $end_date, $page, $limit)
    // {
    //     $this->view('exec/win_loss', ['partner_id' => $partnerID, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, "limit" => $limit, 'flag' => 'users-win-loss']);
    //     $this->view->render();
    // }
    // public function get_top_agents($partnerID, $lottery_id, $start_date, $end_date, $page)
    // {

    //     $this->view('exec/win_loss', ['partner_id' => $partnerID, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'flag' => 'get-top-agents']);
    //     $this->view->render();
    // }
    // public function get_subs($partnerID, $user_id, $lottery_id, $start_date, $end_date, $page)
    // {

    //     $this->view('exec/win_loss', ['partner_id' => $partnerID, 'user_id' => $user_id, 'lottery' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'flag' => 'get-subs']);
    //     $this->view->render();
    // }
    // public function get_user_details($partnerID, $user_id, $lottery_id, $start_date, $end_date, $page)
    // {
    //     $this->view('exec/win_loss', ['partner_id' => $partnerID, 'user_id' => $user_id, 'lottery' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'flag' => 'get-user-details']);
    //     $this->view->render();
    // }

    
  
    public function  searchPaymentPlatform($platformName, $currency, $status, $startDate, $endDate, $page, $limit)
    {
        $this->view('exec/payment_platform', ["platformName" => $platformName, "currency" => $currency, "status" => $status, "startDate" => $startDate, "endDate" => $endDate, "page" => $page, "limit" => $limit, 'flag' => 'searchPaymentPlatform']);
        $this->view->render();
    }

    public function  addNewPaymentPlaftorm($partnerID, $paymentType, $paymentTypeName, $currency, $status, $fee, $maxAmount, $minAmount, $siteUrl, $adminSiteUrl, $info, $priority, $countries)
    {
        $this->view('exec/payment_platform', ['partner_id' => $partnerID, "paymentType" => $paymentType, "paymentTypeName" => $paymentTypeName, "currency" => $currency, "status" => $status, "fee" => $fee, "maxAmount" => $maxAmount, "minAmount" => $minAmount, "siteUrl" => $siteUrl, "adminSiteUrl" => $adminSiteUrl, "info" => $info, "priority" => $priority, "countries" => $countries, 'flag' => 'addNewPaymentPlaftorm']);
        $this->view->render();
    }



    public function  fetchBonusTwoSides($lotteryID, $lotteryGameGroup)
    {
        $this->view('exec/lottery_bonus_parameters', ["lottery_type" => $lotteryID, "game_group" => $lotteryGameGroup, "flag" => "fetchBonusTwoSides"]);
        $this->view->render();
    }

   
    //games for user
    public function updatesGames($userid,$data)
    {
        $this->view('exec/account_manage', ["uid"=>$userid, "data" => $data ,"flag" => 'updateLotteryState']);
        $this->view->render();
    }

   
     public function getallgamegroup()
    {
        $this->view('exec/account_manage', ["flag" => 'getallgamegroup']);
        $this->view->render();
    }

   
    
    public function fetchLoterytype()
    {
        $this->view('exec/account_manage', ["flag" => 'fetchLoterytype']);
        $this->view->render();
    }


    //NOTE -
    //////////////lottery bounus Parameter -//////////
    // 
    public function fetchgames()
    {
        $this->view('exec/game_manage', ['flag' => 'fetchgames']);
        $this->view->render();
    }

    //languages

    public function changelang(string $lang)
    {
        $this->view('exec/switchlang', ['lang' => $lang]);
        $this->view->render();
    }

    //google authentication
    public function google()
    {
        $this->view('html/tabs/auth/google');
        $this->view->render();
    }

    public function mobile()
    {
        $this->view('html/tabs/auth/mobile');
        $this->view->render();
    }

    public function email()
    {
        $this->view('auth/email');
        $this->view->render();
    }


    public function checkotpstatus()
    {
        $this->view('exec/googletwofa', ['flag' => 'checkotpstatus']);
        $this->view->render();
    }

    public function activateotp($email)
    {
        $this->view('exec/googletwofa', ['email' => $email, 'flag' => 'twofaenable']);
        $this->view->render();
    }
    public function verifyotp($otpcode)
    {
        $this->view('exec/googletwofa', ['otpcode' => $otpcode, 'flag' => 'verifyotp']);
        $this->view->render();
    }

    public function verifyloginotp($otpcodes, $flagtype)
    {
        $this->view('exec/googletwofa', ['flagtype' => $flagtype, 'otpcodes' => $otpcodes, 'flag' => 'verifyloginotp']);
        $this->view->render();
    }


    public function verifycodebyemail($email)
    {
        $this->view('exec/googletwofa', ['email' => $email, 'flag' => 'verifycodebyemail']);
        $this->view->render();
    }
    public function verifycodebycontact($contact)
    {
        $this->view('exec/googletwofa', ['contact' => $contact, 'flag' => 'verifycodebycontact']);
        $this->view->render();
    }

    public function verifyoption($otpcodes, $flagtype)
    {
        $this->view('exec/googletwofa', ['flags' => $flagtype, 'otpcodes' => $otpcodes, 'flag' => 'verifyoption']);
        $this->view->render();
    }

    public function activateotpmobile($email)
    {
        $this->view('exec/googletwofa', ['email' => $email, 'flag' => 'twofaenables']);
        $this->view->render();
    }
    public function getcodeverify()
    {
        $this->view('exec/googletwofa', ['flag' => 'getcodeverify']);
        $this->view->render();
    }

    public function resetauth()
    {
        $this->view('exec/googletwofa', ['flag' => 'resetauth']);
        $this->view->render();
    }

  
  

 
    //search name inputs
    public function searchusernames($username)
    {
        $this->view('exec/userbank_manage', ['username' => $username, 'flag' => 'searchusername']);
        $this->view->render();
    }

     
    // public function searchusername($username)
    // {
    //     $this->view('exec/businessflow', ['username' => $username, 'flag' => 'searchusername']);
    //     $this->view->render();
    // }
   
    

    //searchadmin names
    public function searchusernamesss($username)
    {
        $this->view('exec/admins_exec', ['username' => $username, 'flag' => 'searchusernamess']);
        $this->view->render();
    }

 

    public function filteradmindata($username, $uid, $pageNumber, $limit)
    {
        $this->view('exec/admins_exec', [
            'username' => $username,
            'uid' => $uid,
            'flag' => 'filteradminpayments',
            'page' => $pageNumber,
            'limit' => $limit,
        ]);
        $this->view->render();
    }

    public function changerAdminpassword($email, $repeatPassword){
      $this->view('exec/admins_exec', ['email' => $email, 'repeatPassword' => $repeatPassword, 'flag' => 'changeadminpassword']);
        $this->view->render();
    }


    // reset user login attempt

     public function resetUser($uid) {
    
    $this->view('exec/account_manage', [
        'uid' => $uid,
        'flag' => 'resetloginattempt'
    ]);
    $this->view->render();
}

   

    //filteradmindata
}
