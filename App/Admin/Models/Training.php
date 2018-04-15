<?php

namespace App\Admin\Models;

use PDO;
use App\Paginate;

class Training extends \Core\Model {

    public function __construct($data = []) {

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function create() {

        try {

            $sql = "INSERT INTO trainings (training_name,training_cat_id, "
                    . "training_apply_date , training_duration,training_hours,training_applicant)"
                    . "VALUES (:name,:category_id,:training_apply_date,:training_duration,:training_hours,:training_applicant) ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->training_name, PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
            $stmt->bindValue(':training_apply_date', $this->training_apply_date, PDO::PARAM_STR);
            $stmt->bindValue(':training_duration', $this->training_duration, PDO::PARAM_STR);
            $stmt->bindValue(':training_hours', $this->training_hours, PDO::PARAM_STR);
            $stmt->bindValue(':training_applicant', $this->training_applicant, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    
        public static function findAll(){

        $sql = "SELECT * FROM trainings";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

       return $stmt->fetchAll();

    }

    public static function getTraining($page, $data_per_page, $class) {
        
        $paginate = new Paginate($page, $data_per_page, $class);
        
         try {            $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

        $sql = "SELECT * FROM trainings LIMIT {$data_per_page} OFFSET {$paginate->offset()}";
        
            }else {
                switch (strtolower($_GET["lang"])) {
                    case $_GET["lang"]:
                          $_SESSION['lang'] = $_GET["lang"];       
                               $sql = "SELECT tt.training_name,tc.training_cat_name,t.training_apply_date,t.training_duration,t.training_hours,t.training_applicant
                                FROM trainings t
                                INNER JOIN trainings_translation tt
                                ON t.training_id = tt.training_id
                                INNER JOIN training_category tc
                                ON t.training_cat_id = tc.training_category_id
                                WHERE tt.lang_code = '" . $_SESSION["lang"] . "' AND "
                                . "tc.training_cat_name  =  (SELECT training_cat_name FROM training_category WHERE training_category_id =t.training_cat_id)";
                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
            }
          
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }catch (Exception $e) {
            $error = $e->getMessage();
      }
      
    }
    public static function getTrainingCategory() {
        try {
            $sql = "SELECT * FROM training_category ";
            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    /**
     * @param $page number of pages
     * @param $data_per_page
     * @param $class Class that need to be paginated
     * @return float
     */
    public static function getPages($page, $data_per_page, $class) {

        $paginate = new Paginate($page, $data_per_page, $class);

        $pages = $paginate->totalPage(Training::class);

        return $pages;
    }

}