<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/3/2018
 * Time: 5:38 PM
 */

namespace App\Admin\Controllers;

use \Core\View;
use App\Helper;
use App\Flash;
use App\Admin\Models\Post as PostModel;

class Post extends \App\Controllers\Authenticated {

    /**
     * Show  index page and retrieve all news
     *
     * @return void
     */
    public function showAction() {

        View::renderTemplate("Post/index.html",[
            "posts" => PostModel::getPost()
        ]);

    }

    
     /**
     * Show  particular post and retrieve all news
     */
    public function getAction() {


        View::renderTemplate("Post/index.html", [
            'post' =>PostModel::findById($this->route_params["id"]),
            'postCategory'=> PostModel::getPostCategoty(),
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
     * Create Post
     *
     * @return true if succesfull , false otherwise
     */

    public function createAction()
    {

        $post = new PostModel($_POST);

        $post->setFile($_FILES['post_image']);

        if ($post->save('create')) {

            Flash::addMessage("Post Added Succesfully");
            $this->redirect("/admin/post/show");

        } else {

            Flash::addMessage("Post couldn't be added", Flash::WARNING);
            $this->redirect("/admin/post/show");

        }

    }



    /**
     * Edit the Post
     * @return void
     */
    public function editAction() {


        View::renderTemplate("Post/index.html",[
            "member" => PostModel::findById($this->route_params["id"]),
            "postCategory"=> PostModel::getPostCategoty(),
        ]);
    }
    
    
    
    function updateAction() {

        $post = new PostModel($_POST);

        $post->setFile($_FILES['post_image']);

        if ($post->save('update',$this->route_params["id"])) {

            Flash::addMessage("Post updated succesfully");
            $this->redirect("/admin/post/show");

        }else{

            Flash::addMessage("Photo couldn't be updated", Flash::WARNING);
            $this->redirect("/admin/post/show");

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
