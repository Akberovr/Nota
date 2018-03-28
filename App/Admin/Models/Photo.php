<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/14/2018
 * Time: 6:54 PM
 */

namespace App\Admin\Models;

use PDO;
use App\Paginate;

class Photo extends \Core\Model
{

    /**
     * @var $upload_directory directory for upload photos
     */

    public $upload_directory = 'images/gallery';

    /**
     * @var $photo_filename name of the file
     */

    public $photo_filename;

    /**
     * @var $tmp_path temporary path of file
     */

    public $tmp_path;

    /**
     * @var $photo_type type of file
     */

    public $photo_type;

    /**
     * @var $photo_size size of the file
     */

    public $photo_size;

    /**
     * @var array $valid_types eligible file types allowed
     */

    public $valid_types = ["jpg","png","jpeg"];


    /**
     * Error messages for photo upload process
     *
     * @var array
     */


    public $upload_errors_array = [

            UPLOAD_ERR_OK         => "There is no error",
            UPLOAD_ERR_INI_SIZE   => "The upload file exceeds the upload_max_size directive",
            UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the max_file_size directive",
            UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded",
            UPLOAD_ERR_NO_FILE    => "No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporery folder",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
            UPLOAD_ERR_EXTENSION  => "A PHP extension stopped to file upload"
    ];


    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */

    public function __construct($data=[])
    {
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
            $this->photo_type     = $file['type'];
            $this->photo_size     = $file['size'];

        }

    }



    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */

    public function save() {

        if (!empty($this->errors)){
            return false;
        }

        if (empty($this->photo_filename) || empty($this->tmp_path)){

            $this->errors[] = "The File was not avaiable";
            return false;

        }

        $target_path =  dirname(dirname(dirname(__DIR__)))."\\"."public"."\\"."images"."\\"."gallery"."\\".$this->photo_filename;

        if (file_exists($target_path)){

            $this->errors[] = "File already exists";

            return false;

        }

       if ($this->validate()){

           if (move_uploaded_file($this->tmp_path,$target_path)){

               if($this->create()){

                   unset($this->tmp_path);
                   return true;

               }
                return false;
           }
            return false;
       }

    }


    /**
     * Insert Photo and Photo details to the Database
     *
     * @return boolean  True if the photo was saved, false otherwise
     */

    public function create(){

            if (empty($this->errors)){

                $sql = "INSERT INTO media (media_filename, media_type, media_size,media_title) VALUES (:media_filename, :media_type, :media_size,:media_title)";

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':media_filename', $this->photo_filename, PDO::PARAM_STR);
                $stmt->bindValue(':media_type', $this->photo_type, PDO::PARAM_STR);

                if (empty($this->photo_title)) {
                    $this->photo_title = "test";
                }
                $stmt->bindValue(':media_title',$this->photo_title,PDO::PARAM_STR);
                $stmt->bindValue(':media_size', $this->photo_size, PDO::PARAM_INT);

                return $stmt->execute();
            }
        return false;
    }

    /**
     * Validates file's extension
     * @return boolean  True if the file type is valid , false otherwise
     */

    private function validate(){

        $extension = substr($this->photo_filename,strpos($this->photo_filename,'.') + 1);

        if(in_array($extension, $this->valid_types)){

            return true;

        }else{

            $this->errors[] = "Please insert valid file type";

            return false;
        }

    }

    /**
     * @return mixed
     */

    public static function findAll(){

        $sql = "SELECT * FROM media";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getPhotos($page,$data_per_page,$class){

        $paginate = new Paginate($page,$data_per_page,$class);

        $sql = "SELECT * FROM media LIMIT {$data_per_page} OFFSET {$paginate->offset()}";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function photoById($id){

        $sql = "SELECT * FROM media WHERE media_id = :id";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     *  Delete certain Photo from database
     *  @return true or false
     */

    public function deleteById($id){

        $this->deletePhoto($id);

        $sql = "DELETE FROM media WHERE media_id = :photo_id ";

        $db = static::getDB();


        $stmt = $db->prepare($sql);

        $stmt->bindParam(":photo_id",$id,PDO::PARAM_INT);

        $stmt->setFetchMode();

        $stmt->execute();



    }


    /**
     * @param $size Photo file size
     * @param int $precision Photo file precision length
     * @return string
     */
    public static function formatBytes($size = null, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'kB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    /**
     * @param int $id
     * @return bool|string
     */

    public function picturePath(int $id){

        if(isset($id)){

            $photo = $this->photoById($id);

            return $this->upload_directory.'/'.$photo->media_filename;

        }

    }

    /**
     * @return bool
     */

    private function deletePhoto($id = null){

        if (isset($id)){

             $target_path = dirname(dirname(dirname(__DIR__)))."\\"."public"."\\".$this->picturePath($id);

            if(file_exists($target_path)){

                return unlink($target_path) ? true : false;

            }

        }

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

        $pages = $paginate->totalPage(Photo::class);

        return $pages;

    }



}