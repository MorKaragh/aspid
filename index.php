<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
require_once "classes/InventoryDAO.php";
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
?>

<div class="container-fluid block block_fullscreen" style="height: 100%;">
    <div class="row" style="padding: 20px;">
        <div class="col-md-5 col-sm-5">
            <img src="img/logo.png" class="img-responsive"  style="padding: 20px; margin: 0 auto; height: auto; width: 360px;"/>
        </div>
        <div class="col-md-7 col-sm-7 index-presentation col-centered">
            <h1>МСК "АСПИД"</h1>
            <h3>Страйкбольная команда. Город Москва.</h3>
            <h5>Моделирование собирательного образа Спецназа РФ.</h5>
        </div>
    </div>
<!--    <div class="row block staff-main-block"  >-->
<!--        <div class="col-sm-12 col-md-8" style="height: 355px;">-->
<!--            <div class="index-main-description">-->
<!--                <br/><br/>-->
<!--                <h1>МСК "АСПИД"</h1>-->
<!--                <p>Моделирование собирательного образа спецназа РФ</p>-->
<!--                <p>образована 20 Февраля 2015г.</p>-->
<!--                <br/><br/>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

</div>
</body>
</html>