<?php

	class UrlValidatorBehavior extends UnitTestCase
	{
		private $_validator;
		
		
		function setUp()
		{
			$this->_validator = new UrlValidator();
		}
		
		function tearDown() { }
		
		
		
		public function test_isValid_shouldReturnFalseForInvalidValues()
		{
			$this->assertFalse($this->_validator->isValid("htp://www.saidi.se"));
			$this->assertFalse($this->_validator->isValid("www.saidi.se"));
			$this->assertFalse($this->_validator->isValid("htp://www.saidi.se."));
		}
		
		public function test_isValid_shouldReturnTrueForValidValues()
		{
			$this->assertTrue($this->_validator->isValid("http://www.saidi.se"));
		}
	}

?>