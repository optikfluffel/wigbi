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
 * The Wigbi.JS.Wigbi class.
 * 
 * This is the main Wigbi class of the Wigbi JavaScript layer. It is
 * fully described in the class documentation, which can be found at
 * http://www.wigbi.com/documentation or downloaded as a part of the
 * Wigbi source code download.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
function Wigbi() {} 


//Private, static variables
Wigbi._ajaxConfigFile = "";
Wigbi._cacheHandler = null;
Wigbi._dataPluginClasses = [];
Wigbi._languageHandler = null;
Wigbi._logHandler = null;
Wigbi._sessionHandler = null;
Wigbi._uiPluginClasses = [];
Wigbi._webRoot = "";


//Get the relative path to the Wigbi async postback page
Wigbi.asyncPostBackPage = function()
{
	return Wigbi.webRoot() + "wigbi/postBack.php";
};

//Get the default Wigbi CacheHandler instance
Wigbi.cacheHandler = function()
{
	return Wigbi._cacheHandler;
};

//Get all available data plugin classes
Wigbi.dataPluginClasses = function()
{
	return Wigbi._dataPluginClasses;
};

//Get the default Wigbi LanguageHandler instance
Wigbi.languageHandler = function()
{
	return Wigbi._languageHandler;
};

//Get the default Wigbi LogHandler instance
Wigbi.logHandler = function()
{
	return Wigbi._logHandler;
};

//Get the default Wigbi SessionHandler instance
Wigbi.sessionHandler = function()
{
	return Wigbi._sessionHandler;
};

//Get all available data plugin classes
Wigbi.uiPlugins = function()
{
	return Wigbi._uiPlugins;
};

//Get all available UI plugin classes
Wigbi.uiPluginClasses = function()
{
	return Wigbi._uiPluginClasses;
};

//Get the web root path
Wigbi.webRoot = function()
{
	return Wigbi._webRoot;
};



//Perform an asynchronous method call
Wigbi.ajax = function(className, object, functionName, functionParameters, callBack)
{
	//Create request object
	var requestObject = {};
	requestObject.configFile = Wigbi._ajaxConfigFile;
	requestObject.webRoot = Wigbi.webRoot();
	requestObject.className = className;
	requestObject.object = object;
	requestObject.functionName = functionName;
	requestObject.functionParameters = functionParameters;
		
	//Handle empty parameters
	if (!requestObject.functionParameters)
		requestObject.functionParameters = [];
		
	//Create async data object
	var asyncData = {"wigbi_asyncPostBack":1, "wigbi_asyncPostBackData":JSON.stringify(requestObject)};
	
	//Define a callback function
	function onCallBack(response)
	{
		if (callBack)
		{
			var result = JSON.parse(response.trim());
			callBack(result[0], result[1]);
		}
	};
	
	//Perform the operation
	$.post(Wigbi.asyncPostBackPage(), asyncData, onCallBack);
};