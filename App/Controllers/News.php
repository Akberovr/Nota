<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/11/2018
 * Time: 5:31 PM
 */

namespace App\Controllers;

use Core\View;
use App\Paginate;
use App\Admin\Models\News as ModelNews;


class News extends \Core\Controller
{


    /**
     *Show the index page
     *
     *@return void
     */

    public function indexAction(){

        $page = isset($_GET["page"]) ? $_GET["page"] : 1 ;
        
        View::renderTemplate('News/index.html',[
            
            "news"    => ModelNews::getNews($page,4, ModelNews::class),
            "pages"   => ModelNews::getPages($page,5,ModelNews::class),
            "current_page" => $page
                
        ]);

    }

    /**
     * Show the specific news page
     *
     * @return void
     */

    public function showAction(){

        View::renderTemplate('News/index.html',[
            "member" => ModelNews::findById($this->route_params["id"])
        ]);

    }




}