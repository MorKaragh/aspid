/**
 * Created by tookuk on 29.06.15.
 */

function processAllAspids(){
    console.log('enter processAllAspids');
    VK.init({
        apiId: 4953382
    });
    VK.Api.call('groups.getMembers', {group_id: "msk_aspid"}, function(r) {
        if(r) {
            deactivateNonActive(JSON.stringify(r.response.users));
            console.log("MEMBERS: " + JSON.stringify(r.response.users))
            for(var i in r.response.users){
                var uid = r.response.users[i];
                pausecomp(500)
                console.log("MEMBER: " + JSON.stringify(uid));
                insertOrUpdateUser(uid);
            }
        }
        location.reload(true);
    });
}

function insertOrUpdateUser(vkuid){
    VK.Api.call('users.get', {uids: vkuid}, function(r) {
        if(r.response) {
            var uid = r.response[0].uid;
            var name = r.response[0].first_name + " " + r.response[0].last_name;
            console.log("uid="+uid+"; name="+name);
            $.ajax({
                url: 'phpscripts/saveuser.php',
                type: 'post',
                data: { "vkuid": uid, "vkname": name},
                success: function(response) { console.log(response); },
                error: function() { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
            });
        }
    });
}

function deactivateNonActive(prm){
    $.ajax({
        url: 'phpscripts/saveuser.php',
        type: 'post',
        data: { "jsn": prm},
        success: function(response) { console.log(response); },
        error: function() { console.log("***ERROR***\n" + response + "\n*** *** ***"); }
    });
}

function pausecomp(millis)
{
    var date = new Date();
    var curDate = null;
    do { curDate = new Date(); }
    while(curDate-date < millis);
}

function renewAspidList(){
    processAllAspids();
}