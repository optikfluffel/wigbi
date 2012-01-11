<?php

/**
 * The Wigbi NonLogger class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi NonLogger class.
 * 
 * This class can be used to swallow log errors, and do nothing to
 * handle them in any way.  
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Log
 * @version			2.0.0
 */
class NonLogger implements ILogger
{
	/**
	 * Swallow a log message, without doing anything.
	 * 
	 * @param	string				$message	The message to log.
	 * @param	LogMessageSeverity	$severity	The severity of the log message.
	 */
	function log($message, $severity)
	{
	}
}

?>