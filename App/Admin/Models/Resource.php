<?php

namespace App\Admin\Models;

use PDO;
use App\Paginate;

class Resource extends \Core\Model {

    public function __construct($data = []) {

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function create($id) {

        try {



            $sql = "INSERT INTO training_material (training_id,material_title, "
                    . "material_body , media)"
                    . "VALUES ($id,:title,:body,:media) ";


            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':body', $this->body, PDO::PARAM_STR);
            $stmt->bindValue(':media', $this->media, PDO::PARAM_STR);


            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public function update($id) {

        try {

            $defaultLang = '';

            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

                $sql = "UPDATE training_material "
                        . "SET "
                        . "material_title = :title, "
                        . "material_body = :body, "
                        . " media = :media "
                        . "WHERE material_id = :id";


                $db = static::getDB();

                $stmt = $db->prepare($sql);
                $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
                $stmt->bindValue(':body', $this->body, PDO::PARAM_STR);
                $stmt->bindValue(':media', $this->media, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                switch (strtolower($_GET["lang"])) {


                    case $_GET["lang"]:
                        $_SESSION['lang'] = $_GET["lang"];

                        $sql = "UPDATE material_translation "
                                . " SET "
                                . " lang_code = :lang_code, "
                                . " material_title = :title, "
                                . " material_body = :body "
                                . "  WHERE material_id = :id AND  lang_code = '" . $_SESSION['lang'] . "'";


                        $db = static::getDB();

                        $stmt = $db->prepare($sql);

                        $stmt->bindValue(':lang_code', $this->lang_code, PDO::PARAM_STR);
                        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
                        $stmt->bindValue(':body', $this->body, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);



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
                $sql = "DELETE  FROM  training_material WHERE training_id =  :id ";
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

    public static function findAll() {

        $sql = "SELECT * FROM training_material";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getResource($id, $page, $data_per_page, $class) {

        $paginate = new Paginate($page, $data_per_page, $class);

        $defaultLang = '';

        if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
            $sql = "SELECT * FROM training_material WHERE training_id = :id"
                    . " LIMIT {$data_per_page} OFFSET {$paginate->offset()}";
        } else {
            switch (strtolower($_GET["lang"])) {
                case $_GET["lang"]:
                    //If the string is another language
                    $_SESSION['lang'] = $_GET["lang"];
                    $sql = "SELECT * FROM material_translation WHERE training_id = :id AND lang_code =  '" . $_SESSION["lang"] . "'";
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

        return $stmt->fetchAll();
    }

    public static function findById($id) {

        $defaultLang = '';

        if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

            $sql = "SELECT * FROM training_material WHERE material_id = :id ";
        } else {
            switch (strtolower($_GET["lang"])) {
                case $_GET["lang"]:
                    //If the string is another language
                    $_SESSION['lang'] = $_GET["lang"];
                    $sql = "SELECT * FROM material_translation WHERE material_id = :id AND lang_code =  '" . $_SESSION["lang"] . "'";
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

    public static function findTrainingId($id) {
        try {
            $sql = "SELECT training_id FROM training_material WHERE material_id = :id";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (Exception $e) {
            
        }
    }

    public function translate($id) {
        try {

            $sql = "INSERT INTO material_translation "
                    . "(material_id,training_id,lang_code,material_title,material_body) "
                    . "VALUES "
                    . "($id,:training_id,:lang_code,:title,:body)";

            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':training_id', $this->training_id, PDO::PARAM_INT);
            $stmt->bindValue(':lang_code', $this->lang_code, PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':body', $this->body, PDO::PARAM_STR);
            $stmt->bindValue(':body', $this->body, PDO::PARAM_STR);



            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function getPages($page, $data_per_page, $class) {

        $paginate = new Paginate($page, $data_per_page, $class);

        $pages = $paginate->totalPage(Resource::class);

        return $pages;
    }

}
