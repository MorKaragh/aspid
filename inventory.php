<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 04.07.15
 * Time: 21:10
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
require_once "classes/Item.php";
require_once "classes/AspidAuth.php";
require_once "classes/UserDAO.php";
require_once "classes/InventoryDAO.php";
require_once "classes/ComboboxFactory.php";
require_once "classes/dictionary/ItemGroupDictionary.php";
require_once "classes/PrivateNavbar.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php PageHead::getNormalHead() ?>
    <script src="js/userjs.js" type="application/javascript"></script>
</head>

<body>

<?php Navbar::show('USTAV'); ?>

<div class="container" style="padding-top: 40px;">

    <div class="row">
        <?php
        $auth = new AspidAuth();
        $member = $auth->authOpenAPIMember();

        if($member !== FALSE) {
            $inventoryDAO = new InventoryDAO();
            $comboboxFactory = new ComboboxFactory();
            $itemGroupDictionary = new ItemGroupDictionary($inventoryDAO);

            $privateNavbar = new PrivateNavbar();
            $privateNavbar->showInventoryBar($auth,$comboboxFactory,$itemGroupDictionary);


            if($auth->checkRole("COMMANDER")){
                echo '
                    <div id="inventoryContainer" class="col-md-12 blackblock lowerblock inventory-main-block" style="margin-top:84px;">

                    </div>
                ';
            }

        } else {
            echo '
                <div class="col-md-12 col-centered block"><h1>Доступ сюда разрешен только членам команды!</h1>
                <br/><h3>Вы не являетесь членом команды или не вошли на сайт.</h3></div>
              ';
        }

        ?>
    </div>
</div>

<script>

    $(".dropdown-menu.rank-combobox li a").click(function(){
        var selText = $(this).text();
        $(this).parents('.btn-item-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        var selectedGroup = $(this).attr('group_id');
        var uid = $(this).parents('.btn-item-group').attr('uid');
        $(this).parents('.btn-item-group').attr('group_id',selectedGroup);
        setUserRank(uid,selectedRank);
    });

    function setUserRank(uid, rank_id){
        alert('need something?');
    }

</script>

</body>
</html>