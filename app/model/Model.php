<?php 
use Josantonius\Session\Session;
(new Session)->start();
class Model extends MEDOOHelper{

    public static function authenticate($email, $password){
        $res = parent::selectOne("admin_tbl",'*',['email'=> $email]);
        if(!empty($res) && password_verify($password, $res['password'])){
           
            (new Session)->set("isUserLoggedIn",value: $email);
            (new Session)->regenerateId();
           
            return [
                'type' => 'success',
                'message'=> 'sign in successful',
                'email' => $email,
                'role' => $res['role'],
                'Oauth' => $res['status'] == 'on' ? '../admin/Oauth' : 'Off',
                'url' => '../limvo/admin/home',
                'sessionId' => (new Session)->get("isUserLoggedIn")
            ];
        }else{
            return [
                'type' => 'error',
                'message'=> 'Wrong email or password'
            ];
        }
    }

    public static function getAllUsers($page, $limit) {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT uid, username, nickname, user_email, user_dob, user_contact, company, agent, balance, rebate FROM users LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );
        $totalRecords  = parent::count('users');
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function paginateAllUsers(mixed $currentPage, mixed $itemPerPage) {

        $totalRecords  = parent::count('users');
        $pages = ceil($totalRecords / $itemPerPage) ?? 1;

        $pagination = [
            'prev' => ($currentPage > 1) ? $currentPage - 1 : 1,
            'next' => ($currentPage < $pages) ? $currentPage + 1 : $pages,
            'pages' => []
        ];

        for ($i = 1; $i <= $pages; $i++) {
            $pagination['pages'][] = $i;
        }

        return $pagination;

    }


}