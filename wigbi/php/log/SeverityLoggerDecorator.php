<?php

/**
 * The Wigbi SeverityLoggerDecorator class file.
 * 
 * Wigbi is released under the MIT license. More info can be found
 * at http://www.opensource.org/licenses/mit-license.php
 */

/**
 * The Wigbi SeverityLoggerDecorator class.
 * 
 * This class can be used to log errors, using another ILogger. It
 * will, however, abort a log operation if the message severity is
 * not of interest.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2012, Daniel Saidi
 * @link			http://www.wigbi.com
 * @package			Wigbi
 * @subpackage		PHP.Log
 * @version			2.0.0
 */
class SeverityLoggerDecorator implements ILogger
{
	private $_logger;
	private $_severities;
	
	/**
	 * @param	ILogger						$logger			The Logger to use for logging.
	 * @param	array[LogMessageSeverity]	$severities		The severities of interest.
	 */
	public function __construct($logger, $severities)
	{
		$this->_logger = $logger;
		$this->_severities = $severities;
	}
	
	
	/**
	 * Log a message of a certain severity.
	 * 
	 * @param	string				$message	The message to log.
	 * @param	LogMessageSeverity	$severity	The severity of the log message.
	 */
	function log($message, $severity)
	{
		foreach ($this->severities() as $_severity)
			if ($_severity == $severity)
				$this->_logger->log($message, $severity);
	}
	
	/**
	 * The log message severities of interest.
	 * 
	 * @return	string
	 */
	function severities()
	{
		return $this->_severities;
	}
}

?>