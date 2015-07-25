<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 19.07.15
 * Time: 22:26
 */

class Achievement {
    var $uid;
    var $id;
    var $fromWho;
    var $name;
    var $description;
    var $dateGive;
    var $type;
    var $fromWhoName;
    var $toWhoName;

    public function __construct($aspidAchievementsRow){
        if(isset($aspidAchievementsRow)){
            $this->id = $aspidAchievementsRow['id'];
            $this->fromWho = $aspidAchievementsRow['from_who'];
            $this->dateGive = $aspidAchievementsRow['date_give'];
            $this->description = $aspidAchievementsRow['description'];
            $this->uid = $aspidAchievementsRow['uid'];
            $this->type = $aspidAchievementsRow['type'];
            $this->name = $aspidAchievementsRow['name'];
            $this->fromWhoName = $aspidAchievementsRow['from_who_name'];
            $this->toWhoName = $aspidAchievementsRow['to_who_name'];
        }
    }
}