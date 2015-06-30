<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 20.06.15
 * Time: 22:10
 */

require_once dirname(__FILE__) . '/../UserDAO.php';

class GroupDictionary {

    var $groups;

    public function __construct(UserDAO $usrDao){
        $this->groups = $usrDao->getAllGroups();
    }

    public function getNameById($id){
        foreach($this->groups as $group){
            if($group['id'] == $id){
                return $group['group_name'];
            }
        }
    }

    public function getGroups(){
        return $this->groups;
    }

}