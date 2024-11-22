<?php

class AgentManageModel extends MEDOOHelper
{

    //NOTE -
    ////////////// QUOTA SETTINGS -//////////

    public static function FetchQuotaData($page, $limit): array
    {
        $startpoint = ($page * $limit) - $limit;
        $data = parent::query(
            "SELECT * FROM rebate  ORDER BY rebate_id  ASC LIMIT :offset, :limit",
            ['offset' => $startpoint, 'limit' => $limit]
        );

        $totalRecords  = parent::count('rebate');
        return ['data' => $data, 'total' => $totalRecords];
    }
    // public static function FilterUserlinks($page, $limit, $username, $startdate, $enddate)
    // {
    //     $whereConditions = self::FilterUserlinksDataSubQuery($username,  $startdate, $enddate);
    //     $startpoint = ($page * $limit) - $limit;

    //     $data = parent::selectAll("referral_link", '*', ["AND" => $whereConditions, "ORDER" => ["refid" => "DESC"], "LIMIT" => [$startpoint, $limit]]);
    //     $lastQuery = MedooOrm::openLink()->log();
    //     $totalRecords  = parent::selectAll('referral_link', '*', ['AND' => $whereConditions]);
    //     return ['data' => $data, 'total' => count($totalRecords), 'sql' => $lastQuery[0]];
    // }

    // public static function FilterUserlinksDataSubQuery($username = '', $from = '', $to = '')
    // {
    //     $conditions = [];

    //     if (!empty($username) && $username != 'all') {
    //         $conditions['referral_link.agent_id'] = $username;
    //     }

    //     // if (!empty($states) && $states != 'all') {
    //     //     $conditions['users.state'] = $states;
    //     // }

    //     if ($from != '' && $to != '') {
    //         $conditions['referral_link.date_created[<>]'] = [$from, $to];
    //     } elseif ($from != '') {
    //         $conditions['referral_link.date_created[>=]'] = $from;
    //     } elseif ($to != '') {
    //         $conditions['referral_link.date_created[<=]'] = $to;
    //     }

    //     return $conditions;
    // }

    public static function UpdateSingleQuota($rebateid, $quota)
    {
      
        $data = ["quota" => $quota]; 
        $where = ["rebate_id" => $rebateid]; 
        $Singlequota = parent::update("rebate", $data, $where);

        // Check if the update was successful
        if ($Singlequota > 0) {
          
            $data = parent::query("SELECT uid, rebate FROM users");
            foreach ($data as $user) {
             $rebateData = parent::selectAll("rebate",["odds_group", "rebate", "quota", "counts"],["rebate[<=]"  => $user['rebate']]);
             self::UpdateUserquotaData(json_encode(($rebateData)),$user['uid']);
 
            }
         
        } else {
            echo "No rows updated ";
        }
        
    }

    public static function UpdateAllQuota($quota)
    {
        
        $Allquota = parent::query("UPDATE rebate SET quota = :quota",["quota"=>$quota]);

        // Check if the update was successful
        if ($Allquota  > 0) {
            $data = parent::query("SELECT uid, rebate FROM users");
            foreach ($data as $user) {
             $rebateData = parent::selectAll("rebate",["odds_group", "rebate", "quota", "counts"],["rebate[<=]"  => $user['rebate']]);
             self::UpdateUserquotaData(json_encode(($rebateData)),$user['uid']);
 
            }
         
        } else {
            echo "No rows updated ";
        }
        
    }

    public static function UpdateUserquotaData($userData, $uid)
    {
        $data = ["rebate_list" => $userData,];
        $where = ["uid" => $uid];
        $upudaterebatelist = parent::update("users", $data, $where);
        if ($upudaterebatelist > 0) {
        // self::getRebateQuotaByUserId($uid);
            return "success";
        } else {
            return "No changes made to user data.";
        }
       
    }

    public static function getRebateQuotaByUserId($uid)
    {

        $rebatelist  = (new UserManageModel())->fetchUserRebateList($uid);
        //  $res = parent::selectAll("referral_link", ["register_count","rebate"], ["agent_id" =>$uid]);
         $res = parent::query("SELECT register_count, rebate FROM referral_link",["agent_id" =>$uid]);
        if ($res) {

            foreach ($rebatelist as $value) {
                foreach ($res as $data) {

                    if ($value->rebate == $data['rebate']) {
                        $TotalQuota = $value->quota;
                        $quotaUsed =  $TotalQuota;
                        $data=["quota_used" =>$quotaUsed];
                        $where  =[
                           "agent_id" => $uid,
                            "rebate" => $data['rebate'],
                        ];
                      $updatereferalLink = parent::update("referral_link",$data,$where);
                      return $updatereferalLink ;
                       
                    }
                }
            }
        }
    }

    public static function FilterRebate($rebate)
    {
        $data = parent::selectAll("rebate", "*", [ "OR" => ["rebate[~]" => $rebate, "odds_group[~]" => $rebate] ]);
        return ['data' => $data];
    }

 
    ////////////// QUOTA SETTINGS -//////////




}
