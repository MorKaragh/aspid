<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 23.07.15
 * Time: 22:11
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "../classes/UserDAO.php";

if ($_POST != null) {
    $userDao = new UserDAO();

    $uid = $_POST['uid'];
    $path = $_POST['path'];
    $userDao->setUserAvatar($_POST['uid'], $_POST['path']);

    do_return("OK",null);

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