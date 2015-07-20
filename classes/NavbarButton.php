<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 07.06.15
 * Time: 19:13
 */

require_once "Navbar.php";

class NavbarButton {
    var $html;
    var $caption;
    var $active;
    var $link;

    function __construct($caption){
        $this->caption = $caption;
    }


    function setLink($link){
        $this->link = $link;
    }

    function active($active){
        if($active){
            $this->active = ' active ';
        }
        $this->active = '';
    }

    function show(){
        return '<li><a href="'.$this->link.$this->active.'">'.$this->caption.'</a></li>';
    }


}