<?php class DatabaseHandlerBehavior extends UnitTestCase
{
	private $obj;	
	private $host = "localhost";
	private $dbName = "wigbi_test_DatabaseHandler";
	private $userName = "root";
	private $password = "root";
	private $tableName = "TestTable";

	
	
	function DatabaseHandlerBehavior()
	{
		$this->UnitTestCase("DatabaseHandler");
		$this->createDatabase();
	}
	
	function setUp()
	{
		$this->obj = new DatabaseHandler($this->host, $this->dbName, $this->userName, $this->password);
	}
	
	function tearDown()
	{
		if ($this->obj->isConnected())
			$this->obj->disconnect();
	}
	
	function createDatabase()
	{
		$db = new DatabaseHandler($this->host, null, $this->userName, $this->password);
		$db->connect();
		$db->query("CREATE DATABASE " . $this->dbName);
		$db->disconnect();
		$db = new DatabaseHandler($this->host, $this->dbName, $this->userName, $this->password);
		$db->connect();
		$db->query("CREATE TABLE " . $this->tableName . " (id VARCHAR(32), name VARCHAR(32), PRIMARY KEY(id))");
		$db->disconnect();
	}
	
	
	
	function test_constructor_shouldInitializeObject()
	{
		$this->assertEqual($this->obj->host(), $this->host);
		$this->assertEqual($this->obj->dbName(), $this->dbName);
		$this->assertEqual($this->obj->userName(), $this->userName);
		$this->assertEqual($this->obj->password(), $this->password);
	}

	
    
	function test_host_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->obj->host(), $this->host);
	}
	
	function test_dbName_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->obj->dbName(), $this->dbName);
	}
	
	function test_userName_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->obj->userName(), $this->userName);
	}
	
	function test_password_shouldReturnCorrectValue()
	{
		$this->assertEqual($this->obj->password(), $this->password);
	}
	
	function test_isConnected_shouldReturnFalseWhenNotConnected()
	{
		$this->assertFalse($this->obj->isConnected());
	}
	
	function test_isConnected_shouldReturnTrueWhenConnected()
	{
		$this->obj->connect();
		
		$this->assertTrue($this->obj->isConnected());
	}
	
	
	
	function test_connect_shouldReturnFalseIfAlreadyConnected()
	{
		$this->obj->connect();
		
		$this->assertFalse($this->obj->connect());
	}
	
	function test_connect_shouldReturnFalseForInvalidDatabaseName()
	{
		$this->obj = new DatabaseHandler($this->host, $this->dbName . "_notExists", $this->userName, $this->password);
		
		$this->assertFalse($this->obj->connect());
	}
	
	function test_connect_shouldReturnTrueForValidCredentialsAndNoDatabaseName()
	{
		$this->obj = new DatabaseHandler($this->host, "", $this->userName, $this->password);
		
		$this->assertTrue($this->obj->connect());
	}
	
	function test_connect_shouldReturnTrueForValidCredentialsAndDatabaseName()
	{
		$this->obj = new DatabaseHandler($this->host, $this->dbName, $this->userName, $this->password);
		$this->assertTrue($this->obj->connect());
	}
	
	function test_dataBaseExists_shouldReturnFalseForNonExistingDatabase()
	{
		$this->obj->connect();
		$this->assertFalse($this->obj->databaseExists("nonExisting"));
	}
	
	function test_dataBaseExists_shouldReturnTrueForExistingDatabase()
	{
		$this->obj->connect();
		$this->assertTrue($this->obj->databaseExists($this->dbName));
	}
	
	function test_disconnect_shouldReturnTrueIfConnected()
	{
		$this->obj->connect();
		$this->assertTrue($this->obj->disconnect());
	}
	
	function test_getNextRow_shouldReturnMultipleRowsIfAvailable()
	{
		$this->obj->connect();
		
		$this->obj->query("INSERT INTO " . $this->tableName . " (id, name) VALUES ('myId1','myId1')");
		$this->obj->query("INSERT INTO " . $this->tableName . "  (id, name) VALUES ('myId2','myId2')");
		$result = $this->obj->query("SELECT * FROM " . $this->tableName . " LIMIT 0,2");
		$row1 = $this->obj->getNextRow($result);
		$row2 = $this->obj->getNextRow($result);
		$this->obj->query("DELETE FROM " . $this->tableName . " WHERE id = 'myId1'");
		$this->obj->query("DELETE FROM " . $this->tableName . " WHERE id = 'myId2'");
		
		$this->assertEqual(gettype($row1), "array");
		$this->assertEqual(gettype($row2), "array");
	}
	
	function test_query_shouldReturnResourceForSelectTypeQueries()
	{
		$this->obj->connect();
		$result = $this->obj->query("SELECT * FROM " . $this->tableName);
		
		$this->assertEqual(gettype($result), "resource");
	}
	
	function test_query_shouldReturnBooleanForInsertTypeQueries()
	{
		$this->obj->connect();
		$result = $this->obj->query("INSERT INTO " . $this->tableName . " ('id', 'name') VALUES ('myId', 'myName')");
		$this->obj->query("DELETE FROM " . $this->tableName . " WHERE id = 'myId'");
		
		$this->assertEqual(gettype($result), "boolean");
	}
	
	function test_tableExists_shouldReturnFalseForNonExistingTable()
	{
		$this->obj->connect();
		
		$this->assertFalse($this->obj->tableExists("nonExisting"));
	}
	
	function test_tableExists_shouldReturnTrueForExistingTable()
	{
		$this->obj->connect();
		
		$this->assertTrue($this->obj->tableExists($this->tableName));
	}
	
	function test_tableColumnExists_shouldReturnFalseForNonExistingColumn()
	{
		$this->obj->connect();
		
		$this->assertFalse($this->obj->tableColumnExists($this->tableName, "nonExisting"));
	}
	
	function test_tableColumnExists_shouldReturnTrueForExistingColumn()
	{
		$this->obj->connect();
		
		$this->assertTrue($this->obj->tableColumnExists($this->tableName, "id"));
	}
}

?>