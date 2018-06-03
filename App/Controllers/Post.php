<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/25/2018
 * Time: 1:14 AM
 */

namespace App\Controllers;
use Core\View;
use App\Admin\Models\Post as AdminPost;
use App\Models\Navigation as NavigationModel;

class Post extends \Core\Controller
{

    public function announcesAction ()
    {

        View::renderTemplate("Post/announces.html",[
            "announces" => AdminPost::getAnnounces(),
            "navigation" => NavigationModel::getCategory()
        ]);

    }

    public function eventsAction ()
    {

        View::renderTemplate("Post/events.html",[
            "events" => AdminPost::getEvents(),
            "navigation" => NavigationModel::getCategory()
        ]);

    }

    public function articlesAction ()
    {

        View::renderTemplate("Post/articles.html",[
            "articles"  => AdminPost::getArticles(),
            "navigation" => NavigationModel::getCategory()
        ]);

    }

    /**
     * Show the specific news page
     *
     * @return void
     */

    public function announceAction(){

        View::renderTemplate('Post/announce_detail.html',[
            "member" => AdminPost::findByUrl($this->route_params["title"]),
            "navigation" => NavigationModel::getCategory()
        ]);

    }

    /**
     * Show the specific news page
     *
     * @return void
     */

    public function eventAction(){

        View::renderTemplate('Post/event_detail.html',[
            "member" => AdminPost::findByUrl($this->route_params["title"]),
            "navigation" => NavigationModel::getCategory()
        ]);

    }

    /**
     * Show the specific news page
     *
     * @return void
     */

    public function articleAction(){

        View::renderTemplate('Post/article.html',[
            "member" => AdminPost::findByUrl($this->route_params["title"]),
            "navigation" => NavigationModel::getCategory()
        ]);

    }
}