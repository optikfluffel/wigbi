<?php

	class ErrorLogTypeBehavior extends UnitTestCase
	{
		function setUp() { }
		
		function tearDown() { } 
		
		
		public function test_messages_shouldReturnCorrectSeverity()
		{
			$this->assertEqual(ErrorLogType::system(), 0);
			$this->assertEqual(ErrorLogType::email(), 1);
			$this->assertEqual(ErrorLogType::file(), 3);
			$this->assertEqual(ErrorLogType::sapi(), 4);
		}
	}

?>