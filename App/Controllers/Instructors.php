<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/23/2018
 * Time: 11:28 AM
 */

namespace App\Controllers;
use Core\View;

class Instructors extends \Core\Controller
{

    public function index ()
    {

        View::renderTemplate('Instructors/index.html');

    }


}