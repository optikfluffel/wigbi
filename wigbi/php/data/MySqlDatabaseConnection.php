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
class MySqlDatabaseConnection
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
		
		$this->_isConnected = true;
		
		return $this->isConnected();
	}
	
	/**
	 * Check whether or not a certain database exists.
	 * 
	 * @return	bool
	 */
	public function databaseExists($name)
	{
		
	}
	
	/**
	 * Disconnect from the specified database.
	 * 
	 * @return	bool	Whether or not the operation was successful.
	 */
	function disconnect()
	{
		
	}
	
	/**
	 * Whether or not the data provider is currently connected.
	 * 
	 * @return	bool	Whether or not the data provider is currently connected.
	 */
	function isConnected()
	{
		return $this->_connection != null;
	}
	
	/**
	 * Execute a query and return result, if any.
	 * 
	 * @param	string	$query	The query to execute.
	 * @return	mixed			The query result, based on the type of query executed.
	 */
	function query($query)
	{
		
	}
	
	/**
	 * Select a certain database to work with.
	 * 
	 * @return	bool	Whether or not the database could be selected
	 */
	function selectDatabase($databaseName)
	{
		
	}
	
	/**
	 * Check whether or not a certain table exists.
	 * 
	 * @return	bool
	 */
	function tableExists($tableName)
	{
		
	}
	
	/**
	 * Check whether or not a certain table exists.
	 * 
	 * @return	bool
	 */
	function tableColumnExists($tableName, $columnName)
	{
		
	}
}

?>