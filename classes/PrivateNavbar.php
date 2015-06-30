<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 26.06.15
 * Time: 21:44
 */

class PrivateNavbar {

    public function __construct(){

    }

    public function show(){

        echo '

        <div class="private-navbar blackblock" style="padding: 20px;">
            <button type="button" id="refreshAspidList" class="btn btn-labeled btn-warning" style="width:180px;">
                <span class="btn-label"><i class="glyphicon glyphicon-refresh"></i></span><span id="captionRefresh">Обновить список</span></button>
            </div>
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

}