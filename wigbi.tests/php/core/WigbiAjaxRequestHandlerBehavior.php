<?php

	class WigbiAjaxRequestHandlerBehavior extends UnitTestCase
	{
		private $_handler;
		private $_data;
		
		
		function setUp()
		{
			$this->_handler = new WigbiAjaxRequestHandler();
		}
		
		function tearDown() { }
		
		
		public function test_isAjaxRequest_shouldReturnFalseForInvalidServerProperties()
		{
			$this->assertFalse($this->_handler->isAjaxRequest());
		}
		
		public function test_isAjaxRequest_shouldReturnTrueForValidServerProperties()
		{
			$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
			
			$this->assertTrue($this->_handler->isAjaxRequest());
			
			unset($_SERVER['HTTP_X_REQUESTED_WITH']);
		}
		
	}

?>