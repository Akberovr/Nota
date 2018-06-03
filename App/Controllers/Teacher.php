<?php

/*
 * registration intented courses controller.  
 */

namespace App\Controllers;

use \Core\View;

use App\Models\Navigation as NavigationModel;

class Teacher extends \Core\Controller {

    public function indexAction() {

        View::renderTemplate('Teacher/index.html',[
             "navigation" => NavigationModel::getCategory()
        ]);
    }

}
