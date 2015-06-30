<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 15.06.15
 * Time: 20:42
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "CoreDAO.php";

class UserDAO extends CoreDAO {

    public function insertNewUser($vkuid, $name){
        $query = "INSERT INTO public.aspid_users(vkuid,username) VALUES($1,$2)";
        parent::execStatement($query,array($vkuid,$name));
    }


    public function getAllActiveUsers(){
        $result = parent::execQuery("select * from public.aspid_users where is_active != 6 or is_active is null order by coalesce(is_active,0), rank_id, uid",null);
        return $result;
    }

    public function setUserGroup($uid, $group_id){
        $query = "update public.aspid_users set group_id = $1, is_active = 1 where uid = $2";
        parent::execStatement($query,array($group_id,$uid));
    }

    public function getAllGroups(){
        $result = parent::execQuery("select * from public.aspid_groups",null);
        return $result;
    }

    public function getAllRanks(){
        $result = parent::execQuery("select * from public.aspid_ranks",null);
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

    public function setUserRank($uid, $rankId){
        $query = "update public.aspid_users set rank_id = $1 where uid = $2";
        parent::execStatement($query,array($rankId,$uid));
    }

    public function renewAspid($vkuid, $name){
        $result = parent::execQuery("SELECT count(1) FROM aspid_users WHERE vkuid = ?",array($vkuid));
        if($result[0][0] == 1){
            parent::execUpdate("UPDATE aspid_users SET username = ? WHERE vkuid = ?", array($name,$vkuid));
        } else if($result[0][0] == 0){
            parent::execInsert("INSERT INTO public.aspid_users(vkuid,username) VALUES(?,?)",array($vkuid,$name));
        };
    }

    public function setUserStatusByVkuid($vkuid,$status){
        parent::execUpdate("UPDATE aspid_users SET is_active = ? WHERE vkuid = ?",array($status,$vkuid));
    }

}