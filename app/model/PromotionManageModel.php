<?php

class PromotionManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// INVITATION AND REFREAL LINK -//////////

    public static function FetchUserlinkData($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query("SELECT * FROM referral_link  ORDER BY refid  DESC LIMIT :offset, :limit",
        ['offset' => $startpoint, 'limit' => $limit]);

        $totalRecords  = parent::count('referral_link');
        return ['data' => $data, 'total' => $totalRecords];
    }
    public static function FilterUserlinks($page, $limit, $username, $startdate, $enddate)
    {
        $whereConditions = self::FilterUserlinksDataSubQuery($username,  $startdate, $enddate);
        $startpoint = ($page * $limit) - $limit;
        
        $data = parent::selectAll("referral_link", '*', ["AND" => $whereConditions, "ORDER" => ["refid" => "DESC"], "LIMIT" => [$startpoint, $limit]]);
        $lastQuery = MedooOrm::openLink()->log();
        $totalRecords  = parent::selectAll('referral_link', '*', ['AND' => $whereConditions]);
        return ['data' => $data, 'total' => count($totalRecords), 'sql' => $lastQuery[0]];
    }

    public static function FilterUserlinksDataSubQuery($username = '', $from = '', $to = '')
    {
        $conditions = [];

        if (!empty($username) && $username != 'all') {
            $conditions['referral_link.agent_id'] = $username;
        }

        // if (!empty($states) && $states != 'all') {
        //     $conditions['users.state'] = $states;
        // }

        if ($from != '' && $to != '') {
            $conditions['referral_link.date_created[<>]'] = [$from, $to];
        } elseif ($from != '') {
            $conditions['referral_link.date_created[>=]'] = $from;
        } elseif ($to != '') {
            $conditions['referral_link.date_created[<=]'] = $to;
        }

        return $conditions;
    }
 
  
      ////////////// INVITATION AND REFREAL LINK -//////////
  
   


}
