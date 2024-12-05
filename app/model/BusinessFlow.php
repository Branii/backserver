<?php

class BusinessFlow extends MEDOOHelper
{


    public static function FetchTrsansactionData($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT transaction.*,users_test.nickname, COALESCE(users_test.username, 'N/A') AS username FROM transaction   
            JOIN users_test ON users_test.uid = transaction.uid  ORDER BY trans_id DESC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );
        $totalRecords  = parent::count('transaction');
        $trasationIds = array_column($data, 'order_id');
        return ['data' => $data, 'total' => $totalRecords, 'transactionIds' => $trasationIds];
    }


    public static function filterusername(string $username)
    {
        $data = parent::query("SELECT uid,username FROM users_test WHERE username LIKE :username ORDER BY username ASC", ['username' => "%{$username}%"]);
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
                "SELECT $gameTable.*, users_test.username,game_type.name FROM $gameTable 
             JOIN users_test ON users_test.uid = $gameTable.uid 
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
        return ['data' => $data, 'totalPages' => $totalRecords];
    }


    public static function fetchLotteryname(): array
    {
        return  $res = parent::selectAll("game_type", ["gt_id", "name"], ["ORDER" => ["lottery_type" => "ASC"]]);
    }


    public static function Searchusername(string $username)
    {
        $username = strtolower($username);
        $data = parent::query("SELECT uid, username  FROM users_test WHERE username LIKE :search ORDER BY  CASE  WHEN username LIKE :startsWith THEN 1  -- Prioritize usernames that start with the search term
            ELSE 2 END,  username ASC  LIMIT 50", ['search' => "%$username%", 'startsWith' => "$username%"]);
        return $data;
    }


    // public static function getAllUserBetByUserId($subQuery)
    // {

    //     try {

    //         $bettable = self::getAllGameIds();
    //         $data = [];
    //         $totalRecords = 0;
    //         foreach ($bettable as $tables) {

    //             $tableName = $tables['bet_table'];
    //             $result = parent::query("SELECT $tableName.*, users.username,game_type.name FROM $tableName 
    //          JOIN users ON users.uid = $tableName.uid 
    //          JOIN game_type ON game_type.gt_id = $tableName.game_type WHERE $subQuery
    //          ORDER BY $tableName.bid DESC");


    //             if (!empty($result)) {
    //                 $data = array_merge($data, $result);
    //                 $totalRecords += parent::count($tableName); // Count only if there are records
    //             }
    //         }

    //         usort($data, function ($a, $b) {
    //             return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
    //         });

    //         // $totalPages = ceil($totalRecords / $limit);
    //         return ['data' => $data, 'totalPages' => $totalRecords];
    //     } catch (Exception $e) {
    //         // Handle the exception, e.g., log it and return a default value
    //         error_log("Error executing query: " . $e->getMessage());
    //         return 0; // Return 0 or any default value you want in case of an error
    //     }
    // }
    // public static function filterBetData($betadata, $limit)
    // {

    //     //   print_r($betadata);
    //     // exit;

    //     $filterConditions = [];
    //     $subQuery = '';

    //     $uid = ($betadata["usernames"] == 'all') ? '' : $betadata["usernames"];
    //     $betstatus =  ($betadata["betstatus"] == 'all') ? '' : $betadata["betstatus"];
    //     $bestate   = ($betadata["betsate"] == 'all') ? '' : $betadata["betsate"];
    //     $lottery  = ($betadata['lotteryname'] == 'all') ? '' : $betadata['lotteryname'];
    //     $from  = ($betadata['startdate'] == '') ? '' : $betadata['startdate'];
    //     $to  =  ($betadata['enddate'] == '')  ? '' : $betadata['enddate'];

    //     if (!empty($uid)) {
    //         $filterConditions[] = "uid = '$uid'";
    //     }

    //     if (!empty($lottery)) {
    //         $filterConditions[] = "game_type = '$lottery'";
    //     }


    //     if (!empty($betstatus)) {
    //         $filterConditions[] = "bet_status = '$betstatus'";
    //     }

    //     if (!empty($bestate)) {
    //         $filterConditions[] = "state = '$bestate'";
    //     }

    //     if (!empty($from) && !empty($to)) {
    //         $filterConditions[] = "bet_date BETWEEN '$from' AND '$to'";
    //     } elseif (!empty($from)) {
    //         $filterConditions[] = "bet_date = '$from'";
    //     } elseif (!empty($to)) {
    //         $filterConditions[] = "bet_date = '$to'";
    //     }

    //     if (!empty($filterConditions)) {
    //         $subQuery .= '' . implode(' AND ', $filterConditions);
    //     }

    //     $subQuery .= "ORDER BY server_date DESC LIMIT $limit";

    //     return $subQuery;
    // }

    public static function getAllUserBetByUserId($subQuery)
    {
        try {
            $bettable = self::getAllGameIds();
            $data = [];
            $totalRecords = 0;

            foreach ($bettable as $tables) {
                $tableName = $tables['bet_table'];

                // Ensure query includes subquery conditions (e.g., WHERE clause)
                $result = parent::query("SELECT $tableName.*, users_test.username, game_type.name FROM $tableName
             JOIN users ON users_test.uid = $tableName.uid
             JOIN game_type ON game_type.gt_id = $tableName.game_type
             WHERE $subQuery");

                // If the result is not empty, merge it into the data array
                if (!empty($result)) {
                    $data = array_merge($data, $result);
                    // Count records based on the query results, not just table count
                    $totalRecords += count($result);
                }
            }

            // Sort data by date and time
            usort($data, function ($a, $b) {
                return strtotime($b["server_date"] . " " . $b["server_time"]) <=> strtotime($a["server_date"] . " " . $a["server_time"]);
            });

            return ['data' => $data, 'total' => $totalRecords];
        } catch (Exception $e) {
            // Handle the exception (log error)
            error_log("Error executing query: " . $e->getMessage());
            return ['data' => [], 'total' => 0]; // Return empty data on error
        }
    }

    public static function filterBetData($betadata, $limit)
    {
        $filterConditions = [];
        $subQuery = '';

        $uid = ($betadata["usernames"] == 'all') ? '' : $betadata["usernames"];
        $betstatus =  ($betadata["betstatus"] == 'all') ? '' : $betadata["betstatus"];
        $bestate   = ($betadata["betsate"] == 'all') ? '' : $betadata["betsate"];
        $lottery  = ($betadata['lotteryname'] == 'all') ? '' : $betadata['lotteryname'];
        $from  = ($betadata['startdate'] == '') ? '' : $betadata['startdate'];
        $to  =  ($betadata['enddate'] == '')  ? '' : $betadata['enddate'];

        // Build filter conditions
        if (!empty($uid)) {
            $filterConditions[] = "uid = '$uid'";
        }

        if (!empty($lottery)) {
            $filterConditions[] = "game_type = '$lottery'";
        }

        if (!empty($betstatus)) {
            $filterConditions[] = "bet_status = '$betstatus'";
        }

        if (!empty($bestate)) {
            $filterConditions[] = "state = '$bestate'";
        }

        if (!empty($from) && !empty($to)) {
            $filterConditions[] = "bet_date BETWEEN '$from' AND '$to'";
        } elseif (!empty($from)) {
            $filterConditions[] = "bet_date = '$from'";
        } elseif (!empty($to)) {
            $filterConditions[] = "bet_date = '$to'";
        }

        // Add conditions to subquery (handle WHERE and AND appropriately)
        if (!empty($filterConditions)) {
            $subQuery = 'WHERE ' . implode(' AND ', $filterConditions);
        }
        // Add ordering and limit to the query
        $subQuery .= " ORDER BY server_date DESC LIMIT $limit";

        return $subQuery;
    }
}
