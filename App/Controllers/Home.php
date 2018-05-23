<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Mail;
use App\Models\City as CityModel;
use App\Models\Home as ModelHome;

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

    public function search ()
    {

        if (isset($_POST["search"])){

            if (count(ModelHome::search($_POST["search"])) >= 1) {

                echo "Found";

            }else{

                echo "Not Found";
            }

        }

    }

}

?>
