<?php

switch (Controller::action())
{
	case "about":
		View::addView("~/views/home/about.php");
		break;
		
	case "index":
		View::addView("~/views/home/index.php");
		break;
}

?>