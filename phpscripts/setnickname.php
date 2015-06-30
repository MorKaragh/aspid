<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 21.06.15
 * Time: 22:50
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "../classes/UserDAO.php";

if ($_POST != null) {
    $userDao = new UserDAO();

    $group = $_POST['nickname'];
    $userDao->setUserNickname($_POST['uid'], $_POST['nickname']);
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