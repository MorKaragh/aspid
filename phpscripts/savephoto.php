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
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Не верные параметры.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('Выберите файл!');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Файл слишком большой!');
        default:
            throw new RuntimeException('Случилось хрен пойми что...');
    }

    // You should also check filesize here.
    if ($_FILES['upfile']['size'] > 1000000) {
        throw new RuntimeException('Слишком большой файл! '.$_FILES['upfile']['size']);
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
        throw new RuntimeException('Invalid file format.');
    }



    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.

    define("finalname",sha1_file($_FILES['upfile']['tmp_name']));

    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        sprintf('/home/m/meworyru/strikeball/msk-aspid/public_html/album/%s.%s',
            finalname,
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    $resizer = new SimpleImage();
    $resizer->load(    sprintf('/home/m/meworyru/strikeball/msk-aspid/public_html/album/%s.%s',
        finalname,
        $ext
    ));
    $resizer->resizeToHeight(200);
    $resizer->save(sprintf('/home/m/meworyru/strikeball/msk-aspid/public_html/album/thumbs/%s.%s',
        finalname,
        $ext
    ));

    echo 'File is uploaded successfully.';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}

?>