<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;
use App\Helper;
use App\Admin\Models\Feedback as FeedbackModel;

class Feedback extends \App\Controllers\Authenticated {

    public function showAction() {
        
         $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        
        View::renderTemplate("Feedback/index.html",[
            'feedbacks' => FeedbackModel::getFeedback($page, 5, FeedbackModel::class),
            "pages" => FeedbackModel::getPages($page, 5, FeedbackModel::class),
            "current_page" => $page,
        ]);
    }
    
    
    

    public function addAction() {
        View::renderTemplate("Feedback/index.html");
    }
    
    
        public function editAction()
    {

        View::renderTemplate("Feedback/index.html" , [
            "feedback" => FeedbackModel::findById($this->route_params["id"]),
          
        ]);
        


    }
    
        public function updateAction()
    {

        $feedback = new FeedbackModel($_POST);

        $feedback->setFile($_FILES['photo']);

        $id = $this->route_params["id"];

        if ($feedback->save('update', $id)) {

            Flash::addMessage("Changes Saved");

            $this->redirect("/admin/feedback/show");

        } else {

            $message = join(",", $feedback->errors);

            Flash::addMessage("Problem " . $message, Flash::WARNING);

            $this->redirect("/admin/feedback/show");

        }

    }
    
    
        public function deleteAction()
    {

        if (FeedbackModel::deleteById($this->route_params["id"])) {

            Flash::addMessage("Feedback Deleted Succesfully");
            $this->redirect("/admin/feedback/show");

        } else {

            Flash::addMessage("Feedback didn't deleted", Flash::WARNING);
            $this->redirect("/admin/feedback/show");

        }

    }
    
    
    
        public function createAction() {

        $feedback = new FeedbackModel($_POST);

        $feedback->setFile($_FILES['photo']);

        if ($feedback->save('create')) {

            Flash::addMessage("Success");
            $this->redirect("/admin/feedback/show");

        } else {

            Flash::addMessage("Something went wrong", Flash::WARNING);
            $this->redirect("/admin/feedback/add");
        }

    }
    
    
    
    

}
