<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Mail;
use App\Models\City as CityModel;

class Home extends \Core\Controller {

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction() {

        View::renderTemplate('Home/index.html');
    }

    /**
     * Show the about page
     *
     * @return void
     */
    public function aboutAction() {
        $city = CityModel::getCity();
        View::renderTemplate('Home/about.html', [
            'city' => $city,
        ]);
    }

    public function showAction() {
        $city = CityModel::getCity();
        View::renderTemplate('Home/about.html', [
            'city' => $city,
            'city_info' => CityModel::getCityInfo($this->route_params["id"]),
        ]);
    }

}

?>
