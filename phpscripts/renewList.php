<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 27.06.15
 * Time: 23:03
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
    $userDao->renewAspid($_POST['vkuid'],$_POST['name']);
    do_return("SUCCESS","");
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