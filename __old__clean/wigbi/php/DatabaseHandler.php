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
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class DatabaseHandler
{
	
	
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