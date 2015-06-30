<?php
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
require_once "classes/ComboboxFactory.php";
require_once "classes/dictionary/GroupDictionary.php";
require_once "classes/dictionary/RankDictionary.php";
require_once "classes/PrivateNavbar.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php PageHead::getNormalHead() ?>
    <script src="js/userjs.js" type="application/javascript"></script>
</head>

<body>

<?php Navbar::show('USTAV'); ?>

<div class="container">

<div class="row">

    <?php
    $auth = new AspidAuth();
    $member = $auth->authOpenAPIMember();

    if($member !== FALSE) {

        $privateNavbar = new PrivateNavbar();
        $privateNavbar->show();

        $userDAO = new UserDAO();
        $set = $userDAO->getAllActiveUsers();
        if($set != null) {

            echo '

        <div id="privateActionArea" class="col-md-12 blackblock lowerblock" style="padding:5px;">
        <div id="no-more-tables">

                <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Имя в VK</th>
                    <th>Позывной</th>
                    <th>Группа</th>
                    <th>Должность</th>
                </tr>
                </thead>
                <tbody>
            ';

            $canModify = ($auth->checkRole('TEAM_EDIT') == 1);
            $groupDictionary = new GroupDictionary($userDAO);
            $rankDictionary = new RankDictionary($userDAO);
            $comboboxFactory = new ComboboxFactory();
            $i = 1;

            foreach ($set as $row) {
                if($canModify){
                    $group = $comboboxFactory->getUserGroupComboboxHtml($row['group_id'],$row['uid'],$groupDictionary);
                    $nickname = '<input uid="'.$row['uid'].'" type="text" placeholder="Введите позывной..." class="darktextinput nicknameinput">';
                    if($row['nickname'] != null){
                        $nickname = '<input uid="'.$row['uid'].'" type="text" placeholder="Введите позывной..." value="'.$row['nickname'].'" class="darktextinput nicknameinput">';
                    }
                    if($row['rank_id'] != 1){
                        $rank = $comboboxFactory->getRankComboboxHtml($row['rank_id'],$row['uid'],$rankDictionary);
                    } else {
                        $rank = '<span class="highlighted_rank" style="margin-left : 30px;">Командир команды</span>';
                    }
                } else {
                    $group = $groupDictionary->getNameById($row['group_id']);
                    $nickname = $row['nickname'] != null ? $row['nickname'] : '';
                    if($row['rank_id'] != 1) {
                        $rank = $rankDictionary->getNameById($row['rank_id']);
                    } else {
                        $rank = '<span class="highlighted_rank">Командир команды</span>';
                    }
                }
                echo
                    '   <tr class="">
                        <td data-title="#">' . $i++ . '</td>
                        <td data-title="Имя в VK" class="vknametablecell">' . $row['username'] . '</td>
                        <td data-title="Позывной">'.$nickname.'</td>
                        <td data-title="Группа">'.$group.'</td>
                        <td data-title="Звание">'.$rank.'</td>
                    </tr>
                ';
            }

            echo '
                </tbody>
            </table>
            </div>
            </div>

            ';
        }


    } else {
        echo '
                <div class="col-md-12 col-centered block"><h1>Доступ сюда разрешен только членам команды!</h1>
                <br/><h3>Вы не являетесь членом команды или не вошли на сайт.</h3></div>
              ';
    }

    ?>
</div>
</div>

<script>

    $(".dropdown-menu.group-combobox li a").click(function(){
        var selText = $(this).text();
        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        var selectedGroup = $(this).attr('group_id');
        var uid = $(this).parents('.btn-group').attr('uid');
        $(this).parents('.btn-group').attr('group_id',selectedGroup);
        setUserGroup(uid,selectedGroup);
    });

    function setUserGroup(uid, group_id){
        $.ajax({
            url: 'phpscripts/setusergroup.php',
            type: 'post',
            data: { "uid": uid, "group_id": group_id},
            error: function(response) { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
        });
    }

    $(".nicknameinput").blur(function(){
        var uid = $(this).attr('uid');
        var nick = $(this).val();
        $.ajax({
            url: 'phpscripts/setnickname.php',
            type: 'post',
            data: { "uid": uid, "nickname": nick},
            success: function(response) { console.log("***SUCCESS***\n" + response + "\n*** *** ***");},
            error: function(response) { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
        });
    });

    $(".dropdown-menu.rank-combobox li a").click(function(){
        var selText = $(this).text();
        $(this).parents('.btn-rank').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        var selectedRank = $(this).attr('rank_id');
        var uid = $(this).parents('.btn-rank').attr('uid');
        $(this).parents('.btn-rank').attr('rank_id',selectedRank);
        setUserRank(uid,selectedRank);
    });

    function setUserRank(uid, rank_id){
        $.ajax({
            url: 'phpscripts/setuserrank.php',
            type: 'post',
            data: { "uid": uid, "rank_id": rank_id},
            error: function(response) { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
        });
    }

</script>

</body>
</html>