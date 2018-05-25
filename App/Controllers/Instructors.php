<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/23/2018
 * Time: 11:28 AM
 */

namespace App\Controllers;
use Core\View;
use App\Admin\Models\Instructor as AdminInstructor;
use App\Models\Navigation as NavigationModel;

class Instructors extends \Core\Controller
{

    public function index ()
    {

        View::renderTemplate('Instructors/index.html',[
            "instructors" => AdminInstructor::getAll(),
            "navigation" => NavigationModel::getCategory()
                
        ]);

    }
    public function show ()
    {

        View::renderTemplate('Instructors/about.html',[
            "instructor" => AdminInstructor::findById($this->route_params["id"]),
            "navigation" => NavigationModel::getCategory()
        ]);

    }


}