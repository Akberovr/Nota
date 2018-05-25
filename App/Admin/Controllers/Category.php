<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;
use App\Admin\Models\Category as CategoryModel;

class Category extends \App\Controllers\Authenticated {

    public function showAction() {

        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        View::renderTemplate("Category/index.html", [
            'trainingCategory' => CategoryModel::findAll(),
            'pages' => CategoryModel::getPages($page, 5, CategoryModel::class),
            "current_page" => $page,
        ]);
    }

    public function addAction() {
        View::renderTemplate("Category/index.html");
    }

    public function createAction() {
        $category = new CategoryModel($_POST);

        if ($category->create()) {

            Flash::addMessage("Category Added Succesfully");
            $this->redirect("/admin/category/show");
        } else {
            Flash::addMessage("There is an error occured");
            $this->redirect("/admin/category/show");
        }
    }

    public function deleteAction() {

        $id = $this->route_params["id"];
        $post = CategoryModel::deleteById($id);
        if ($post) {
            Flash::addMessage("CategoryModel deleted", Flash::SUCCESS);
            $this->redirect('/Admin/Category/show');
        } else {
            Flash::addMessage("Training deleted", Flash::SUCCESS);
            $this->redirect('/Admin/Category/show');
        }
    }

    public function getAction() {
        View::renderTemplate("Category/index.html", [
            'trainingCategory' => CategoryModel::findById($this->route_params["id"]),
        ]);
    }

    public function updateAction() {
        $category = new CategoryModel($_POST);
//        print_r("<pre>");
//        print_r($training);
//        print_r("</pre>");

        if ($category->update($this->route_params["id"])) {
            Flash::addMessage("Updated  Succesfully");
            $this->redirect("/admin/category/show");
        } else {
            Flash::addMessage("There is an error occured");
            $this->redirect("/admin/category/show");
        }
    }

}
