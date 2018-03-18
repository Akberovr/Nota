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

        $photos = PhotoModel::getPhotos();

        View::renderTemplate("Photos/index.html",[
            "photos" => PhotoModel::getPhotos(),
            "round()" => PhotoModel::formatBytes()
        ]);

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


    public function deleteAction(){

        $id = $this->route_params["id"];
        $photo = new PhotoModel();
        if ($photo->deleteById($id)){

            Flash::addMessage("Photo Deleted Succesfully");
            $this->redirect("/admin/photo/show");
        }else{

            Flash::addMessage("Problemo",Flash::WARNING);
            $this->redirect("/admin/photo/show");

        }

    }


}


