<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use \Core\View;
use App\Models\City as CityModel;

class About extends \Core\Controller {

    public function showAction() {

        $city = CityModel::getCityInfo($this->route_params["id"]);
        print_r($city);
        View::renderTemplate('Home/about.html', [
            "city" => $city,
        ]);
    }

}
