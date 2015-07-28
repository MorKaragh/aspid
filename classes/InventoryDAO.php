<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 12.06.15
 * Time: 21:19
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "CoreDAO.php";
require_once "Item.php";


class InventoryDAO extends CoreDAO {

    public function saveInventory(){

    }

    public function getAllItemGroups(){
        $result = parent::execQuery("select * from public.item_groups",null);
        return $result;
    }

    public function saveItem(Item $item){
        if($item->id == null || $item->id == ''){
            parent::execInsert("INSERT INTO public.aspid_inventory_items(item_name,item_link,item_description,item_group_id) VALUES(?,?,?,?)",array($item->name,$item->link,$item->description,$item->groupId));
            $result = parent::execQuery("select max(id) as maxid from public.aspid_inventory_items",null);
            return $result[0]['maxid'];
        } else {
            parent::execUpdate("
                    UPDATE public.aspid_inventory_items s
                        SET item_name = ?
                        ,item_description = ?
                        ,item_link = ?
                        ,item_group_id = ?
                        WHERE id = ?"
                , array($item->name,$item->description,$item->link,$item->groupId,$item->id)
            );
            return $item->id;
        }
    }

    public function removeItem(Item $item){
        if(isset($item->id)){
            parent::execUpdate("DELETE FROM public.aspid_user_inventory WHERE item_id = ?",array($item->id));
            parent::execUpdate("DELETE FROM public.aspid_inventory_items WHERE id = ?",array($item->id));
        }
    }

    public function respondToItem(Item $item, $uid){
        $exists = parent::execQuery("SELECT 1 AS flag FROM public.aspid_user_inventory WHERE uid = ? and item_id = ?",array($uid,$item->id));
        if(isset($exists[0]['flag'])){
            parent::execUpdate("UPDATE public.aspid_user_inventory SET respond_comment = ?, have_status = ?, ins_date = CURRENT_TIMESTAMP WHERE uid = ? and item_id = ?",
                array($item->respondcomment,$item->ihave,$uid,$item->id));
        } else {
            parent::execInsert("INSERT INTO public.aspid_user_inventory(uid,item_id,respond_comment,have_status)values(?,?,?,?)",
                array($uid,$item->id,$item->respondcomment,$item->ihave));
        }
    }

    public function getAllItems(){
        $result = parent::execQuery("SELECT * FROM public.aspid_inventory_items ORDER BY item_group_id",null);
        $array = [];
        foreach($result as $i){
            $item = new Item();
            $item -> description = $i['item_description'];
            $item -> name = $i['item_name'];
            $item -> link = $i['item_link'];
            $item -> groupId = $i['item_group_id'];
            $item -> id = $i['id'];
            array_push($array,$item);
        }
        return $array;
    }

    public function getAllItemsByUid($uid){
        $result = parent::execQuery("select * from public.aspid_inventory_items s full outer join public.aspid_user_inventory u on u.item_id = s.id where u.uid = ? or u.uid is null order by item_group_id,id"
            ,array($uid));
        $result = $this->getUserInventoryRecord($uid);
        $array = [];
        foreach($result as $i){
            $item = new Item();
            $item -> description = $i['item_description'];
            $item -> name = $i['item_name'];
            $item -> link = $i['item_link'];
            $item -> groupId = $i['item_group_id'];
            $item -> id = $i['id'];
            $item -> respondcomment = $i['respond_comment'];
            $item -> ihave = $i['have_status'];
            array_push($array,$item);
        }
        return $array;
    }

    public function getUserInventoryRecord($uid)
    {
        $result = parent::execQuery("with t as (select * from aspid_user_inventory where uid = ?) select s.*, t.* from aspid_inventory_items s full outer join  t on t.item_id = s.id order by item_group_id, item_name ",array($uid));
        return $result;
    }

}