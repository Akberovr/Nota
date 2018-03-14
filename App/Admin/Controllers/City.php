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
     * Add a new city
     * @return void
     */
    public function addAction() {
        $city = new CityModel($_POST);

        if (isset($_POST)) {
            if ($city->save()) {
                print_r("<pre>");
                print_r($city);
                print_r("</pre>");
            }
        }


        View::renderTemplate("City/photo-gallery.html");
    }

    /**
     * Edit the city
     * @return void
     */
    public function getAction() {

        $id = $this->route_params["id"];
        $city = CityModel::findById($id);

        View::renderTemplate("City/edit_city.html", [
            'city' => $city
        ]);
        print_r("<pre>");
        print_r($city);
        print_r("</pre>");
    }

    public function deleteAction() {

        $id = $this->route_params["id"];
        $city = CityModel::deleteById($id);

        Flash::addMessage("City deleted", Flash::SUCCESS);
        $this->redirect('/Admin/City/show');

        if ($_GET) {
            print_r($id);
        }
    }

}
