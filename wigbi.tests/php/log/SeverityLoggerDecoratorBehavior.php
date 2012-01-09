<?php

	class SeverityLoggerDecoratorBehavior extends UnitTestCase
	{
		private $_logger;
		private $_errorLog;
		
		
		function setUp()
		{
			$this->setUpLogger();	
		}
		
		function setUpLogger()
		{
			Mock::generate('ILogger');
			$this->_errorLog = new MockILogger();
			
			$this->_logger = new SeverityLoggerDecorator($this->_errorLog, array(LogMessageSeverity::alert(), LogMessageSeverity::warning()));
		}
		
		function tearDown() { } 
		
		
		public function test_log_shouldAbortForNonInterestingSeverity()
		{
			$this->logNonInterestingSeverity(LogMessageSeverity::emergency());
			$this->logNonInterestingSeverity(LogMessageSeverity::critical());
			$this->logNonInterestingSeverity(LogMessageSeverity::error());
			$this->logNonInterestingSeverity(LogMessageSeverity::info());
			$this->logNonInterestingSeverity(LogMessageSeverity::debug());
		}
		
		public function test_log_shouldLogForInterestingSeverity()
		{
			$this->logInterestingSeverity(LogMessageSeverity::alert());
			$this->logInterestingSeverity(LogMessageSeverity::warning());
		}
		
		private function logInterestingSeverity($severity)
		{
			$this->setUpLogger();
			$this->_errorLog->expectOnce("log", array("foo", $severity));
			$this->_logger->log("foo", $severity);
		}
		
		private function logNonInterestingSeverity($severity)
		{
			$this->setUpLogger();
			$this->_errorLog->expectNever("log", array("foo", $severity));
			$this->_logger->log("foo", $severity);
		}
	}

?>