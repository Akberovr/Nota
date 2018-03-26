<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/3/2018
 * Time: 5:38 PM
 */

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;
use App\Admin\Models\Post as PostModel;

class Post extends \App\Controllers\Authenticated {

    /**
     * Show  index page and retrieve all news
     *
     * @return void
     */
    public function showAction() {

        $post = PostModel::getPost();


        View::renderTemplate("Post/index.html", [
            'post' => $post
        ]);
    }

    
     /**
     * Show  particular post and retrieve all news
     */
    public function getAction() {
        $id = $this->route_params["id"];

        $post = PostModel::findById($id);
        
        $postCategory = PostModel::getPostCategoty();

        View::renderTemplate("Post/index.html", [
            'post' => $post,
            'postCategory'=> $postCategory,
            'id' => $this->route_params['id']
            
        ]);
    }

    /**
     * Add a new Post
     * @return void
     */
    public function addAction() {

        View::renderTemplate("Post/index.html");
    }

    /**
     * Edit the Post
     * @return void
     */
    public function editAction() {

        View::renderTemplate("Post/index.html");
    }
    
    
    
    function updateAction() {

         $post = new PostModel($_POST);
         print_r("<pre>");
          print_r($_POST);
          print_r("</pre>");
         $id = $this->route_params["id"];
         
         if($post->updatePost($id)){
          Flash::addMessage("Changes Saved");
          $this->redirect('/Admin/Post/show'); 
         

        }else{
            echo "Problem";
        }
        
    }
    
        /**
     * Delete the Post
     * @return boolean
     */
    public function deleteAction() {

        $id = $this->route_params["id"];
        $post = PostModel::deleteById($id);

        Flash::addMessage("News deleted", Flash::SUCCESS);
        $this->redirect('/Admin/Post/show');

        if ($_GET) {
            print_r($id);
        }
    }

}
