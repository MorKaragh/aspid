<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 15.07.15
 * Time: 20:24
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
require_once "classes/InventoryDAO.php";
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
</head>


<body class="private-body private-body" style="background-image:none;  background-color:#000C00;">

<?php (new Navbar())->show('USTAV'); ?>

<div class="container-fluid blackblock lowerblock" style="padding-top: 40px; height: 100%;">



        <?php
            $auth = new AspidAuth();
            $member = $auth->authOpenAPIMember();

            if($member !== FALSE) {

                echo '
                        <br/><br/>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                 <button type="button" id="fullReportBtn" class="btn btn-labeled btn-warning" style="width:280px;">
                                    <span class="btn-label"><i class="glyphicon glyphicon-shopping-cart"></i></span><span id="captionRefresh">Выгрузить отчет по снаряжению</span>
                                 </button>
                            </div>
                        </div>
                        <div class="report-container">

                        </div>

                ';

            }else{
                echo '<div style="height: 100%" class="col-md-12 blackblock lowerblock">'.WarningsAndErrors::getNonTeamError().'</div>';
            }
        ?>


<script>

    $("#fullReportBtn").click(function(){
        $.ajax({
            url: 'phpscripts/full_inventory_report.php',
            success: function(resultOfAjaxCall) {
                $(".report-container").html(resultOfAjaxCall);
            }
        });
    });

</script>

</div>

</body>