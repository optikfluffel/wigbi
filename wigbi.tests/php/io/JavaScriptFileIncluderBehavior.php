<?php

	class JavaScriptFileIncluderBehavior extends UnitTestCase
	{
		private $_includer;
		
		
		function setUp()
		{
			$this->_includer = new JavaScriptFileIncluder();
		}
		
		
		public function test_isApplicationRelative_shouldReturnFalseForProtocol()
		{
			$this->assertFalse($this->_includer->isApplicationRelative("http://www.foo.js"));
			$this->assertFalse($this->_includer->isApplicationRelative("https://www.foo.js"));
		}
		
		public function test_isApplicationRelative_shouldReturnFalseForAbsolutePath()
		{
			$this->assertFalse($this->_includer->isApplicationRelative("/foo.js"));
		}
		
		public function test_isApplicationRelative_shouldReturnFalseForBackwardPath()
		{
			$this->assertFalse($this->_includer->isApplicationRelative("../foo.js"));
		}
	}

?>