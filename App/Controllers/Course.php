<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/21/2018
 * Time: 12:47 PM
 */

namespace App\Controllers;
use \Core\View;

class Course extends \Core\Controller
{

    public function index ()
    {

        View::renderTemplate('Course/courses.html');

    }

    public function course ()
    {

        View::renderTemplate('Course/course.html');

    }

}