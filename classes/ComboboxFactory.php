<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 20.06.15
 * Time: 18:55
 */

require_once 'dictionary/RankDictionary.php';

class ComboboxFactory {

    public function getUserGroupComboboxHtml($selectedGroupId,$uid,$groupDictionary){

        $groups = $groupDictionary->getGroups();

        $selectedText = ".......";
        $valuesHtml = "";
        foreach($groups as $group){
            $valuesHtml = $valuesHtml.'<li><a group_id="'.$group['id'].'">'.$group['group_name'].'</a></li>';
            if($selectedGroupId == $group['id']){
                $selectedText = $group['group_name'];
            }
        }

        return '
        <div class="btn-group" uid="'.$uid.'">
            <a class="btn btn-primary dropdown-toggle btn-select aspdcombobox" data-toggle="dropdown" href="#">
                ' .$selectedText.'<span class="caret" style="margin-left: 2px;"></span>
            </a>
            <ul class="dropdown-menu group-combobox">
                '.$valuesHtml.'
                <li class="divider"></li>
                <li><a group_id="0">Без группы</a></li>
            </ul>
        </div>

        ';
    }

    public function getRankComboboxHtml($selectedRank,$uid,RankDictionary $rankDictionary){
        $ranks = $rankDictionary->getNonCommanderRanks();

        $selectedText = "нет ";
        $valuesHtml = "";
        foreach($ranks as $rank){
            $valuesHtml = $valuesHtml.'<li><a rank_id="'.$rank['id'].'">'.$rank['rank_name'].'</a></li>';
            if($selectedRank == $rank['id']){
                $selectedText = $rank['rank_name'];
            }
        }

        return '
        <div class="btn-group btn-rank" uid="'.$uid.'">
            <a class="btn btn-primary dropdown-toggle btn-select aspdcombobox" data-toggle="dropdown" href="#" style="width: 200px;" >
                ' .$selectedText.'<span class="caret"></span>
            </a>
            <ul class="dropdown-menu rank-combobox">
                '.$valuesHtml.'
                <li class="divider"></li>
                <li><a rank_id="0">Без звания</a></li>
            </ul>
        </div>

        ';
    }

}