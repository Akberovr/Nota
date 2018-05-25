<?php

namespace App\Models;

use PDO;

class Feedback extends \Core\Model {
    
        public static function getFeedback() {
        try {
            $sql = "SELECT * FROM feedback";
            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }
}