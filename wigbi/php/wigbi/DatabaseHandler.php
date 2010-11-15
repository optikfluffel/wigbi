<?php

/**
 * Wigbi.PHP.DatabaseHandler class file.
 * 
 * Wigbi is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *  
 * Wigbi is distributed in the hope that it will be useful, but WITH
 * NO WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Wigbi. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The Wigbi.PHP.DatabaseHandler class.
 * 
 * This class can be used to connect to and work with a database. It
 * has few methods, which makes it easy to work with although it may
 * be a bit limited for some contexts.
 * 
 * Remember to call the connect() function before attempting to work
 * towards the database.  
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class DatabaseHandler
{
	/**#@+
	 * @ignore
	 */
	private $_connection;
	private $_dbName;
	private $_host;
	private $_password;
	private $_userName;
	/**#@-*/
	

	
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$host		The database host URL.
	 * @param	string	$dbName		The name of the database to work with.
	 * @param	string	$userName	The user name to use to login to the database.
	 * @param	string	$password	The password to use to login to the database.
	 */
	public function __construct($host, $dbName, $userName, $password)
	{
		$this->_host = $host;
		$this->_dbName = $dbName;
		$this->_userName = $userName;
		$this->_password = $password;
	}
	
	
	
	/**
	 * Get the name of the database to work with.
	 * 
	 * @access	public
	 * 
	 * @return	string	The name of the database to work with.
	 */
	public function dbName()
	{
		return $this->_dbName;
	}
	
	/**
	 * Get the database host URL.
	 * 
	 * @access	public
	 * 
	 * @return	string	The database host URL.
	 */
	public function host()
	{
		return $this->_host;
	}
	
	/**
	 * Get whether or not the handler is currently connected to a database.
	 * 
	 * @access	public
	 * 
	 * @return	bool	Whether or not the handler is currently connected to a database.
	 */
	public function isConnected()
	{
		return $this->_connection ? true : false;
	}
	
	/**
	 * Get password to use to login to the database.
	 * 
	 * @access	public
	 * 
	 * @return	string	The password to use to login to the database.
	 */
	public function password()
	{
		return $this->_password;
	}
	
	/**
	 * Get user name to use to login to the database.
	 * 
	 * @access	public
	 * 
	 * @return	string	The user name to use to login to the database.
	 */
	public function userName()
	{
		return $this->_userName;
	}
	
	
	
	/**
	 * Connect the handler to the specified database server.
	 *
	 * Note that this function will both attempt to connect to the
	 * database server and select the database, if a name has been
	 * specified. If any of these steps fail, false is returned.
	 *  
	 * @access	public
	 * 
	 * @return	bool	Whether or not a connection could be established.
	 */
	public function connect()
	{
		//Return false if a connection already exists
		if ($this->isConnected())
			return false;
		
		//Connect to the database server, abort if no result
		$this->_connection = mysql_connect($this->host(), $this->userName(), $this->password(), true);
		if (!$this->_connection)
			return false;
		
		//Select database, if any, and return result
		if ($this->dbName())
			return mysql_select_db($this->dbName(), $this->_connection);
		return true;
	}
	
	/**
	 * Check whether or not a certain database exists.
	 * 
	 * @access	public
	 * 
	 * @param		string	The name of the database.
	 * @return	bool		Whether or not sa certain database exists.
	 */
	public function databaseExists($name)
	{
		return mysql_select_db($name, $this->_connection);
	}
	
	/**
	 * Disconnect the handler any currently established connection.
	 * 
	 * @access	public
	 * 
	 * @return	bool	Whether or not the operation was successful.
	 */
	public function disconnect()
	{
		$result = mysql_close($this->_connection);
		$this->_connection = null;
		return $result;
	}

	/**
	 * Move to the next row in a record set.
	 * 
	 * If no record set is given as a parameter, the last one that
	 * was created with the query(...) method will be used.
	 * 
	 * @access	public
	 * 
	 * @return	array	The next row in the record set; null if none.
	 */
	public function getNextRow($rs = null)
	{
		if (!$rs)
			$rs = $this->_rs;
		return mysql_fetch_assoc($rs);
	}
	
	/**
	 * Execute a query and return result, if any.
	 * 
	 * SELECT, SHOW, DESCRIBE, EXPLAIN queries return a result set.
	 * INSERT, UPDATE, DELETE, DROP queries return a result boolean.
	 * 
	 * @access	public
	 * 
	 * @param		string	$query	The query to execute.
	 * @return	mixed						Query result, based on the query.
	 */
	public function query($query)
	{
		$this->_rs = mysql_query($query, $this->_connection);
		return $this->_rs;
	}
	
	/**
	 * Check whether or not a certain table exists in the database.
	 * 
	 * @access	public
	 * 
	 * @param		string	$name	Table name.
	 * @return	bool						Whether or not the table exists.
	 */
	public function tableExists($name)
	{
		$result = $this->query("show tables like '" . $name . "'");
		return $this->getNextRow($result) ? true : false;
	}
	
	/**
	 * Check whether or not a certain table column exists in the database.
	 * 
	 * @access	public
	 * 
	 * @param		string	$tableName	Table name.
	 * @param		string	$columnName	Column name.
	 * @return	bool								Whether or not the column exists.
	 */
	public function tableColumnExists($tableName, $columnName)
	{
		$columns = mysql_list_fields($this->dbName(), $tableName);
		for ($i=0; $i < mysql_num_fields($columns); $i++)
			if (mysql_field_name($columns, $i) == $columnName)
				return true;
		return false;
	}
}

?>