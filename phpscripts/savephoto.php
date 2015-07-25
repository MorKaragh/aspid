<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 29.06.15
 * Time: 22:00
 */

// В PHP 4.1.0 и более ранних версиях следует использовать $HTTP_POST_FILES
// вместо $_FILES.

ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(1);

header('Content-Type: text/plain; charset=utf-8');
require_once "../classes/SimpleImage.php";
require_once "../classes/UserDAO.php";

try {

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.

    $uploadpath = '/home/m/meworyru/strikeball/msk-aspid/public_html/album/%s.%s';
    $resizepath = '/home/m/meworyru/strikeball/msk-aspid/public_html/album/thumbs/%s.%s';
    $sizeX = 175;
    $sizeY = 175;

    if(isset($_POST['uplpath']) && isset($_POST['sizeX']) && isset($_POST['sizeY'])){
        $uploadpath = $resizepath = $_POST['uplpath'];
        $sizeX = $_POST['sizeX'];
        $sizeY = $_POST['sizeY'];
    }

    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        do_return(null,'Не верные параметры.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            do_return(null,'Выберите файл!');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            do_return(null,'Файл слишком большой!');
        default:
            do_return(null,'Случилось хрен пойми что...');
    }

    // You should also check filesize here.
    if ($_FILES['upfile']['size'] > 1000000) {
        do_return(null,'Слишком большой файл!');
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);

    if (false === $ext = array_search(
            $finfo->file($_FILES['upfile']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
        do_return(null,'Формат файла не известен!');
    }



    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.

    define("finalname",sha1_file($_FILES['upfile']['tmp_name']));

    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        sprintf($uploadpath,
            finalname,
            $ext
        )
    )) {
        do_return(null,'Failed to move uploaded file.');
    }


    $resizer = new SimpleImage();
/*
$resizer->load(    sprintf('/home/m/meworyru/strikeball/msk-aspid/public_html/album/%s.%s',
    finalname,
    $ext
));
$resizer->resizeToWidth(200);
$resizer->save(sprintf('/home/m/meworyru/strikeball/msk-aspid/public_html/album/thumbs/%s.%s',
    finalname,
    $ext
));
*/

    $resizer->resize_crop_image($sizeX, $sizeY,sprintf($uploadpath,
        finalname,
        $ext
    ),sprintf($resizepath,
        finalname,
        $ext
    ));


    do_return(sprintf($resizepath,
        finalname,
        $ext
    ),null);

} catch (RuntimeException $e) {

    echo $e->getMessage();

}


function do_return($msg, $err){
    echo '
        {
         "message" : "'.$msg.'",
         "error" : "'.$err.'"
        }';
    exit;
}

?>