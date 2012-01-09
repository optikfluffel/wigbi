<?php

/**
 * The Wigbi ILogger interface file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ILogger interface.
 * 
 * This interface can be implemented by any class that can be used
 * to log error messages.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Log
 * @version			2.0.0
 */
interface ILogger
{	
	/**
	 * Log a message of a certain severity.
	 * 
	 * @param	string				$message	The message to log.
	 * @param	LogMessageSeverity	$severity	The severity of the log message.
	 */
	function log($message, $severity);
}

?>