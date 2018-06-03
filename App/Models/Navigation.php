<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Admin\Models\News;
use PDO;

class Navigation extends \Core\Model {

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

    public static function getTraining() {
        try {
            $sql = "SELECT * FROM trainings ";
            $db = static::getDB();

            $stmt = $db->prepare($sql);
            
//            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }

}
