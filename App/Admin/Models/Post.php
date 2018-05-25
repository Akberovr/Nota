<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Models;

use PDO;
use App\Helper;
use Carbon\Carbon;

class Post extends \Core\Model {


    /**
     * @var $upload_directory directory for upload photos
     */

    public static $upload_directory = 'images/posts';

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


    /*
     * retrieving all news from database and  data acccording  to them.
     */

    public static function getPost() {

        try {

            $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

                $sql = "SELECT  *   
                    FROM post
                    INNER JOIN post_category pc
                    ON post.category_id = pc.category_id
                    WHERE pc.category_name  =  (SELECT category_name FROM post_category WHERE category_id = post.category_id)";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case $_GET["lang"]:
                        //
                        $_SESSION['lang'] = 'en';
                        $sql = "SELECT  p.post_id,p.date ,p.image , pt.lang_code,pt.post_title,pt.post_body,pc.category_name
                                FROM post p
                                INNER JOIN post_translation pt
                                ON p.post_id = pt.post_id
                                INNER JOIN post_category pc
                                ON p.category_id = pc.category_id
                                WHERE pt.lang_code = '" . $_SESSION["lang"] . "' AND "
                                . "pc.category_name  =  (SELECT category_name FROM post_category WHERE category_id = p.category_id)";
                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
            }
            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    /*
     * retrieving infividual news from database to process or read it.
     */

    public static function findById($id) {
            $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {

                $sql = "SELECT  *
                    FROM post
                    INNER JOIN post_category pc
                    ON post.category_id = pc.category_id
                    WHERE pc.category_name  =  (SELECT category_name FROM post_category WHERE category_id = post.category_id)";
            } else {
                switch (strtolower($_GET["lang"])) {
                    case $_GET["lang"]:
                        //If the string is en or EN
                        $_SESSION['lang'] = $_GET["lang"];
                        $sql = "SELECT  p.post_id,p.date ,p.image , pt.lang_code,pt.post_title,pt.post_body,pc.category_name
                                FROM post p
                                INNER JOIN post_translation pt
                                ON p.post_id = pt.post_id
                                INNER JOIN post_category pc
                                ON p.category_id = pc.category_id
                                WHERE pt.lang_code = '" . $_SESSION["lang"] . "' AND "
                                . "pc.category_name  =  (SELECT category_name FROM post_category WHERE category_id = p.category_id)";
                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                        //Invalid languages
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
            }
            $db = static::getDB();


            $stmt = $db->prepare($sql);
            $stmt->bindParam('post_id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetch();

    }

    /**
     * Insert News and News details to the Database
     *
     * @return boolean  True if the news was saved, false otherwise
     */

    public function create(){

        $sql = "INSERT INTO post (category_id,date,image,post_title,post_body,url) VALUES (:category_id,:date,:image,:post_title,:post_body,:url) ";

        $db = static::getDB();

        $stmt =  $db->prepare($sql);

        $stmt->bindValue(':category_id' , $this->category_id,PDO::PARAM_INT);
        $stmt->bindValue(':date',Carbon::now(),PDO::PARAM_STR);
        $stmt->bindValue('image',$this->photo_filename,PDO::PARAM_STR);
        $stmt->bindValue(':post_title',$this->post_title,PDO::PARAM_STR);
        $stmt->bindValue(':post_body',$this->post_body,PDO::PARAM_STR);
        $stmt->bindValue(':url' , Helper::sefLink($this->post_title),PDO::PARAM_STR);

        return $stmt->execute();
    }


    public function update($id) {
        try {
             $defaultLang = '';
            if (empty($_GET["lang"]) || $_GET["lang"] == 'az') {
                $sql = "UPDATE post SET "
                    . "category_id = :category_id, "
                    . "post_title = :post_title, "
                    . "post_body = :post_body "
                    . "WHERE post_id = :post_id";
            }else {
                switch (strtolower($_GET["lang"])) {
                    case $_GET["lang"]:
                        //If the string is en or EN
                        $_SESSION['lang'] = $_GET["lang"];
                        $sql = "UPDATE post_translation , post "
                                . "SET "
                                . "post.category_id = :category_id, "
                                . "post_translation.post_title = :post_title, "
                                . "post_translation.post_body = :post_body "
                                . "WHERE post.post_id = :post_id "
                                . "AND post_translation.lang_code = '". $_SESSION['lang'] ."'";
                        

                    default:
                        //IN ALL OTHER CASES your default langauge code will set
                    
                        $_SESSION['lang'] = $defaultLang;
                        break;
                }
            }
            
            
                        
            $db = static::getDB();

            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':post_title', $this->post_title, PDO::PARAM_STR);
            $stmt->bindValue(':post_body', $this->post_body, PDO::PARAM_STR); 
            $stmt->bindValue(':category_id', $this->category_id, PDO::PARAM_STR);
            $stmt->bindValue(':post_id',$id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    /*
     * deleting infividual individual news.
     */

    public static function deleteById($id) {
        try {

            $sql = "DELETE  FROM  post WHERE post_id =  :id ";

            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    
     /*
     * Fetching post categories.
     */
    
    public static function getPostCategoty() {
        try {
            $sql = "SELECT * FROM post_category ";
            $db = static::getDB();

            $stmt = $db->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }


    /**
     * @param $method Post method which implemented when save method called
     * @param null $id
     * @return bool
     */

    public function save($method,$id = null){

        $target_path =  dirname(dirname(dirname(__DIR__)))."//"."public"."//"."images"."//"."posts"."//".$this->photo_filename;

        if (move_uploaded_file($this->tmp_path,$target_path)){

            if($this->$method($id)){

                unset($this->tmp_path);
                return true;

            }
            return false;
        }

    }

    public static function getAnnounces ()
    {

        $db = static::getDB();

        $sql = "SELECT * FROM post WHERE category_id = 2";

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }
    public static function getEvents ()
    {

        $db = static::getDB();

        $sql = "SELECT * FROM post WHERE category_id = 3";

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }
    public static function getArticles ()
    {

        $db = static::getDB();

        $sql = "SELECT * FROM post WHERE category_id = 4";

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }

    /**
     * @param $title
     * @return mixed
     */

    public static function findByUrl($url){

        $sql = "SELECT * FROM post WHERE url = :url ";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':url', $url, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();

    }


}
