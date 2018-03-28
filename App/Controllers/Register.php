<?php

/* 
 * registration intented courses controller.  
 */


namespace App\Controllers;
use \Core\View;


class Register  extends \Core\Controller
{
    
    public function indexAction() {
        View::renderTemplate('Register/index.html');
    }
    
    
    
    
    
    
}
