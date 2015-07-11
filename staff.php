<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
require_once "classes/InventoryDAO.php";
require_once "classes/StaffPresenter.php";
if(!isset($_SESSION)){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head><?php PageHead::getNormalHead() ?></head>

<body>

<?php
(new Navbar())->show('USTAV');
$presenter = new StaffPresenter();

?>


<div class="container" style="padding-top: 40px;">

    <div class="row block staff-main-block"  >
        <div class="col-md-offset-3 col-md-6 col-centered group-main-image">
            <img src="img/commandspn.jpg" class="img-responsive"/>
            <h2 class="text-center">Командный состав</h2>
            <br/>
            <?php
            $presenter->showGroup(4);
            ?>
        </div>
    </div>

    <div class="row block staff-main-block"  >
        <div class="col-md-4 col-centered group-main-image">
            <img src="img/recongroup.jpg" class="img-responsive"/>
            <h2 class="text-center">Группа разведки</h2>
            <br/>
            <?php
            $presenter->showGroup(2);
            ?>
        </div>
        <div class="col-md-4 col-centered group-main-image">
            <img src="img/maingroup.jpg" class="img-responsive"/>
            <h2 class="text-center">Основная группа</h2>
            <br/>
            <?php
            $presenter->showGroup(1);
            ?>
        </div>
        <div class="col-md-4 col-centered group-main-image">
            <img src="img/assault.jpg" class="img-responsive"/>
            <h2 class="text-center">Штурмовая группа</h2>
            <br/>
            <?php
            $presenter->showGroup(3);
            ?>
        </div>
    </div>

    <div class="row block staff-main-block"  >
        <div class="col-md-offset-2 col-md-4 col-centered group-main-image">
            <img src="img/recrutspn.jpg" class="img-responsive"/>
            <h2 class="text-center">Рекруты</h2>
            <br/>
            <?php
            $presenter->showGroup(5);
            ?>
        </div>
        <div class="col-md-4 col-centered group-main-image">
            <img src="img/zapasspn.jpg" class="img-responsive"/>
            <h2 class="text-center">Запас</h2>
            <br/>
            <?php
            $presenter->showGroup(6);
            ?>
        </div>
    </div>

</div>
</body>
</html>