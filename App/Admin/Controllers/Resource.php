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
            'resource_id' => TrainingModel::findById($this->route_params["id"]),
        ]);
    }

    public function addAction() {
        View::renderTemplate("Resource/index.html", [
            'resources' => ResourceModel::findById($this->route_params["id"]),
            'resource_id' => TrainingModel::findById($this->route_params["id"]),
        ]);
    }

    public function createAction() {
        $resource = new ResourceModel($_POST);
        $id = $this->route_params["id"];

        if ($resource->create($this->route_params["id"])) {

            Flash::addMessage("Resource Added Succesfully");
            $this->redirect("/admin/resource/show/" . $id);
        } else {
            Flash::addMessage("There is an error occured");
            $this->redirect("/admin/resource/show/" . $id);
        }
    }

    public function getAction() {
        View::renderTemplate("Resource/index.html", [
            'resources' => ResourceModel::findById($this->route_params["id"]),
            'languages' => TrainingModel::getLingualInfo(),
            
        ]);
    }

    public function updateAction() {
        $resource = new ResourceModel($_POST);
        print_r("<pre>");
        print_r($resource);
        print_r("</pre>");

        if ($resource->update($this->route_params["id"])) {
            Flash::addMessage("Updated  Succesfully");
            $this->redirect("/admin/training/show");
        } else {
            Flash::addMessage("There is an error occured");
            $this->redirect("/admin/training/show");
        }
    }

    public function deleteAction() {

        $id = $this->route_params["id"];
        $post = ResourceModel::deleteById($id);
        
            Flash::addMessage("Resource deleted", Flash::SUCCESS);
            $this->redirect('/Admin/Training/show');
    }

    public function langAction() {

        View::renderTemplate("Resource/index.html", [
            'resources' => ResourceModel::findById($this->route_params["id"]),
            'languages' => TrainingModel::getLingualInfo(),
            'training' => ResourceModel::findTrainingId($this->route_params["id"]),
                
        ]);
    }

    public
            function translateAction() {

        $translate = new ResourceModel($_POST);

        print_r("<pre>");
        print_r($translate);
        print_r("</pre>");
        if ($translate->translate($this->route_params["id"])) {
            Flash::addMessage("Translated  Succesfully");
            $this->redirect("/admin/training/show");
        } else {
            Flash::addMessage("There is an error occured");
            $this->redirect("/admin/training/show");
        }
    }

}
