<?php

class BusinessFlow extends MEDOOHelper
{


    public static function FetchTrsansactionData($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT transaction.*, COALESCE(users.username, 'N/A') AS username FROM transaction   
            JOIN users ON users.uid = transaction.uid  ORDER BY trans_id DESC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );
        $totalRecords  = parent::count('transaction');
        $trasationIds = array_column($data, 'order_id');
        return ['data' => $data, 'total' => $totalRecords, 'transactionIds' => $trasationIds];
    }


    public static function filterusername(string $username)
    {
        $data = parent::query("SELECT username FROM users WHERE username LIKE :username ORDER BY username ASC", ['username' => "%{$username}%"]);
        return $data;
    }


    //NOTE -
    ////////////// LOTTERY BETTING-//////////

    public static function getAllGameIds(): array
    {
        $res = parent::selectAll("gamestable_map", ["bet_table"]);
        return $res;
    }

    public static function fetchBetRecords($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $res = self::getAllGameIds();
        $data = [];
        $totalRecords = 0;

        foreach ($res as $tables) {
            $gameTable = $tables['bet_table'];

            $records = parent::query(
                "SELECT $gameTable.*, users.username,game_type.name FROM $gameTable 
             JOIN users ON users.uid = $gameTable.uid 
             JOIN game_type ON game_type.gt_id = $gameTable.game_type 
             ORDER BY $gameTable.bid DESC 
             LIMIT :offset, :limit",
                ['offset' => $startpoint, 'limit' => $limit]
            );

            if (!empty($records)) {
                $data = array_merge($data, $records);
                $totalRecords += parent::count($gameTable); // Count only if there are records
            }
        }

        usort($data, function ($a, $b) {
            return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
        });

        // $totalPages = ceil($totalRecords / $limit);
        return [
            'data' =>$data ,
            'totalPages' => $totalRecords

        ];
    }


    public static function fetchLotteryname(): array
    {
        return  $res = parent::selectAll("game_type", ["gt_id", "name"], ["ORDER" => ["lottery_type" => "ASC"]]);
    }

}
