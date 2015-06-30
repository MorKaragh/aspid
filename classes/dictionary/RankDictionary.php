<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 24.06.15
 * Time: 21:07
 */
require_once dirname(__FILE__) . '/../UserDAO.php';

class RankDictionary {

    var $ranks;

    public function __construct(UserDAO $usrDao){
        $this->ranks = $usrDao->getAllRanks();
    }

    public function getNameById($id){
        $ranks = $this->ranks;
        foreach ($ranks as $rank){
            if($rank['id'] == $id){
                return $rank['rank_name'];
            }
        }
        return null;
    }

    public function getNonCommanderRanks(){
        $result = array();
        $ranks = $this->ranks;
        foreach($ranks as $rank){
            if($rank['hier_level'] > 1){
                array_push($result,$rank);
            }
        }
        return $result;
    }

}