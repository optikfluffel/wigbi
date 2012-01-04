<?php

	class ControllerBehavior extends UnitTestCase
	{
		private $_controller;
		
		
		function setUp()
		{
			$this->_controller = new TestController();
		}
		
		function tearDown() { }
		
		
		public function test_action_shouldCallActionAndReturnResult()
		{
			$result = $this->_controller->action("TestAction");
			
			$this->assertEqual($result, "foo");
		}
	}


	class TestController extends Controller
	{
		public function TestAction()
		{
			return "foo";
		}
	}

?>