<?php
use Josantonius\Session\Session;

class Controller{
    protected  $view;
    public function view($viewName,$data=[]){
      $this->view = new View($viewName,$data);
      return $this->view;
    }

    public function isUserLoggedIn(){  
      return (new Session)->has("isUserLoggedIn");
    }

    public function getSeesion(string $name){
      return (new Session)->get($name);
    }

    public function getUsername(string $fullname){
      return (new Model())->getUsername($fullname);
    }


    public function getUserPermissions(string $email){
      $response = (new Model())->getUserPermissions($email);
      return json_decode($response,true);
    }

    public function getPermissionSidebars(){
      $result = [];
      $response = (new Model())->getPermissionSidebar();
      $result['title'] = json_decode($response['side_bar_title'],true);
      $result['menu']  = json_decode($response['side_bar_menu'],true);
      return $result;
    }

    public function addAdminLoggins(string $adminId, string $actionPerformed, string $oldVal, string $newVal, string $affectedEntity, string $status){
      return (new Model())->addAdminLogs($adminId, $actionPerformed, $oldVal, $newVal, $affectedEntity, $status);
    }

}