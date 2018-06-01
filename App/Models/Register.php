<?php
/**
 * Created by PhpStorm.
 * User: akberovr
 * Date: 5/31/18
 * Time: 13:14
 */

namespace App\Models;

use PDO;

class Register extends \Core\Model {


    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }



    public static function getTraining($id) {
        try {


            $sql = "SELECT training_name FROM trainings WHERE  training_cat_id = :id";
            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(":id" ,$id,PDO::PARAM_INT);

            $stmt->execute();



            return $stmt->fetchAll();




        } catch (Exception $ex) {
            $error = $e->getMessage();
        }

    }



    public static function getCategory() {


        try {
            $sql = "SELECT * FROM training_category";
            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }


    }




}