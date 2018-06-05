<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/24/2018
 * Time: 9:13 PM
 */

namespace App\Admin\Models;
use PDO;

class Instructor extends \Core\Model
{

    /**
     * @var $upload_directory directory for upload photos
     */

    public static $upload_directory = 'images/instructors';

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

        };

    }

    /**
     * @return mixed
     */

    public static function getAll(){

        $sql = "SELECT * FROM instructors";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }


    /**
     * @param $id
     * @return mixed
     */

    public static function findById($id){

        $sql = "SELECT * FROM instructors WHERE id = :id ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Sets file and checks whether empty errors or not
     *
     *  @return true or false
     */

    public function setFile($file){

        if (empty($file) || !$file || !is_array($file)) {

            $this->errors[] = "No file was uploaded";
            return false;

        }elseif($file['error'] != 0){

            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;

        }else{

            $this->photo_filename = basename($file['name']);
            $this->tmp_path       = $file['tmp_name'];

        }
    }

    /**
     * Save the staff model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */


    public function save($method,$id = null){

        $target_path =  dirname(dirname(dirname(__DIR__)))."/"."public"."/"."images"."/"."instructors"."/".$this->photo_filename;

        if (move_uploaded_file($this->tmp_path,$target_path)){

            if($this->$method($id)){

                unset($this->tmp_path);
                return true;

            }
            return false;
        }

    }

    /**
     * Insert Staff and Staff details to the Database
     *
     * @return boolean  True if the staff was saved, false otherwise
     */


    private function create(){


        $sql = "INSERT INTO instructors (name,email,about,photo,field) ";
        $sql .= "VALUES (:name,:email,:about,:photo,:field) ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name',$this->name,PDO::PARAM_STR);
        $stmt->bindValue(':email',$this->email,PDO::PARAM_STR);
        $stmt->bindValue(':about',$this->about,PDO::PARAM_STR);
        $stmt->bindValue(':photo',$this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(':field',$this->field,PDO::PARAM_STR);

        return $stmt->execute();


    }

    /**
     * @param $id
     * @return bool
     */

    public static function deleteById($id){

        if (static::deletePhoto($id)){

            $sql = "DELETE FROM instructors WHERE id = :id ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return  $stmt->execute();


        }else{
            return false;
        }



    }

    /**
     *
     */

    public function update($id){

        $sql = "UPDATE instructors SET name = :name , photo = :photo , email = :email, field = :field,";
        $sql .= " about = :about WHERE id = :id";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(":name" , $this->name,PDO::PARAM_STR);
        $stmt->bindValue(":photo",$this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->email,PDO::PARAM_STR);
        $stmt->bindValue(":about",$this->about,PDO::PARAM_STR);
        $stmt->bindValue(":field",$this->field,PDO::PARAM_STR);
        $stmt->bindParam(":id" , $id , PDO::PARAM_INT);

        $stmt->execute();

        return true;
    }

    /**
     * @param $id
     * @return bool
     */

    public static function deletePhoto($id){

        if (isset($id)){

            $target_path = dirname(dirname(dirname(__DIR__)))."/"."public"."/".static::picturePath($id);

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

            $staff = static::findById($id);

            return static::$upload_directory.'/'.$staff->photo;

        }
        return false;
    }

}