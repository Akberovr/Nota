<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/11/2018
 * Time: 5:31 PM
 */

namespace App\Controllers;
use \Core\View;
use \App\Admin\Models\Photo;
class Gallery extends \Core\Controller
{

    /**
     *Show the index page
     *
     *@return void
     */

    public function photosAction(){

        View::renderTemplate('Gallery/photo-gallery.html',["photos" => Photo::findAll()]);

    }

}