<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/14/2018
 * Time: 2:27 PM
 */

namespace App\Admin\Controllers;

use \Core\View;
use \App\Flash;
use App\Admin\Models\Photo as PhotoModel;

class Photo extends \App\Controllers\Authenticated
{
    /**
     *Show the index page
     *
     * @return void
     */
    public function showAction()
    {

        View::renderTemplate("Photos/index.html");

    }

    /**
     * shows add photo page
     *
     * @return void
     */

    public function addAction()
    {

        View::renderTemplate("Photos/index.html");

    }

    /**
     * Create a new city
     *
     * @return void
     */

    public function createAction()
    {


        $photo = new PhotoModel($_POST);

        $photo->setFile($_FILES['file_upload']);

           if($photo->save()){

                 Flash::addMessage("Success Photo Uploaded" );

                 $this->redirect('/admin/photo/show');

         }else{

               $message = join(",", $photo->errors);

               Flash::addMessage($message, Flash::WARNING);

               $this->redirect('/admin/photo/add');


          }

    }
}


