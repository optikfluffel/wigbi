<?php

/**
 * The Wigbi IAjaxHandler interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi IAjaxHandler interface.
 * 
 * This interface can be implemented by any class that can be used
 * to handle an async request.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Context
 * @version			2.0.0
 */
interface IAjaxRequestHandler
{
	/**
	 * Get whether or not the current request is an AJAX request.
	 * 
	 * @return	bool
	 */
	function isAjaxRequest();
}

?>