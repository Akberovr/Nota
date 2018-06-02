<?php

/* 
 *  view intented resource controller.  
 */



namespace App\Controllers;
use App\Models\Navigation as NavigationModel;
use App\Models\Resource as ResourceModel;
use \Core\View;


class Resource  extends \Core\Controller
{
    
    public function indexAction() {

                
        View::renderTemplate('Resource/index.html',[
             "navigation" => NavigationModel::getCategory(),
            "training" => NavigationModel::getTraining(),
        ]);
    }


    public function  getResourceAction(){






        $id = $this->route_params["id"];

       $resource = ResourceModel::getResource($id);

       echo json_encode($resource);



    }






}

