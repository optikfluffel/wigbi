<?php

//Include Wigbi (prepares Wigbi, so that it then can be started)
include "../wigbi/wigbi.php";

//Define shortcut help methods for the view
function sr($path){ return Wigbi::serverRoot($path); }
function cr($path){ return Wigbi::clientRoot($path); }
function psr($path){ print Wigbi::serverRoot($path); }
function pcr($path){ print Wigbi::clientRoot($path); }

//Get query string values that are set by root .htaccess routes
$controllerName = Context::current()->get("controller");
$actionName = Context::current()->get("action");

//Start Wigbi (this content area must be added to the HEAD tag)
MasterPage::open("wigbi-start");
	try { Wigbi::start(); }
	catch(Exception $e) { View::viewData("wigbi-error", $e); }
MasterPage::close();

//Initialize the controller by calling the correct class action
require($controllerName . "Controller.php");
eval ('$controller = new ' . $controllerName . 'Controller();');
$controller->action($actionName);
	
//Stop Wigbi (this content area is optional to add to the page)
MasterPage::open("wigbi-stop");
	Wigbi::stop();
MasterPage::close();

//Build the master page, which aborts itself if it is not used
MasterPage::build();

?>