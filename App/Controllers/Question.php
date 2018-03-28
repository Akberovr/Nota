<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Controllers;
use \Core\View;
use App\Models\Question as QuestionModel;


class Question  extends \Core\Controller
{
    
    
     
    
    public function indexAction() {
        $question = QuestionModel::submitQuestion();
        View::renderTemplate('Question/index.html',$question);
        
            
    }
    
    
    
    
    
    
}
