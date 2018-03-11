<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/11/2018
 * Time: 5:35 PM
 */

namespace App\Controllers;
use \Core\View;

class Staff extends \Core\Controller
{

    /**
     *Show the index page
     *
     *@return void
     */

    public function indexAction(){

        View::renderTemplate('Staff/index.html');

    }

}