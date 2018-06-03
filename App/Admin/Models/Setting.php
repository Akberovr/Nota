<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/25/2018
 * Time: 3:47 PM
 */

namespace App\Admin\Models;


use App\Flash;
use PDO;


class Setting extends \Core\Model
{

    /**
     * @var $upload_directory directory for upload photos
     */

    private static $upload_directory = 'images/top_slider';

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

    public function add ($section)
    {
            switch ($section){

                case 'socials':
                    $this->addSocials();
                    break;
                case 'statuses':
                    $this->addStatuses();
                    break;
                case 'links':
                    $this->addLinks();
                    break;
                case 'contact':
                    $this->addContact();
                    break;
                default:
                    Flash::addMessage("Enter Valid URL");

            }

    }
    /**
     * Save the slider model with the current property values
     *
     * @return boolean  True if the slider was saved, false otherwise
     */


    public function save($method,$id = null){

        $target_path =  dirname(dirname(dirname(__DIR__)))."/"."public"."/"."images"."/"."top_slider"."/".$this->photo_filename;

        if (move_uploaded_file($this->tmp_path,$target_path)){

            if($this->$method($id)){

                unset($this->tmp_path);
                return true;

            }
            return false;
        }

    }

    public static function allSlider ()
    {

        $sql = "SELECT * FROM slider";

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

    public static function sliderByID($id){

        $sql = "SELECT * FROM slider WHERE id = :id ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Creates new slider
     * @return bool
     */

    public function create(){

        $db = static::getDB();

        $sql = "INSERT INTO slider(title,deadline,image) VALUES(:title,:deadline,:image) ";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(":title",$this->title,PDO::PARAM_STR);
        $stmt->bindValue(":deadline",$this->deadline,PDO::PARAM_STR);
        $stmt->bindValue(":image",$this->photo_filename,PDO::PARAM_STR);

        return $stmt->execute();

    }

    /**
     * @param $id
     * @return bool
     */

    public static function deleteSlider($id){

        if (static::deletePhoto($id)){

            $sql = "DELETE FROM slider WHERE id = :id ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return true;
        }

        return false;

    }

    /**
     * Deletes slider from Database
     * @return mixed
     */

    public function update($id){

        $sql = "UPDATE slider SET title = :title,deadline = :deadline, image= :image WHERE id = :id";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(":title" , $this->title,PDO::PARAM_STR);
        $stmt->bindValue(":deadline",$this->deadline,PDO::PARAM_STR);
        $stmt->bindValue(":image",$this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);

        $stmt->execute();

        return true;
    }


    /**
     * @param $id
     * @return bool
     */

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

            $slider = static::sliderByID($id);

            return static::$upload_directory.'/'.$slider->image;

        }
        return false;
    }



}