<?php

class PromotionManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// INVITATION AND REFREAL LINK -//////////

    public static function FetchUserlinkData($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT referral_link.*,users_test.email,users_test.contact,users_test.reg_type,users_test.username FROM referral_link   
             INNER JOIN users_test ON users_test.uid= referral_link.agent_id  ORDER BY refid DESC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
         );
        // $data = parent::query(
        //     "SELECT * FROM referral_link  ORDER BY refid  DESC LIMIT :offset, :limit",
        //     ['offset' => $startpoint, 'limit' => $limit]
        // );

        $totalRecords  = parent::count('referral_link');
        return ['data' => $data, 'total' => $totalRecords];
    }
    public static function FilterUserlinks($subQuery,$page, $limit)
    {
        $startpoint = ($page - 1) * $limit;

        $sql = "
        SELECT 
           referral_link.*, 
           users_test.email AS email, 
           users_test.reg_type,
           users_test.username AS username, 
           users_test.contact
        FROM referral_link
        LEFT JOIN users_test ON users_test.uid = referral_link.agent_id
        WHERE $subQuery
        LIMIT :offset, :limit
  ";

        // Define the query to count total records
        $countSqls = "
            SELECT 
                COUNT(*) AS total_counts
            FROM 
                referral_link
            WHERE 
                $subQuery
        ";

    
        $data = parent::query($sql, ['offset' => $startpoint, 'limit' => $limit]);

        $totalRecordsResult = parent::query($countSqls);
        $totalRecords = $totalRecordsResult[0]['total_counts'];
        $lastQuery = MedooOrm::openLink()->log();

        return ['data' => $data, 'total' => $totalRecords, 'sql' => $lastQuery];
    }

    public static function FilterUserlinksDataSubQuery($username, $startdate, $enddate)
    {
        $filterConditions = [];

        // Build filter conditions
        if (!empty($username)) {
            $filterConditions[] = "referral_link.agent_id = '$username'";
        }

        if (!empty($startdate) && !empty($enddate)) {
            $filterConditions[] = "referral_link.date_created BETWEEN '$startdate' AND '$enddate'";
        } elseif (!empty($startdate)) {
            $filterConditions[] = "referral_link.date_created = '$startdate'";
        } elseif (!empty($enddate)) {
            $filterConditions[] = "referral_link.date_created = '$enddate'";
        }

        // Add conditions to subquery (handle WHERE and AND appropriately)
        if (!empty($filterConditions)) {
            $subQuery = implode(' AND ', $filterConditions);
        }
        // Add ordering and limit to the query
        $subQuery .= " ORDER BY referral_link.date_created DESC";

        return $subQuery;
    }


    ////////////// INVITATION AND REFREAL LINK -//////////




}
