<?php

namespace App\Controllers;

use App\Helper;
use \Core\View;
use \App\Auth;
use \App\Mail;
use App\Models\City as CityModel;
use App\Admin\Models\City as AdminCity;
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
            'cities' => $city,
        ]);
    }

    public function showAction() {

        $city = CityModel::getCity();
        $adminCity = new AdminCity();
        View::renderTemplate('Home/about.html', [

            'cities' => $city,
            "route_name" => $this->route_params["name"],
            "photos"  =>$adminCity->photoById($this->route_params["id"]),
            'city_info' => CityModel::getCityInfo($this->route_params["name"]),

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
