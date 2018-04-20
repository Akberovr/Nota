<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/29/2018
 * Time: 2:14 PM
 */

namespace App\Admin\Controllers;

use App\Flash;
use \Core\View;
use App\Admin\Models\Staff as ModelStaff;


class Job extends \App\Controllers\Authenticated
{

    /**
     *Show the index page
     *
     * @return void
     */

    public function showAction()
    {

        View::renderTemplate();

    }

    /**
     * Add a new Job
     * @return void
     */
    public function addAction()
    {

        View::renderTemplate();

    }

    /**
     * Edit the Job
     * @return void
     */
    public function editAction()
    {

        View::renderTemplate();

    }


    /**
     * Create a new staff member
     *
     * @return void
     */
    public function createAction()
    {

    }
}