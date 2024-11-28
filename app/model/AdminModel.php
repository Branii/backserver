<?php

class AdminModel extends MEDOOHelper
{
    public static function addNewAdmin(array $formData) {
            return parent::insert('system_administrators',$formData);
    }

    public static function viewAllAdmin($page, $limit) {
            $startpoint = ($page * $limit) - $limit;
            $data = parent::query(" SELECT * FROM system_administrators 
            ORDER BY admin_id DESC 
            LIMIT :offset, :limit",['offset' => $startpoint, 'limit' => $limit]);
            $totalRecords  = parent::count('system_administrators');
            return ['data' => $data, 'total' => $totalRecords];
    }

    public static function updatePermissions(string $permissionsData, string $adminId){
            return parent::update('system_administrators',['permissions'=> $permissionsData],['admin_id' => $adminId]);
    }

    public static function getAdminLogs($page, $limit, $adminId) {
        try {
             $startpoint = ($page * $limit) - $limit;
             $data = parent::query("SELECT * FROM admin_activity_logs WHERE admin_id = :admin_id
             ORDER BY admin_id DESC 
             LIMIT :offset, :limit",['admin_id' => $adminId, 'offset' => $startpoint, 'limit' => $limit]);
             $totalRecords  = parent::count('admin_activity_logs','*',['admin_id' => $adminId]);
             return ['data' => $data, 'total' => $totalRecords];
        } catch (PDOException $e) {
            return $e;
        }
    }

    public static function filterAdminLogs($page, $limit, $adminId, $datefrom, $dateto) {
        try {
             $startpoint = ($page * $limit) - $limit;
             $conditions = self::filterConditions($adminId,$datefrom,$dateto);
             $data = (new MedooOrm())->openLink()->select('admin_activity_logs', '*', [
            'AND' => $conditions,
            'ORDER' => ['admin_id' => 'DESC'],
            'LIMIT' => [$startpoint, $limit]
        ]);
             $totalRecords  = parent::count('admin_activity_logs', [
                'AND' => $conditions
            ]);
             return ['data' => $data, 'total' => $totalRecords];
        } catch (PDOException $e) {
            return $e;
        }
    }

    public static function filterConditions($adminId,$datefrom='',$dateto=''){
            $conditions = [];
            $conditions = ['admin_id' => $adminId];
            if ($datefrom && $dateto) {
                $conditions['created_at[>=]'] = $datefrom;
                $conditions['created_at[<=]'] = $dateto;
            } elseif ($datefrom) {
                $conditions['created_at[>=]'] = $datefrom;
            } elseif ($dateto) {
                $conditions['created_at[<=]'] = $dateto;
            }
            return $conditions;
    }

    public static function deleteAdim(array $formData): int {
            return 1;//parent::insert('system_administrators',$formData);
    }

}
