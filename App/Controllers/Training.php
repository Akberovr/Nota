<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Models;

use PDO;

class Training extends \Core\Model {
    
        public static function getTraining($id) {
        try {
            $sql = "SELECT * FROM trainings WHERE training_cat_id = :id";
            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }
}

