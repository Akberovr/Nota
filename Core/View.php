<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 12/19/2017
 * Time: 6:59 PM
 */

namespace Core;


class View
{


    /**
     * Render a view file
     *
     * @param string $view The view file
     *
     * @return void
     */

    public static function render($view, $args = [])
    {

        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; // Views files are stored at App/Views

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }

    }

    public static function renderTemplate($viewLocation = null,$template, $args = [])
    {
        echo static::getTemplate($viewLocation,$template, $args);
    }


    public static function getTemplate($viewLocation = null,$template, $args = [])
    {

        static $twig = null;

        if ($twig === null) {

            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/'.$viewLocation.'/Views');
            $twig = new \Twig_Environment($loader);
            //$twig->addGlobal('session',$_SESSION);
            // $twig->addGlobal('is_logged_in',\App\Auth::isLoggedIn());
            $twig->addGlobal('current_user', \App\Auth::getUser());
            $twig->addGlobal('flash_messages', \App\Flash::getMessage());
            $twig->addGlobal('source' , \App\Helper::getURL());

        }

        return $twig->render($template, $args);
    }




}