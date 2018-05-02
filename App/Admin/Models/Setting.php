<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/25/2018
 * Time: 3:47 PM
 */

namespace App\Admin\Models;


use App\Flash;
use PDO;


class Setting extends \Core\Model
{

    public function __construct ($data=[])
    {
        foreach ((array)$data as $key => $value) {
            $this->$key = $value;
        };

    }

    public function add ($section)
    {
            switch ($section){

                case 'socials':
                    $this->addSocials();
                    break;
                case 'statuses':
                    $this->addStatuses();
                    break;
                case 'links':
                    $this->addLinks();
                    break;
                case 'contact':
                    $this->addContact();
                    break;
                default:
                    Flash::addMessage("Enter Valid URL");

            }

    }

    public static function create(){






    }



}