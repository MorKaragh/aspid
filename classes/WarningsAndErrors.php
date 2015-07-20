<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 13.07.15
 * Time: 21:40
 */

class WarningsAndErrors {

    public static function getNonTeamError(){
        return '
                <div class="col-md-12 col-centered block">
                <h1 style="color:#67b168">Доступ закрыт!</h1>
                <br/>
                <h4 style="color:#999999">Вы не член команды? Если так - вам сюда нельзя.</h4>
                <h4 style="color:#999999">Если вы член команды, то вы не входили ранее, или срок действия сессии истек. Используйте кнопку "войти".</h4>
                <br/>
                <h3 style="color:#4cae4c" class="enter-button">ВОЙТИ</h3>

                </div>

                <script>
                    $(".enter-button").click(function(){
                        enterVk();
                    });
                    $( ".enter-button" ).mouseenter( function(){
                        $(this).addClass("redborder");
                    } ).mouseleave( function(){
                        $(this).removeClass("redborder");
                    } );
                </script>
              ';
    }

}