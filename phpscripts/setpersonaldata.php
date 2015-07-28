<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 25.07.15
 * Time: 20:42
 */
require_once "../classes/UserDAO.php";

if(!empty($_POST)){


    $dao = new UserDAO();
    $data = json_decode($_POST['jsn']);
    $uid = $_POST['uid'];

    //aspid_personal_info(type_id integer references personal_info_type, uid integer references aspid_users, val varchar(4000));

    $dao->execUpdate("DELETE FROM public.aspid_personal_info WHERE uid = ?",array($uid));
    foreach($data as $i){
        $dao->execInsert("INSERT INTO public.aspid_personal_info(type_id,uid,val) values (?,?,?)",array($i->name,$uid,$i->value));
    }

    do_return("OK",null);

} else {
    do_return(null,"post is empty!");
}


function do_return($msg, $err){
    echo '
        {
         "message" : "'.$msg.'",
         "error" : "'.$err.'"
        }';
    exit;
}