<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Admin\Models\News;
use PDO;

class Course extends \Core\Model {

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

    public static function getTraining($id) {
        try {
            $sql ="SELECT t.training_id,t.training_name,t.training_cat_id,t.training_duration,t.cn_sef_link,t.training_hours,t.training_applicant,t.info,t.description,t.program,t.field,t.certificate,tc.cn_sef,tc.training_cat_name"
                ." FROM trainings t "
                ." INNER JOIN training_category tc"
                ." ON t.training_cat_id = tc.training_category_id "
                . " WHERE t.training_cat_id =:id";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }


    public static function getCourse($sef) {
        try {
            $sql ="SELECT t.training_id,t.training_name,t.training_cat_id,t.training_duration,t.cn_sef_link,t.training_hours,t.training_applicant,t.info,t.description,t.program,t.field,t.certificate,tc.cn_sef,tc.training_cat_name"
                ." FROM trainings t "
                ." INNER JOIN training_category tc"
                ." ON t.training_cat_id = tc.training_category_id "
                . " WHERE tc.cn_sef = :id";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $sef, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }



    public static function getCategoryById($id) {
        try {
            $sql = "SELECT * FROM training_category WHERE  training_category_id = :id";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }


    public static function getCourseById($id) {
        try {


            $sql = "SELECT t.training_id,t.training_name,t.training_cat_id,t.training_duration,t.cn_sef_link,t.training_hours,t.training_applicant,t.info,t.description,t.program,t.field,t.certificate,tc.cn_sef,tc.training_cat_name"
                ." FROM trainings t "
                ." INNER JOIN training_category tc"
                ." ON t.training_cat_id = tc.training_category_id "
                . " WHERE t.training_id =:id";


            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }







    public static function getCourseByCategory($id) {
        try {
            $sql = "SELECT * FROM trainings WHERE training_cat_id = :id";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
        } catch (Exception $ex) {
            $error = $e->getMessage();
        }
    }

}
