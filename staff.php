<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
require_once "classes/InventoryDAO.php";
require_once "classes/StaffPresenter.php";
if(!isset($_SESSION)){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head><?php PageHead::getNormalHead() ?></head>

<body>

<?php
(new Navbar())->show('USTAV');
$presenter = new StaffPresenter();

?>


<div class="container-fluid" style="padding-top: 40px;">

    <div class="row block staff-main-block"  >
        <div class="col-md-offset-3 col-md-6 col-centered group-main-image">
            <img src="img/commandspn.jpg" class="img-responsive img-staff-group"/>
            <h2 class="text-center">Командный состав</h2>
            <br/>
            <?php
            $presenter->showGroup(4);
            ?>
        </div>
    </div>

    <div class="row block staff-main-block"  >
        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 col-centered group-main-image">
            <img src="img/recongroup.jpg" class="img-responsive img-staff-group"/>
            <h2 class="text-center">Группа разведки</h2>
            <br/>
            <?php
            $presenter->showGroup(2);
            ?>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12  col-centered group-main-image">
            <img src="img/maingroup.jpg" class="img-responsive img-staff-group"/>
            <h2 class="text-center">Основная группа</h2>
            <br/>
            <?php
            $presenter->showGroup(1);
            ?>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12  col-centered group-main-image">
            <img src="img/assault.jpg" class="img-responsive img-staff-group"/>
            <h2 class="text-center">Штурмовая группа</h2>
            <br/>
            <?php
            $presenter->showGroup(3);
            ?>
        </div>
    </div>

    <div class="row block staff-main-block"  >
        <div class="col-md-offset-2 col-md-4 col-centered group-main-image">
            <img src="img/recrutspn.jpg" class="img-responsive img-staff-group"/>
            <h2 class="text-center">Рекруты</h2>
            <br/>
            <?php
            $presenter->showGroup(5);
            ?>
        </div>
        <div class="col-md-4 col-centered group-main-image">
            <img src="img/zapasspn.jpg" class="img-responsive img-staff-group"/>
            <h2 class="text-center">Запас</h2>
            <br/>
            <?php
            $presenter->showGroup(6);
            ?>
        </div>
    </div>

    <script>
        $( document ).ready(function() {
            $("#profile").hide();
        });


        $(".btn-expand").click(function(){

            var profileBlock = $("#profile");

            var uid = $(this).parent().siblings(".uid-inpt").val();

            $.ajax({
                url: "phpscripts/printprofile.php",
                type: "post",
                async: false,
                data: { "uid": uid},
                success: function(response) {
                    profileBlock.html(response);

                },
                error: function() { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
            });

            $(".btn-expand").not($(this)).each(function(){
                $(this).find(".glyphicon").removeClass("glyphicon-menu-up");
            });

            if($(this).find(".glyphicon").hasClass("glyphicon-menu-up")){
                $(this).find(".glyphicon").removeClass("glyphicon-menu-up");
                profileBlock.slideUp( "slow", function() {
                    // Animation complete.
                });
            } else {
                $(this).find(".glyphicon").addClass("glyphicon-menu-up");
                profileBlock.hide();
                $(this).parents(".staff-member-block").first().after( profileBlock );
                profileBlock.slideDown( "slow", function() {
                    // Animation complete.
                });
            }


        });

    </script>


    <div id="profile" class="print-profile-block">

        тут будет подробная информация по бойцу. Фотография в горке и сумраке, специализация и тому подобное. Напишите Джинну что бы вы хотели тут видеть.

    </div>

    <div id="nmyModal" class="modal achievement-modal item-block " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" style="color:#4cae4c; padding: 0px 5px 2px 5px; border: 2px solid #4cae4c; border-radius: 5px;" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"/>
        </div>
        <div class="modal-body">
            <p/>
        </div>
        <div class="modal-footer">
            <p/>
        </div>
    </div>

</div>
</body>
</html>