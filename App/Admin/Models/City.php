<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Models;

use App\Helper;
use PDO;
use \Core\View;
use \App\Flash;

class City extends \Core\Model {

    /**
     * @var $upload_directory directory for upload photos
     */

    private $upload_directory = 'images/city';

    /**
     * @var $photo_filename name of the file
     */

    private $photo_filename;

    /**
     * @var $tmp_path temporary path of file
     */

    private $tmp_path;


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
        };
    }

    public function setFile($file){

            $this->photo_filename = $file["name"];
            $this->tmp_path       = $file["tmp_name"];

    }


    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save() {

        $sql = "BEGIN;"
            . "INSERT INTO city (city_name, city_info,city_sef_link)"
            . "VALUES(:name, :info,:city_sef_link);"
            . "SET @city_id = LAST_INSERT_ID();"
            . "INSERT INTO city_contact (city_id, postal_code, fax, email, address)"
            . "VALUES(@city_id, :postal_code, :fax, :email, :address);"
            . "INSERT INTO city_phone_number (city_id, city_phone)"
            . "VALUES(@city_id, :number);"
            . "COMMIT;";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':info', $this->info, PDO::PARAM_STR);
        $stmt->bindValue(':city_sef_link', Helper::sefLink($this->name), PDO::PARAM_STR);
        $stmt->bindValue(':postal_code', $this->postal_code, PDO::PARAM_STR);
        $stmt->bindValue(':fax', $this->fax, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
        $stmt->bindValue(':number', $this->number, PDO::PARAM_STR);

        return $stmt->execute();

    }

    public function addImages ($id)
    {
        $image_name = mt_rand()."_"."image.PNG";

        $this->photo_filename = $image_name;

        $db = static::getDB();

        $sql = "INSERT INTO city_galery(city_id,city_image) VALUES(:city_id,:city_image)";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(":city_id",$id,PDO::PARAM_INT);
        $stmt->bindValue(":city_image",$this->photo_filename,PDO::PARAM_STR);

        return $stmt->execute();

    }

    public function create ($id)
    {

      if ($this->addImages($id)){

          $target_path = dirname(dirname(dirname(__DIR__))) . "//" . "public" . "//" . $this->upload_directory. "//" . $this->photo_filename;

          if (move_uploaded_file($this->tmp_path, $target_path)) {

                  unset($this->tmp_path);
                  return true;

          }
        return false;
      }

    }

    /**
     * @return mixed
     */

    public static function getCity() {

        try {
            $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                $sql = "SELECT c.id,c.city_name,c.city_info,ct.address "
                        . "FROM  city  `c` "
                        . "INNER JOIN city_contact  `ct` "
                        . "ON c.id = ct.city_id";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case "en":
                        //If the string is en or EN
                        $_SESSION['lang'] = 'en';
                        $sql = "SELECT  c.id,cr.city_name,cr.city_info,ctt.lang_code,ctt.address "
                                . "FROM city  as c "
                                . "INNER JOIN city_contact as ct "
                                . "ON c.id = ct.city_id "
                                . "INNER JOIN city_translation as cr "
                                . "ON c.id = cr.city_id "
                                . "INNER JOIN city_contact_translation as ctt "
                                . "WHERE ctt.lang_code = '" . $_SESSION["lang"] . "' AND cr.lang_code = '" . $_SESSION["lang"] . "'";
                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
                if (empty($_SESSION["lang"])) {
                    //Set default lang if there was no language
                    $_SESSION["lang"] = "$defaultLang";
                }
                $defaultLang = $_SESSION['lang'];
            }


            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();


            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                $error = $errorInfo[2];
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public static function findById($id) {

        try {

            $defaultLang = 'en';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

                $sql = " SELECT c.id, c.city_name, c.city_info, ct.postal_code, ct.fax, ct.email, ct.address, GROUP_CONCAT(cpn.city_phone SEPARATOR ', ') as phone_number"
                        . " FROM city `c`"
                        . " INNER JOIN city_contact `ct` "
                        . " ON c.id = ct.city_id "
                        . " INNER JOIN city_phone_number `cpn`"
                        . " ON c.id = cpn.city_id    "
                        . " WHERE id = :id ";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case "en":
                        //If the string is en or EN
                        $_SESSION['lang'] = 'en';

                        $sql = "SELECT c.id, ct.city_name, ct.city_info, cc.postal_code, cc.fax, cc.email, cct.address,"
                                . "GROUP_CONCAT(cpn.city_phone SEPARATOR ', ') as phone_number "
                                . "FROM city  as c "
                                . "INNER JOIN city_contact as cc "
                                . "ON c.id = cc.city_id "
                                . "INNER JOIN city_translation as ct "
                                . "ON c.id = ct.city_id "
                                . "INNER JOIN city_phone_number `cpn`"
                                . " ON c.id = cpn.city_id "
                                . "INNER JOIN city_contact_translation as cct "
                                . "WHERE cct.lang_code = '" . $_SESSION["lang"] . "' AND ct.lang_code = '" . $_SESSION["lang"] . "' AND c.id = :id ";

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
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
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

    public function updateCity($id) {


        try {
            $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                $sql = "BEGIN;"
                        . "UPDATE city SET city_name = :name , city_info = :info  WHERE id = :id ;"
                        . " UPDATE city_contact  SET postal_code = :postal_code  , fax = :fax , email = :email , address = :address WHERE city_id = :id ;"
                        . " UPDATE city_phone_number  SET city_phone = :number WHERE city_id = :id ;"
                    . " COMMIT;";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case $_GET["lang"]:
                        //If the string is en or EN
                        $_SESSION['lang'] = $_GET["lang"];
                        $sql = "BEGIN;"
                                . "UPDATE city_translation SET city_name = :name , city_info = :info  WHERE city_translation.city_id = :id AND  city_translation.lang_code = '". $_SESSION['lang'] ."' ;"
                                . " UPDATE city_contact  SET postal_code = :postal_code  , fax = :fax , email = :email , address = :address WHERE city_id = :id ;"
                                . " UPDATE city_phone_number  SET city_phone = :number WHERE city_id = :id ;"
                            . " COMMIT;";


                    default:
                        //IN ALL OTHER CASES your default langauge code will set

                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
            }

            $db = static::getDB();

            $stmt = $db->prepare($sql);


            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':info', $this->info, PDO::PARAM_STR);
            $stmt->bindValue(':postal_code', $this->postal_code, PDO::PARAM_STR);
            $stmt->bindValue(':fax', $this->fax, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
            $stmt->bindValue(':number', $this->number, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (Exception $e) {

            $error = $e->getMessage();
        }
    }

    public  function deleteById($id) {

        $iter = count($this->photoById($id));

        for ($i = 0; $i < $iter; $i++){

            $this->deletePhoto($id,$i);

        }

            $sql = "DELETE  FROM  city WHERE id =  :id ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();


    }

    private function deletePhoto($id,$i)
    {

        $target_path = dirname(dirname(dirname(__DIR__)))."/"."public"."/".$this->picturePath($id,$i);

        if(file_exists($target_path)){

            return unlink($target_path) ? true : false;

        }


    }

    private function  picturePath($id,$i)
    {
        if(isset($id)){

            $photo = $this->photoById($id);

            return $this->upload_directory.'/'.$photo[$i]->city_image;

        }
        return false;

    }

    public function photoById ($id)
    {

        $db = static::getDB();

        $sql = "SELECT city_image FROM city_galery WHERE city_id = :city_id";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":city_id" ,$id,PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }

}
