<?php

	class MySqlDatabaseConnectionBehavior extends UnitTestCase
	{
		private $_connection;
		
		
		function setUp()
		{
			$this->_connection = new MySqlDatabaseConnection("localhost", "root", "root");
		}
		
		function setUpInvalidConnection()
		{
			$this->_connection = new MySqlDatabaseConnection("foo", "bar", "foobar");
		}
		
		function tearDown()
		{
			$this->_connection->disconnect();
			$this->enableLogging();
		}
		
		
		function disableLogging()
		{
			error_reporting(null);
		}
		
		function enableLogging()
		{
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		}
		
		
		public function test_connect_shouldNotConnectWithInvalidCredentials()
		{
			$this->disableLogging();
			$this->setUpInvalidConnection();
			
			$result = $this->_connection->connect();
			
			$this->assertFalse($result);
		}
		
		public function test_connect_shouldConnectOnce()
		{	
			$result = $this->_connection->connect();
			
			$this->assertTrue($result);
		}
		
		public function test_connect_shouldNotConnectTwice()
		{
			$this->_connection->connect();
			$result = $this->_connection->connect();
			
			$this->assertFalse($result);
		}
		
		public function test_connect_shouldConnectAgainAfterDisconnect()
		{
			$this->_connection->connect();
			$this->_connection->disconnect();
			$result = $this->_connection->connect();
			
			$this->assertTrue($result);
		}
		
		public function test_databaseExists_shouldReturnFalseForNonExistingDatabase()
		{
			$this->_connection->connect();
			
			$result = $this->_connection->databaseExists("wigbi_tests");
			
			$this->assertFalse($result);
		}
		
		public function test_databaseExists_shouldReturnTrueForExistingDatabase()
		{
			$this->_connection->connect();
			$this->_connection->query("CREATE DATABASE wigbi_tests");
			
			$result = $this->_connection->databaseExists("wigbi_tests");
			
			$this->assertTrue($result);
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
			
			$result = $this->_connection->databaseExists("wigbi_tests");
			
			$this->assertFalse($result);
		}
		
		public function test_query_shouldReturnTrueForNonRecordSetQuery()
		{
			$this->_connection->connect();
			$result = $this->_connection->query("CREATE DATABASE wigbi_tests");
			
			$this->assertTrue($result);
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
		}
		
		public function test_query_shouldReturnAssociativeArrayCollectionForRecordSetQuery()
		{
			$this->_connection->connect();
			$this->_connection->query("CREATE DATABASE wigbi_tests");
			$this->_connection->selectDatabase("wigbi_tests");
			$this->_connection->query("CREATE TABLE wigbi_table (id VARCHAR(40) NOT NULL, PRIMARY KEY(id))");
			$this->_connection->query("INSERT INTO wigbi_table (id) VALUES ('first')");
			$this->_connection->query("INSERT INTO wigbi_table (id) VALUES ('second')");
			$this->_connection->query("INSERT INTO wigbi_table (id) VALUES ('third')");
			
			$result = $this->_connection->query("SELECT * FROM wigbi_table ORDER BY id");
			
			$this->assertEqual(sizeof($result), 3);
			$this->assertEqual($result[0]["id"], "first");
			$this->assertEqual($result[1]["id"], "second");
			$this->assertEqual($result[2]["id"], "third");
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
		}
		
		public function test_selectDatabase_shouldFailForNoConnection()
		{
			$this->disableLogging();
			$result = $this->_connection->selectDatabase("ougehghewuaoihgaw");
			
			$this->assertFalse($result);
		}
		
		public function test_selectDatabase_shouldReturnFalseForNonExistingDatabase()
		{
			$this->_connection->connect();
			
			$result = $this->_connection->selectDatabase("wigbi_tests");
			
			$this->assertFalse($result);
		}
		
		public function test_selectDatabase_shouldReturnTrueForExistingDatabase()
		{
			$this->_connection->connect();
			$this->_connection->query("CREATE DATABASE wigbi_tests");
			
			$result = $this->_connection->selectDatabase("wigbi_tests");
			
			$this->assertTrue($result);
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
		}
		
		public function test_tableExists_shouldFailForNoConnection()
		{
			$this->disableLogging();
			$result = $this->_connection->tableExists("ougehghewuaoihgaw");
			
			$this->assertFalse($result);
		}
		
		public function test_tableExists_shouldReturnFalseForNonExistingTable()
		{
			$this->_connection->connect();
			$this->_connection->query("CREATE DATABASE wigbi_tests");
			
			$result = $this->_connection->tableExists("wigbi_tests");
			
			$this->assertFalse($result);
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
		}
		
		public function test_tableExists_shouldReturnTrueForExistingTable()
		{
			$this->_connection->connect();
			$this->_connection->query("CREATE DATABASE wigbi_tests");
			$this->_connection->selectDatabase("wigbi_tests");
			$this->_connection->query("CREATE TABLE wigbi_tests (id VARCHAR(40) NOT NULL, PRIMARY KEY(id))");
			
			$result = $this->_connection->tableExists("wigbi_tests");
			
			$this->assertTrue($result);
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
		}
		
		public function test_tableColumnExists_shouldFailForNoConnection()
		{
			$this->disableLogging();
			$result = $this->_connection->tableColumnExists("wigbi_tests", "wigbi_tests", "id");
			
			$this->assertFalse($result);
		}
		
		public function test_tableColumnExists_shouldReturnFalseForNoExistingTableColumn()
		{
			$this->_connection->connect();
			$this->_connection->query("CREATE DATABASE wigbi_tests");
			$this->_connection->selectDatabase("wigbi_tests");
			$this->_connection->query("CREATE TABLE wigbi_tests (id VARCHAR(40) NOT NULL, PRIMARY KEY(id))");
			
			$result = $this->_connection->tableColumnExists("wigbi_tests", "wigbi_tests", "name");
			
			$this->assertFalse($result);
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
		}
		
		public function test_tableColumnExists_shouldReturnTrueForExistingTable()
		{
			$this->_connection->connect();
			$this->_connection->query("CREATE DATABASE wigbi_tests");
			$this->_connection->selectDatabase("wigbi_tests");
			$this->_connection->query("CREATE TABLE wigbi_tests (id VARCHAR(40) NOT NULL, PRIMARY KEY(id))");
			
			$result = $this->_connection->tableColumnExists("wigbi_tests", "wigbi_tests", "id");
			
			$this->assertTrue($result);
			
			$this->_connection->query("DROP DATABASE wigbi_tests");
		}
	}

?>