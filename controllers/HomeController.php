<?php

class HomeController extends Controller
{
	public function index()
	{
		View::add(Wigbi::serverRoot("views/home/index.php")); 
	}	
}

?>