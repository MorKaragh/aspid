/**
 * Created by tookuk on 12.06.15.
 */

function enterVk(){
    console.log("=============== enter enterVk ===============");
    VK.init({
        apiId: 4978729
    });
    console.log("trying to login...");
    VK.Auth.login(enterRange,262144);
    console.log("after login...");
}

function loggin(response){
    alert(JSON.stringify(VK.Auth.getSession()));
}
/*
function isAspid(uid){
    console.log("=============== enter isAspid ===============");
    console.log("uid = "+uid);
    VK.Api.call('groups.isMember', {gid:"msk_aspid", uids: uid}, function(r) {
        console.log("=============== isAspid ===============");
        console.log(JSON.stringify(r));
        if(r.response[0].member == 1) {
            writeMyNameToCookies();
            window.open("http://msk-aspid.ru/private.php","_self");
        } else {
            alert("Вы не член команды \"АСПИД МСК\"");
        }
    });
}
*/
function renewList(){
    VK.init({
        apiId: 4978729
    });
    VK.Api.call('groups.getMembers', {group_id:'msk_aspid'}, function(r) {
        //alert("!!");
        console.log("=============== isAspid ===============");
        console.log(JSON.stringify(r));
        $.ajax({
            url: 'phpscripts/renewList.php',
            type: 'post',
            data: { "param": r},
            success: function(response) { console.log("SETTED!" + response); },
            error: function(response) { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
        });
    });
}

function enterRange(response){
    console.log("=============== enterRange ===============");
    console.log(JSON.stringify(response));
    var uid = response.session.user.id;
    if(response.status == "connected"){
        console.log("*****========== we are connected ==========*****");
        window.open("http://msk-aspid.ru/private.php","_self");
    }
}
/*
function writeMyNameToCookies(){
    console.log("=============== writeMyNameToCookies ===============");
    sessionData = VK.Auth.getSession();
    console.log(JSON.stringify(sessionData));
    var name = sessionData.user.first_name+" " +sessionData.user.last_name;
    $("#authBtn").html('<a href="#" onclick="enterVk();" >"+name+"</a>');
    setToSession("aspid_member_name",name);
}
*/
function setCookie (name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
    ((expires) ? "; expires=" + expires : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    ((secure) ? "; secure" : "");
}

function setToSession(param,val){
    console.log("=============== setToSession ===============");
    $.ajax({
        url: 'phpscripts/saveToSession.php',
        type: 'post',
        data: { "param": param, "val": val},
        success: function(response) { console.log("SETTED!" + response); },
        error: function(response) { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
    });
}

function log(param){
    console.log(param);
}