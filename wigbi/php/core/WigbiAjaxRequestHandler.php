<?php

/**
 * The Wigbi WigbiAjaxRequestHandler class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi WigbiAjaxRequestHandler class.
 * 
 * This class can be used to handle incoming AJAX requests for any
 * Wigbi application. It parses the provided posted parameters and
 * executes the appropriate method.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Context
 * @version			2.0.0
 */
class WigbiAjaxRequestHandler implements IAjaxRequestHandler
{
	/**
	 * Get whether or not the current request is an AJAX request.
	 * 
	 * @return	bool
	 */
	public function isAjaxRequest()
	{
		if (array_key_exists("HTTP_X_REQUESTED_WITH", $_SERVER))
			return $_SERVER['HTTP_X_REQUESTED_WITH'] =='XMLHttpRequest';
		return false;
	}
	
}

?>