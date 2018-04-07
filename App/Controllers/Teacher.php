<?php

/*
 * registration intented courses controller.  
 */

namespace App\Controllers;

use \Core\View;

class Teacher extends \Core\Controller {

    public function indexAction() {

        View::renderTemplate('Teacher/index.html');
    }

}
