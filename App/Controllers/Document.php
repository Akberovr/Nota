<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/23/2018
 * Time: 11:15 AM
 */

namespace App\Controllers;
use Core\View;
use App\Models\Navigation as NavigationModel;
class Document extends \Core\Controller
{

    public function index ()
    {

        view::renderTemplate('Documents/index.html',[
             "navigation" => NavigationModel::getCategory()
        ]);

    }

}