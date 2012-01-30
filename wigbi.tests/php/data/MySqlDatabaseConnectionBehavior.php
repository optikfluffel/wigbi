<?php

	class MySqlDatabaseConnectionBehavior extends UnitTestCase
	{
		private $_connection;
		
		
		function setUp()
		{
			$this->_connection = new MySqlDatabaseConnection("foo", "bar", "foobar");
		}
		
		function setUpValidConnection()
		{
			$this->_connection = new MySqlDatabaseConnection("localhost", "root", "root");
		}
		
		function tearDown()
		{
			$this->_connection->disconnect();
		}
		
		
		public function test_connect_shouldConnectOnce()
		{
			$this->setUpValidConnection();
			
			$result = $this->_connection->connect();
			
			$this->assertTrue($result);
		}
		
		public function test_connect_shouldNotConnectTwice()
		{
			$this->setUpValidConnection();
			
			$result = $this->_connection->connect();
			$result = $this->_connection->connect();
			
			$this->assertFalse($result);
		}
	}

?>