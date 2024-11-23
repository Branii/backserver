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

    public static function deleteAdim(array $formData): int {
        return 1;//parent::insert('system_administrators',$formData);
    }

}
