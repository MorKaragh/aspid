<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 16.07.15
 * Time: 11:28
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once "../classes/Navbar.php";
require_once "../classes/PageHead.php";
require_once "../classes/Item.php";
require_once "../classes/AspidAuth.php";
require_once "../classes/UserDAO.php";
require_once "../classes/InventoryDAO.php";
require_once "../classes/ComboboxFactory.php";
require_once "../classes/dictionary/GroupDictionary.php";
require_once "../classes/dictionary/RankDictionary.php";
require_once "../classes/PrivateNavbar.php";
require_once "../classes/WarningsAndErrors.php";

$inventoryDao = new InventoryDAO();
$userDao = new UserDAO();

$allItems = $inventoryDao->getAllItems();
$allUsers = $userDao->getAllActiveUsersOrderByAlphabet();

printTableOfItemType($allItems, 1, $allUsers, $inventoryDao);
echo '<h2 style="color:#2b542c;">основное снаряжение</h2>';

printTableOfItemType($allItems, 2, $allUsers, $inventoryDao);
echo '<h2 style="color:#2b542c;">второстепенное снаряжение</h2>';

printTableOfItemType($allItems, 3, $allUsers, $inventoryDao);
echo '<h2 style="color:#2b542c;">рекомендуемое снаряжение</h2>';

/**
 * @param $allItems
 * @param $itemImportanceId
 * @param $allUsers
 * @param $inventoryDao
 */
function printTableOfItemType($allItems, $itemImportanceId, $allUsers, $inventoryDao)
{
    echo '
<div class="row blackblock">
<div class="col-md-10">
    <table class="table">
        <thead>
            <tr>
            <th style="border-bottom: 4px solid #2b542c; color: #f0ad4e; border: 1px solid #2b542c;">Позывной</th>';
    /*
    foreach($allUsers as $user){
        echo '<th class="">'.$user['nickname'].'</th>';
    }
    */
    $mainItems = extractItemsByGroupId($allItems, $itemImportanceId);
    foreach ($mainItems as $item) {
        echo '<th style="border-bottom: 4px solid #2b542c; color: #f0ad4e; border: 1px solid #2b542c;">' . $item->name . '</th>';
    }
    echo '
        </tr>
    </thead>';

    echo '<tbody>';

    foreach ($allUsers as $user) {

        echo '<tr><td style="color:#c0a16b; border: 1px solid #2b542c;">' . $user['nickname'] . '</td>';

        $userInventory = $inventoryDao->getUserInventoryRecord($user['uid']);
        foreach ($mainItems as $item) {
            foreach ($userInventory as $inventoryRow) {
                if ($item->id == $inventoryRow['id']) {
                    echo '<td style="border: 1px solid #2b542c;">' . getUserItemStatus($inventoryRow['have_status']) . '</td>';
                }
            }
        }

        echo '</tr>';

    }

    echo '
    </tbody>
</div>
</div>
';
}

function getUserItemStatus($haveStatus){
    switch($haveStatus){
        case 1:
            return '<img src="img/icons/accept.png"/><span style="color:#8a6d3b">Есть</span>';
        case 2:
            return '<img src="img/icons/time.png"/><span style="color:#8a6d3b">Купит</span>';
        case 3:
            return '<img src="img/icons/decline.png"/><span style="color:#8a6d3b">Не нужно</span>';
        default:
            return '';//'<img src="img/icons/question2.png"/>';
    }
}

function extractItemsByGroupId($items,$groupId){
    $result = [];
    foreach($items as $item){
        if($item->groupId == $groupId){
            array_push($result,$item);
        }
    }
    return $result;
}

?>