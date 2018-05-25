<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use PDO;

class City extends \Core\Model {

    public static function getCity() {
        try {
            $sql = "SELECT id ,city_name,city_sef_link FROM city";
            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }

    public static function getCityInfo($sefLink) {

            $sql = "SELECT * FROM city WHERE city_sef_link = :sef_link";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(":sef_link",$sefLink,PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetch();


           

    }
    
        public static  function getAboutInfo() {
            
         try {
             
          $sql = "SELECT * FROM about WHERE id = 1";

             $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetch();
           

           
        } catch (Exception $ex) {
             $error = $e->getMessage();
        }

    }

}
