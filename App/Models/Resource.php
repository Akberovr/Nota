<?php
/**
 * Created by PhpStorm.
 * User: akberovr
 * Date: 6/2/18
 * Time: 16:28
 */

namespace App\Models;

use PDO;

class Resource extends \Core\Model {


    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }






    public static function getResource($id) {
        try {


            $sql = "SELECT * FROM training_material WHERE training_id = :id";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(":id" ,$id,PDO::PARAM_INT);

            $stmt->execute();



            return $stmt->fetchAll(PDO::FETCH_ASSOC);




        } catch (Exception $ex) {
            $error = $e->getMessage();
        }

    }










}