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
use App\Paginate;
use App\Admin\Models\Photo;
use App\Admin\Models\Staff as ModelStaff;


class Staff extends \App\Controllers\Authenticated
{
    /**
     *Show the index page
     *
     *@return void
     */

    public function showAction(){

        View::renderTemplate("Staff/index.html");

    }

    /**
     * Add a new Staff
     * @return void
     */
    public function addAction(){

        View::renderTemplate("Staff/index.html");

    }

    /**
     * Edit the Staff
     * @return void
     */
    public function editAction(){

        View::renderTemplate("Staff/index.html");

    }

    /**
     * Create a new staff member
     *
     * @return void
     */
    public function createAction(){

        if (ModelStaff::save()){

            Flash::addMessage("Success");
            $this->redirect("/admin/staff/add");

        }else{

            Flash::addMessage("Something went wrong brother/sister",Flash::WARNING);
            $this->redirect("/admin/staff/add");
        }

    }
}