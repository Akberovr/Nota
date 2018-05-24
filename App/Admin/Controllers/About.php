<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;
use App\Admin\Models\About as AboutModel;

class About extends \App\Controllers\Authenticated {

    /**
     * Load  about city
     *
     * @return void
     */
    public function getAction() {

        View::renderTemplate("About/index.html", [
            'about' => AboutModel::findAll(),
        ]);
    }

    public function updateAction() {
        $about = new AboutModel($_POST);

        if ($about->update()) {

            Flash::addMessage("Changes Saved");
            $this->redirect('/Admin/about/get');
        } else {
            echo "Problem";
        }
    }

}
