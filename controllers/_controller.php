<?php

/*
 * Note: Wigbi is started and stopped in master page regions make sure
 * that the page output is controlled. Make sure that the start output
 * is printed to the resulting HEAD tag, otherwise Wigbi will not work.
 */

//Include and start Wigbi
include "../wigbi/wigbi.php";
MasterPage::openContentArea("wigbi-start");
	try { Wigbi::start(); }
	catch(Exception $e) { View::viewData("wigbi-error", $e); }
MasterPage::closeContentArea();

//Pass handling on to the controller
require(Controller::name() . "Controller.php");

//Stop Wigbi
MasterPage::openContentArea("wigbi-stop");
Wigbi::stop();
MasterPage::closeContentArea();

//If the resulting view uses a master poge, build it
if (MasterPage::filePath())
	MasterPage::build();

?>