<?php

	class MySqlSelectQueryBuilderBehavior extends UnitTestCase
	{
		private $_builder;
		
		
		function setUp()
		{
			$this->_builder = new MySqlSelectQueryBuilder();
		}
		
		function tearDown()
		{
		}
		
		
		public function test_build_shouldHandleEmptyQuery()
		{
			$result = $this->_builder->buildFor("table");
			
			$this->assertEqual($result, "SELECT * FROM table LIMIT 0,10");
		}
		
		public function test_build_shouldHandleSingleSelect()
		{
			$result = $this->_builder->select(array("col"))->buildFor("table");
			
			$this->assertEqual($result, "SELECT col FROM table LIMIT 0,10");
		}
		
		public function test_build_shouldHandleMultipleSelects()
		{
			$result = $this->_builder->select(array("col1", "col2"))->buildFor("table");
			
			$this->assertEqual($result, "SELECT col1,col2 FROM table LIMIT 0,10");
		}
		
		public function test_build_shouldHandleWhereWithNoSelect()
		{
			$result = $this->_builder->where(array("col='1'"))->buildFor("table");
			
			$this->assertEqual($result, "SELECT * FROM table WHERE col='1' LIMIT 0,10");
		}
		
		public function test_build_shouldHandleSingleWhere()
		{
			$result = $this->_builder->select(array("col"))->where(array("col='1'"))->buildFor("table");
			
			$this->assertEqual($result, "SELECT col FROM table WHERE col='1' LIMIT 0,10");
		}
		
		public function test_build_shouldHandleMultipleWheres()
		{
			$result = $this->_builder->select(array("col1", "col2"))->where(array("col1='1'","col2='2'"))->buildFor("table");
			
			$this->assertEqual($result, "SELECT col1,col2 FROM table WHERE col1='1' AND col2='2' LIMIT 0,10");
		}
		
		public function test_build_shouldApplySingleAscendingSort()
		{
			$result = $this->_builder->select(array("col1", "col2"))->where(array("col1='1'","col2='2'"))->sort("col1")->skip(25)->take(100)->buildFor("table");
			
			$this->assertEqual($result, "SELECT col1,col2 FROM table WHERE col1='1' AND col2='2' ORDERBY col1 LIMIT 25,100");
		}
		
		public function test_build_shouldApplySingleDescendingSort()
		{
			$result = $this->_builder->select(array("col1", "col2"))->where(array("col1='1'","col2='2'"))->sort("col1",1)->skip(25)->take(100)->buildFor("table");
			
			$this->assertEqual($result, "SELECT col1,col2 FROM table WHERE col1='1' AND col2='2' ORDERBY col1 DESC LIMIT 25,100");
		}
		
		public function test_build_shouldApplyDefaultSkipAndTake()
		{
			$result = $this->_builder->select(array("col1", "col2"))->where(array("col1='1'","col2='2'"))->buildFor("table");
			
			$this->assertEqual($result, "SELECT col1,col2 FROM table WHERE col1='1' AND col2='2' LIMIT 0,10");
		}
		
		public function test_build_shouldApplyCustomSkipAndTake()
		{
			$result = $this->_builder->select(array("col1", "col2"))->where(array("col1='1'","col2='2'"))->skip(25)->take(100)->buildFor("table");
			
			$this->assertEqual($result, "SELECT col1,col2 FROM table WHERE col1='1' AND col2='2' LIMIT 25,100");
		}
	}

?>