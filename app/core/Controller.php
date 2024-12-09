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

    public function getUserPermissionSidebars(string $email){
      return (new Model())->getUserPermissionSidebar($email);
    }

    //admin_id	action_performed	created_date	created_time	ip_address	affected_entity	old_value	new_value	action_status	
    public function addAdminLoggins(string $adminId, string $actionPerformed, string $oldVal, string $newVal, string $affectedEntity, string $status){
      return (new Model())->addAdminLogs($adminId, $actionPerformed, $oldVal, $newVal, $affectedEntity, $status);
    }

}