<?php

	class ControllerBehavior extends UnitTestCase
	{
		private $_controller;
		
		
		function setUp()
		{
			$this->_controller = new TestController();
		}
		
		function tearDown() { }
		
		
		public function test_executeAction_shouldReturnActionResult()
		{
			$result = $this->_controller->executeAction("Action");
			
			$this->assertEqual($result, "foo");
		}
	}


	class TestController extends Controller
	{
		public function Action()
		{
			return "foo";
		}
	}

?>