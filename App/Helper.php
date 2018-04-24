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
     * Gets the route parameters
     * @return String
    */

    public static function getURL(){

        $url = $_SERVER['QUERY_STRING'];

        $urlString = explode("/" , $url);
        
        if (count($urlString) == 3 || count($urlString) == 4) {

            if (isset($_GET["tab"] , $_GET["lang"])){

                $urlString = explode("=", $urlString[2]);
                return $urlString[2];

            } elseif (!isset($_GET["lang"]) && isset($_GET["tab"])){

                $urlString = explode("=", $urlString[2]);
                return $urlString[1];

            }

            if (isset($_GET["lang"])) {

                $urlString = explode("&", $urlString[2]);
                return $urlString[0];

            }

            return $urlString[2];
            
        }else{
            
            $urlString[2] = null;
            return $urlString[2];
            
       }

    }

    /**
     * Gets the lang parametrs from @array $_GET
     * @return String
     */

    public static function getLang(){

        if (isset($_GET['lang'])){

            return $_GET['lang'];

        }

    }

}