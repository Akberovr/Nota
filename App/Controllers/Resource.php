<?php

/* 
 *  view intented resource controller.  
 */



namespace App\Controllers;
use \Core\View;


class Resource  extends \Core\Controller
{
    
    public function indexAction() {
        View::renderTemplate('Resource/index.html');
    }
    
    
    
    
    
    
}

