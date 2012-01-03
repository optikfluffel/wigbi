<?php

	class HexValueValidatorBehavior extends UnitTestCase
	{
		private $_validator;
		
		
		function setUp()
		{
			$this->_validator = new HexValueValidator();
		}
		
		function tearDown() { }
		
		
		
		public function test_isValid_shouldReturnFalseForInvalidValues()
		{
			$this->assertFalse($this->_validator->isValid("ffffff"));
			$this->assertFalse($this->_validator->isValid("#gggggg"));
			$this->assertFalse($this->_validator->isValid("#fffffff"));
			$this->assertFalse($this->_validator->isValid("#ff"));
		}
		
		public function test_isValid_shouldReturnTrueForValidValues()
		{
			$this->assertTrue($this->_validator->isValid("#fff"));
			$this->assertTrue($this->_validator->isValid("#ffffff"));
		}
	}

?>