<?php

namespace App\Admin\Models;

use PDO;
use App\Helper;
use App\Paginate;

class Feedback extends \Core\Model {

    /**
     * @var $upload_directory directory for upload photos
     */
    public static $upload_directory = 'images/feedback';

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
     *
     */

    public function update($id){

        $sql = "UPDATE feedback SET name = :name , image = :photo ,feed = :feed  ";
        $sql .= " WHERE id = :id";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(":name" , $this->name,PDO::PARAM_STR);
        $stmt->bindValue(":photo",$this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(":feed",$this->feedback,PDO::PARAM_INT);
        
       
        $stmt->bindParam(":id" , $id , PDO::PARAM_INT);

        $stmt->execute();

        return true;
    }
    
    
 /**
     * Save the feedback model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */


    public function save($method,$id = null){

        $target_path =  dirname(dirname(dirname(__DIR__)))."/"."public"."/"."images"."/"."feedback"."/".$this->photo_filename;

        if (move_uploaded_file($this->tmp_path,$target_path)){

            if($this->$method($id)){

                unset($this->tmp_path);
                return true;

            }
            return false;
        }

    }
    
    
    
    
    
    
        /**
     * Insert Feedback details to the Database
     *
     * @return boolean  True if the staff was saved, false otherwise
     */


    private function create(){


            $sql = "INSERT INTO feedback (name,feed,image) "
                    . " VALUES (:name,:feed,:photo)";
          

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':name',$this->name,PDO::PARAM_STR);
            $stmt->bindValue(':feed',$this->feed,PDO::PARAM_STR);
            $stmt->bindValue(':photo',$this->photo_filename,PDO::PARAM_STR);
           
   

            return $stmt->execute();


    }
    
    
    /**
     * @return mixed
     */

    public static function findAll(){

        $sql = "SELECT * FROM feedback";

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

    $sql = "SELECT * FROM feedback WHERE id = :id ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }
    
     /**
     * @param $page
     * @param $data_per_page
     * @param $class
     * @return array
     */

    public static function getFeedback($page,$data_per_page,$class){

        $paginate = new Paginate($page,$data_per_page,$class);

        $sql = "SELECT * FROM feedback LIMIT {$data_per_page} OFFSET {$paginate->offset()}";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    
    
     /**
     * @param $id
     * @return bool
     */

   public static function deleteById($id){

       if (static::deletePhoto($id)){

           $sql = "DELETE FROM feedback WHERE id = :id ";

           $db = static::getDB();

           $stmt = $db->prepare($sql);

           $stmt->bindParam(':id', $id, PDO::PARAM_INT);

           $stmt->execute();

           return true;
       }

        return false;

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

            $feedback = static::findById($id);

            return static::$upload_directory.'/'.$feedback->image;

        }
        return false;
    }


    /**
     * @param $page number of pages
     * @param $data_per_page
     * @param $class Class that need to be paginated
     * @return float
     */

    public static function getPages($page,$data_per_page,$class)
    {

        $paginate = new Paginate($page,$data_per_page,$class);

        $pages = $paginate->totalPage(Feedback::class);

        return $pages;

    }

}
