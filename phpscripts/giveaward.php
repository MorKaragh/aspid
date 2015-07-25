<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 21.07.15
 * Time: 22:08
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "../classes/UserDAO.php";
require_once "../classes/AspidAuth.php";

if ($_POST != null) {

    $auth = new AspidAuth();
    $member = $auth->authOpenAPIMember();
    if(!$member || !$auth->checkRole("GIVE_AWARD")){
        do_return(null,"Нет доступа!");
    }

    $dao = new UserDAO();

    if(isset($_POST['jsn'])){
        $array = json_decode($_POST['jsn']);
        $uids = json_decode($array->jsn);
        $name = $array->name;
        $descr = $array->descr;

        foreach ($uids as $uid) {
            $dao->giveAchievement($name,$descr,$uid->uid,$member['uid']);
        }
        do_return("SUCCESS",null);
    }


    /*
     *
     * create table aspid_achievements
(
    id integer primary key default nextval('aspid_achievements_seq'),
    name varchar(400),
    description varchar (4000),
    uid integer references aspid_users,
    from_who integer references aspid_users,
    date_give date default current_date,
    type integer references aspid_achievement_type
);
     *
     * */

} else {
    do_return("","POST is empty!");
}


function do_return($msg, $err){
    echo '
        {
         "message" : "'.$msg.'",
         "error" : "'.$err.'"
        }';
    exit;
}