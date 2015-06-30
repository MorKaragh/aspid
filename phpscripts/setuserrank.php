<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 20.06.15
 * Time: 19:50
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "../classes/UserDAO.php";

if ($_POST != null) {
    $userDao = new UserDAO();

    $group = $_POST['rank_id'];
    if($group == 0){
        $group = PDO::PARAM_NULL;
    }
    $userDao->setUserRank($_POST['uid'], $_POST['rank_id']);
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