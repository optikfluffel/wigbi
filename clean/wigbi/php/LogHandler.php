<?php

/**
 * Wigbi.PHP.LogHandler class file.
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
 * The Wigbi.PHP.LogHandler class.
 * 
 * This class can be used to log messages of different priorities to
 * different log targets. It supports six different log targets
 * 
 * 	<ul>
 * 		<li>display - bool</li>
 * 		<li>file - file URL</li>
 * 		<li>firebug - bool</li>
 * 		<li>mailadresses - array</li>
 * 		<li>syslog - bool</li>
 * 		<li>window - bool</li>
 * 	</ul>
 * 
 * and can log messages of eight different priority levels:
 * 
 * 	<ul>
 * 		<li>emergency (0)</li>
 * 		<li>alert (1)</li>
 * 		<li>critical (2)</li>
 * 		<li>error (3)</li>
 * 		<li>warning (4)</li>
 * 		<li>notice (5)</li>
 * 		<li>info (6)</li>
 * 		<li>debug (7)</li>
 * 	</ul>
 * 
 * The easiest way to use the class is to create an instance and use
 * the log function with all parameters set. This will cause the log
 * handler to log the message as is specified by the parameters.
 * 
 * However, a more flexible way to log is to add sub handlers to the
 * log handler. This makes it possible to fully tailor how different
 * priority levels are handled. For instance, one sub handler can be
 * set to log all messages to file, while another can be set to send
 * e-mails only when critical messages are logged. When log handlers
 * have sub handlers, the log method can be called with just message
 * and priority level.
 * 
 * This is a wrapper for the Pear Log Package (see pear.php.net/Log).
 * Wigbi will automatically include the package when it is included.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP
 * @version			1.0.0
 */
class LogHandler
{
	/**#@+
	 * @ignore
	 */
	public $_handlers = array();
	public $_id = "";
	/**#@-*/
	

	
	/**
	 * Create an instance of the class.
	 * 
	 * @access	public
	 * 
	 * @param	string	$id		The id string that will be added to the logged data; default empty.
	 */
	public function __construct($id = "")
	{
		$this->id($id);
	}
	
	
	
	/**
	 * Get the list of added sub log handlers.
	 * 
	 * @access	public
	 * 
	 * @return	array	The list of added sub log handlers.
	 */
	public function handlers()
	{
		return $this->_handlers;
	}
	
	/**
	 * Get/set the id string that will be added to the logged data.
	 * 
	 * @access	public
	 * 
	 * @param		string	$value	Optional set value.
	 * @return	string					The id string that will be added to the logged data.
	 */
	public function id($value = "")
	{
		if(func_num_args() != 0)
			$this->_id = func_get_arg(0);
		return $this->_id;
	}

	
	
	/**
	 * Add a sub log handler to the log handler. 
	 * 
	 * See the class documentation for further information about how
	 * to use sub log handlers. 
	 * 
	 * @access	public
	 * 
	 * @param	array		$priorities			A list of priority levels that the handle should handle.
	 * @param	bool		$display				Whether or not to log to screen.
	 * @param	string	$file						Path to a log file to log to, if any.
	 * @param	bool		$firebug				Whether or not to log to firebug.
	 * @param	string	$mailaddresses	A comma-separated list of e-mail addresses to which log messages should be sent.
	 * @param	bool		$syslog					Whether or not to log to the system log.
	 * @param	bool		$window					Whether or not to log to a log window.
	 */
	public function addHandler($priorities, $display, $file, $firebug, $mailaddresses, $syslog, $window)
	{
		$handler = array();
		$handler["priorities"] = $priorities;
		$handler["display"] = $display;
		$handler["file"] = $file;
		$handler["firebug"] = $firebug;
		$handler["mailaddresses"] = $mailaddresses;
		$handler["syslog"] = $syslog;
		$handler["window"] = $window;
		
		array_push($this->_handlers, $handler);
	}
	
	/**
	 * Log a message with a certain priority level.
	 * 
	 * If only message and priority (which is optional) is specified,
	 * the handler will attempt to log the message using the sub log
	 * handlers, if any, that have been added to the handler.
	 * 
	 * However, if the method is called with more than the first two
	 * parameters, the handler will by-pass its sub log handlers and
	 * attempt to log the message as is described by the parameters.    
	 * 
	 * @access	public
	 * 
	 * @param		string	$message				The message to log.
	 * @param		int			$priority				The message priority level; default debug (7).
	 * @param		bool		$display				Whether or not to log to screen; default false.
	 * @param		string	$file						Path to a log file to log to, if any; default none.
	 * @param		bool		$firebug				Whether or not to log to firebug; default false.
	 * @param		string	$mailaddresses	A comma-separated list of e-mail addresses to which log messages should be sent; default blank.
	 * @param		bool		$syslog					Whether or not to log to the system log; default false.
	 * @param		bool		$window					Whether or not to log to a log window; default false.
	 * @return	bool										Whether or not the log operation succeeded.
	 */
	public function log($message, $priority = 7, $display = 0, $file = "", $firebug = 0, $mailaddresses = "", $syslog = 0, $window = 0)
	{
		//Log using any added sub log handlers if two parameters at most are set
		if (func_num_args() <= 2)
			return $this->logWithSubLogHandlers($message, $priority); 
		
		//Init log singleton
		$composite = &Log::singleton('composite');
		
		//Define handlers
		$displayHandler = &Log::singleton('display', '', $this->id());
		$fileHandler = &Log::singleton('file', $file, $this->id());
		$firebugHandler = &Log::singleton('firebug', '', $this->id());
		$mailHandler = &Log::singleton('mail', $mailaddresses, $this->id());
		$syslogHandler = &Log::singleton('syslog', '', $this->id());
		$windowHandler = &Log::singleton('win', 'LogWindow', $this->id());
			
		//Enable display logging, if set
		if ($display)
			$composite->addChild($displayHandler);
			
		//Enable file logging, if set
		if ($file)
			$composite->addChild($fileHandler);
			
		//Enable Firebug logging, if set
		if ($firebug)
			$composite->addChild($firebugHandler);
			
		//Enable e-mail logging, if set
		if ($mailaddresses)
			$composite->addChild($mailHandler);
			
		//Enable system logging, if set
		if ($syslog)
			$composite->addChild($syslogHandler);
		
		//Enable window logging, if set
		if ($window)
			$composite->addChild($windowHandler);
		
		//Perform the operation
		$composite->log($message, $priority);
		
		//Remove all handlers
		$composite->removeChild($displayHandler);
		$composite->removeChild($fileHandler);
		$composite->removeChild($firebugHandler);
		$composite->removeChild($mailHandler);
		$composite->removeChild($syslogHandler);
		$composite->removeChild($windowHandler);
		
		//Return success if the code reached here
		return true;
	}
	
	/**
	 * Log a message using any added sub log handlers.
	 * 
	 * This method is called by the log method, if it is called with
	 * not only the message and priority parameters set.
	 * 
	 * @access	public
	 * 
	 * @param		string	$message		The message to log.
	 * @param		int			$priority		The message priority level; default debug (7).
	 * @return	bool								Whether or not the log operation succeeded.
	 */
	private function logWithSubLogHandlers($message, $priority = 7)
	{
		//Abort if no log handlers exist
		if (sizeof($this->handlers()) == 0)
			return false;
			
		//Init log singleton
		$composite = &Log::singleton('composite');
		
		//Iterate over all added handlers
		foreach ($this->handlers() as $handler)
		{
			//Skip if the handler is not interested in the priority
			if (!in_array($priority, $handler["priorities"]))
				continue;
			
			//Define handlers
			$displayHandler = &Log::singleton('display', '', $this->id());
			$fileHandler = &Log::singleton('file', $handler["file"], $this->id());
			$firebugHandler = &Log::singleton('firebug', '', $this->id());
			$mailHandler = &Log::singleton('mail', $handler["mailaddresses"], $this->id());
			$syslogHandler = &Log::singleton('syslog', '', $this->id());
			$windowHandler = &Log::singleton('win', 'LogWindow', $this->id());
			
			//Enable display logging, if set
			if ($handler["display"])
				$composite->addChild($displayHandler);
			
			//Enable file logging, if set
			if ($handler["file"])
				$composite->addChild($fileHandler);
				
			//Enable Firebug logging, if set
			if ($handler["firebug"])
				$composite->addChild($firebugHandler);
				
			//Enable e-mail logging, if set
			if ($handler["mailaddresses"] > 0)
				$composite->addChild($mailHandler);
				
			//Enable system logging, if set
			if ($handler["syslog"])
				$composite->addChild($syslogHandler);
			
			//Enable window logging, if set
			if ($handler["window"])
				$composite->addChild($windowHandler);
			
			//Perform the operation
			$composite->log($message, $priority);
			
			//Remove all handlers
			$composite->removeChild($displayHandler);
			$composite->removeChild($fileHandler);
			$composite->removeChild($firebugHandler);
			$composite->removeChild($mailHandler);
			$composite->removeChild($syslogHandler);
			$composite->removeChild($windowHandler);
		}
		
		//Return success if the code reached here
		return true;
	}
}

?>