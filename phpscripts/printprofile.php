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
            $avatar = '
<div class="col-md-5 col-lg-5 col-sm-3 col-xs-0">
    <div class="avatar-block">
        <img class="avatar img-responsive" style="float:left;" src="'.$avatar.'" />
    </div>
</div>';
        } else {
            $avatar = '';
        }

        $personal = $dao->getPersonalInfo($_POST['uid']);

        echo '
        <!--<div class="container">-->

            <div class="row">

                    '.$avatar.'

                <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
                    <div class="profile-contacts item-link-ahref" style="padding: 10px;">
                    <div>
                        <span><a style="margin-left: 0;" href="http://vk.com/id'.$row['vkuid'].'">' .'VK: '. $row['username'] . '</a></span>
                    </div>

                    ';

                foreach($personal as $p){
                    echo'
                    <div>
                        <span>'.$p['name'].': <span class="contact-info">'.($p['val'] != '' ? $p['val'] : 'не указано').'</span></span>
                    </div>'
                    ;
                }



        echo '
                    </div>
                    '.buildAchievementsBlock($achies).'
                </div>



            </div>

        <!--</div>-->
            ';
    }


}