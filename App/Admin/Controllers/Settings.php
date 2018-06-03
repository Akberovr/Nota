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

    public function listAction ()
    {

        View::renderTemplate('Settings/index.html');


    }

    /**
     * Shows the slider page
     *
     * @return void
     */

    public function sliderAction()
    {

        View::renderTemplate('Settings/index.html',[
            "sliders" => ModelSetting::allSlider()
        ]);

    }

    public function editSliderAction ()
    {

        View::renderTemplate("Settings/index.html",[
            "slider" => ModelSetting::sliderByID($this->route_params["id"])
        ]);

    }
    /**
     * Adds new slider to the Database
     *
     * @return void
     */

    public function addSliderAction ()
    {

        $slider = new ModelSetting($_POST);

        $slider->setFile($_FILES["image"]);

        if ($slider->save('create')){

            Flash::addMessage("Slider Added Succesfully!");
            $this->redirect("/admin/settings/slider");

        }else{

            Flash::addMessage("Slider Couldn't be added!",Flash::WARNING);
            $this->redirect("/admin/settings/slider");

        }

    }

    /**
     * Update Slider data
     * @return mixed
     */

    public function updateSliderAction()
    {

        $setting = new ModelSetting($_POST);

        $setting->setFile($_FILES['image']);

        $id = $this->route_params["id"];

        if ($setting->save('update', $id)) {

            Flash::addMessage("Changes Saved");

            $this->redirect("/admin/settings/slider");

        } else {

            $message = join(",", $setting->errors);

            Flash::addMessage("Problem " . $message, Flash::WARNING);

            $this->redirect("/admin/settings/slider");

        }

    }
    /**
     * Deletes slider from Database
     *
     * @return void
     */

    public function deleteSliderAction ()
    {

        if (ModelSetting::deleteSlider($this->route_params["id"])){

            Flash::addMessage("Slider Deleted Succesfully!");
            $this->redirect("/admin/settings/slider");

        }else{

            Flash::addMessage("Slider Couldn't been deleted",Flash::WARNING);
            $this->redirect("/admin/settings/slider");
        }

    }


}