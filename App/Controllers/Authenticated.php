<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/2/2018
 * Time: 1:19 PM
 */

namespace App\Controllers;


abstract class Authenticated extends \Core\Controller
{

    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     * @return void
     */
    protected function before(){
        $this->requireLogin();
    }

}