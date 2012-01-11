<?php

	class ErrorLogBehavior extends UnitTestCase
	{
		private $_errorLog;
		
		
		function setUp()
		{
			$this->_errorLog = new ErrorLog(array(ErrorLogType::email(), ErrorLogType::sapi()), "foo@bar.se", "foo=bar");
		}
		
		function tearDown() { } 
		
		
		public function test_ctor_shouldInitializeLogger()
		{
			$this->assertEqual($this->_errorLog->types(), array(ErrorLogType::email(), ErrorLogType::sapi()));
			$this->assertEqual($this->_errorLog->destination(), "foo@bar.se");
			$this->assertEqual($this->_errorLog->extra_headers(), "foo=bar");
		}
	}

?>