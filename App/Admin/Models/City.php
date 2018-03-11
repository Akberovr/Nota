<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Models;
use PDO;

class City extends \Core\Model {

    public static function getCity() {

        try {
            $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                    $sql = "SELECT c.id,c.city_name,c.city_info,ct.postal_code,ct.fax,ct.email,ct.address "
                            . "FROM  city  `c` "
                            . "INNER JOIN city_contact  `ct` "
                                   . "ON c.id = ct.city_id";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case "en":
                        //If the string is en or EN
                        $_SESSION['lang'] = 'en';
                         $sql = "SELECT  c.id,cr.city_name,cr.city_info,ct.postal_code,ctt.lang_code,ct.fax,ct.email,ctt.address "
                        . "FROM city  as c "
                        . "INNER JOIN city_contact as ct "
                        . "ON c.id = ct.city_id "
                        . "INNER JOIN city_translation as cr "
                        . "ON c.id = cr.city_id "
                        . "INNER JOIN city_contact_translation as ctt "
                        . "WHERE ctt.lang_code = '" . $_SESSION["lang"] . "' AND cr.lang_code = '" . $_SESSION["lang"] . "'";
                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
                if (empty($_SESSION["lang"])) {
                    //Set default lang if there was no language
                    $_SESSION["lang"] = "$defaultLang";
                }
                $defaultLang = $_SESSION['lang'];
            }


            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();


            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                $error = $errorInfo[2];
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function getCityInfo($id) {

        try {
            $sql = "SELECT * FROM city WHERE id = :id ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch();

            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                $error = $errorInfo[2];
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    
    public static function deleteCityInfo($id) {
        try{
            //delete operation
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

}

