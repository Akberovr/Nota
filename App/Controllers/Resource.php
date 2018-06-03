<?php

/* 
 *  view intented resource controller.  
 */



namespace App\Controllers;
use App\Models\Navigation as NavigationModel;
use \Core\View;


class Resource  extends \Core\Controller
{
    
    public function indexAction() {
        
          

       
                
        View::renderTemplate('Resource/index.html',[
             "navigation" => NavigationModel::getCategory(),
            "training" => NavigationModel::getTraining(),
        ]);
    }
    
    
    
    
    
    
}

