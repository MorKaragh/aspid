<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 16.07.15
 * Time: 15:00
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

<div class="container-fluid blackblock lowerblock" style="padding-top: 40px; height: 100%;">

    <div class="row">

        <?php
        $auth = new AspidAuth();
        $member = $auth->authOpenAPIMember();

        if($member !== FALSE) {

            $dao = $auth->getUsetDao();
            $avatar = $dao->getAvatarPath($member['uid']);

            if(!empty($avatar)){
                $avatar = '<img class="avatar" src="'.$avatar.'" />';
            } else {
                $avatar = '';
            }

            /**


            <form style="margin: 20px 0px 0px 0px;" class="uploader-file upava" enctype="multipart/form-data" class="upava">
            <input name="upfile" type="file" />
            <input type="hidden" name="sizeX" value="70" />
            <input type="hidden" name="sizeY" value="70" />
            <input type="hidden" name="uplpath" value="/home/m/meworyru/strikeball/msk-aspid/public_html/avatars/%s.%s" />
            <input type="button" style="margin-top:15px; color:black;" value="ЗАГРУЗИТЬ" class="btn-warning btn-upload"/>
            </form>


             */

            echo '
                <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12" style="padding-top: 40px;">

                <div class="staff-member-block" style="height:300px;">
                    <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">'
                        .$avatar.'
                        <h3>'.$member['nickname'].'</h3>
                        <p>'.$member['name'].'</p>
                    </div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
                        <h5>загрузка аватары</h5>

                        не сейчас!
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                    </div>
                    </div>
                </div>
                <input id="uid" type="hidden" value="'.$member['uid'].'" />

                <script>
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
                                    alert("OK!");
                                }
                            },
                            error: function(response){
                                console.log(response);
                            }
                         })
                    };


                </script>
                </div>
            ';

        } else {
            echo '<div style="height: 100%" class="col-md-12 blackblock lowerblock">'.WarningsAndErrors::getNonTeamError().'</div>';
        }

        ?>

    </div>

</div>


</body>
</html>