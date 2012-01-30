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
 * All methods except buildFor must return the query builder. This
 * enables that methods can be chained after eachother, which will
 * make composing the queries a lot simpler.
 * 
 * This class is only meant to be used for basic queries. If an IN
 * or JOIN statement etc is needed, you are probably better off to
 * write your own query builder. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Data
 * @version			2.0.0
 */
class MySqlSelectQueryBuilder implements IDatabaseSelectQueryBuilder
{
	private $_select;
	private $_skip = 0;
	private $_sort;
	private $_take = 10;
	private $_where;
	
	
	public function __construct()
	{
		$this->_select = array();
		$this->_sort = array();
		$this->_where = array();
	}
	
	
	/**
	 * Build the resulting query for a certain table.
	 * 
	 * @return	string
	 */
	public function buildFor($tableName)
	{
		$result = "";
		$result .= sizeof($this->_select) == 0 ? "SELECT *" : "SELECT " . implode(",", $this->_select);
		$result .= " FROM $tableName";
		$result .= sizeof($this->_where) == 0 ? "" : " WHERE " . implode(" AND ", $this->_where);
		$result .= sizeof($this->_sort) == 0 ? "" : " ORDERBY " . implode(",", $this->_sort);
		$result .= " LIMIT $this->_skip,$this->_take";

		return trim($result);
	}
	
	/**
	 * Define which columns that are of interest.
	 * 
	 * @param	array	$list					A list of names to select, e.g. ["foo", "bar"].
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	public function select($list)
	{
		foreach ($list as $select)
			array_push($this->_select, $select);
		return $this;
	}
	
	/**
	 * Define which columns to sort on.
	 * 
	 * 
	 * @param	array	$columnName				The column to sort on.
	 * @param	array	$descending			  	Give this arg a positive value to apply descending sort.
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	public function sort($columnName, $descending = 0)
	{
		$result = $columnName;
		$result .= $descending ? " DESC" : "";
		array_push($this->_sort, $result);
		
		return $this;
	}
	
	/**
	 * Define how many items to skip in the result.
	 * 
	 * @param	int		$skipCount
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	public function skip($skipCount)
	{
		$this->_skip = $skipCount;
		return $this;
	}
	
	/**
	 * Define how many items to take, starting at the skip count.
	 * 
	 * @param	int		$takeCount
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	public function take($takeCount)
	{
		$this->_take = $takeCount;
		return $this;
	}
	
	/**
	 * Define which columns that are of interest.
	 * 
	 * @param	array	$list					A list of filter conditions, e.g. ["foo=1", "bar=2"].
	 * @return	IDatabaseSelectQueryBuilder		The resulting query builder.
	 */
	public function where($list)
	{
		foreach ($list as $where)
			array_push($this->_where, $where);
		return $this;
	}
}

?>