<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 07.07.15
 * Time: 22:20
 */

require_once dirname(__FILE__) . '/../UserDAO.php';
require_once dirname(__FILE__) . '/../InventoryDAO.php';

class ItemGroupDictionary {

    var $groups;

    public function __construct(InventoryDAO $inventoryDAO){
        $this->groups = $inventoryDAO->getAllItemGroups();
    }

}