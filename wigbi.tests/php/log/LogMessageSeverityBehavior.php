<?php

	class LogMessageSeverityBehavior extends UnitTestCase
	{
		function setUp() { }
		
		function tearDown() { } 
		
		
		public function test_messages_shouldReturnCorrectSeverity()
		{
			$this->assertEqual(LogMessageSeverity::emergency(), 0);
			$this->assertEqual(LogMessageSeverity::alert(), 1);
			$this->assertEqual(LogMessageSeverity::critical(), 2);
			$this->assertEqual(LogMessageSeverity::error(), 3);
			$this->assertEqual(LogMessageSeverity::warning(), 4);
			$this->assertEqual(LogMessageSeverity::notice(), 5);
			$this->assertEqual(LogMessageSeverity::info(), 6);
			$this->assertEqual(LogMessageSeverity::debug(), 7);
		}
	}

?>