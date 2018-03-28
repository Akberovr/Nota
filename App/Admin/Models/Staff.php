<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/28/2018
 * Time: 5:36 PM
 */

namespace App\Admin\Models;


class Staff extends \Core\Model
{
    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */
    public function __construct($data = []) {

        foreach ($data as $key => $value) {

            $this->$key = $value;

        };

    }


    public static function save(){

        return false;

    }


}