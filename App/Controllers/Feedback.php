<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



namespace App\Controllers;

use \Core\View;
use App\Models\Feedback as FeedbackModel;



class Feedback extends \Core\Controller {
    public function showAction() {
        
      

        View::renderTemplate('Includes/testimonials.html',[
            
            "feedback" =>  FeedbackModel::getFeedback(),
            
        ]);
    }
    
    
}


