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

        $trainingCategory = TrainingModel::getTrainingCategory();

        View::renderTemplate("Training/index.html", [
            'trainingCategory' => $trainingCategory,
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

}
