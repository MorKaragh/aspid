<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 21.07.15
 * Time: 20:54
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
require_once "classes/ComboboxFactory.php";
require_once "classes/dictionary/GroupDictionary.php";
require_once "classes/dictionary/RankDictionary.php";
require_once "classes/PrivateNavbar.php";
require_once "classes/WarningsAndErrors.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php PageHead::getNormalHead() ?>
    <script src="js/userjs.js" type="application/javascript"></script>
</head>

<body>

<?php (new Navbar())->show('USTAV'); ?>

<div class="container-fluid blackblock" style="height: 100%;">

    <div class="row blackblock lowerblock" style="padding: 60px 0px 60px 0px;">

        <?php

        $auth = new AspidAuth();
        $member = $auth->authOpenAPIMember();

        if($member) {

            $userDao = new UserDAO();
            $users = $userDao->getAllActiveUsers();
            echo '<div class="col-lg-4 col-md-4 col-sm-8 col-xs-8 people-to-award">';
            foreach ($users as $user) {
                echo '<div class="staff-member-block candidate">
                    <button class="btn btn-primary btn-choose-award">Выбрать</button>
                    <input type="hidden" class="is-selected" value="0"/>
                    <input type="hidden" class="uid" value="' . $user['uid'] . '"/>
                    <div style="float:right; font-size: larger;">
                      ' . $user['nickname'] . '
                    </div>
                  </div>';
            }
            echo '</div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <button type="button" class="btn btn-labeled btn-danger btn-give-award" style="width:130px;">
                            <span class="btn-label"><i class="glyphicon glyphicon-star-empty"></i></span><span id="captionRefresh">Наградить</span></button>
                    </div>';
        } else {
            echo '<div style="height: 100%" class="col-md-12 blackblock lowerblock">'.WarningsAndErrors::getNonTeamError().'</div>';
        }

        ?>

    </div>
</div>

<div id="awardModal" class="modal item-block achievement-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <input type="hidden" id="modalJsn"/>
    <div class="modal-header" style="border:none;">
        <button type="button" class="close" style="color:#4cae4c; padding: 0px 5px 2px 5px; border: 2px solid #4cae4c; border-radius: 5px;" data-dismiss="modal" aria-hidden="true">x</button>
    </div>
    <div class="modal-body" style="border:none;">
        <input id="nam" type="text" placeholder="название" class="darktextinput" style="font-style: normal;"/>
    </div>
    <div class="modal-footer" style="border:none;">
        <textarea id="descr" name="itemdescr" class="form-control darktextinput" rows="3" placeholder="подробное описание" style="font-style: italic; color: #C2C2C2; font-weight: lighter;"></textarea>
        <button type="button" class="btn btn-labeled btn-danger btn-save-award" style="width:130px; margin-top: 20px;">
            <span class="btn-label"><i class="glyphicon glyphicon-star-empty"></i></span><span id="captionRefresh">Наградить</span></button>
        <p/>
    </div>
</div>

<script>
    $(".btn-choose-award").click(
        function(){
            var inpt = $(this).siblings(".is-selected");
            if($(this).hasClass("btn-warning")){
                $(this).removeClass("btn-warning");
                $(this).html("Выбрать");
                inpt.val("0");
            } else {
                $(this).addClass("btn-warning");
                $(this).html("Выбрано");
                inpt.val("1");
            }
        }
    );

    $(".btn-give-award").click(
        function(){
            var total = [];
            $(".candidate").each(
                function(){
                    if($(this).find(".is-selected").val() == 1){
                        total.push({ uid: $(this).find(".uid").val()});
                    }
                }
            );
            $("#modalJsn").val(JSON.stringify(total));
            $("#awardModal").modal('toggle');
        }
    );

    $(".btn-save-award").click(
        function(){
            var total = {
                "jsn" : $("#modalJsn").val(),
                "descr" : $("#descr").val(),
                "name" : $("#nam").val()
            };
            $.ajax({
                url: "phpscripts/giveaward.php",
                type: "post",
                data: { "jsn": JSON.stringify(total)},
                success: function(response) {
                    var reply = JSON.parse(response);
                    if(reply.message){
                        location.reload(true);
                    } else if(reply.error){
                        alert("ОШИБКА: " + reply.error);
                    };
                },
                error: function() { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
            });
        }
    );

//    $('.close').click(
//        function(){
//            $("#awardModal").toggle();
//        }
//    );

</script>

</body>
</html>