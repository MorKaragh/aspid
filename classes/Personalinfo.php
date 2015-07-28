<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 25.07.15
 * Time: 17:50
 */

class Personalinfo {

    var $dao;
    public function __construct(UserDAO $udao){
        $this->dao = $udao;
    }

    public function getFormForEdit($uid){
        $info = $this->dao->getPersonalInfo($uid);

        $result = '<form class="form-horizontal" id="personal-info-form">
';

                foreach($info as $row){
                    $result = $result.'
                      <div style="display: inline-block; margin-top:5px;">
                        <span><div style="width: 100px; display: inline-block;">'.$row['name'].'</div></span>
                        <input id="textinput" name="'.$row['id'].'" type="text" placeholder="'.$row['name'].'" value="'.$row['val'].'" style="display: inline-block;" class="darktextinput">
                      </div>
                      <br/>

                    ';
                }

        $result = $result.'
                    <button id="savepersonal" name="singlebutton" style="margin-top:10px;" class="btn btn-primary">Сохранить</button>
                    </form>

                    <script>
                        $("#savepersonal").click(
                            function(){
                                var json = JSON.stringify($("#personal-info-form").serializeArray());
                                var uid = $("#uid").val();

                                $.ajax({
                                    url: "phpscripts/setpersonaldata.php",
                                    type: "post",
                                    data: { "jsn": json, "uid": uid},
                                    success: function(response){
                                        console.log(response);
                                    },
                                    error: function(response){
                                        console.log(response);
                                    }
                                })

                            }

                        );
                    </script>
                    ';

        return $result;

    }

}