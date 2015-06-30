<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 07.06.15
 * Time: 18:00
 */
ini_set("display_errors",1);
error_reporting(E_ALL);

require_once "classes/NavbarButton.php";

class Navbar {


    public static function show($pageType)
    {

        $ustavButton = new NavbarButton('Устав');
        $ustavButton->setLink('ustav.php');

        $contactsButton = new NavbarButton('Контакты');
        $contactsButton->setLink('contacts.php');

        $staffButton = new NavbarButton('Состав');
        $staffButton->setLink('staff.php');

        $galleryButton = new NavbarButton('Фотогалерея');
        $galleryButton->setLink('gallery.php');

        $enterVkButton = new NavbarButton('Войти через Вконтакте');
        $enterVkButton->setLink('private.php');

        $cabinetButton = '<a href="#" onclick="enterVk();" >Войти через VK</a>';

//        if($_COOKIE['aspid_member_name']){
//            $cabinetButton = '<a href="#" onclick="enterVk();" >'.rawurldecode($_COOKIE['aspid_member_name']).'</a>';
//        }
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['aspid_member_name'])){
            $cabinetButton = '<a href="#" onclick="enterVk();" >'.$_SESSION['aspid_member_name'].' (Личный кабинет)</a>';
        }

        $bodyHtml =
        '

<nav class="navbar navbar-default navbar-fixed-top" style="">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">МСК "АСПИД"</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                                  '.$ustavButton->show().'
                                  '.$staffButton->show().'
                                  '.$contactsButton->show().'
                                  '.$galleryButton->show().'

                    </ul>
                    <ul class="nav navbar-nav navbar-right" >
                            <li id="authBtn">'.$cabinetButton.'</li>
                    </ul>
                </div>
            </div>
        </nav>
        ';

        echo($bodyHtml);

    }

    public function utf8_urldecode($str) {
        return html_entity_decode(preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($str)), null, 'UTF-8');
    }

}

?>
