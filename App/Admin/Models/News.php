<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/6/2018
 * Time: 1:53 PM
 */

namespace App\Admin\Models;

use PDO;
use App\Paginate;
use Carbon\Carbon;

class News extends \Core\Model
{


    /**
     * @var $upload_directory directory for upload photos
     */

    public static $upload_directory = 'images/news';

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

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

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
     * Fetch all the news from the database
     *
     * @return array
     */

    public static function findAll(){

        $sql = "SELECT * FROM news";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }

    
    /**
     * 
     * @param type $id News id 
     * @return mixed
     */
    
    
    public static function findById($id){

        $sql = "SELECT * FROM news WHERE id = :id ";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();

    }


    /**
     * Gets news with offset from database
     *
     * @return array
     */

    public static function getNews($page,$data_per_page,$class){

        $paginate = new Paginate($page,$data_per_page,$class);

        $sql = "SELECT * FROM news  LIMIT {$data_per_page} OFFSET {$paginate->offset()}";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }



    /**
     * Insert News and News details to the Database
     *
     * @return boolean  True if the news was saved, false otherwise
     */

    public function create(){


        $sql = "INSERT INTO news (title,status,tags,image,content,date) VALUES (:title,:status,:tags,:image,:content,:date) ";

        $db = static::getDB();

        $stmt =  $db->prepare($sql);

        $stmt->bindValue(':title' , $this->title,PDO::PARAM_STR);
        $stmt->bindValue(':status',$this->status,PDO::PARAM_STR);
        $stmt->bindValue(':tags' , $this->tags,PDO::PARAM_STR);
        $stmt->bindValue('image',$this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(':content',$this->content,PDO::PARAM_STR);
        $stmt->bindValue(':date',Carbon::now(),PDO::PARAM_STR);

        return $stmt->execute();

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

            $sql = "DELETE FROM news WHERE id = :id ";

            $db = static::getDB();

            $stmt =  $db->prepare($sql);

            $stmt->bindParam(":id" ,$id,PDO::PARAM_STR);

            $stmt->execute();

            return true;
        }
        return false;

    }
    
        
    
    
    
    public function update($id){
        
           
        $sql = "UPDATE news SET title = :title,status = :status,tags = :tags, image = :image,content = :content WHERE id = :id";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':title', $this->title,PDO::PARAM_STR);
        $stmt->bindValue(':status',$this->status,PDO::PARAM_STR);
        $stmt->bindValue(':tags', $this->tags,PDO::PARAM_STR);
        $stmt->bindValue(':image',$this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(':content',$this->content,PDO::PARAM_STR);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        
        
        return $stmt->execute();
    }


    
    /**
     * @param $method News method which implemented when save method called
     * @param null $id
     * @return bool
     */

    public function save($method,$id = null){

        $target_path =  dirname(dirname(dirname(__DIR__)))."//"."public"."//"."images"."//"."news"."//".$this->photo_filename;

        if (move_uploaded_file($this->tmp_path,$target_path)){

            if($this->$method($id)){

                unset($this->tmp_path);
                return true;

            }
            return false;
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

        $pages = $paginate->totalPage(News::class);

        return $pages;

    }

    
    /**
     * @param int $id ID of the staff's photo
     * @return bool|string
     */

    public static function picturePath(int $id){

        if(isset($id)){

            $news = static::findById($id);

            return static::$upload_directory.'/'.$news->image;

        }
        return false;
    }


    
    





}