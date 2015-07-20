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

            echo '

                <div class="col-md-12">
                    
                </div>

                <div>

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