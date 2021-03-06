<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use \Core\View;
use App\Models\City as CityModel;

class City extends \Core\Controller {

    public function indexAction() {
        $city = CityModel::getCity();
    }

    public function showAction() {
        
        $city = CityModel::getCityInfo($this->route_params["id"]);

        View::renderTemplate('Home/about.html');
    }
    
    public function aboutAction() {
         $about = CityModel::getAboutInfo();
         View::renderTemplate('Home/about.html', [
            "about" => $about,
        ]);
    }
    

}
