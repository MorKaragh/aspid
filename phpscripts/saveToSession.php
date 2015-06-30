<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 18.06.15
 * Time: 20:49
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
if(!isset($_SESSION)){
    session_start();
}
$_SESSION[$_POST['param']] = $_POST['val'];
