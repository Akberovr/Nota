<?php

namespace App\Admin\Models;

use PDO;
use App\Paginate;

class Category extends \Core\Model {

    public function __construct($data = []) {

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function findAll() {

        $sql = "SELECT * FROM training_category";


        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getPages($page, $data_per_page, $class) {

        $paginate = new Paginate($page, $data_per_page, $class);

        $pages = $paginate->totalPage(Category::class);

        return $pages;
    }

    public function create() {
        try {
            $sql = "INSERT INTO training_category (training_cat_name)"
                    . " VALUES (:name) ";
            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->category_name, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function findById($id) {

        $defaultLang = '';

        if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

            $sql = "SELECT * FROM training_category WHERE training_category_id = :id ";
        } else {
            switch (strtolower($_GET["lang"])) {
                case $_GET["lang"]:
                    //If the string is another language
                    $_SESSION['lang'] = $_GET["lang"];
                    $sql = "SELECT * FROM training_category_translation WHERE id = :id AND lang_code =  '" . $_SESSION["lang"] . "'";
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

    public function update($id) {


        try {

            $defaultLang = '';

            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

                $sql = "UPDATE training_category  "
                        . "SET training_cat_name = :category_name "
                        . "WHERE training_category_id = :id";


                $db = static::getDB();

                $stmt = $db->prepare($sql);

                $stmt->bindValue(':category_name', $this->category_name, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//                
            } else {
                switch (strtolower($_GET["lang"])) {


                    case $_GET["lang"]:
                        $_SESSION['lang'] = $_GET["lang"];

                        $sql = "WHERE training_id = :training_id AND  lang_code = '" . $_SESSION['lang'] . "'";


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

    public static function deleteById($id) {

        try {

            $defaultLang = '';

            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                $sql = "DELETE FROM training_category WHERE training_category_id =   :id ";
            } else {
                switch (strtolower($_GET["lang"])) {

                    case $_GET["lang"]:
                        $_SESSION['lang'] = $_GET["lang"];

                        $sql = "DELETE  FROM  training_category_translation WHERE id =  :id  AND  lang_code = '" . $_SESSION['lang'] . "'";

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

}
