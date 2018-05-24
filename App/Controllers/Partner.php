<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/23/2018
 * Time: 11:12 AM
 */

namespace App\Controllers;
use Core\View;
use App\Admin\Models\Partner as AdminPartner;
class Partner extends \Core\Controller
{

    public function index ()
    {

        View::renderTemplate('Partners/index.html',[
            "partners" => AdminPartner::findAll()
        ]);

    }

}