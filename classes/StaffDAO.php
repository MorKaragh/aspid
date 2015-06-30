<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 22.06.15
 * Time: 22:27
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "CoreDAO.php";

class StaffDAO extends CoreDAO {

    public function insertNewUser($vkuid, $name){
        $query = "INSERT INTO public.aspid_users(vkuid,username) VALUES($1,$2)";
        parent::execStatement($query,array($vkuid,$name));
    }


    public function getAllUsers(){
        $result = parent::execQuery("select * from public.aspid_users order by uid",null);
        return $result;
    }

    public function setUserGroup($uid, $group_id){
        $query = "update public.aspid_users set group_id = $1 where uid = $2";
        parent::execStatement($query,array($group_id,$uid));
    }

    public function getAllGroups(){
        $result = parent::execQuery("select * from public.aspid_groups",null);
        return $result;
    }

    public function userHasRole($uid,$role_id){
        $query = "select count(1) flag from public.aspid_user_roles where uid = ? and role_id = ? ";
        $set = parent::execQuery($query,array($uid,$role_id));
        if($set[0]['flag'] == 1){
            return true;
        }
        return false;
    }

    public function getUserByVkId($vkId){
        $result =  parent::execQuery("select * from public.aspid_users where vkuid = ?",array($vkId));
        return $result[0];
    }

    public function getGroupNameByid($groupId){
        $result =  parent::execQuery("select group_name from public.aspid_groups where id = ?",array($groupId));
        return $result[0]['group_name'];
    }

    public function setUserNickname($uid, $nickname){
        $query = "update public.aspid_users set nickname = $1 where uid = $2";
        parent::execStatement($query,array($nickname,$uid));
    }

    public function getGroupMembersOrdered($id){
        $query = "select * from aspid_users s, aspid_ranks a where a.id = s.rank_id and group_id = ? and s.nickname is not null and s.nickname <> '' and s.is_active = 1 order by a.hier_level, s.uid";
        return parent::execQuery($query,array($id));
    }


}