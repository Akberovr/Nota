<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/3/2018
 * Time: 7:08 PM
 */

namespace App\Admin\Controllers;

use App\Flash;
use \Core\View;
use App\Admin\Models\Job;
use App\Admin\Models\Staff as ModelStaff;


class Staff extends \App\Controllers\Authenticated
{
    /**
     *Shows the index page
     *
     * @return void
     */

    public function showAction()
    {

        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        View::renderTemplate("Staff/index.html", [
            'staff' => ModelStaff::getStaff($page, 5, ModelStaff::class),
            "pages" => ModelStaff::getPages($page, 5, ModelStaff::class),
            "current_page" => $page,
        ]);

    }

    /**
     * Add a new Staff
     * @return void
     */
    public function addAction()
    {

        View::renderTemplate("Staff/index.html", [
            "categories" => Job::findAll()
        ]);

    }


    /**
     * Create a new staff member
     *
     * @return void
     */
    public function createAction()
    {

        $staff = new ModelStaff($_POST);

        $staff->setFile($_FILES['photo']);

        if ($staff->save('create')) {

            Flash::addMessage("Success");
            $this->redirect("/admin/staff/show");

        } else {

            Flash::addMessage("Something went wrong", Flash::WARNING);
            $this->redirect("/admin/staff/add");
        }

    }


    /**
     * Shows edit staff page and fetch staff info
     * @return void
     */
    public function editAction()
    {

        View::renderTemplate("Staff/index.html", [
            "member" => ModelStaff::findById($this->route_params["id"]),
            "categories" => Job::findAll()
        ]);

    }

    public function updateAction()
    {

        $staff = new ModelStaff($_POST);

        $staff->setFile($_FILES['photo']);

        $id = $this->route_params["id"];

        if ($staff->save('update', $id)) {

            Flash::addMessage("Changes Saved");

            $this->redirect("/admin/staff/show");

        } else {

            $message = join(",", $staff->errors);

            Flash::addMessage("Problem " . $message, Flash::WARNING);

            $this->redirect("/admin/staff/show");

        }

    }

    /**
     * Delete staff member
     *
     * @return True if staff deleted, False otherwise
     */

    public function deleteAction()
    {

        if (ModelStaff::deleteById($this->route_params["id"])) {

            Flash::addMessage("User Deleted Succesfully");
            $this->redirect("/admin/staff/show");

        } else {

            Flash::addMessage("User didn't deleted", Flash::WARNING);
            $this->redirect("/admin/staff/show");

        }

    }


}