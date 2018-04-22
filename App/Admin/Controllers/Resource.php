<?php

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;
use App\Admin\Models\Resource as ResourceModel;
use App\Admin\Models\Training as TrainingModel;

class Resource extends \App\Controllers\Authenticated {

    public function showAction() {


        $page = isset($_GET["page"]) ? $_GET["page"] : 1;


        View::renderTemplate("Resource/index.html", [
            'resources' => ResourceModel::getResource($this->route_params["id"], $page, 5, ResourceModel::class),
            'pages' => ResourceModel::getPages($page, 5, ResourceModel::class),
            'current_page' => $page,
        ]);
    }

    public function addAction() {
        View::renderTemplate("Resource/index.html");
    }

    public function langAction() {

        View::renderTemplate("Training/index.html", [
            'resources' => ResourceModel::findById($this->route_params["id"]),
            'languages' => TrainingModel::getLingualInfo(),
        ]);
    }

}
