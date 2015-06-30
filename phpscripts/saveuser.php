<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 15.06.15
 * Time: 20:41
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "../classes/UserDAO.php";
require_once "../classes/AspidAuth.php";

if ($_POST != null) {

    $auth = new AspidAuth();
    if(!$auth->checkRole("RENEW_LIST")){
        do_return(null,"Нет доступа!");
    }

    $userDao = new UserDAO();

    if(isset($_POST['jsn'])){
        $membersInBase = $userDao->getAllActiveUsers();
        foreach($membersInBase as $member){
            if(!in_array($member['vkuid'],json_decode($_POST['jsn']))){
                $userDao->debugLog($member['vkuid']);
                $userDao->setUserStatusByVkuid($member['vkuid'],6);
            }
        }
        do_return("Non-members deactivated","");
    }

    $userDao->renewAspid($_POST['vkuid'],$_POST['vkname']);
    do_return("Aspid renewed","");

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