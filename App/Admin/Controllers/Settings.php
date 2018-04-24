<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/23/2018
 * Time: 6:34 PM
 */

namespace App\Admin\Controllers;

use \Core\View;

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

    /**
     * Shows the slider page
     *
     * @return void
     */


    public function slider()
    {

        View::renderTemplate("Settings/index.html");

    }

    /**
     * Shows the footer page
     *
     * @return void
     */


    public function footer()
    {

        View::renderTemplate("Settings/index.html");

    }

}