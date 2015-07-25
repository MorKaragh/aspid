<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 22.06.15
 * Time: 22:26
 */

require_once 'UserDAO.php';
require_once 'Achievement.php';
require_once 'AspidAuth.php';
class StaffPresenter {

    var $dao;
    var $auth;
    public function __construct(){
        $this->auth = new AspidAuth();
        $this->dao = $this->auth->getUsetDao();
    }

    public function showGroup($groupId){

        $user = $this->auth->authOpenAPIMember();
        $members = $this->dao->getGroupMembersOrdered($groupId);


        foreach ($members as $member){
            $achievements = $this->dao->getUserAchievements($member['uid']);


            //'.$this->buildAchievementsBlock($achievements).'

            if($user){
                $expandButton = '<div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                    <button style="float:right; margin-top:10px;" type="button" class="btn btn-success btn-circle btn-lg btn-expand"><i class="glyphicon glyphicon-menu-down"></i></button>
                                </div>';
            } else {
                $expandButton = '';
            }

            echo '
            <div class="staff-member-block" style="height: 100px;">
                <input type="hidden" class="uid-inpt" value="'.$member['uid'].'">
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
                    <h4>'.$member['nickname'].'</h4>
                    <p>'.$member['rank_name'].'</p>
                </div>
                '.$expandButton.'
            </div>
            ';
        }
    }






}