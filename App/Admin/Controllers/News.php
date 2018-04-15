<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/6/2018
 * Time: 1:41 PM
 */

namespace App\Admin\Controllers;

use App\Flash;
use Core\View;
use App\Paginate;
use App\Admin\Models\News as ModelNews;
use Carbon\Carbon;

class News extends \App\Controllers\Authenticated
{

    /**
     *Show the index page
     *
     *@return void
     */

    public function showAction(){

        $page = (isset($_GET['page'])) ? $_GET["page"]  : 1 ;

        View::renderTemplate("news/index.html",[

            "news"         => ModelNews::getNews($page,5,ModelNews::class),
            "pages"        => ModelNews::getPages($page,5,ModelNews::class),
            "current_page" => $page,

        ]);

    }

    /**
     * Add a new News
     * @return void
     */

    public function addAction(){

        View::renderTemplate("News/index.html");

    }


    /**
     * Shows edit news page and fetch staff info
     *
     * @return void
     */

    public function editAction(){

        View::renderTemplate("News/index.html",[
            "news" => ModelNews::findById($this->route_params["id"])
        ]);

    }

    /**
     * Delete specific news
     *
     * @return void
     */

    public function deleteAction(){

        if (ModelNews::deleteById($this->route_params["id"])){

            Flash::addMessage("News Deleted Succesfully");
            $this->redirect("/admin/news/show");

        }else{

            Flash::addMessage("News Couldn't be deleted",Flash::WARNING);
            $this->redirect("/admin/news/show");

        }

    }

    /**
     * Create News
     *
     * @return true if succesfull , false otherwise
     */

    public function createAction(){

        $news = new ModelNews($_POST);

        $news->setFile($_FILES['photo']);

        if ($news->save('create')){

            Flash::addMessage("News Added Succesfully");
            $this->redirect("/admin/news/show");

        }else{

            Flash::addMessage("News couldn't be added",Flash::WARNING);
            $this->redirect("/admin/news/show");

        }

    }

    /**
     * Update specific news
     *
     * @return true if successful ,else otherwise
     */

    public function updateAction(){

        
        $news = new ModelNews($_POST);
        
        $news->setFile($_FILES['image']);

        
        if ($news->save('update',$this->route_params["id"])) {
            
            Flash::addMessage("News updated succesfully");
            $this->redirect("/admin/news/show");
            
        }else{
            
            Flash::addMessage("Photo couldn't be updated", Flash::WARNING);
            $this->redirect("/admin/news/show");

        }
        
        
    }

}