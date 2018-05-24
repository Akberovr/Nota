<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/21/2018
 * Time: 12:47 PM
 */

namespace App\Controllers;
use \Core\View;

use App\Models\Course as CourseModel;

class Course extends \Core\Controller
{

    public function index ()
    {
        
        $id = $this->route_params["id"];

        View::renderTemplate('Course/courses.html',[
            'courses' => CourseModel::getTraining($id),
            'category' => CourseModel::getCategoryById($id),
            'trainings' => CourseModel::getCategory(),
        ]);

    }

    public function course ()
    {   
        
        $id = $this->route_params["id"];
        

        View::renderTemplate('Course/course.html',[
            'course' => CourseModel::getCourseById($id), 
            'filtered' => CourseModel::getCourseByCategory($id),
        ]);

    }

}