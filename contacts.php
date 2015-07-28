<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
if(!isset($_SESSION)){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php PageHead::getNormalHead() ?>

        <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>

    </head>
<body>

<script type="text/javascript">
    VK.init({
        apiId: 4953382,
        onlyWidgets: true
    });
</script>

<?php (new Navbar())->show('USTAV'); ?>
<div class="container-fluid block_fullscreen" style="">
    <div class="row block" style="height: 100%">

        <div class="col-md-5 col-centered">
            <br/>
            <div class="staff-member-block">
                <h1>Командир</h1>
<!--                <p>ФИО: <strong>Владимир Удалов</strong></p>-->
                <p>Позывной: <strong>Доктор</strong></p>
                <a style="color:cadetblue;" class="btn-group" href="http://vk.com/loki_84">Вконтакте</a>
            </div>
            <div class="staff-member-block">
                <h1>Заместитель командира</h1>
                <p>Позывной: <strong>Леон</strong></p>
                <a style="color:cadetblue;" class="btn-group" href="http://vk.com/id208271533">Вконтакте</a>
            </div>
            <div class="staff-member-block">
                <h1>Веб-мастер</h1>
<!--                <p>ФИО: <strong>Сергей Степанов</strong></p>-->
                <p>Позывной: <strong>Джинн</strong></p>
                <a style="color:cadetblue;" class="btn-group" href="http://vk.com/publicvoidmain">Вконтакте</a>
            </div>
        </div>

        <div class="col-md-7" style="margin-top: 25px;">
            <div id="vk_comments" style="height:300px;"></div>
            <script type="text/javascript">
                VK.Widgets.Comments('vk_comments');
            </script>
        </div>
    </div>

</div>

</body>
</html>