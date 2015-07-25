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
require_once "Achievement.php";


class UserDAO extends CoreDAO {

    public function insertNewUser($vkuid, $name){
        $query = "INSERT INTO public.aspid_users(vkuid,username) VALUES($1,$2)";
        parent::execStatement($query,array($vkuid,$name));
    }


    public function getAllActiveUsers(){
        $result = parent::execQuery("select * from public.aspid_users where is_active != 6 or is_active is null order by coalesce(is_active,0), rank_id, uid",null);
        return $result;
    }

    public function getUser($uid){
        $result = parent::execQuery("select * from public.aspid_users where uid = ?",array($uid));
        return $result[0];
    }

    public function getAllActiveUsersOrderByAlphabet(){
        $result = parent::execQuery("select * from public.aspid_users where is_active != 6 or is_active is null order by nickname",null);
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
        if(!isset($result[0])){
            return null;
        }
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

    public function getAllUsers(){
        $result = parent::execQuery("select * from public.aspid_users order by uid",null);
        return $result;
    }

    public function getGroupMembersOrdered($id){
        $query = "select * from aspid_users s, aspid_ranks a where a.id = s.rank_id and group_id = ? and s.nickname is not null and s.nickname <> '' and s.is_active = 1 order by a.hier_level, s.uid";
        return parent::execQuery($query,array($id));
    }

    public function getUserAchievements($uid)
    {
        $result = [];
        $query = "select aa.*,(select nickname from aspid_users s where s.uid = aa.from_who) from_who_name, (select nickname from aspid_users s where s.uid = aa.uid) to_who_name from aspid_achievements aa where  aa.uid = ?";
        $set = parent::execQuery($query,array($uid));
        foreach($set as $row){
            array_push($result, new Achievement($row));
        }
        return $result;
    }

    public function giveAchievement($name, $description, $uid, $fromWho){
        $query = "insert into public.aspid_achievements(name, description, uid, from_who, type) values (?,?,?,?,2)";
        parent::execUpdate($query,array($name, $description, $uid, $fromWho));
    }

    public function setUserAvatar($uid,$path){
        $query = "select * from public.user_avatar where uid = ?";
        $set = parent::execQuery($query,array($uid));
        if(!empty($set)){
            $query = "update public.user_avatar set path = ? where uid = ?";
            parent::execUpdate($query,array($path,$uid));
        } else {
            $query = "insert into public.user_avatar(uid,path) values (?,?)";
            parent::execInsert($query,array($uid,$path));
        }
    }

    public function getAvatarPath($uid){
        $query = "select path from public.user_avatar where uid = ?";
        $set = parent::execQuery($query,array($uid));
        if(!empty($set)){
            return str_replace("/home/m/meworyru/strikeball/msk-aspid/public_html/","",$set[0]['path']);
        }
        return null;
    }

}