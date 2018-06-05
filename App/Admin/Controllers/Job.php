<?php
/**
 * Created by PhpStorm.
 * User: akberovr
 * Date: 6/5/18
 * Time: 19:16
 */


namespace App\Admin\Controllers;

use Core\View;
use App\Flash;

use App\Admin\Models\Job as JobModel;

class Job extends \App\Controllers\Authenticated
{


    public function show ()
    {

        View::renderTemplate("Job/index.html",[
            "category" => JobModel::findAll(),
        ]);

    }


    public function addAction()
    {

        View::renderTemplate("Job/index.html");

    }


    public function createAction() {

        $category = new JobModel($_POST);

        if ($category->createCategory()) {

            Flash::addMessage("Success");
            $this->redirect("/admin/job/show");

        } else {

            Flash::addMessage("Something went wrong", Flash::WARNING);
            $this->redirect("/admin/job/show");
        }

    }

    public function  deleteAction(){

        $category  = new JobModel($_POST);


        if ($category->deleteById($this->route_params["id"])) {

            Flash::addMessage("User Deleted Succesfully");
            $this->redirect("/admin/job/show");

        } else {

            Flash::addMessage("User didn't deleted", Flash::WARNING);
            $this->redirect("/admin/job/show");

        }


    }

}