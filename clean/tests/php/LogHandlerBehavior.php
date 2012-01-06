<?php

class LogHandlerBehavior extends UnitTestCase
{
	private $logFolder;
	private $logFile1;
	private $logFile2;
	private $logFile3;
	private $logFile4;
	private $logFile5;
	private $logHandler;
	


	function LogHandlerBehavior()
	{
		$this->UnitTestCase("LogHandler");
	}
	
	function setUp()
	{
		$this->logHandler = new LogHandler("id");
		
		$this->logFolder = Wigbi::serverRoot() . "log/";
		$this->logFile1 = $this->logFolder . "file1.txt";
		$this->logFile2 = $this->logFolder . "file2.txt";
		$this->logFile3 = $this->logFolder . "file3.txt";
		$this->logFile4 = $this->logFolder . "file4.txt";
		$this->logFile5 = $this->logFolder . "file5.txt";
	}
	
	function tearDown()
	{
		if (file_exists($this->logFile1))
			unlink($this->logFile1);
		if (file_exists($this->logFile2))
			unlink($this->logFile2);
		if (file_exists($this->logFile3))
			unlink($this->logFile3);
		if (file_exists($this->logFile4))
			unlink($this->logFile4);
		if (file_exists($this->logFile5))
			unlink($this->logFile5);
		if (is_dir($this->logFolder))
			rmdir($this->logFolder);
	}
	
	
	
	function test_constructor_shouldInitializeDefaultObject()
	{
		$this->logHandler = new LogHandler();
		
		$this->assertEqual($this->logHandler->id(), "");
	}
	
	function test_constructor_shouldInitializeCustomObject()
	{
		$this->logHandler = new LogHandler("id");
		
		$this->assertEqual($this->logHandler->id(), "id");
	}
			
	
	
	function test_handlers_shouldReturnEmptyArrayByDefault()
	{
		$this->assertEqual(gettype($this->logHandler->handlers()), "array");
		$this->assertEqual(sizeof($this->logHandler->handlers()), 0);
	}
	
	function test_id_shouldGetSetValue()
	{
		$this->assertEqual($this->logHandler->id(), "id");
		$this->assertEqual($this->logHandler->id("newId"), "newId");
		$this->assertEqual($this->logHandler->id(), "newId");
	}
	
	
	function test_addHandler_shouldAddMultipleHandlers()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), true, "foobar", true, "foobar", true, true);
		$this->logHandler->addHandler(array(0,7), false, "foo bar", false, "foo bar", false, false);
		$handlers = $this->logHandler->handlers();
		
		$this->assertEqual(sizeof($handlers), 2);
		
		$handler  = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(0,1,2,3,4,5,6,7));
		$this->assertTrue($handler["display"]);
		$this->assertEqual($handler["file"], "foobar");
		$this->assertTrue($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "foobar");
		$this->assertTrue($handler["syslog"]);
		$this->assertTrue($handler["window"]);
		
		$handler  = $handlers[1];
		
		$this->assertEqual($handler["priorities"], array(0,7));
		$this->assertFalse($handler["display"]);
		$this->assertEqual($handler["file"], "foo bar");
		$this->assertFalse($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "foo bar");
		$this->assertFalse($handler["syslog"]);
		$this->assertFalse($handler["window"]);
	}
	
	function test_addHandler_shouldAddDisplayHandler()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), true, "", false, "", false, false);
		$handlers = $this->logHandler->handlers();
		
		$handler  = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(0,1,2,3,4,5,6,7));
		$this->assertTrue($handler["display"]);
		$this->assertEqual($handler["file"], "");
		$this->assertFalse($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "");
		$this->assertFalse($handler["syslog"]);
		$this->assertFalse($handler["window"]);
	}
	
	function test_addHandler_shouldAddFileHandler()
	{
		$this->logHandler->addHandler(array(0,1), false, $this->logFile1, false, "", false, false);
		$handlers = $this->logHandler->handlers();
		$handler  = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(0,1));
		$this->assertFalse($handler["display"]);
		$this->assertEqual($handler["file"], $this->logFile1);
		$this->assertFalse($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "");
		$this->assertFalse($handler["syslog"]);
		$this->assertFalse($handler["window"]);
	}
	
	function test_addHandler_shouldAddFirebugHandler()
	{
		$this->logHandler->addHandler(array(6,7), false, "", true, "", false, false);
		$handlers = $this->logHandler->handlers();
		$handler  = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(6,7));
		$this->assertFalse($handler["display"]);
		$this->assertEqual($handler["file"], "");
		$this->assertTrue($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "");
		$this->assertFalse($handler["syslog"]);
		$this->assertFalse($handler["window"]);
	}
	
	function test_addHandler_shouldAddMailHandler()
	{
		$this->logHandler->addHandler(array(0), false, "", false, "daniel.saidi@gmail.com, daniel.saidi@hotmail.com", false, false);
		$handlers = $this->logHandler->handlers();
		$handler  = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(0));
		$this->assertFalse($handler["display"]);
		$this->assertEqual($handler["file"], "");
		$this->assertFalse($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "daniel.saidi@gmail.com, daniel.saidi@hotmail.com");
		$this->assertFalse($handler["syslog"]);
		$this->assertFalse($handler["window"]);
	}
	
	function test_addHandler_shouldAddSyslogHandler()
	{
		$this->logHandler->addHandler(array(7), false, "", false, "", true, false);
		$handlers = $this->logHandler->handlers();
		$handler  = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(7));
		$this->assertFalse($handler["display"]);
		$this->assertEqual($handler["file"], "");
		$this->assertFalse($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "");
		$this->assertTrue($handler["syslog"]);
		$this->assertFalse($handler["window"]);
	}
	
	function test_addHandler_shouldAddWindowHandler()
	{
		$this->logHandler->addHandler(array(7), false, "", false, "", false, true);
		$handlers = $this->logHandler->handlers();
		$handler  = $handlers[0];
		
		$this->assertEqual($handler["priorities"], array(7));
		$this->assertFalse($handler["display"]);
		$this->assertEqual($handler["file"], "");
		$this->assertFalse($handler["firebug"]);
		$this->assertEqual($handler["mailaddresses"], "");
		$this->assertFalse($handler["syslog"]);
		$this->assertTrue($handler["window"]);
	}
	
	function test_log_twoParams_shouldReturnFalseForNoLogHandlers()
	{
		$this->assertFalse($this->logHandler->log("A log message", 0));
	}
	
	function test_log_twoParams_shouldReturnTrueButIgnoreIrrelevantPriority()
	{
		$this->logHandler->addHandler(array(1,2,3,4,5,6,7), true, $this->logFile1, true, "daniel.saidi@gmail.com", true, true);
		
		ob_start();
		$result = $this->logHandler->log("A log message", 0);
		$output = " " . ob_get_clean();
		
		$this->assertTrue($result);
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "LogWindow = window.open"));
	}
	
	function test_log_twoParams_displayLogHandlerShouldOnlyLogToScreen()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), true, "", false, "", false, false);
		
		ob_start();
		$result = $this->logHandler->log("A log message", 0);
		$output = " " . ob_get_clean();
		
		$this->assertTrue($result);
		$this->assertTrue(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "LogWindow = window.open"));
	}
	
	function test_log_twoParams_fileLogHandlerShouldOnlyCreateFileWithContent()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, $this->logFile1, false, "", false, false);
		
		ob_start();
		$result = $this->logHandler->log("A log message", 0);
		$fileContent = file_get_contents($this->logFile1);
		$output = " " . ob_get_clean();
		
		$this->assertTrue($result);	
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertTrue(file_exists($this->logFile1));
		$this->assertTrue(strpos($fileContent, $this->logHandler->id() . " [emergency] A log message"));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "LogWindow = window.open"));
	}
	
	function test_log_twoParams_firebugLogHandlerShouldOnlyAddFirebugCodeToPage()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", true, "", false, false);
		
		ob_start();
		$result = $this->logHandler->log("A log message", 0);
		$output = " " . ob_get_clean();
		
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertTrue(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "LogWindow = window.open"));
	}
	
	function test_log_twoParams_mailLogHandlerShouldOnlySendEmail()
	{
		//TODO - How do we test that an e-mail is sent?
		//$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", true, array("daniel.saidi@gmail.com"), false, false);
	}
	
	function test_log_twoParams_syslogLogHandlerShouldOnlyLogToSystemLog()
	{
		//TODO - How do we test that the system log has received the log message? 
		//$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", false, array(), true, false);
	}
	
	function test_log_twoParams_windowLogHandlerShouldOnlyAddWindowScriptToCode()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", false, "", false, true);
		
		ob_start();
		$result = $this->logHandler->log("A log message", 0);
		$output = " " . ob_get_clean();
		
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertTrue(strpos($output, "LogWindow = window.open"));
	}
	
	function test_log_twoParams_logHandlerShouldHandleMultipleTargets()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), true, $this->logFile2, true, "", true, true);
		
		ob_start();
		$result = $this->logHandler->log("A log message", 0);
		$output = " " . ob_get_clean();
		
		$this->assertTrue(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertTrue(file_exists($this->logFile2));
		$this->assertTrue(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is sent?
		//TODO - How do we test that the system log has received the log message? 
		$this->assertTrue(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
	
	function test_log_twoParams_logHandlerShouldHandleMultipleSubHandlers()
	{
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), true, "", false, "", false, false);
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, $this->logFile3, false, "", false, false);
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", true, "", false, false);
		//$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", false, "daniel.saidi@gmail.com", false, false);
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", false, "", true, false);
		$this->logHandler->addHandler(array(0,1,2,3,4,5,6,7), false, "", false, "", false, true);
		
		ob_start();
		$result = $this->logHandler->log("A log message", 0);
		$output = " " . ob_get_clean();
		
		$this->assertTrue(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertTrue(file_exists($this->logFile3));
		$this->assertTrue(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is sent?
		//TODO - How do we test that the system log has received the log message? 
		$this->assertTrue(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
	
	function test_log_allParams_shouldReturnFalseForNoLogHandlers()
	{
		$this->assertTrue($this->logHandler->log("A log message", 0, false, "", false, "", false, false));
	}
	
	function test_log_allParams_shouldNotTriggerDisabledTargets()
	{
		ob_start();
		$result = $this->logHandler->log("A log message", 0, false, "", false, "", false, false);
		$output = " " . ob_get_clean();
		
		$this->assertTrue($result);
		
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
	
	function test_log_allParams_displayLogHandlerShouldOnlyLogToScreen()
	{
		ob_start();
		$result = $this->logHandler->log("A log message", 0, true, "", false, "", false, false);
		$output = " " . ob_get_clean();
		
		$this->assertTrue($result);
		
		$this->assertTrue(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
	
	function test_log_allParams_fileLogHandlerShouldOnlyCreateFileWithContent()
	{
		ob_start();
		$result = $this->logHandler->log("A log message", 0, false, $this->logFile4, false, "", false, false);
		$fileContent = file_get_contents($this->logFile4);
		$output = " " . ob_get_clean();
		
		$this->assertTrue($result);
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertTrue(file_exists($this->logFile4));
		$this->assertTrue(strpos($fileContent, $this->logHandler->id() . " [emergency] A log message"));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
	
	function test_log_allParams_firebugLogHandlerShouldOnlyAddFirebugCodeToPage()
	{
		ob_start();
		$result = $this->logHandler->log("A log message", 0, false, "", true, "", false, false);
		$output = " " . ob_get_clean();
		
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertTrue(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertFalse(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
	
	function test_log_allParams_mailLogHandlerShouldOnlySendEmail()
	{
		//TODO - How do we test that an e-mail is sent?
	}
	
	function test_log_allParams_syslogLogHandlerShouldOnlyLogToSystemLog()
	{
		//TODO - How do we test that the system log has received the log message? 
	}
	
	function test_log_allParams_windowLogHandlerShouldOnlyAddWindowScriptToCode()
	{
		ob_start();
		$result = $this->logHandler->log("A log message", 0, false, "", false, "", false, true);
		$output = " " . ob_get_clean();
		
		$this->assertFalse(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertFalse(file_exists($this->logFile1));
		$this->assertFalse(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is not sent?
		//TODO - How do we test that the system log has not received the log message? 
		$this->assertTrue(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
	
	function test_log_allParams_logHandlerShouldHandleMultipleTargets()
	{
		ob_start();
		$result = $this->logHandler->log("A log message", 0, true, $this->logFile5, true, "", true, true);
		$output = " " . ob_get_clean();
		
		$this->assertTrue(strpos($output, "<b>emergency</b>: A log message"));
		$this->assertTrue(file_exists($this->logFile5));
		$this->assertTrue(strpos($output, "console.error(\"" . $this->logHandler->id() . " [emergency] A log message\");"));
		//TODO - How do we test that an e-mail is sent?
		//TODO - How do we test that the system log has received the log message? 
		$this->assertTrue(strpos($output, "self.focus")); //self.focus, since the window is already created
	}
}

?>