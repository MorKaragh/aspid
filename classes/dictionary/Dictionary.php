<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 20.07.15
 * Time: 20:30
 */

class Dictionary {

    var $data = [];

    public function addItem($id, $name){
        $item = [];
        $item['name'] = $name;
        $item['id'] = $id;
        array_push($this->data, $item);
    }

    public function getNameById($id){
        foreach($this->data as $item){
            if($item['id'] == $id){
                return $item['name'];
            }
        }
        return null;
    }

}