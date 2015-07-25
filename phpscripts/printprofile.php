<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 24.07.15
 * Time: 21:31
 */

require_once "../classes/UserDAO.php";
require_once "../classes/AspidAuth.php";

if(isset($_POST['uid'])){

    $auth = new AspidAuth();
    $dao = $auth->getUsetDao();
    $member = $auth->authOpenAPIMember();
    $achies = $dao->getUserAchievements($_POST['uid']);



    function buildAchievementsBlock($achi){
        if(empty($achi)){
            return '';
        }
        $result = '<div class="achievements-block">';
        foreach($achi as $achievement){
            $result = $result.'
                  <div class="achievement-icon">
                        <img src="img/logoLavr75.png" title="'.$achievement->name.'"/>
                        <input class="achievement-description" type="hidden" value="'.$achievement->description.'" />
                        <input class="achievement-fromwho" type="hidden" value="'.$achievement->fromWhoName.'" />
                        <input class="achievement-date" type="hidden" value="'.(new DateTime($achievement->dateGive))->format('d.m.Y').'" />
                        <input class="achievement-name" type="hidden" value="'.$achievement->name.'" />
                  </div>';
        }
        $result = $result. '
                    </div>
                    <script>
                            $(".achievement-icon").click(
                                function(){
                                    var tmp = $(this).find(".achievement-description").val();
                                    var modal = $("#nmyModal");
                                    modal.find(".modal-body").find("p").html(tmp);

                                    tmp = $(this).find(".achievement-name").val();
                                    $("#myModalLabel").html(tmp);

                                    tmp = "Выдал " + $(this).find(".achievement-fromwho").val() + ", " + $(this).find(".achievement-date").val()+"г.";
                                    modal.find(".modal-footer").find("p").html(tmp);

                                    modal.modal("toggle");
                            }
                    );
                    </script>
                    ';

        return $result;
    }




    if($member){
        $row = $dao->getUser($_POST['uid']);

        $avatar = $dao->getAvatarPath($_POST['uid']);

        if(!empty($avatar)){
            $avatar = '<img class="avatar" src="'.$avatar.'" />';
        } else {
            $avatar = '';
        }


        echo '
        <div class="container">

            <div class="row">

                <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 item-link-ahref">

                    <div class="profile-contacts">
                    <div>
                        <span>VK: <a href="http://vk.com/id'.$row['vkuid'].'">' . $row['username'] . '</a></span>
                    </div>
                    <div>
                        <span>Телефон: <span class="contact-info">999-999-999</span></span>
                    </div>
                    </div>

                </div>
                <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12" style="padding-right: 80px;">
                    '.$avatar.'
                </div>
            </div>
            <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                '.buildAchievementsBlock($achies).'
            </div>
            </div>
        </div>
            ';
    }


}