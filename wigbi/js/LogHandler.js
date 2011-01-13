/**
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
 * The Wigbi.JS.LogHandler class.
 * 
 * This class is fully described in the class documentation that can
 * be found at http://www.wigbi.com/documentation or downloaded as a
 * part of the Wigbi source code download.
 *  
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
function LogHandler(id)
{
	//Private variables
	this._id = id;
	this._handlers = [];
	this._priorityNames = ["emergency", "alert", "critical", "error", "warning", "notice", "info", "debug"];


	//Inherit WigbiClass
	$.extend(this, new WigbiClass());
    

	//Get the list of added sub log handlers
	this.handlers = function()
	{
		return this._handlers;
	};
	
	//Get/set the id string that will be added to the logged data
	this.id = function(newVal)
	{
		if (typeof(newVal) != "undefined")
			this._id = newVal;
		if (typeof(this._id) == "undefined")
			this._id = "";
		return this._id;
	};
	

	//Add a sub log handler
	this.addHandler = function(priorities, display, file, firebug, mailaddresses, syslog, window)
	{
		var handler = {};
		handler["priorities"] = priorities;
		handler["display"] = display;
		handler["file"] = file;
		handler["firebug"] = firebug;
		handler["mailaddresses"] = mailaddresses;
		handler["syslog"] = syslog;
		handler["window"] = window;
		
		this._handlers.push(handler);
	};
	
	//Get an object that can be used in asynchronous operations
	this.getRequestObject = function()
	{
		//Create request object
		var obj = new LogHandler();
		$.extend(obj, this);
		
		//Adjust each sub handler
		for (var i in obj._handlers)
			if (obj._handlers[i]["file"])
				obj._handlers[i]["file"] = "../../" + obj._handlers[i]["file"];
		
		//Return request object	
		return obj;	
	};
	
	//Log a message with a certain priority level
	this.log = function(message, priority, onLog)
	{
		//Use debug (7) by default
		if (typeof(priority) == "undefined")
			priority = 7;
			
		//Get and adjust the AJAX request object
		var obj = this.getRequestObject();
		
		//Init client log flags
		var display = false;
		var firebug = false;
		var window = false;
		
		//Disable display and firebug and handle them separately
		for (var i in obj._handlers)
		{
			//Get handler and init log flag
			var handler = obj._handlers[i];
			var log = false;
			
			//Handle logging if the handler uses the priority
			for (var j=0; j<handler["priorities"].length; j++)	
				log = log || (parseInt(handler["priorities"][j]) == priority);
			
			//Handle logging only if the log flag is raised
			if (log)
			{
				//Check if an async logging should be done
				var async = false;
				async = async || handler["file"];
				async = async || handler["mailaddresses"];
				async = async || handler["syslog"];
				
				//Check if a client-based logging should be done
				display = display || handler["display"];
				firebug = firebug || handler["firebug"];
				window = window || handler["window"];
				
				//Perform an async logging for each sub handler
				if (async)
					Wigbi.ajax("LogHandler", obj, "log", [message, priority, 0, handler["file"], 0, handler["mailaddresses"], handler["syslog"], 0], onLog);
			}
		}
		
		//If display is enabled, write to document
		if (display)
			document.write("<strong>" + this._priorityNames[priority] + "</strong>: " + message);
		if (firebug)
			console.error("[" + this._priorityNames[priority] + "] " + message);
		if (window)
			this.logToWindow(this._priorityNames[priority], message);
	};
	
	//Log a message to a separate window
	this.logToWindow = function(priorityName, message)
	{
		//Create window if none exists
		if (typeof LogWindow == 'undefined')
		{
			LogWindow = window.open('', 'LogWindow', 'toolbar=no,scrollbars,width=600,height=400');
			LogWindow.document.writeln('<html>');
			LogWindow.document.writeln('<head>');
			LogWindow.document.writeln('<title>Log Output Window</title>');
			LogWindow.document.writeln('<style type="text/css">');
			LogWindow.document.writeln('body { font-family: monospace; font-size: 8pt; }');
			LogWindow.document.writeln('td,th { font-size: 8pt; }');
			LogWindow.document.writeln('td,th { border-bottom: #999999 solid 1px; }');
			LogWindow.document.writeln('td,th { border-right: #999999 solid 1px; }');
			LogWindow.document.writeln('tr { text-align: left; vertical-align: top; }');
			LogWindow.document.writeln('td.l0 { color: red; }');
			LogWindow.document.writeln('td.l1 { color: orange; }');
			LogWindow.document.writeln('td.l2 { color: yellow; }');
			LogWindow.document.writeln('td.l3 { color: green; }');
			LogWindow.document.writeln('td.l4 { color: blue; }');
			LogWindow.document.writeln('td.l5 { color: indigo; }');
			LogWindow.document.writeln('td.l6 { color: violet; }');
			LogWindow.document.writeln('td.l7 { color: black; }');
			LogWindow.document.writeln('</style>');
			LogWindow.document.writeln('</head>');
			LogWindow.document.writeln('<body>');
			LogWindow.document.writeln('<table border="0" cellpadding="2" cellspacing="0">');
			LogWindow.document.writeln('<tr><th>Time</th>');
			
			LogWindow.document.writeln('<th>Priority</th><th width="100%">Message</th></tr>');
		}
		
		//Log if window exists
		if (typeof LogWindow != 'undefined')
		{
			LogWindow.document.writeln('<tr><td>22:14:00.88</td><td>' + priorityName + '</td><td class=\"l0\">' + message + '</td></tr>');
			self.focus();
		}
	};
};