<?php

namespace App\Admin\Controllers;

use \Core\View;
use App\Flash;

class Training extends \App\Controllers\Authenticated {
    
        public function showAction() {
        View::renderTemplate("Training/index.html");
    }
    
    
    
    
}
