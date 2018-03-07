<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/3/2018
 * Time: 5:38 PM
 */

namespace App\Admin\Controllers;
use \Core\View;

class News extends \App\Controllers\Authenticated
{

    /**
     *Show the index page
     *
     *@return void
     */

    public function showAction(){

        View::renderTemplate("News/index.html");

    }

    /**
     * Add a new News
     * @return void
     */
    public function addAction(){

        View::renderTemplate("News/index.html");

    }

    /**
     * Edit the News
     * @return void
     */
    public function editAction(){

        View::renderTemplate("News/index.html");

    }


}