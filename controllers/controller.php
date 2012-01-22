<?php

/*
 * Wigbi is started and stopped in master page regions. Make sure
 * that the start output is printed inside the resulting HEAD tag.
 */


//Include Wigbi
include "../wigbi/wigbi.php";

//Get query string values passed by routing
$controllerName = Context::current()->get("controller");
$actionName = Context::current()->get("action");

//Start Wigbi (this MUST be added to the HEAD tag)
MasterPage::open("wigbi-start");
	//try { Wigbi::start(); }
	//catch(Exception $e) { View::viewData("wigbi-error", $e); }
MasterPage::close();

//Initialize the controller (query string-based)
require($controllerName . "Controller.php");
eval ('$controller = new ' . $controllerName . '();');
$controller->action($actionName);
	
//Stop Wigbi (this does not have to be added to the page)
MasterPage::open("wigbi-stop");
	//Wigbi::stop();
MasterPage::close();

//Build the master page (aborts if not needed)
MasterPage::build();

?>