<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Models;

use PDO;
use \Core\View;
use \App\Flash;

class Post extends \Core\Model {
    
    
    
    
        public function __construct($data = []) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            };
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
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    public function updatePost($id) {
        try {
//             $defaultLang = '';
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
                        $sql = "UPDATE post_translation "
                                . "SET"
                                . "post_title: post_title, "
//                                . "category_id = :category_id, "
                                . "post_body = :post_body "
                                . "WHERE post_id = :post_id"
                                . "AND lang_code = '" . $_SESSION["lang"] . "'";
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
//            $stmt->bindValue(':category_id', $this->category_id, PDO::PARAM_STR);
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

}
