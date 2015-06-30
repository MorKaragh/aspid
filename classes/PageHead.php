<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 11.06.15
 * Time: 8:20
 */

class PageHead {

    public static function getNormalHead(){
        echo '
            <meta charset="utf-8">

            <meta http-equiv="X-UA-Compatible" content="IE=edge">

            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>МСК-АСПИД</title>

            <link href="css/bootstrap.min.css" rel="stylesheet">

            <link href="css/bootstrap-combined.min.css" rel="stylesheet">

            <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">

            <link href="css/aspid.css" rel="stylesheet">

            <script src="//vk.com/js/api/openapi.js" type="application/javascript"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

            <script src="js/bootstrap.min.js"></script>

            <script src="//vk.com/js/api/openapi.js" type="application/javascript"></script>

            <script src="js/aspid.js" type="application/javascript"></script>
        ';
    }

}