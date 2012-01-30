<?php

/**
 * The Wigbi MySqlDatabaseQueryBuilder class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi MySqlDatabaseQueryBuilder class.
 * 
 * This class can be used to to build search queries, specifically
 * for a MySQL database.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Data
 * @version			2.0.0
 */
class MySqlDatabaseSelectQueryBuilder implements IDatabaseSelectQueryBuilder
{
	private $_select;
	
	
	public function __construct()
	{
		$this->_select = array();
	}
	
	
	/**
	 * Build the resulting query for a certain table.
	 * 
	 * @return	string
	 */
	public function buildFor($tableName)
	{
		$result = "";
		$result .= "SELECT ";
		$result .= sizeof($this->_select) == 0 ? "*" : implode(",", $this->_select);
		$result .= " FROM $tableName";
		
		return $result;
	}
	
	/**
	 * Define which columns that are of interest.
	 * 
	 * @param	array	$list	A list of names to select.
	 */
	public function select($list)
	{
		foreach ($list as $select)
			array_push($this->_select, $select);
		return $this;
	}
}

?>