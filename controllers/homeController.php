<?php

switch (Controller::action())
{
	default:
		View::addView("~/views/home/index.php");
		break;
}

?>