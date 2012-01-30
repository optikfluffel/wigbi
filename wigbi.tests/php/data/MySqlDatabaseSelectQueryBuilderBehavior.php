<?php

	class MySqlDatabaseSelectQueryBuilderBehavior extends UnitTestCase
	{
		private $_builder;
		
		
		function setUp()
		{
			$this->_builder = new MySqlDatabaseSelectQueryBuilder();
		}
		
		function tearDown()
		{
		}
		
		
		public function test_build_shouldHandleEmptyQuery()
		{
			$result = $this->_builder->buildFor("foo");
			
			$this->assertEqual($result, "SELECT * FROM foo");
		}
		
		public function test_build_shouldHandleSingleSelect()
		{
			$result = $this->_builder->select(array("bar"))->buildFor("foo");
			
			$this->assertEqual($result, "SELECT bar FROM foo");
		}
		
		public function test_build_shouldHandleMultipleSelects()
		{
			$result = $this->_builder->select(array("foo", "bar"))->buildFor("foo");
			
			$this->assertEqual($result, "SELECT foo,bar FROM foo");
		}
	}

?>