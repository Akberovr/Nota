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

class About extends \Core\Model {

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public static function findAll() {
        try {
            $sql = "SELECT * FROM about";


            $db = static::getDB();

            $stmt = $db->prepare($sql);

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

    public function update() {

        try {
            $sql = "UPDATE about SET "
                    . " info = :info , description = :desc "
                    . "WHERE id = 1";


            $db = static::getDB();

            $stmt = $db->prepare($sql);


            $stmt->bindValue(':info', $this->info, PDO::PARAM_STR);
            $stmt->bindValue(':desc', $this->desc, PDO::PARAM_STR);


            return $stmt->execute();

            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                $error = $errorInfo[2];
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

}
