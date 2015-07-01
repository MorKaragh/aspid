<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 26.06.15
 * Time: 21:44
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once 'AspidAuth.php';

class PrivateNavbar {

    public function __construct(){

    }

    public function show(AspidAuth $aspidAuth){

        echo '<div class="private-navbar blackblock" style="padding: 20px;">';

        if($aspidAuth->checkRole("RENEW_ASPIDS")) {

            echo '
                <button type="button" id="refreshAspidList" class="btn btn-labeled btn-warning" style="width:180px;">
                    <span class="btn-label"><i class="glyphicon glyphicon-refresh"></i></span><span id="captionRefresh">Обновить список</span></button>

                <script>
                    $("#refreshAspidList").click(function(){
                        $(this).unbind();
                        $(this).addClass("btn-danger");
                        $("#captionRefresh").text("ПОДОЖДИТЕ");
                        renewAspidList();
                    });
                </script>
            ';

        }

        echo '</div>';

    }

}