<?php include("wigbi/wigbi.php"); 


			$errorLog = new ErrorLog(array(ErrorLogType::email(), ErrorLogType::system()), "daniel.saidi@gmail.com", "subject:log\nContent-Type: text/html; charset=ISO-8859-1");
			$errorLog->log("Hej hej hej", LogMessageSeverity::alert());
			

?>