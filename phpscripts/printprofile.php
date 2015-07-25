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
            return;
        }
        echo '<div style = "float:right;" class="reward-block">';
        foreach($achi as $achievement){
            echo '<p>награды</p>
                  <div class="achievement-icon">
                        <img src="img/logo30norm.png" title="'.$achievement->name.'"/>
                        <input class="achievement-description" type="hidden" value="'.$achievement->description.'" />
                        <input class="achievement-fromwho" type="hidden" value="'.$achievement->fromWhoName.'" />
                        <input class="achievement-date" type="hidden" value="'.(new DateTime($achievement->dateGive))->format('d.m.Y').'" />
                        <input class="achievement-name" type="hidden" value="'.$achievement->name.'" />
                  </div>';
        }
        echo '</div>
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
    }


    if($member){
        $row = $dao->getUser($_POST['uid']);
        echo '
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-8 col-xs-8">
                    бла бла бла
                </div>
                <div class="col-md-2 col-lg-2 col-sm-4 col-xs-4 item-link-ahref">
                    <a href="http://vk.com/id'.$row['vkuid'].'">VK: ' . $row['username'] . '</a>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                '.buildAchievementsBlock($achies).'
            </div>
            </div>
        </div>
            ';
    }


}