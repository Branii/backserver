<?php

class UserBankManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// Bank Card  LIST -//////////

    public static function FetchBankcardlistData($page, $limit): array
    {

        $startpoint = ($page - 1) * $limit;
        $data = parent::query(
            "SELECT user_bank.*, users_test.username, users_test.nickname, users_test.email
            FROM user_bank
            JOIN users_test ON user_bank.uid = users_test.uid
            ORDER BY bank_id DESC
            LIMIT :startpoint, :limit",
            ['startpoint' => (int)$startpoint, 'limit' => (int)$limit]
        );

        $totalRecords = parent::count('user_bank');

        return ['data' => $data, 'total' => $totalRecords];
    }
}

 