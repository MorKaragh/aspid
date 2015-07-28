<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 04.07.15
 * Time: 21:10
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
require_once "classes/InventoryDAO.php";
require_once "classes/ComboboxFactory.php";
require_once "classes/dictionary/ItemGroupDictionary.php";
require_once "classes/PrivateNavbar.php";
require_once "classes/WarningsAndErrors.php";

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <?php PageHead::getNormalHead() ?>
    <script src="js/userjs.js" type="application/javascript"></script>
</head>

<body style="background-image: none; background-color: #000C00;">

<?php (new Navbar())->show('USTAV'); ?>

<div class="container-fluid blackblock lowerblock" style="padding-top: 40px; height: 100%;">

    <div class="row">
        <?php
        $auth = new AspidAuth();
        $member = $auth->authOpenAPIMember();

        if($member !== FALSE) {
            $inventoryDAO = new InventoryDAO();
            $comboboxFactory = new ComboboxFactory();
            $itemGroupDictionary = new ItemGroupDictionary($inventoryDAO);
            //&& (!isset($_GET) || !isset($_GET['noncom']))
            if($auth->checkRole("COMMANDER") == 1 && !isset($_GET['noncom'])) {
                showInventoryBar($auth, $comboboxFactory, $itemGroupDictionary);
            }


            if($auth->checkRole("COMMANDER") == 1 && !isset($_GET['noncom'])){
                echo '<form id="inve">
                        <div id="inventoryContainer" class="col-md-12 inventory-main-block blackblock lowerblock" style="padding-bottom:40px; margin-top:84px;">
                            ';

                        $allItems = $inventoryDAO->getAllItems();


                        foreach($allItems as $i){
                            echo getItemBlock($i);
                        }

                echo '
                        <script>
                            prepareListeners(false);
                        </script>
                        </div>
                        </form>


                ';
            } else {
                $allMyItems = $inventoryDAO->getAllItemsByUid($member['uid']);
                echo '
                        <div id="inventoryContainer" class="col-md-12 inventory-main-block blackblock" style="padding-top:34px;">
                            ';
                        foreach($allMyItems as $i){
                            echo getClientItemBlock($i);
                        }


                $listeners = '
                <script>
                    $(".itemrespondcomment").blur(function(){
                        var form = $(this).parents("form").first();
                        respondItem(form);
                    });

                    $("input:radio.itemHaveRadio").change(
                        function(){
                            var form = $(this).parents("form").first();
                            respondItem(form);
                        }
                    );

                    function respondItem(form){
                        console.log("--- logging form ---");
                            console.log(form);
                            console.log("=== saveItemToBase ===");
                            var json = form.serializeArray();
                            console.log(JSON.stringify(json));
                            $.ajax({
                                url: "phpscripts/respond_inventory.php",
                                type: "post",
                                data: { "jsn": JSON.stringify(json)},
                                success: function(response) {
                                    console.log(">>> RESPONSE <<<")
                                    console.log(response);
                                    console.log("<<< RESPONSE >>>")
                                },
                                error: function() { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
                            });
                    }


                </script>
            ';

                echo $listeners.'</div>
                    ';

            }

        } else {
              echo '<div style="height: 100%" class="col-md-12 blackblock lowerblock">'.WarningsAndErrors::getNonTeamError().'</div>';

        }






        function showInventoryBar(AspidAuth $aspidAuth, ComboboxFactory $comboboxFactory, ItemGroupDictionary $itemGroupDictionary){
            if($aspidAuth->checkRole("COMMANDER")) {

                echo '<div class="row private-navbar blackblock" style="z-index: 10; border-bottom: 1px dotted #1a4413;">';

                $itemBlock = getItemBlock(new Item());

                echo '
                <button type="button" id="addNewInventoryItemBtn" class="btn btn-labeled btn-primary" style="width:180px;">
                    <span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span><span>Добавить предмет</span></button>

                <button type="button" id="switchToNonCom" class="btn btn-labeled btn-danger" style="width:300px;">
                    <span class="btn-label"><i class="glyphicon glyphicon-star"></i></span><span>Выключить командирский режим</span></button>

                    <!--'.$comboboxFactory->getItemGroupCombobox(null,null,$itemGroupDictionary).'-->
                <script>
                    $("#addNewInventoryItemBtn").click(function(){
                        $("#inventoryContainer").append("'.$itemBlock.'");
                        //var typeId = $(".dropdown-menu.rank-combobox li a").parents(".btn-item-group").attr("group_id");
                        setClassForBlock(1);
                        prepareListeners(true);
                    });

                    $("#switchToNonCom").click(function(){
                        window.location.href = "http://www.msk-aspid.ru/inventory.php?noncom";
                    });

                    function setClassForBlock(groupId){
                        if(groupId == 1){
                            $(".item-block").last().addClass("item-block-essential");
                            $(".item-block").last().find(".itemTypeLabel").text("Обязательное снаряжение");
                        } else if(groupId == 2){
                            $(".item-block").last().addClass("item-block-needed");
                            $(".item-block").last().find(".itemTypeLabel").text("Второстепенное снаряжение");
                        } else if(groupId == 3){
                            $(".item-block").last().find(".itemTypeLabel").text("Рекомендуемое снаряжение");
                        }
                        $(".item-block").last().find(".i-type").val(groupId);
                    }


                    function prepareListeners(forLastOnly){

                        var tmp;
                        if(forLastOnly){
                            tmp = $(".del-item-button").last();
                        } else {
                            tmp = $(".del-item-button");
                        }

                        tmp.click(
                            function(){
                                var form = $(this).closest("form");
                                if(form.find(".i-id").val() != ""){
                                    if(!confirm("Точно удалить?")){
                                        return;
                                    }
                                    form.find(".i-name").val("DELETEIT");
                                };
                                var form = $(this).closest("form");
                                saveItemToBase(form);
                                $(this).closest(".item-row").remove();
                            }
                        );

                        if(forLastOnly){
                            tmp = $(".save-item-button").last();
                        } else {
                            tmp = $(".save-item-button");
                        }
                        tmp.click(
                            function(){
                                var form = $(this).parents("form").first();
                                if(form.find(".i-name").val()){
                                    saveItemToBase(form);
                                } else {
                                    form.find(".i-name").focus();
                                }
                            }
                        )

                        if(forLastOnly){
                            tmp = $("input:radio.itemGroupRadio").slice(-3);
                        } else {
                            tmp = $("input:radio.itemGroupRadio");
                        }

                        tmp.change(
                            function(){
                                var value = $(this).val();
                                var itemBlock = $(this).parents(".item-block").first();
                                itemBlock.removeClass("item-block-essential");
                                itemBlock.removeClass("item-block-needed");
                                if(value == 1){
                                    itemBlock.addClass("item-block-essential");
                                    itemBlock.find(".itemTypeLabel").text("Обязательное снаряжение");
                                } else if(value == 2){
                                    itemBlock.addClass("item-block-needed");
                                    itemBlock.find(".itemTypeLabel").text("Второстепенное снаряжение");
                                } else if(value == 3){
                                    itemBlock.find(".itemTypeLabel").text("Рекомендуемое снаряжение");
                                }
                                itemBlock.find(".i-type").val(value);
                                if(itemBlock.find(".i-id").val()){
                                    var form = $(this).parents("form").first();
                                    saveItemToBase(form);
                                }
                            }
                        );
                    }

                    function saveItemToBase(form){
                        console.log("--- logging form ---");
                        console.log(form);
                        console.log("=== saveItemToBase ===");
                        var json = form.serializeArray();
                        console.log(JSON.stringify(json));
                        $.ajax({
                            url: "phpscripts/save_inventory.php",
                            type: "post",
                            data: { "jsn": JSON.stringify(json)},
                            success: function(response) {
                                console.log(">>> RESPONSE <<<")
                                console.log(response);
                                console.log("<<< RESPONSE >>>")
                                var reply = JSON.parse(response);
                                form.find(".i-id").val(reply.message);

                            },
                            error: function() { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
                        });
                    }

                </script>
            ';
            }
            echo '</div>';
        }


        function getItemBlock(Item $item){

            $radio = str_replace(array("\r\n", "\r", "\n"), ' ','
                <div class="row" style="padding-left: 20px; padding-top: 10px;">
                    <div>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary btn-radio-inventory '.($item->groupId==1||!isset($item->groupId)?'active':'').'">
                                <input type="radio" class="itemGroupRadio" id="groupRadio1" name="groupRadio " value="1" /> Обязательное
                            </label>
                            <label class="btn btn-primary btn-radio-inventory '.($item->groupId==2?'active':'').'">
                                <input type="radio" class="itemGroupRadio" id="groupRadio2" name="groupRadio" value="2" /> Второстепенное
                            </label>
                            <label class="btn btn-primary btn-radio-inventory '.($item->groupId==3?'active':'').'">
                                <input type="radio" class="itemGroupRadio" id="groupRadio3" name="groupRadio" value="3" /> Рекомендуемое
                            </label>
                        </div>
                        <!--<button style="margin-left: 40px;" type="button" class="del-item-button btn btn-danger btn-circle"><i class="glyphicon glyphicon-remove"></i></button>-->
                    </div>
                </div>
            ');

            $result =
                '<div class="item-row">'.
                    '<form class="itemCreateForm">'.
                        '<div class="item-block '.addStyleToBlock($item->groupId).'" style="display:inline-block;">'.
                            $radio.
                            //'<div class="itemTypeLabel">'.addGroupIdLabelByGroup($item->groupId).'</div>'.
                            '<input name="itemname" type="text" placeholder="название предмета" class="darktextinput inventory-text-input i-name needed" '.addValueToInput($item->name).' />'.
                            '<input name="itemlink" type="text" placeholder="ссылка" class="darktextinput inventory-text-input i-link" '.addValueToInput($item->link).' />'.
                            '<input name="itemtypeid" type="hidden" placeholder="тип" class="i-type" '.addValueToInput($item->groupId).' />'.
                            '<input name="itemid" type="hidden" placeholder="идентифиактор" class="i-id" '.addValueToInput($item->id).' />'.
                            '<textarea name="itemdescr" class="form-control darktextinput item-description needed" rows="3" placeholder="подробное описание">'.$item->description.'</textarea>'.
                            '<button style="margin-right:10px; float:right;" type="button" class="save-item-button btn btn-primary"><i style="margin-right:4px;" class="glyphicon glyphicon-save"></i>сохранить</button>'.
                '</div>'.
                    '</form>'.
                '</div>'
            ;

            if(!isset($item->id)){
                return addslashes($result);
            }
            return $result;
        }

        function getClientItemBlock(Item $item){

            $radio = str_replace(array("\r\n", "\r", "\n"), ' ','
                <div class="row" style="padding-left: 10px;">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary btn-radio-inventory '.(isset($item->ihave)&&$item->ihave==1?'active':'').'">
                                <input type="radio" class="itemHaveRadio" id="havingRadio1" name="havingRadio" value="1" /> Уже имею
                            </label>
                            <label class="btn btn-primary btn-radio-inventory '.(isset($item->ihave)&&$item->ihave==2?'active':'').'">
                                <input type="radio" class="itemHaveRadio" id="havingRadio2" name="havingRadio" value="2" /> Вскоре куплю
                            </label>
                            <label class="btn btn-primary btn-radio-inventory '.(isset($item->ihave)&&$item->ihave==3?'active':'').'">
                                <input type="radio" class="itemHaveRadio" id="havingRadio3" name="havingRadio" value="3" /> Мне не нужно
                            </label>
                        </div>
                    </div>
                </div>
            ');


            $result =
                '<div class="item-row">'.
                '<div class="item-block item-block-client" style="display:inline-block;">'.
                //'<div class="itemTypeLabel">'.addGroupIdLabelByGroup($item->groupId).</div>'.

                '<form class="itemRespondForm">'.
                '<input readonly name="itemname" type="text" placeholder="название предмета" class="darktextinput inventory-text-input i-name labelinput" '.addValueToInput($item->name).' />'.
                makeMeLinkAhref($item->link).
                '<input readonly name="itemtypeid" type="hidden" placeholder="тип" class="i-type" '.addValueToInput($item->groupId).' />'.
                '<input readonly name="itemid" type="hidden" placeholder="идентифиактор" class="i-id" '.addValueToInput($item->id).' />'.
                '<input readonly name="itemhave" type="hidden" placeholder="наличие" class="i-ihave" '.addValueToInput($item->ihave).' />'.
                '<div class="item-description" >'.$item->description.'</div>'.
                $radio.
                '<textarea name="itemrespondcomment" class="form-control darktextinput itemrespondcomment needed" rows="3" placeholder="Опишите тут что имеете, или оставьте комментарий">'.$item->respondcomment.'</textarea>'.
                '</form>'.
                '</div>'
            ;




            if(!isset($item->id)){
                return addslashes($result);
            }
            return $result;
        }


        function makeMeLinkAhref($link){
            if(!isset($link) || $link == null || $link == ''){
                return '';
            }
            return '<span class="item-link-ahref"><a  href="'.$link.'">Ссылка на предмет</a></span>';
        }


        function addValueToInput($val){
            if(isset($val) && $val != null && $val != ''){
                $val = str_replace("\"","&quot;",$val);
                return 'value="'.$val.'""';
            }
            return '';
        }

        function addStyleToBlock($groupId){
            if(isset($groupId) && $groupId != null && $groupId != ''){
                switch($groupId){
                    case 1: return "item-block-essential"; break;
                    case 2: return "item-block-needed";  break;
                    default: return "";
                }
            }
        }

        function addGroupIdLabelByGroup($groupId){
            if(isset($groupId) && $groupId != null && $groupId != ''){
                switch($groupId){
                    case 1: return "Обязательное снаряжение"; break;
                    case 2: return "Второстепенное снаряжение";  break;
                    case 3: return "Рекомендуемое снаряжение";  break;
                    default: return "";
                }
            }
        }
        ?>
    </div>
</div>

<script>

    $(".dropdown-menu li a").click(function(){
        var selText = $(this).text();
        $(this).parents('.btn-item-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        var selectedGroup = $(this).attr('group_id');
        var uid = $(this).parents('.btn-item-group').attr('uid');
        $(this).parents('.btn-item-group').attr('group_id',selectedGroup);
    });


</script>

</body>
</html>