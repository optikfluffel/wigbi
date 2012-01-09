<?php

/**
 * The Wigbi ErrorLog class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi ErrorLog class.
 * 
 * This class can be used to log errors using the error_log method.
 * For more info about how to configure it, view the documentation
 * at http://php.net/manual/en/function.error-log.php  
 * 
 * Note that the type is an array instead of a single value, which
 * means that one logger can send messages in several ways.  
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Log
 * @version			2.0.0
 */
class ErrorLog implements ILogger
{
	private $_destination;
	private $_headers;
	private $_types;
	
	/**
	 * @param	array[ErrorLogType]	$types			How the logger should log its messages.
	 * @param	string				$destination	The e-mail address or file to send messages to.
	 * @param	string				$headers		Extra headers that will be added to any e-mails being sent.
	 */
	public function __construct($types, $destination = "", $headers = "")
	{
		$this->_types = $types;
		$this->_destination = $destination;
		$this->_headers = $headers;
	}
	
	
	/**
	 * Get the e-mail address or file that the logger will log to.
	 * 
	 * @return	string
	 */
	function destination()
	{
		return $this->_destination;
	}
	
	/**
	 * Get the extra headers that will be added to any e-mails being sent.
	 * 
	 * @return	string
	 */
	function headers()
	{
		return $this->_headers;
	}
	
	/**
	 * Log a message of a certain severity.
	 * 
	 * @param	string				$message	The message to log.
	 * @param	LogMessageSeverity	$severity	The severity of the log message.
	 */
	function log($message, $severity)
	{
		foreach ($this->types() as $type)
			error_log($message, $type, $this->destination(), $this->headers());
	}
	
	/**
	 * Log a message of a certain type.
	 * 
	 * @return	array[ErrorLogType]
	 */
	function types()
	{
		return $this->_types;
	}
}

?>