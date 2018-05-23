<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/23/2018
 * Time: 10:55 PM
 */

namespace App\Admin\Controllers;

use App\Flash;
use Core\View;
use App\Admin\Models\Partner as PartnerModel;

class Partner extends \App\Controllers\Authenticated
{

    public function show ()
    {

        View::renderTemplate("Partners/index.html",[
            "partners" => PartnerModel::findAll()
        ]);

    }

    public function add ()
    {

        View::renderTemplate("Partners/index.html");

    }

    public function create ()
    {

        $partner = new PartnerModel($_POST);

        $partner->setFile($_FILES["image"]);

        if ($partner->save('create')){

            Flash::addMessage("Partner Added");
            $this->redirect("/admin/partner/show");

        }else{

            Flash::addMessage("Partner Didn't added",Flash::WARNING);
            $this->redirect("/admin/partner/show");

        }

    }

    public function delete ()
    {

        if (PartnerModel::deleteById($this->route_params["id"])) {

            Flash::addMessage("Partner Deleted Succesfully");
            $this->redirect("/admin/partner/show");

        } else {

            Flash::addMessage("Partner Couldn't be deleted", Flash::WARNING);
            $this->redirect("/admin/partner/show");

        }

    }
}