<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 17.06.15
 * Time: 0:11
 */
error_reporting(1);
require_once 'UserDAO.php';

/* msk_aspid
 * ZvlvolKarLra1Q7U4r2E
 * 4953382
 *
 * */

class AspidAuth {

    var $userDao;

    public function __construct(){
        $this->userDao = new UserDAO();
        if(!defined("APP_ID")){
            define("APP_ID",     "4978729");
        }
        if(!defined("APP_SHARED_SECRET")){
            define("APP_SHARED_SECRET",    "BJ2DiBTndvMqnHeVqunE");
        }
    }

    function authOpenAPIMember() {

        $session = array();
        $member = FALSE;
        $valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig');
        if(!isset($_COOKIE['vk_app_'.APP_ID])){
            return FALSE;
        }
        $app_cookie = $_COOKIE['vk_app_'.APP_ID];
        if ($app_cookie) {
            $session_data = explode ('&', $app_cookie, 10);
            foreach ($session_data as $pair) {
                list($key, $value) = explode('=', $pair, 2);
                if (empty($key) || empty($value) || !in_array($key, $valid_keys)) {
                    continue;
                }
                $session[$key] = $value;
            }
            foreach ($valid_keys as $key) {
                if (!isset($session[$key])) return $member;
            }
            ksort($session);

            $sign = '';
            foreach ($session as $key => $value) {
                if ($key != 'sig') {
                    $sign .= ($key.'='.$value);
                }
            }
            $sign .= APP_SHARED_SECRET;
            $sign = md5($sign);
            if ($session['sig'] == $sign && $session['expire'] > time()) {

                $this->userDao->debugLog(intval($session['mid']));
                $user = $this->userDao->getUserByVkId(intval($session['mid']));
                if($user == null || $user['is_active'] != 1){
                    return FALSE;
                }

                $member = array(
                    'id' => intval($session['mid']),
                    'secret' => $session['secret'],
                    'sid' => $session['sid'],
                    'name' => $user['username'],
                    'nickname' => $user['nickname'],
                    'vklink' => 'http://vk.com/id'.$user['vkuid']
                );
            }
        }
        return $member;
    }

    public function checkRole($role){
        $user = $this->authOpenAPIMember();
        if($user){
            $userRecord = $this->userDao->getUserByVkId($user['id']);
            if($this->userDao->userHasRole($userRecord['uid'],$role) || $this->userDao->userHasRole($userRecord['uid'],'FULL_ACCESS')){
                return true;
            } else {
                return false;
            };
            return true;
        } else {
            return FALSE;
        }
    }

}