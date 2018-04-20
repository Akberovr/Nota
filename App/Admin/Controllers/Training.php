<?php

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;
use App\Admin\Models\Training as TrainingModel;

class Training extends \App\Controllers\Authenticated {

    public function showAction() {


        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        View::renderTemplate("Training/index.html", [
            'trainingCategory' => TrainingModel::getTrainingCategory(),
            'trainings' => TrainingModel::getTraining($page, 5, TrainingModel::class),
            'pages' => TrainingModel::getPages($page, 5, TrainingModel::class),
            "current_page" => $page,
        ]);
    }

    public function addAction() {

        View::renderTemplate("Training/index.html", [
            'trainingCategory' => TrainingModel::getTrainingCategory(),
            'trainingNames' => TrainingModel::findAll()
        ]);
    }

    public function createAction() {
        $training = new TrainingModel($_POST);

        if ($training->create()) {

            Flash::addMessage("Training Added Succesfully");
            $this->redirect("/admin/training/show");
        } else {
            Flash::addMessage("There is an error occured");
            $this->redirect("/admin/training/show");
        }
    }

    public function langAction() {
        
        View::renderTemplate("Training/index.html", [
            'trainings' => TrainingModel::findById($this->route_params["id"]),
            'languages' => TrainingModel::getLingualInfo(),
            
        ]);
    }

    public function translateAction() {

        $translate = new TrainingModel($_POST);

        if ($translate->translate($this->route_params["id"])) {
            Flash::addMessage("Translated  Succesfully");
            $this->redirect("/admin/training/show");
        } else {
            Flash::addMessage("There is an error occured");
            $this->redirect("/admin/training/show");
        }
    }

}
