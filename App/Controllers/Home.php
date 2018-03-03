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

//			Views::render('Home/index.php',[
//				'name' => 'Elshan',
//				'age'  => 21
//			]);

			View::renderTemplate('','Home/index.html');

		}


	}




 ?>
