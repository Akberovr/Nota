<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 12/29/2017
 * Time: 10:22 PM
 */


namespace Core;

use PDO;
use App\Config;

abstract class Model{

    /**
     * Get the PDO database connection
     *
     * @return void
     */


    protected static function getDB(){

        static $db = null;

        if ($db === null){

                $dsn = 'mysql:host='.Config::DB_HOST. ';dbname='.Config::DB_NAME. ';charset=utf8';
                $db = new \PDO($dsn ,Config::DB_USER,Config::DB_PASS);

                // Throw an Exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}