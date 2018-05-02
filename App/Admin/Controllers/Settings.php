<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/23/2018
 * Time: 6:34 PM
 */

namespace App\Admin\Controllers;

use App\Flash;
use Core\Model;
use Core\View;
use App\Admin\Models\Setting as ModelSetting;

class Settings extends \App\Controllers\Authenticated
{

    /**
     * Shows the index page
     *
     * @return void
     */

    public function list ()
    {

        View::renderTemplate('Settings/index.html');


    }

    public function slider()
    {

        View::renderTemplate('Settings/index.html');

        if(isset($_GET["create"])){


            $photo = new PhotoModel($_POST);

            $photo->setFile($_FILES['file']);




        }

    }

    /**
     * Adds new info to the related settings
     *
     * @returns void
     */

    public function add ()
    {
        if (isset($_GET["tab"],$_GET["section"])){


        }

        Flash::addMessage("Please Select so me category to set",Flash::WARNING);

        $this->redirect('/admin/settings/list');

    }

}