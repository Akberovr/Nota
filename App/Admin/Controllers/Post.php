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

        View::renderTemplate("Post/index.html");

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
        $postCategory = PostModel::getPostCategoty();
        View::renderTemplate("Post/index.html",[
             'postCategory'=> $postCategory
        ]);
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

        Flash::addMessage("Post deleted", Flash::SUCCESS);
        $this->redirect('/Admin/Post/show');

       
    }

}
