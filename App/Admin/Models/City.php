<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Models;

use PDO;
use \Core\View;
use \App\Flash;

class City extends \Core\Model {

    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */
    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save() {

        try {
            //insert operation

            $sql = "BEGIN;"
                    . "INSERT INTO city (city_name, city_info)"
                    . "VALUES(:name, :info);"
                    . "SET @city_id = LAST_INSERT_ID();"
                    . "INSERT INTO city_contact (city_id, postal_code, fax, email, address)"
                    . "VALUES(@city_id, :postal_code, :fax, :email, :address);"
                    . "INSERT INTO city_phone_number (city_id, city_phone)"
                    . "VALUES(@city_id, :number);"
                . "COMMIT;";


            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':info', $this->info, PDO::PARAM_STR);
            $stmt->bindValue(':postal_code', $this->postal_code, PDO::PARAM_STR);
            $stmt->bindValue(':fax', $this->fax, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
            $stmt->bindValue(':number', $this->number, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function getCity() {

        try {
            $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                $sql = "SELECT c.id,c.city_name,c.city_info,ct.address "
                        . "FROM  city  `c` "
                        . "INNER JOIN city_contact  `ct` "
                        . "ON c.id = ct.city_id";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case "en":
                        //If the string is en or EN
                        $_SESSION['lang'] = 'en';
                        $sql = "SELECT  c.id,cr.city_name,cr.city_info,ctt.lang_code,ctt.address "
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

    public static function findById($id) {

        try {
            
                 $defaultLang = 'en';
             if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                 
                   $sql = " SELECT c.id, c.city_name, c.city_info, ct.postal_code, ct.fax, ct.email, ct.address, GROUP_CONCAT(cpn.city_phone SEPARATOR ', ') as phone_number"
                    . " FROM city `c`"
                    . " INNER JOIN city_contact `ct` "
                    . " ON c.id = ct.city_id "
                    . " INNER JOIN city_phone_number `cpn`"
                    . " ON c.id = cpn.city_id    "
                    . " WHERE id = :id ";
             } else {
                  switch (strtolower($_GET["lang"])) {
                    case "en":
                        //If the string is en or EN
                        $_SESSION['lang'] = 'en';
                        
                        $sql = "SELECT c.id, ct.city_name, ct.city_info, cc.postal_code, cc.fax, cc.email, cct.address,"
                                . "GROUP_CONCAT(cpn.city_phone SEPARATOR ', ') as phone_number "
                                . "FROM city  as c "
                                . "INNER JOIN city_contact as cc "
                                . "ON c.id = cc.city_id "
                                . "INNER JOIN city_translation as ct "
                                . "ON c.id = ct.city_id "
                                . "INNER JOIN city_phone_number `cpn`"
                                . " ON c.id = cpn.city_id "
                                . "INNER JOIN city_contact_translation as cct "
                                . "WHERE cct.lang_code = '" . $_SESSION["lang"] . "' AND ct.lang_code = '" . $_SESSION["lang"] . "' AND c.id = :id ";
                        
                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
             }

                 
                // 
   
                // INNER JOIN city_translation  as ct
                // ON c.id = ct.city_id
                // INNER JOIN city_contact_translation as cct
                // ON cc.contact_id = cct.contact_id
                // WHERE c.id = 6     



            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
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

    public function updateCity($id) {
      
       
        try {
            $sql = "BEGIN;"
                    . "UPDATE city SET city_name = :name , city_info = :info  WHERE id = :id ;"
                    . " UPDATE city_contact  SET postal_code = :postal_code  , fax = :fax , email = :email , address = :address WHERE city_id = :id ;"
                    . " UPDATE city_phone_number  SET city_phone = :number WHERE city_id = :id ;"
                . " COMMIT;";
            
            $db = static::getDB();

            $stmt = $db->prepare($sql);

           
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':info', $this->info, PDO::PARAM_STR);
            $stmt->bindValue(':postal_code', $this->postal_code, PDO::PARAM_STR);
            $stmt->bindValue(':fax', $this->fax, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
            $stmt->bindValue(':number', $this->number, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id,PDO::PARAM_INT);
            return $stmt->execute();
            
        }catch (Exception $e) {
            
            $error = $e->getMessage();
            
        }
        
    }

    public static function deleteById($id) {
        try {
            //delete operation

            $sql = "DELETE  FROM  city WHERE id =  :id ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

}
