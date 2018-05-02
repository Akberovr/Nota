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
            $sql = "SELECT id ,city_name FROM city";
            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }

    public static function getCityInfo($id) {

        try {
            $sql = "SELECT c.id,c.city_name,c.city_info,cc.contact_id,cc.postal_code,cc.fax,cc.email,cc.address,cpn.city_phone "
                    . "FROM city c "
                    . " INNER JOIN city_contact cc "
                    . " ON c.id = cc.contact_id "
                    . " INNER JOIN city_phone_number cpn "
                    . " ON c.id = cpn.city_id "
                    . " WHERE c.id = $id ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetch();

           return $stmt->fetch();
        } catch (Exception $ex) {
             $error = $e->getMessage();
        }
    }

}
