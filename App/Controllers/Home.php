<?php 

	
	namespace App\Controllers;
	use \Core\View;
	use \App\Auth;
	use \App\Mail;


	class Home extends \Core\Controller{


		/**
		 *Show the index page
		 *
		 *@return void
		*/

		public function indexAction(){

			View::renderTemplate('Home/index.html');

		}

        /**
         *Show the about page
         *
         *@return void
         */

        public function aboutAction(){

            View::renderTemplate('Home/about.html');

        }


	}




 ?>
