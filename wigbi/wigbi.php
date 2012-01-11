<?php

//Find wigbi root folder (cannot be placed in single file)
$wigbi_root = "";
while(!is_dir($wigbi_root . "wigbi/"))
	$wigbi_root = "../" . $wigbi_root;

//Define global variables
require($wigbi_root . "wigbi/wigbi.globals.php");

//Include all classes required to start Wigbi
require($wigbi_root . "wigbi/wigbi.include.php");

//Bootstrap Wigbi (this file can be replaced by setting $wigbi_bootstrapper)
require(isset($wigbi_bootstrapper) ? $wigbi_root . $wigbi_bootstrapper : $wigbi_root . "wigbi/wigbi.bootstrap.php");



//TODO:
//return str_replace("~/", Wigbi::webRoot(), $url);
//return str_replace("~/", Wigbi::serverRoot(), $url);
/*function psurl($url) { print UrlHandler::parseServerUrl($url); }
function pwurl($url) { print UrlHandler::parseWebUrl($url); }
function surl($url) { return UrlHandler::parseServerUrl($url); }
function wurl($url) { return UrlHandler::parseWebUrl($url); }*/

?>