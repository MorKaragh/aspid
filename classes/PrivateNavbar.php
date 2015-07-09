<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 26.06.15
 * Time: 21:44
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once 'AspidAuth.php';
require_once "classes/ComboboxFactory.php";

class PrivateNavbar {

    public function __construct(){

    }

    public function show(AspidAuth $aspidAuth){

        echo '<div class="blackblock" style="padding: 20px;">';

        if($aspidAuth->checkRole("RENEW_ASPIDS")) {

            echo '
                <button type="button" id="refreshAspidList" class="btn btn-labeled btn-warning" style="width:180px;">
                    <span class="btn-label"><i class="glyphicon glyphicon-refresh"></i></span><span id="captionRefresh">Обновить список</span></button>

                <script>
                    $("#refreshAspidList").click(function(){
                        $(this).unbind();
                        $(this).addClass("btn-danger");
                        $("#captionRefresh").text("ПОДОЖДИТЕ");
                        renewAspidList();
                    });
                </script>
            ';

        }

        echo '</div>';

    }


    public function showInventoryBar(AspidAuth $aspidAuth, ComboboxFactory $comboboxFactory, ItemGroupDictionary $itemGroupDictionary){
        if($aspidAuth->checkRole("COMMANDER")) {

            echo '<div class="private-navbar blackblock">';

            $itemBlock = addslashes(
                '<div class="item-block">'.
                    '<input uid="" type="text" placeholder="название предмета" class="darktextinput inventory-text-input" />'.
                    '<input uid="" type="text" placeholder="ссылка" class="darktextinput inventory-text-input" />'.
                    '<textarea class="form-control darktextinput item-description" rows="3" placeholder="подробное описание"></textarea>'.
                '</div>'
            );

            echo '
                <button type="button" id="addNewInventoryItemBtn" class="btn btn-labeled btn-primary" style="width:180px;">
                    <span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span><span id="captionRefresh">Добавить предмет</span></button>

'.$comboboxFactory->getItemGroupCombobox(null,null,$itemGroupDictionary).'

                <script>
                    $("#addNewInventoryItemBtn").click(function(){
                        $("#inventoryContainer").append("'.$itemBlock.'");
                        alert($(".dropdown-toggle.aspid-items-box").text());
                    });
                </script>
            ';
        }

        echo '</div>';
    }

}