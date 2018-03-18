<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 12/29/2017
 * Time: 11:07 PM
 */
namespace App;

class Config {

    /**
     * Database host
     * @var string
     */

    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */

    const DB_NAME = 'egov_az';

    /**
     * Database user
     * @var string
     */

    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */

    const DB_PASS = '';

    /**
     * Show or hide error message on screen
     * @var beeloan
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
    */

     const SECRET_KEY = 'R5UCU0HU4tb3YRjCRoOQIvXXchp1yXPC';

    /**
     * Images path
     * @var string
     */

    const IMAGES =  "C:\\xampp\\htdocs\\Nota" ."\\". "public" ."\\". "images" ."\\";
}
