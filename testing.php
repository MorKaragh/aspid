<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 16.07.15
 * Time: 15:00
 */
ini_set("display_errors", 1);
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
require_once "classes/Item.php";
require_once "classes/AspidAuth.php";
require_once "classes/UserDAO.php";
require_once "classes/ComboboxFactory.php";
require_once "classes/dictionary/GroupDictionary.php";
require_once "classes/dictionary/RankDictionary.php";
require_once "classes/PrivateNavbar.php";
require_once "classes/WarningsAndErrors.php";
require_once "classes/Personalinfo.php";

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <?php PageHead::getNormalHead() ?>
    <script src="js/userjs.js" type="application/javascript"></script>
</head>

<body>

<?php (new Navbar())->show('USTAV'); ?>

<div class="container-fluid blackblock" style="padding: 40px 0px 40px 0px; height: 100%;">

    <div class="row">

        <?php
        $auth = new AspidAuth();
        $member = $auth->authOpenAPIMember();

        if ($member !== FALSE) {


            $dao = $auth->getUsetDao();
            $avatar = $dao->getAvatarPath($member['uid']);
            $personal = new Personalinfo($dao);

            if (!empty($avatar)) {
                $avatar = '<div class="avatar-block"> <img class="avatar" src="' . $avatar . '" /> </div>';
            } else {
                $avatar = '';
            }


            echo '
                <div class="col-md-3 col-lg-2 col-sm-4 col-xs-0" style="padding-top: 40px;">'
                . $avatar . '
                <input id="lets-upload" type="button" style="margin:15px 0px 0px 15px; color:black;" value="Загрузить аватарку" class="btn btn-primary"/>

                </div>

                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" style="margin: 0 0 0 20px;">
                    <h3 style="margin-top:40px; color: #FFF0A9;">' . $member['nickname'] . '</h3>
                    <p style="color: #FFF0A9;">' . $member['name'] . '</p>
                    '.$personal->getFormForEdit($member['uid']).'
                    <input id="uid" type="hidden" value="' . $member['uid'] . '" />
                </div>

            ';

        } else {
            echo '<div style="height: 100%" class="col-md-12 blackblock lowerblock">' . WarningsAndErrors::getNonTeamError() . '</div>';
        }

        ?>

    </div>

</div>

<div id="avatar-loader" class="avatar-loader" hidden>
    <form style="margin: 20px 0px 0px 0px;" class="upava" enctype="multipart/form-data" class="upava">
        <input name="upfile" type="file" />
        <input type="hidden" name="sizeX" value="160" />
        <input type="hidden" name="sizeY" value="240" />
        <input type="hidden" name="uplpath" value="/home/m/meworyru/strikeball/msk-aspid/public_html/avatars/%s.%s" />
        <input type="button" style="margin-top:15px; color:black;" value="ЗАГРУЗИТЬ" class="btn-warning btn-upload"/>
    </form>
</div>

<script>

    $("#lets-upload").click(function(){
        $(this).after( $("#avatar-loader") );
        $("#avatar-loader").show();
    });

    $(".btn-upload").click(function(){
        var formData = new FormData($(".upava")[0]);
        $.ajax({
            url: "phpscripts/savephoto.php",  //Server script to process data
            type: "POST",
            success: function(response){
                console.log(response);
                var reply = JSON.parse(response.toString());
                if(reply.message){
                    updateAvatarInfo(reply.message);
                } else if(reply.error){
                    alert("ОШИБКА: " + reply.error);
                };

            },
            error: function(response){
                console.log(response);
            },
            // Form data
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
    });

    function updateAvatarInfo(path){
        var uid = $("#uid").val();
        console.log("uid = " + uid);
        console.log("path = " + path);
        $.ajax({
            url: "phpscripts/setuseravatar.php",
            type: "post",
            data: { "uid": uid, "path": path},
            success: function(response){
                console.log(response);
                var json = JSON.parse(response);
                if(json.message){
                    location.reload();
                }
            },
            error: function(response){
                console.log(response);
            }
        })
    };

    $("#savepersonal").click(

        function(){
            var json = JSON.stringify($("#personal-info-form").serializeArray());
            var uid = $("#uid").val();

            alert(uid + " --- " + json);

            $.ajax({
                url: "phpscripts/setpersonaldata.php",
                type: "post",
                data: { "jsn": json, "uid": uid},
                success: function(response){
                    console.log(response);
                },
                error: function(response){
                    (response);
                }
            })

        }

    );

</script>

</body>
</html>