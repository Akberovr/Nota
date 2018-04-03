<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/2/2018
 * Time: 2:20 PM
 */

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;
use App\Admin\Models\City as CityModel;

class City extends \App\Controllers\Authenticated {

    /**
     * Show the index page
     *
     * @return void
     */
    
    
    
    public function showAction() {

        $city = CityModel::getCity();

        View::renderTemplate("City/index.html", [
            'city' => $city
        ]);
    }


    /**
     * shows add city page
     *
     * @return void
     */

    public function addAction(){

        View::renderTemplate("City/index.html");

    }


    /**
     * Create a new city
     *
     * @return void
     */
    public function createAction()
    {
        $city = new CityModel($_POST);

        if($city->save()){
            $this->redirect('/Admin/City/show');
        }else{
            echo "Problem";
        }


    }


    /**
     * Edit the city
     * @return void
     */
    public function getAction() {

        $id = $this->route_params["id"];
        
        $city = CityModel::findById($id);
        
        View::renderTemplate("City/index.html", [
            'city' => $city,
            'id' => $this->route_params['id']
        ]);
//        print_r("<pre>");
//        print_r($city);
//        print_r("</pre>");
    }
    
    function updateAction() {

         $city = new CityModel($_POST);

         $id = $this->route_params["id"];

         if($city->updateCity($id)){

          Flash::addMessage("Changes Saved");
          $this->redirect('/Admin/City/show');

        }else{
            echo "Problem";
        }
        
    }

    public function deleteAction() {

        $id = $this->route_params["id"];
        $city = CityModel::deleteById($id);

        Flash::addMessage("City deleted", Flash::SUCCESS);
        $this->redirect('/Admin/City/show');

    }

}
