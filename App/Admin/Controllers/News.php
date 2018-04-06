<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/6/2018
 * Time: 1:41 PM
 */

namespace App\Admin\Controllers;

use Core\Flash;
use Core\View;
use App\Paginate;
use App\Admin\Models\News as ModelNews;

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
            "current_page" => $page

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

        View::renderTemplate("news/index.html");

    }

    /**
     * Delete specific news
     *
     * @return void
     */

    public function deleteAction(){

        //Delete

    }

    /**
     * Create News
     *
     * @return true if succesfull , false otherwise
     */

    public function createAction(){

        // Create new news HTTP POST method

    }

    /**
     * Update specific news
     *
     * @return true if succesfull ,else otherwise
     */

    public function updateAction(){

        // Update news via HTTP GET method

    }

}