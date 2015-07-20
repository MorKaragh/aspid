<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 12.07.15
 * Time: 15:33
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "../classes/InventoryDAO.php";
require_once "../classes/AspidAuth.php";
require_once "../classes/Item.php";

if($_POST != null){
    //var_dump($_POST);
    $data = json_decode($_POST['jsn'],true);
    //var_dump("---- data ----");
    //var_dump($data);
    //var_dump("---- end data ----");


    $inventoryDao = new InventoryDAO();
    $auth = new AspidAuth();

    $item = new Item();

    foreach($data as $array){

        if($array['name'] == 'itemname'){
            $item ->name = $array['value'];

        }else if($array['name'] == 'itemlink'){
            $item ->link = $array['value'];

        }else if($array['name'] == 'itemtypeid'){
            $item ->groupId = $array['value'];

        }else if($array['name']=='itemid'){
            $item ->id = $array['value'];

        }else if($array['name']=='itemdescr'){
            $item->description=$array['value'];

        }else if($array['name']=='havingRadio'){
            $item->ihave=$array['value'];

        }else if($array['name']=='itemrespondcomment'){
            $item->respondcomment=$array['value'];
        }

    }

    $member = $auth->authOpenAPIMember();
    if($member != FALSE){
        $inventoryDao->respondToItem($item,$member['uid']);
        do_return("OK!",null);
    }

}


function do_return($msg, $err){
    echo '
        {
         "message" : "'.$msg.'",
         "error" : "'.$err.'"
        }';
    exit;
}

?>