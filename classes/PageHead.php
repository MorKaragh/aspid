<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 11.06.15
 * Time: 8:20
 */

class PageHead {

    public static function getNormalHead(){
        PageHead::getNonAspidHead();
        echo '<link href="css/aspid.css" rel="stylesheet">';
    }


    public static function getNonAspidHead(){
        echo '
            <meta charset="utf-8">

            <meta http-equiv="X-UA-Compatible" content="IE=edge">

            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>МСК-АСПИД</title>

            <link href="css/bootstrap.min.css" rel="stylesheet">

            <script src="//vk.com/js/api/openapi.js" type="application/javascript"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

            <script src="js/bootstrap.min.js"></script>

            <script src="//vk.com/js/api/openapi.js" type="application/javascript"></script>

            <script src="js/aspid.js" type="application/javascript"></script>

            <link rel="icon" type="image/png" href="/favicon.png" />
        ';
    }


}