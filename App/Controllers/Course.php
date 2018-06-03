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
use App\Models\Navigation as NavigationModel;

class Course extends \Core\Controller
{

    public function index ()
    {
        
        $id = $this->route_params["id"];
        $sef = $this->route_params["name"];


        View::renderTemplate('Course/courses.html',[
            'route_name' => $sef,
            'courses' => CourseModel::getTraining($id),
            'category' => CourseModel::getCategoryById($id),
            'trainings' => CourseModel::getCategory(),
            "navigation" => NavigationModel::getCategory()
        ]);

    }

    public function course ()
    {   
        
        $id = $this->route_params["id"];
        $sef = $this->route_params["names"];



        $courses = CourseModel::getCourse($sef);

        $course = CourseModel::getCourseById($id);


        $program  = explode(",",$course[0][8]);


        $field  = explode(",",$course[0][9]);


        $certificates  = explode(",",$course[0][10]);




        View::renderTemplate('Course/course.html',[
            'route_name' =>  $this->route_params["name"],
            'course_detail' => $courses,
            'course' => $course,
            'filtered' => CourseModel::getCourseByCategory($id),
            "navigation" => NavigationModel::getCategory(),
            "programs" => $program,
            "fields" => $field,
            "certificates" => $certificates,
        ]);

    }

}