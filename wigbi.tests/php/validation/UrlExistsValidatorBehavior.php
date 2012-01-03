<?php

	class UrlExistsValidatorBehavior extends UnitTestCase
	{
		private $_validator;
		
		
		function setUp()
		{
			$this->_validator = new UrlExistsValidator();
		}
		
		function tearDown() { }
		
		
		
		public function test_isValid_shouldReturnFalseForNonExistingUrl()
		{
			$this->assertFalse($this->_validator->isValid("htp://www.saidi.se"));
		}
		
		public function test_isValid_shouldReturnTrueForValidValues()
		{
			$this->assertTrue($this->_validator->isValid("http://www.saidi.se"));
		}
	}

?>