<?php

class AdminModel extends MEDOOHelper
{
    public static function addNewAdmin(array $formData)
    {
        return parent::insert('system_administrators', $formData);
    }

    public static function viewAllAdmin($page, $limit)
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(" SELECT * FROM system_administrators 
            ORDER BY admin_id DESC 
            LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords  = parent::count('system_administrators');
        return ['data' => $data, 'total' => $totalRecords];
    }


    //update permission table
  public static function updatePermissions(string $permissionsJson, string $adminId)
{
    return parent::update('system_administrators', ['permissions' => $permissionsJson], ['admin_id' => $adminId]);
}


    public static function getAdminLogs($page, $limit, $adminId)
    {
        try {
            $startpoint = ($page * $limit) - $limit;
            $data = parent::query("SELECT * FROM admin_activity_logs WHERE admin_id = :admin_id
             ORDER BY admin_id DESC 
             LIMIT :offset, :limit", ['admin_id' => $adminId, 'offset' => $startpoint, 'limit' => $limit]);
            $totalRecords  = parent::count('admin_activity_logs', '*', ['admin_id' => $adminId]);
            return ['data' => $data, 'total' => $totalRecords];
        } catch (PDOException $e) {
            return $e;
        }
    }

    public static function filterAdminLogs($page, $limit, $adminId, $datefrom, $dateto)
    {
        try {
            $startpoint = ($page * $limit) - $limit;
            $conditions = self::filterConditions($datefrom, $dateto);
            $where = $conditions['where'];
            $params = $conditions['params'];
            $data = parent::query(
                "SELECT * FROM admin_activity_logs WHERE " . $where . " AND admin_id = :admin_id
            ORDER BY admin_id DESC LIMIT :offset, :limit",
                array_merge($params, ['admin_id' => $adminId, 'offset' => $startpoint, 'limit' => $limit])
            );
            //return $lastQuery = MedooOrm::openLink()->log();
            $totalRecords = parent::query(
                "SELECT * FROM admin_activity_logs WHERE " . $where . " AND admin_id = :admin_id ORDER BY admin_id DESC",
                array_merge($params, ['admin_id' => $adminId])
            );
            return ['data' => $data, 'total' => count($totalRecords)];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function filterConditions($datefrom = '', $dateto = '')
    {
        $where = '';
        $params = [];
        if ($datefrom && $dateto) {
            $where .= "created_date >= :datefrom AND created_date <= :dateto";
            $params['datefrom'] = $datefrom;  // Set datefrom parameter
            $params['dateto'] = $dateto;      // Set dateto parameter
        } elseif ($datefrom) {
            $where .= "created_date = :datefrom";
            $params['datefrom'] = $datefrom;
        } elseif ($dateto) {
            $where .= "created_date = :dateto";
            $params['dateto'] = $dateto;
        }
        return ['where' => $where, 'params' => $params];
    }

    public static function searchAdminLogs($page, $limit, $adminId, $query)
    {
        $startpoint = ($page * $limit) - $limit;
        $conditions = self::searchAdminLogQuery($query);
        $where = $conditions['where'];
        $params = $conditions['params'];
        $data = parent::query(
            "SELECT * FROM admin_activity_logs " . $where . "
        ORDER BY admin_id DESC LIMIT :offset, :limit",
            array_merge($params, ['admin_id' => $adminId, 'offset' => $startpoint, 'limit' => $limit])
        );
        $totalRecords = parent::query(
            "SELECT * FROM admin_activity_logs " . $where . " ORDER BY admin_id DESC",
            array_merge($params, ['admin_id' => $adminId])
        );
        return ['data' => $data, 'total' => count($totalRecords)];
    }

    public static function searchAdminLogQuery(string $query = ''): array
    {
        $where = '';
        $params = [];
        if ($query) {
            $where .= "WHERE created_date LIKE :query OR action_performed LIKE :query OR old_value LIKE :query OR new_value LIKE :query";
            $params['query'] = "%$query%";
        } else {
            $where = "";
            $params['query'] = '';
        }
        return ['where' => $where, 'params' => $params];
    }

    public static function createNewBackup(string $backupFile, string $fileSize)
    {
        $fileName = explode("/", $backupFile);
        $data = [
            'backup_name' => end($fileName),
            'backup_type' => 'Full Backup',
            'backup_path' => '/app/backups',
            'backup_status' => 'Active',
            'backup_date' => date("Y-m-d"),
            'backup_time' => date("H:i:s"),
            'backup_size' => $fileSize,
            'encryption' => 'AES-256'
        ];
        return parent::insert('backups', $data);
    }

    public static function getAllBackups($page, $limit)
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(" SELECT * FROM backups  ORDER BY backup_id DESC 
        LIMIT :offset, :limit", ['offset' => $startpoint, 'limit' => $limit]);
        $totalRecords  = parent::count('backups');
        return ['data' => $data, 'total' => $totalRecords];
    }

    public static function Updatepasswordbyemail($email, $repeatPassword)
    {

        $data = parent::query("SELECT * FROM system_administrators WHERE email = :email", ['email' => $email]);
        if (!$data || count($data) === 0) {
            return  ['success' => false, 'message' => 'Email not found'];
        }
        $hashedPassword = password_hash($repeatPassword, PASSWORD_DEFAULT);
        $update = parent::query("UPDATE system_administrators SET password_hash = :password WHERE email = :email", ['password' => $hashedPassword, 'email' => $email]);
        if ($update !== false) {
            return ['success' => true,  'message' => 'Password changed successfully!'];
        } else {
            return ['success' => false, 'message' => 'Failed to update password.'];
        }
    }


    public static function Searchusernames(string $username)
    {
        $query = trim($username); // Clean input
        $data = parent::query(
            "SELECT admin_id, username, email, phone_number, full_name
         FROM system_administrators
         WHERE 
            (LOWER(username) LIKE LOWER(:search) 
            OR LOWER(phone_number) LIKE LOWER(:search) 
            OR LOWER(email) LIKE LOWER(:search)
            OR LOWER(full_name) LIKE LOWER(:search))
         ORDER BY 
            CASE
                WHEN LOWER(username) = LOWER(:exactMatch) THEN 1
                WHEN LOWER(phone_number) = LOWER(:exactMatch) THEN 2
                WHEN LOWER(email) = LOWER(:exactMatch) THEN 3
                WHEN LOWER(full_name) = LOWER(:exactMatch) THEN 4
                WHEN LOWER(username) LIKE LOWER(:startsWith) THEN 5
                WHEN LOWER(phone_number) LIKE LOWER(:startsWith) THEN 6
                WHEN LOWER(email) LIKE LOWER(:startsWith) THEN 7
                WHEN LOWER(full_name) LIKE LOWER(:startsWith) THEN 8
                ELSE 9
            END,
            username ASC
         LIMIT 50",
            [
                'search' => "%$query%",
                'startsWith' => "$query%",
                'exactMatch' => $query
            ]
        );

        return $data;
    }

    public static function getAdminIdByUsername(string $key)
    {
        if (empty($key)) return [];

        $db = parent::openLink();
        return parent::query(
            "SELECT admin_id, username FROM system_administrators 
         WHERE admin_id = :key OR email = :key OR username = :key OR phone_number = :key OR full_name = :key",
            ['key' => $key]
        );
    }

    public static function filteradmindata($adminId, $page, $limit)
    {
        $db = parent::openLink();
        $startpoint = ($page * $limit) - $limit;

        // If a specific admin ID is provided, filter by it
        if (!empty($adminId)) {
            $data = parent::query(
                "SELECT * FROM system_administrators 
             WHERE admin_id = :admin_id 
             ORDER BY admin_id DESC 
             LIMIT :offset, :limit",
                [
                    'admin_id' => $adminId,
                    'offset' => $startpoint,
                    'limit' => $limit
                ]
            );

            // Count only the matching admin
            $totalRecords = parent::query(
                "SELECT COUNT(*) AS total FROM system_administrators WHERE admin_id = :admin_id",
                ['admin_id' => $adminId]
            );
            $total = $totalRecords[0]['total'] ?? 0;
        } else {
            // No filtering, get all admins
            $data = parent::query(
                "SELECT * FROM system_administrators 
             ORDER BY admin_id DESC 
             LIMIT :offset, :limit",
                [
                    'offset' => $startpoint,
                    'limit' => $limit
                ]
            );

            $total = parent::count('system_administrators');
        }

        return ['data' => $data, 'total' => $total];
    }
}
