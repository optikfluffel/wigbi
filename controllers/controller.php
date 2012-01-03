<?php

/*
 * Wigbi is started and stopped in master page regions. Make sure
 * that the start output is printed inside the resulting HEAD tag.
 */

//Include Wigbi
include "../wigbi/wigbi.php";

//Setup the controller context
Controller::currentAction(Context::get("action"));

//Start Wigbi
MasterPage::openContentArea("wigbi-start");
	try { Wigbi::start(); }
	catch(Exception $e) { View::viewData("wigbi-error", $e); }
MasterPage::closeContentArea();

//Pass handling on to the controller
require(Context::get("controller") . "Controller.php");

//If the resulting view uses a master poge, build it
if (MasterPage::filePath())
	MasterPage::build();
	
//Stop Wigbi (will never be displayed)
MasterPage::openContentArea("wigbi-stop");
Wigbi::stop();
MasterPage::closeContentArea();

?>