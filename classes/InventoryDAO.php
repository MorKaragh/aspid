<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 12.06.15
 * Time: 21:19
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "CoreDAO.php";

class InventoryDAO extends CoreDAO {

    public function saveInventory(){

    }

    public function getAllItemGroups(){
        $result = parent::execQuery("select * from public.item_groups",null);
        return $result;
    }

}