<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/14/2018
 * Time: 2:27 PM
 */

namespace App\Admin\Controllers;

use App\Paginate;
use Core\View;
use App\Flash;
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
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        View::renderTemplate("Photos/index.html",[
            "photos" => PhotoModel::getPhotos($page,4,PhotoModel::class),
            "pages"   => PhotoModel::getPages($page,4,PhotoModel::class),
            "current_page" => $page,
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

        $photo->setFile($_FILES['file']);

           if($photo->save()){

                 Flash::addMessage("Success Photo Uploaded" );

                 $this->redirect('/admin/photo/show');

         }else{

               $message = join(",", $photo->errors);

               Flash::addMessage($message, Flash::WARNING);

               $this->redirect('/admin/photo/add');


          }

    }


    /**
     * Delete photo from folder and DB
     *
     * @return void
     */

    public function deleteAction(){

        $id = $this->route_params["id"];
        $photo = new PhotoModel();

        $photo->deleteById($id);

            Flash::addMessage("Photo deleted succesfully");
            $this->redirect("/admin/photo/show");


    }





}



