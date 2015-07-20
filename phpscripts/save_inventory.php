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
    $data = json_decode($_POST['jsn'],true);

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
        }

    }

    if($item->name == 'DELETEIT'){
        $inventoryDao->removeItem($item);
        do_return('deleted',null);
        exit;
    }

    $itemid = $inventoryDao->saveItem($item);
    do_return($itemid,null);

}

function processItem(){

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