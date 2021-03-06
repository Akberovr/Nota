<?php

namespace App\Admin\Models;

use App\Helper;
use PDO;
use App\Paginate;

class Training extends \Core\Model {

    /**
     * @var $upload_directory directory for upload photos
     */
    public static $upload_directory = 'images/training';

    /**
     * @var $photo_filename name of the file
     */
    public $photo_filename;

    /**
     * @var $tmp_path temporary path of file
     */
    public $tmp_path;

    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */
    public function __construct($data = []) {

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function setFile($file) {

        if (empty($file) || !$file || !is_array($file)) {

            $this->errors[] = "No file was uploaded";
            return false;
        } elseif ($file['error'] != 0) {

            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {

            $this->photo_filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
        }
    }
    
    
        public function save($method,$id = null){

        $target_path =  dirname(dirname(dirname(__DIR__)))."/"."public"."/"."images"."/"."training"."/".$this->photo_filename;

        if (move_uploaded_file($this->tmp_path,$target_path)){

            if($this->$method($id)){

                unset($this->tmp_path);
                return true;

            }
            return false;
        }

    }
    
        public static function deletePhoto($id){

        if (isset($id)){

            $target_path = dirname(dirname(dirname(__DIR__)))."\\"."public"."\\".static::picturePath($id);

            if(file_exists($target_path)){

                return unlink($target_path) ? true : false;

            }

        }
        return false;
    }
    
    
        /**
     * @param int $id ID of the staff's photo
     * @return bool|string
     */

    public static function picturePath(int $id){

        if(isset($id)){

            $training = static::findById($id);

            return static::$upload_directory.'/'.$training->photo;

        }
        return false;
    }

    public function create() {

        try {



            $sql = "INSERT INTO trainings (training_name,training_cat_id, "
                    . "  training_duration,training_hours,training_applicant,info,description,program,field,certificate ) "
                    . "VALUES (:name,:category_id,:training_duration,:training_hours,:training_applicant,:info,:desc,:program,:field,:certificate) ";


            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->training_name, PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
            $stmt->bindValue(':training_duration', $this->training_duration, PDO::PARAM_STR);
            $stmt->bindValue(':training_hours', $this->training_hours, PDO::PARAM_STR);
            $stmt->bindValue(':training_applicant', $this->training_applicant, PDO::PARAM_STR);
            $stmt->bindValue(':info', $this->info, PDO::PARAM_STR);
            $stmt->bindValue(':desc', $this->desc, PDO::PARAM_STR);
            $stmt->bindValue(':program', $this->program, PDO::PARAM_STR);
            $stmt->bindValue(':field', $this->field, PDO::PARAM_STR);
            $stmt->bindValue(':certificate', $this->certificate, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public function update($id) {


        try {

            $defaultLang = '';

            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

                $sql = "UPDATE trainings SET training_name = :training_name,"
                        . "training_cat_id = :category_id,"
                        . " training_duration = :duration,"
                        . "training_hours = :hours, "
                        . "training_applicant = :applicant, "
                        . "info = :info, "
                        . " description = :desc "
                        . " WHERE training_id = :training_id";


                $db = static::getDB();

                $stmt = $db->prepare($sql);

                $stmt->bindValue(':training_name', $this->training_name, PDO::PARAM_STR);
                $stmt->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
                $stmt->bindValue(':duration', $this->training_duration, PDO::PARAM_STR);
                $stmt->bindValue(':hours', $this->training_hours, PDO::PARAM_STR);
                $stmt->bindValue(':applicant', $this->training_applicant, PDO::PARAM_INT);
                $stmt->bindValue(':info', $this->info, PDO::PARAM_STR);
                $stmt->bindValue(':desc', $this->desc, PDO::PARAM_STR);
                $stmt->bindParam(':training_id', $id, PDO::PARAM_INT);
//                
            } else {
                switch (strtolower($_GET["lang"])) {


                    case $_GET["lang"]:
                        $_SESSION['lang'] = $_GET["lang"];

                        $sql = " UPDATE trainings_translation SET "
                                . "lang_code = :lang_code , training_name = :training_name "
                                . " WHERE training_id = :training_id AND  lang_code = '" . $_SESSION['lang'] . "'";


                        $db = static::getDB();

                        $stmt = $db->prepare($sql);

                        $stmt->bindValue(':lang_code', $this->lang_code, PDO::PARAM_STR);
                        $stmt->bindValue(':training_name', $this->training_name, PDO::PARAM_STR);
                        $stmt->bindParam(':training_id', $id, PDO::PARAM_INT);



                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
            }


            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function findAll() {

        $sql = "SELECT * FROM trainings";


        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function findById($id) {

        $defaultLang = '';

        if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

            $sql = "SELECT * FROM trainings WHERE training_id = :id ";
        } else {
            switch (strtolower($_GET["lang"])) {
                case $_GET["lang"]:
                    //If the string is another language
                    $_SESSION['lang'] = $_GET["lang"];
                    $sql = "SELECT * FROM trainings_translation WHERE training_id = :id AND lang_code =  '" . $_SESSION["lang"] . "'";
                default:
                    //IN ALL OTHER CASES your default langauge code will set

                    $_SESSION['lang'] = $defaultLang;
                    break;
            }
        }

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function deleteById($id) {
        try {

            $defaultLang = '';

            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                $sql = "DELETE  FROM  trainings WHERE training_id =  :id ";
            } else {
                switch (strtolower($_GET["lang"])) {

                    case $_GET["lang"]:
                        $_SESSION['lang'] = $_GET["lang"];

                        $sql = "DELETE  FROM  trainings_translation WHERE id =  :id  AND  lang_code = '" . $_SESSION['lang'] . "'";

                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
            }



            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function getTraining($page, $data_per_page, $class) {

        $paginate = new Paginate($page, $data_per_page, $class);

        try {

            $defaultLang = '';

            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

                $sql = "SELECT * FROM trainings LIMIT {$data_per_page} OFFSET {$paginate->offset()}";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case $_GET["lang"]:
                        $_SESSION['lang'] = $_GET["lang"];
                        $sql = "SELECT tt.id,tt.training_id,tt.training_name,tc.training_cat_name,t.training_duration,t.training_hours,t.training_applicant
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
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function getTrainingCategory() {

        try {

            $defaultLang = '';

            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                $sql = "SELECT * FROM training_category ";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case $_GET["lang"]:
                        $_SESSION['lang'] = $_GET["lang"];
                        $sql = "SELECT training_cat_id,training_cat_name "
                                . "FROM training_category_translation tct "
                                . "WHERE tct.lang_code = '" . $_SESSION["lang"] . "'";
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

    public static function getLingualInfo() {

        try {
            $sql = "SELECT * FROM language";

            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public function translate($id) {
        try {

            $sql = "INSERT INTO trainings_translation "
                    . "(training_id,lang_code,training_name) "
                    . "VALUES "
                    . "($id,:lang_code,:name)";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':lang_code', $this->lang_code, PDO::PARAM_STR);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);


            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

}
