<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;


use \Core\View;
use App\Models\City as CityModel;

class City extends \Core\Controller
{
   public  function indexAction() {
        $city = CityModel::getCity();
        
    }
    
}


