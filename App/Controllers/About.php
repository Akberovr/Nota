<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use PDO;

class About extends \Core\Model {
    
    public function getAboutInfo() {
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
