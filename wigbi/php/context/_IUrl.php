<?php

/**
 * The Wigbi IUrl interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IUrl interface.
 * 
 * This interface can be implemented by any class that can be used
 * to represent a url.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Context
 * @version			2.0.0
 */
interface IUrl
{
	/**
	 * Get the url scheme, e.g. http.
	 * 
	 * @return	string
	 */
	function scheme();
	
	/**
	 * Get the user part of the url, if any.
	 * 
	 * @return	string
	 */
	function user();
	
	/**
	 * Get the password part of the url, if any.
	 * 
	 * @return	string
	 */
	function password();
	
	/**
	 * Get the url host, e.g. localhost.
	 * 
	 * @return	string
	 */
	function host();
	
	/**
	 * Get the port part of the url, if any.
	 * 
	 * @return	string
	 */
	function port();
	
	/**
	 * Get the absolute url path.
	 * 
	 * @return	string
	 */
	function path();
	
	/**
	 * Get the query part of the url, if any.
	 * 
	 * @return	string
	 */
	function query();
	
	/**
	 * Get the anchor part of the url, if any.
	 * 
	 * @return	string
	 */
	function fragment();
}

?>