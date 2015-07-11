<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 10.06.15
 * Time: 21:02
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "classes/Navbar.php";
require_once "classes/PageHead.php";
if(!isset($_SESSION)){
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head><?php PageHead::getNormalHead() ?></head>
<body>

<?php Navbar::show('USTAV'); ?>

<br/><br/><br/>
<div id="login_button" style="border: 5px solid black" onclick="VK.Auth.login(authInfo);"></div>

<script language="javascript">
    VK.init({
        apiId: 4953382
    });

    var myuid;

    function authInfo(response) {
        if (response.session) {
            myuid = response.session.mid;
        } else {
            alert('not auth');
        }
    }
    VK.Auth.getLoginStatus(authInfo);
    VK.UI.button('login_button');

    function alertUserName(uid){
        VK.Api.call('users.get', {uids: uid}, function(r) {
            if(r.response) {
                alert('Привет, ' + JSON.stringify(r.response[0]) + ' (' + uid +')');
            }
        });
    }

</script>


<button class="btn btn-primary" onclick="window.location.replace('https://oauth.vk.com/authorize?client_id=4953382&scope=notify&redirect_uri=msk-aspid.ru/integration.php&response_type=code&v=5.34&state=SESSION_STATE');">Войти</button>

<button class="btn btn-primary" onclick="alertUserName(myuid);">За кого залогинились?</button>







</body>
</html>