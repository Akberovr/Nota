<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/2/2018
 * Time: 2:20 PM
 */

namespace App\Admin\Controllers;
use \Core\View;

class City extends \App\Controllers\Authenticated
{
    /**
     *Show the index page
     *
     *@return void
     */

    public function showAction(){

        View::renderTemplate('Admin',"City/index.html");

    }

    /**
     * Add a new city
     * @return void
    */
    public function addAction(){

        View::renderTemplate('Admin',"City/index.html");

    }

}