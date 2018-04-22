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


        $sql = "SELECT * FROM training_material WHERE training_id = :id"
                . " LIMIT {$data_per_page} OFFSET {$paginate->offset()}";


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

            $sql = "SELECT * FROM training_material WHERE training_id = :id ";
            
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

        return $stmt->fetch();
    }

    public static function getPages($page, $data_per_page, $class) {

        $paginate = new Paginate($page, $data_per_page, $class);

        $pages = $paginate->totalPage(Resource::class);

        return $pages;
    }

}
