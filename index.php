<?php include("wigbi/wigbi.php"); 


			$cookie1 = new Cookie("foo");
			$cookie2 = new Cookie("bar");
			
			$cookie1->set("foo", "bar");
			$cookie2->set("bar", "foo");
			

?>