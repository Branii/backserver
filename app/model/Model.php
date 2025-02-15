<?php 
// use Josantonius\Session\Session;
// (new Session)->start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class Model extends PDOHelper{

    public static function authenticate($email, $password){
        $sql = "SELECT * FROM system_administrators WHERE email = ?";
        $res = parent::selectOne($sql,[$email]);
        if(!empty($res) && password_verify($password, $res['password_hash'])){
           
            (new SessionMan)->startSession();
            (new SessionMan)->setSession("isUserLoggedIn",$email);
            (new SessionMan)->regenerateId();

            $_SESSION['isUserLoggedIn'] = $email;
            $_SESSION['isUserLoggedInId'] = $res['admin_id'];
            
            session_regenerate_id(true);
            (new Controller)->addAdminLoggins($res['admin_id'], "Sign In", 'Signed Out', 'Signed In', $res['admin_id'], 'success');
           
            return [
                'type' => 'success',
                'message'=> 'sign in successful',
                'email' => $email,
                'role' => $res['role'],
                'Oauth' => $res['status'] == 'on' ? '../admin/Oauth' : 'Off',
                'url' => '../limvo/home/' //index | //home
            ];
        }else{
            return [
                'type' => 'error',
                'message'=> 'Wrong email or password'
            ];
        }
    }

    // public static function getAllUsers($page, $limit) {
    //     $startpoint = ($page * $limit) - $limit;
    //     $data = parent::query(
    //         "SELECT uid, username, nickname, user_email, user_dob, user_contact, company, agent, balance, rebate FROM users LIMIT :offset, :limit",
    //         ['offset' => $startpoint, 'limit' => $limit]
    //     );
    //     $totalRecords  = parent::count('users');
    //     return ['data' => $data, 'total' => $totalRecords];
    // }

    // public static function paginateAllUsers(mixed $currentPage, mixed $itemPerPage) {

    //     $totalRecords  = parent::count('users');
    //     $pages = ceil($totalRecords / $itemPerPage) ?? 1;

    //     $pagination = [
    //         'prev' => ($currentPage > 1) ? $currentPage - 1 : 1,
    //         'next' => ($currentPage < $pages) ? $currentPage + 1 : $pages,
    //         'pages' => []
    //     ];

    //     for ($i = 1; $i <= $pages; $i++) {
    //         $pagination['pages'][] = $i;
    //     }

    //     return $pagination;

    // }

    public static function getUserPermissionSidebar(string $email){

        try {
            $sql = "SELECT permissions FROM system_administrators WHERE email = ?";
            return parent::selectOne($sql,[$email])['permissions'];
        } catch (\Throwable $th) {
           var_dump($th);
        }
    }

    public static function getUserPermissions(string $email){

        try {
            $sql = "SELECT permissions FROM system_administrators WHERE email = ?";
            return parent::selectOne($sql, [$email])['permissions'];
        } catch (\Throwable $th) {
           var_dump($th);
        }
    }

    public static function getPermissionSidebar(){

        try {
            $sql = "SELECT side_bar_title,side_bar_menu FROM permissions_tbl";
            return parent::selectOne( $sql);
        } catch (\Throwable $th) {
           var_dump($th);
        }
    }

    //admin_id	action_performed	created_date	created_time	ip_address	affected_entity	old_value	new_value	action_status
    public static function addAdminLogs(string $adminId, string $actionPerformed, string $oldVal, string $newVal, string $affectedEntity, string $status){
        $log_data = [
            'admin_id' => $adminId,
            'action_performed' => $actionPerformed,
            'created_date' => date("Y-m-d"),
            'created_time' => date("H:i:s"),
            'ip_address' => Utils::getUserIP(),
            'affected_entity' => $affectedEntity,
            'old_value' => $oldVal,
            'new_value' => $newVal,
            'action_status' => $status,
        ];
        $sql = "INSERT INTO admin_activity_logs(admin_id,action_performed,created_date,created_time,
        ip_address,affected_entity,old_value,new_value,action_status)VALUES(?,?,?,?,?,?,?,?,?)";
        return parent::insert($sql,array_values($log_data));
    }

    public static function getTables(string $lotteryId)
    {
        $sql = "SELECT game_type, draw_table, bet_table, draw_storage FROM gamestable_map";
        $result = PDOHelper::selectAll($sql);
        foreach ($result as $data) {
            if($data['game_type'] == $lotteryId){
                return $data;
            };
        }
   
    }


}