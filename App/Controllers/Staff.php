<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/11/2018
 * Time: 5:35 PM
 */

namespace App\Controllers;

use \Core\View;
use App\Admin\Models\Staff as ModelStaff;
use App\Models\Navigation as NavigationModel;


class Staff extends \Core\Controller
{

    /**
     *Show the index page
     *
     *@return void
     */

    public function indexAction(){

        View::renderTemplate('Staff/index.html',[
            "members" => ModelStaff::findAll(),
            "navigation" => NavigationModel::getCategory()
        ]);

    }

    public function showAction(){
        View::renderTemplate('Staff/about_staff.html',[
            "member" => ModelStaff::findByUrl($this->route_params["title"]),
            "navigation" => NavigationModel::getCategory()
        ]);
    }

}