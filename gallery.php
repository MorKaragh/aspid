<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 29.06.15
 * Time: 21:03
 */

ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(1);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
require_once "classes/AspidAuth.php";
require_once "classes/UserDAO.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php PageHead::getNonAspidHead(); ?>

    <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link rel="stylesheet" href="css/bootstrap-image-gallery.min.css"></head>

<body style="background-color:rgba(0,13,0,0.99);">

<?php (new Navbar())->show('USTAV'); ?>
<br/><br/>
<br/><br/>



<div class="container block" style="width: 100%;">

    <?php
    $auth = new AspidAuth();
    if($auth->checkRole("PHOTO_UPLOAD")){
        echo'
            <row >
                <form target="receiver" style="background-color:#67b168; padding: 10px; width: 400px; border-radius: 5px; margin-bottom: 20px;"
                enctype="multipart/form-data" action="phpscripts/savephoto.php" method="POST" target="_self">
                    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <!-- Название элемента input определяет имя в массиве $_FILES -->
                    Загрузить фотографию: <input name="upfile" type="file" />
                    <input type="submit" class="btn-group" value="Отправить" />
                </form>
                <iframe hidden="true" name="receiver" id="receiver"></iframe>

            </row>
    ';
    }
    ?>

    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery block" data-use-bootstrap-modal="false">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    $arr = scandir("/home/m/meworyru/strikeball/msk-aspid/public_html/album/");
    foreach($arr as $file){
        if($file != 'thumbs' && $file != '.' && $file != '..'){
            echo '
                <a href="album/'.$file.'" title="" data-gallery>
                    <img  style="margin-bottom:4px;" src="album/thumbs/'.$file.' " alt="Orange">
                </a>
            ';
        }
    }
    ?>

</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.min.js"></script>

</body>
</html>
