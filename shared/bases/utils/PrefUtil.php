<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 31/10/2018
 * Time: 1:01 PM
 */

class PrefUtil{
    static function setPreference($cName, $row){
        if ($row != null) {
            $cookieStr = json_encode($row);
            $cookieStr = bin2hex($cookieStr); // 16진수로 암호화
            setcookie($cName, $cookieStr, -1, "/", "");
            return true;
        } else {
            return false;
        }
    }

    static function getPreference($cName){
        $cookieStr = $_COOKIE[$cName];

        if($cookieStr == "") $map = null;
        else{
            $cookieStr = pack("H*", $cookieStr);
            $map = json_decode($cookieStr);
        }
        return $map;
    }

    static function getPrefWithDefault($cName, $default){
        $info = self::getPreference($cName);
        if($info == "") return $default;
        else return $info;
    }

    static function emptyPreference($cName){
        setcookie($cName, "", time() - 3600, "/", "");
    }

}