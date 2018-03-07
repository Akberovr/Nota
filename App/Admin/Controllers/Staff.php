<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/3/2018
 * Time: 7:08 PM
 */

namespace App\Admin\Controllers;
use \Core\View;

class Staff extends \App\Controllers\Authenticated
{
    /**
     *Show the index page
     *
     *@return void
     */

    public function showAction(){

        View::renderTemplate("Staff/index.html");

    }

    /**
     * Add a new Staff
     * @return void
     */
    public function addAction(){

        View::renderTemplate("Staff/index.html");

    }

    /**
     * Edit the Staff
     * @return void
     */
    public function editAction(){

        View::renderTemplate("Staff/index.html");

    }
}