<?php

/**
 * Wigbi.PHP.Core.WigbiDataPluginJavaScriptGenerator class file.
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
 * The Wigbi.PHP.Core.WigbiDataPluginJavaScriptGenerator class.
 * 
 * This class is used to create JavaScript class code for Wigbi data
 * plugins. It is used by Wigbi and should not be used by developers.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP.Core
 * @version			1.0.0
 * 
 * @static
 */
class WigbiDataPluginJavaScriptGenerator
{
	/**
	 * Get the JavaScript class code for a certain data plugin.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param		WigbiDataPlugin	$dataPlugin	The object for which a class should be created.
	 * @return	string											The resulting JavaScript class code.
	 */
	public static function getJavaScript($dataPlugin)
	{		
		//Reset the object
		$dataPlugin->reset();
		
		//Define working objects
		$line = "\r\n";
		$line2 = $line . $line;
		$tab = "\t";
		$propertyNames = $dataPlugin->databaseVariables_self();
		$propertyValues = array();
		$ajaxFunctions = $dataPlugin->ajaxFunctions();
		
		//Retrieve database variable values
		foreach ($propertyNames as $property)
		{
			//Get property value
			$value = $dataPlugin->$property;
			
			//Adjust default values
			switch (gettype($value))
			{
				case "boolean":
					$value = $value ? "true" : "false";
					break;
					
				case "string":
					$value = json_encode($value);
					break;
			}
			
			//Add value to array
			array_push($propertyValues, $value);
		}
		
		//Add class header and begin class
		$result = "function " . $dataPlugin->className() . "()" . $line . "{" . $line2;
		
		//Private variables
		$result .= $tab . "/"."* Private variables *****"."/" . $line2;
		for ($i=0; $i<sizeof($propertyNames); $i+=1)
			$result .= $tab . "this." . $propertyNames[$i] . " = " . $propertyValues[$i] . ";" . $line;
		$result .= $line2;
		
		//Inheritance
		$result .= $tab . "/"."* Initialize ************"."/" . $line2;
		$result .= '$.extend(this, new WigbiDataPlugin());' . $line;
		$result .= $line2;

		//Properties
		for ($i=0; $i<sizeof($propertyNames); $i+=1)
		{
			$result .= ($i == 0) ? $line . $line2 . "	/"."* Properties ************"."/" : "";
			$result .= $line2;
			
			$result .= $tab . "/"."/ Get/set the value of the " . $propertyNames[$i] . " variable" . $line;
			$result .= $tab . "this." . substr($propertyNames[$i], 1) . " = function(newVal)" . $line . "	{" . $line;
			$result .= $tab . "if (typeof(newVal) != 'undefined')" . $line;
			$result .= $tab . $tab . "this." . $propertyNames[$i] . " = newVal;" . $line; 
			$result .= $tab . "return this." . $propertyNames[$i] . ";" . $line;
			$result .= $tab . "};"; 
		}
		
		//Non-static functions
		$firstFunction = true;
		for ($i=0; $i<sizeof($ajaxFunctions); $i+=1)
		{
			if ($ajaxFunctions[$i]->isStatic())
				continue;
			
			$result .= $firstFunction ? $line . $line2 . "	/"."* Non-static AJAX functions *********"."/" : "";
			$firstFunction = false;
			$result .= $line2;
			
			$result .= $tab . "	/"."/ Perform an asynchronous " . $ajaxFunctions[$i]->name() . " function" . $line;
	 		$result .= $tab . "this." . $ajaxFunctions[$i]->name() . " = function(";
			$result .= join(", ", $ajaxFunctions[$i]->parameters());
			$result .= (sizeof($ajaxFunctions[$i]->parameters()) > 0) ? ", " : "";
			$result .= "on" . ucfirst($ajaxFunctions[$i]->name()) . ") { ";
			$result .= 'Wigbi.ajax("' . $dataPlugin->className() . '", this, "' . $ajaxFunctions[$i]->name() . '", [' . join(", ", $ajaxFunctions[$i]->parameters()) . '], ' . 'on' . ucfirst($ajaxFunctions[$i]->name()) . '); };';			 
		}

		//End class
		$result .= $line . "};";
		
		//Static functions
		$firstFunction = true;
		for ($i=0; $i<sizeof($ajaxFunctions); $i+=1)
		{
			if (!$ajaxFunctions[$i]->isStatic())
				continue;
			
			$result .= $firstFunction ? $line . $line2 . "/"."* Static AJAX functions *********"."/" : "";
			$firstFunction = false;
			$result .= $line2;
			
			$result .= "/"."/ Perform an asynchronous " . $ajaxFunctions[$i]->name() . " function" . $line;
	 		$result .= "" . $dataPlugin->className() . "." . $ajaxFunctions[$i]->name() . " = function(";
			$result .= join(", ", $ajaxFunctions[$i]->parameters());
			$result .= (sizeof($ajaxFunctions[$i]->parameters()) > 0) ? ", " : "";
			$result .= "on" . ucfirst($ajaxFunctions[$i]->name()) . ") { ";
			$result .= 'Wigbi.ajax("' . $dataPlugin->className() . '", null, "' . $ajaxFunctions[$i]->name() . '", [' . join(", ", $ajaxFunctions[$i]->parameters()) . '], ' . 'on' . ucfirst($ajaxFunctions[$i]->name()) . '); };';			 
		}
		
		//Return result
		return $result;
	}
}


/**#@+
 * @ignore
 */

/**
 * Util class that is used to return all public object variables.
 */
class WigbiDataPluginJavaScriptGeneratorBaseClass extends WigbiDataPlugin { }
/**#@-*/

?>