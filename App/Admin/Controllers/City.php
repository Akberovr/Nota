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
use App\Helper;
use App\Admin\Models\City as CityModel;

class City extends \App\Controllers\Authenticated {

    /**
     * Show the index page
     *
     * @return void
     */



    public function showAction() {

        View::renderTemplate("City/index.html", [

            'city' => CityModel::getCity()

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

            Flash::addMessage("City Added Succefully!");
            $this->redirect('/Admin/City/show');

        }else{
            Flash::addMessage("City Couldn't Added Succefully!",Flash::WARNING);
            $this->redirect('/Admin/City/show');
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
        $city = new CityModel();
        $id = $this->route_params["id"];
        $city->deleteById($id);

        Flash::addMessage("City deleted", Flash::SUCCESS);
        $this->redirect('/Admin/City/show');

    }
    
    public function addPhoto ()
    {
        View::renderTemplate("City/index.html",[
            "id" => $this->route_params["id"]
        ]);

    }

    public function addImages ()
    {
        $city = new CityModel();

        $city->setFile($_FILES["file"]);

        if ($city->create($this->route_params["id"])){

            Flash::addMessage("Added");
            $this->redirect("/admin/city/show");

        }else{
            Flash::addMessage("Not Added",Flash::WARNING);
            $this->redirect("/admin/city/show");
        }

    }

}
