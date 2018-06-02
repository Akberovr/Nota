<?php

	ob_start();


	/**
	 * Azerbaijan/Baku time zone
	 */

	date_default_timezone_set('Asia/Baku');


	/**Twig*/

	require dirname(__DIR__) . '/vendor/autoload.php';

	/**Autoloader*/

	spl_autoload_register(function($class){

		$root = dirname(__DIR__); // get the parent directory
		$file = $root .'/'.str_replace('\\', '/', $class).".php";

		if (file_exists($file) && is_readable($file)) {

			require $root.'/'.str_replace('\\','/',$class).".php";

		}
	});

	/**
	 * Error and Exception handling
	*/

	set_error_handler('Core\Error::errorHandler');
	set_exception_handler('Core\Error::exceptionHandler');
	error_reporting(E_ALL);

	/**
	 *  Session
	*/

	session_start();

	/**
	 * Routing
	*/
	$router = new Core\Router();
	// Add the Routes
	// Route Table

	$router->add('', ['controller' => 'Home', 'action' => 'index']);
	$router->add('home', ['controller' => 'Home', 'action' => 'index']);
	$router->add('login',['controller'=>'Login','action'=>'new']);
	$router->add('logout',['controller'=>'Login','action'=>'destroy']);
	$router->add('signup',['controller'=>'Signup','action'=>'new']);
	$router->add('news',['controller'=>'News','action'=>'index']);
	$router->add('course/{id:\d+}',['controller'=>'Course','action'=>'course']);
	$router->add('courses/{name:[a-z0-9-]+}/{id:\d+}',['controller'=>'Course','action'=>'index']);
	$router->add('partners',['controller'=>'Partner','action'=>'index']);
	$router->add('instructors',['controller'=>'Instructors','action'=>'index']);
	$router->add('instructor/{id:\d+}',['controller'=>'Instructors','action'=>'show']);
	$router->add('documents',['controller'=>'Document','action'=>'index']);
	$router->add('news/{title:[a-z0-9-]+}',['controller'=>'News','action'=>'show']);
	$router->add('announce/{title:[a-z0-9-]+}',['controller'=>'Post','action'=>'announce']);
	$router->add('event/{title:[a-z0-9-]+}',['controller'=>'Post','action'=>'event']);
	$router->add('article/{title:[a-z0-9-]+}',['controller'=>'Post','action'=>'article']);
	$router->add('announces',['controller'=>'Post','action'=>'announces']);
	$router->add('events',['controller'=>'Post','action'=>'events']);
	$router->add('articles',['controller'=>'Post','action'=>'articles']);
	$router->add('staff',['controller'=>'Staff','action'=>'index']);
	$router->add('staff/{title:[a-z0-9-]+}',['controller'=>'Staff','action'=>'show']);
	$router->add('about',['controller'=>'Home','action'=>'about']);
	$router->add('about/{name:[a-z0-9-]+}/{id:\d+}',['controller'=>'Home','action'=>'show']);
	$router->add('question',['controller'=>'Question','action'=>'index']);
	$router->add('call',['controller'=>'Call','action'=>'index']);
	$router->add('register',['controller'=>'Register','action'=>'index']);
	$router->add('register/{id:\d+}',['controller'=>'Register','action'=>'getTraining']);
	$router->add('teacher',['controller'=>'teacher','action'=>'index']);
	$router->add('resource',['controller'=>'Resource','action'=>'index']);
	$router->add('resource/{id:\d+}',['controller'=>'Register','action'=>'getTraining']);
	$router->add('resource/{ids:\d+}/{id:\d+}',['controller'=>'Resource','action'=>'getResource']);
	$router->add('photo-gallery',['controller'=>'Gallery','action'=>'photos']);
$router->add('video-gallery',['controller'=>'Gallery','action'=>'videos']);
	$router->add('{controller}/{action}');
	$router->add('{controller}/{id:\d+}/{action}');
	$router->add('password/reset/{token:[\da-f]+}',['controller'=>'Password','action'=>'reset']);
	$router->add('signup/activate/{token:[\da-f]+}',['controller'=>'Signup','action'=>'activate']);
	$router->add("Admin",["namespace"=>'Admin',"controller"=>"home","action"=>"show"]);
	$router->add('Admin/{controller}/{action}', ['namespace'=>'Admin']);
	$router->add('Admin/{controller}/{action}/{id:\d+}', ['namespace'=>'Admin']);

	$url = $_SERVER['QUERY_STRING'] ;


	$router->dispatch(trim($url,'/'));

?>
