<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/23/2018
 * Time: 11:00 PM
 */

namespace App\Admin\Models;

use PDO;

class Partner extends \Core\Model
{
    /**
     * @var $upload_directory directory for upload photos
     */

    private static $upload_directory = 'images/partners';

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

    /**
     * @param $file
     */

    public function setFile($file){

        $this->photo_filename = $file["name"];
        $this->tmp_path       = $file["tmp_name"];

    }

    /**
     * @return bool
     */

    public function create ()
    {
        $db = static::getDB();

        $sql = "INSERT INTO partner(name,file,uri) VALUES (:name,:file,:uri)";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name' , $this->name,PDO::PARAM_STR);
        $stmt->bindValue(':file' , $this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(':uri' , $this->uri,PDO::PARAM_STR);

        return $stmt->execute();

    }

    /**
     * Finds All records in partners table
     * @return array
     */

    public static function findAll ()
    {

        $db = static::getDB();

        $sql = "SELECT * FROM partner";

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }

    /**
     * @param $method
     * @param null $id
     * @return bool
     */

    public function save($method,$id = null){

        $target_path =  dirname(dirname(dirname(__DIR__)))."//"."public"."//"."images"."//"."partners"."//".$this->photo_filename;

        if (move_uploaded_file($this->tmp_path,$target_path)){

            if($this->$method($id)){

                unset($this->tmp_path);
                return true;

            }
            return false;
        }

    }


    /**
     *
     * @param type $id Partner id
     * @return mixed
     */

    public static function findById($id){

        $sql = "SELECT * FROM partner WHERE id = :id ";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();

    }

    /**
     * @param $id
     * @return bool
     */

    public static function deletePhoto($id){

        if (isset($id)){

            $target_path = dirname(dirname(dirname(__DIR__)))."//"."public"."//".static::picturePath($id);

            if(file_exists($target_path)){

                return unlink($target_path) ? true : false;

            }

        }
        return false;
    }


    /**
     *
     * @param type $id News id
     * @return boolean
     */

    public static function deleteById($id){

        if (static::deletePhoto($id)){

            $sql = "DELETE FROM partner WHERE id = :id ";

            $db = static::getDB();

            $stmt =  $db->prepare($sql);

            $stmt->bindParam(":id" ,$id,PDO::PARAM_STR);

            $stmt->execute();

            return true;
        }
        return false;

    }

    /**
     * @param int $id ID of the staff's photo
     * @return bool|string
     */

    public static function picturePath(int $id){

        if(isset($id)){

            $partner = static::findById($id);

            return static::$upload_directory.'/'.$partner->file;

        }
        return false;
    }




}