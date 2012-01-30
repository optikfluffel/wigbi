<?php

/**
 * The Wigbi MySqlDatabaseConnection class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi MySqlDatabaseConnection class.
 * 
 * This class can be used to work with a MySQL database.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Data
 * @version			2.0.0
 */
class MySqlDatabaseConnection implements IDatabaseConnection
{
	private $_connection;
	private $_host;
	private $_password;
	private $_userName;
	
	
	/**
	 * Create an instance of the class.
	 * 
	 * @param	string	$host		The database host URL, e.g. localhost.
	 * @param	string	$userName	The user name to use to login to the database.
	 * @param	string	$password	The password to use to login to the database.
	 */
	public function __construct($host, $userName, $password)
	{
		$this->_host = $host;
		$this->_userName = $userName;
		$this->_password = $password;
	}
	
	
	
	/**
	 * Connect to the specified database.
	 * 
	 * @return	bool	Whether or not the operation was successful.
	 */
	public function connect()
	{
		if ($this->isConnected())
			return false;
		
		$this->_connection = mysql_connect($this->_host, $this->_userName, $this->_password, true);
		if (!$this->_connection)
			return false;
		
		return $this->isConnected();
	}
	
	/**
	 * Check whether or not a certain database exists.
	 * 
	 * @return	bool
	 */
	public function databaseExists($name)
	{
		return mysql_select_db($name, $this->_connection);
	}
	
	/**
	 * Disconnect from the specified database.
	 * 
	 * @return	bool	Whether or not the operation was successful.
	 */
	public function disconnect()
	{
		$result = mysql_close($this->_connection);
		$this->_connection = null;
		
		return $this->isConnected();
	}
	
	/**
	 * Whether or not the data provider is currently connected.
	 * 
	 * @return	bool	Whether or not the data provider is currently connected.
	 */
	public function isConnected()
	{
		return $this->_connection != null;
	}
	
	/**
	 * Execute a query and return result, if any.
	 * 
	 * SELECT, SHOW, DESCRIBE, EXPLAIN queries return a result set.
	 * INSERT, UPDATE, DELETE, DROP queries return a result boolean.
	 * 
	 * @param	string	$query	The query to execute.
	 * @return	mixed			The query result, based on the type of query executed.
	 */
	public function query($query)
	{
		$result = mysql_query($query, $this->_connection);

		if ($result and $result != 1)
		{
			$return = array();
			while($recordset = mysql_fetch_assoc($result))
				array_push($return, $recordset);
			return $return;
		}

		return $result;
	}
	
	/**
	 * Select a certain database to work with.
	 * 
	 * @return	bool	Whether or not the database could be selected
	 */
	public function selectDatabase($databaseName)
	{
		return mysql_select_db($databaseName, $this->_connection);
	}
	
	/**
	 * Check whether or not a certain table exists.
	 * 
	 * @return	bool
	 */
	public function tableExists($tableName)
	{
		$result = mysql_query("show tables like '" . $tableName . "'", $this->_connection);
		if ($result)
			$result = mysql_fetch_assoc($result);
		return $result ? true : false;
	}
	
	/**
	 * Check whether or not a certain table exists.
	 * 
	 * @return	bool
	 */
	public function tableColumnExists($databaseName, $tableName, $columnName)
	{
		$columns = mysql_list_fields($databaseName, $tableName);
		for ($i=0; $i < mysql_num_fields($columns); $i++)
			if (mysql_field_name($columns, $i) == $columnName)
				return true;
		return false;
		
	}
}

?>