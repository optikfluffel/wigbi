<?php

/**
 * The Wigbi IDataProvider interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IDataProvider interface.
 * 
 * This interface can be implemented by any data provider that can
 * provide data from a data source.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Data
 * @version			2.0.0
 */
interface IDataProvider
{
	/**
	 * Connect the data provider to the specified data source.
	 * 
	 * @return	bool	Whether or not the operation was successful.
	 */
	function connect();
	
	/**
	 * Disconnect the data provider from the specified data source.
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
}

?>