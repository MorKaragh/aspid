<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 22.06.15
 * Time: 22:26
 */

require_once 'StaffDAO.php';

class StaffPresenter {

    var $dao;

    public function __construct(){
        $this->dao = new StaffDAO();
    }

    public function showGroup($groupId){
        $members = $this->dao->getGroupMembersOrdered($groupId);
        foreach ($members as $member){
            echo '
            <div class="staff-member-block">
            <h4>'.$member['nickname'].'</h4>
            <p>'.$member['rank_name'].'</p>
            </div>
            ';
        }
    }




}