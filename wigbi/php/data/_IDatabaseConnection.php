<?php

/**
 * The Wigbi IDatabaseConnection interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IDatabaseConnection interface.
 * 
 * This interface can be implemented by any class that can be used
 * to work with a database.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Data
 * @version			2.0.0
 */
interface IDatabaseConnection
{
	/**
	 * Connect to the specified database.
	 * 
	 * @return	bool	Whether or not the operation was successful.
	 */
	function connect($host, $userName, $password);
	
	/**
	 * Check whether or not a certain database exists.
	 * 
	 * @return	bool
	 */
	function databaseExists($name);
	
	/**
	 * Disconnect from the specified database.
	 * 
	 * @return	bool	Whether or not the operation was successful.
	 */
	function disconnect();
	
	/**
	 * Whether or not the data provider is currently connected.
	 * 
	 * @return	bool	Whether or not the data provider is currently connected.
	 */
	function isConnected();
	
	/**
	 * Execute a query and return result, if any.
	 * 
	 * @param	string	$query	The query to execute.
	 * @return	mixed			The query result, based on the type of query executed.
	 */
	function query($query);
	
	/**
	 * Select a certain database to work with.
	 * 
	 * @return	bool	Whether or not the database could be selected
	 */
	function selectDatabase($databaseName);
	
	/**
	 * Check whether or not a certain table exists.
	 * 
	 * @return	bool
	 */
	function tableExists($tableName);
	
	/**
	 * Check whether or not a certain table exists.
	 * 
	 * @return	bool
	 */
	function tableColumnExists($tableName, $columnName);
}

?>