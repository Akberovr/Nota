<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/24/2018
 * Time: 9:00 PM
 */

namespace App\Admin\Controllers;

use Core\View;
use App\Flash;

use App\Admin\Models\Instructor as InstructorModel;

class Instructor extends \App\Controllers\Authenticated
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function show ()
    {

        View::renderTemplate("Instructor/index.html",[
            "instructors" => InstructorModel::getAll()
        ]);

    }

    /**
     * Add a new Instructor
     * @return void
     */
    public function addAction()
    {

        View::renderTemplate("Instructor/index.html");

    }

    /**
     * Create a new instructor
     *
     * @return void
     */
    public function createAction()
    {

        $staff = new InstructorModel($_POST);

        $staff->setFile($_FILES['photo']);

        if ($staff->save('create')) {

            Flash::addMessage("Success");
            $this->redirect("/admin/instructor/show");

        } else {

            Flash::addMessage("Something went wrong", Flash::WARNING);
            $this->redirect("/admin/instructor/show");
        }

    }


    /**
     * Shows edit staff page and fetch staff info
     * @return void
     */
    public function editAction()
    {

        View::renderTemplate("Instructor/index.html", [
            "instructor" => InstructorModel::findById($this->route_params["id"]),
        ]);

    }

    public function updateAction()
    {

        $staff = new InstructorModel($_POST);

        $staff->setFile($_FILES['photo']);

        $id = $this->route_params["id"];

        if ($staff->save('update', $id)) {

            Flash::addMessage("Changes Saved");

            $this->redirect("/admin/instructor/show");

        } else {

            $message = join(",", $staff->errors);

            Flash::addMessage("Problem " . $message, Flash::WARNING);

            $this->redirect("/admin/instructor/show");

        }

    }

    /**
     * Delete instructor
     *
     * @return True if instructor deleted, False otherwise
     */

    public function deleteAction()
    {

        if (InstructorModel::deleteById($this->route_params["id"])) {

            Flash::addMessage("Instructor Deleted Succesfully");
            $this->redirect("/admin/instructor/show");

        } else {


            Flash::addMessage("Instructor didn't deleted", Flash::WARNING);
            $this->redirect("/admin/instructor/show");

        }

    }
}