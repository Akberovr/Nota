<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/3/2018
 * Time: 2:09 PM
 */

namespace App;


class Helper
{

    /**
     * Gets the route parametrs
     * @return String
    */

    public static function getURL(){

        $url = $_SERVER['QUERY_STRING'];

        $urlString = explode("/" , $url);

        if (count($urlString) == 3 || count($urlString) == 4) {
            return $urlString[2];
        }else{
            $urlString[2] = null;
            return $urlString[2];
       }

    }

}