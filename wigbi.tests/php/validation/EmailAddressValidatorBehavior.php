<?php

	class EmailAddressValidatorBehavior extends UnitTestCase
	{
		private $_validator;
		
		
		function setUp()
		{
			$this->_validator = new EmailAddressValidator();
		}
		
		function tearDown() { }
		
		
		
		public function test_isValid_shouldReturnFalseForInvalidValues()
		{
			$this->assertFalse($this->_validator->isValid("daniel.saidi@"));
			$this->assertFalse($this->_validator->isValid("@gmail.com"));
			$this->assertFalse($this->_validator->isValid("daniel.saidi@gmail"));
		}
		
		public function test_isValid_shouldReturnTrueForValidValues()
		{
			$this->assertTrue($this->_validator->isValid("daniel.saidi@gmail.com"));
		}
	}

?>