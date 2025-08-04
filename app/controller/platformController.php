<?php
class platformController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }

  
    //sms configuration
    public function fetchsmsplatform($page, $pageLimit){
      $this->view('exec/platform_settings', ['page' => $page, 'pageLimit' => $pageLimit, 'flag' => 'fetchsms']);
      $this->view->render();
    }
    public function addprovider($smsprovider,$sendename){
      $this->view('exec/platform_settings', ['smsprovider' => $smsprovider, 'sendename' => $sendename, 'flag' => 'addprovider']);
      $this->view->render();
    }

     public function smspreferences(){
      $this->view('exec/platform_settings', ['flag' => 'savepreferences']);
      $this->view->render();
    }
    public function savesmspreferencestate(){
      $this->view('exec/platform_settings', ['flag' => 'savesmspreferencestate']);
      $this->view->render();
    }
     public function fetchsmsprovider(){
      $this->view('exec/platform_settings', ['flag' => 'fetchsmsprovider']);
      $this->view->render();
     }

     public function deletesms($smsid){
      $this->view('exec/platform_settings', ['sms'=>$smsid,'flag' => 'deletesms']);
      $this->view->render();
     }
     

     public function  filtersms($smsprovider,$smsstatus,$startdate,$enddate,$page,$limit){
      $this->view('exec/platform_settings', [
        'smsprovider'=>$smsprovider,
        'smsstatus'=>$smsstatus,
        'startdate'=>$startdate,
        'enddate'=>$enddate,
        'page'=>$page,
        'limit'=>$limit,
        'flag' => 'filtersms']);
      $this->view->render();
     }

     

   //email configuration
      public function fetchemaildata($page, $pageLimit){
      $this->view('exec/platform_settings', ['page' => $page, 'pageLimit' => $pageLimit, 'flag' => 'fetchemaildata']);
      $this->view->render();
    }

     public function emailaddprovider($emailprovider,$sendename){
      $this->view('exec/platform_settings', ['emailprovider' =>$emailprovider, 'sendename' => $sendename, 'flag' => 'emailaddprovider']);
      $this->view->render();
    }

     public function fetchemailprovider(){
      $this->view('exec/platform_settings', ['flag' => 'fetchemailprovider']);
      $this->view->render();
     }

      public function emailpreferences(){
      $this->view('exec/platform_settings', ['flag' => 'savepreferencesemail']);
      $this->view->render();
    }
    public function savedemailpreferencestate(){
      $this->view('exec/platform_settings', ['flag' => 'savedemailpreferencestate']);
      $this->view->render();
    }

     public function deleteemail($emailid){
      $this->view('exec/platform_settings', ['email'=>$emailid,'flag' => 'deleteemail']);
      $this->view->render();
     }

     public function  filteremail($emailprovider,$emailstatus,$startdate,$enddate,$page,$limit){
        $this->view('exec/platform_settings', [
            'emailprovider'=>$emailprovider,
            'emailstatus'=>$emailstatus,
            'startdate'=>$startdate,
            'enddate'=>$enddate,
            'page'=>$page,
            'limit'=>$limit,
            'flag' => 'filteremail']);
        $this->view->render();
     }
     
}