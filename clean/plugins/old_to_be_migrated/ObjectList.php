<?php
/**
 * Wigbi.PHP.Controls.ObjectList class file.
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
 * The ObjectList control class.
 * 
 * This control can be used to list objects, using a start and stop
 * string to define the list type as well as a custom item function.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * After a control instance has been added to the page, it can be set
 * to refresh its item collection as well as its formatting. 
 * 
 * Note that the PHP and JavaScript add functions are a bit different.
 * PHP uses function NAMES while JavaScript uses a function REFERENCE.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * ObjectList : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string endString()</li>
 * 		<li>public string setEndString(string newVal)</li>
 * 		<li>public string itemFunction(item, index)</li>
 * 		<li>public void setItemFunction(function newVal)</li>
 * 		<li>public string startString()</li>
 * 		<li>public string setStartString(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, array objects, string startString, function itemFunction, string endString, string targetElementId, function onAdd)</li>
 * 		<li>public static void refresh(array objects, string startString, function itemFunction, string endString)</li>
 * 	</ul>
 * 
 * The itemFunction reference defines how each item will be displayed.
 * It is mandatory in the add function, but optional in refresh, just
 * like startString and endString.
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.99.2
 * @version		0.99.2
 */
class ObjectList extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only intended to be used by Wigbi at startup.
	 * 
	 * @access	public
	*/
	public function __construct()
	{
		//Register the general JavaScript
		$this->registerJavaScript(@"
ObjectList = Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	_itemFunction: null,
	
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
	},
	
	
	/* Properties *************/

	//Get/set the string to end the item listing with, e.g. </ul>
	endString: function() { return this.form().endString.value; },
	setEndString: function(newVal) { this.form().endString.value = newVal; },
	
	//Get/set the function itself (not the name) that is to be used to build item strings 
	itemFunction: function() { return this._itemFunction; },
	setItemFunction: function(newVal) { this._itemFunction = newVal; },
	
	//Get/set the string to begin the item listing with, e.g. <ul>
	startString: function() { return this.form().startString.value; },
	setStartString: function(newVal) { this.form().startString.value = newVal; },
	
	
	/* Functions **************/
	
	//Refresh the list with new items and optionally new end and start strings
	refresh: function(items, startString, itemFunction, endString)
	{
		//Update object properties
		if (startString)
			this.setStartString(startString);
		if (itemFunction)
			this.setItemFunction(itemFunction);
		if (endString)
			this.setEndString(endString);
			
		//Update HTML content
		var html = this.startString();
		for (var i=0; i<items.length; i++)
			html += this._itemFunction(items[i], i);
		html += this.endString();
		$('#' + this.controlId() + '-container').html(html);
	}
});


/* Static functions ********/

//Add a new control instance to the page with AJAX
ObjectList.add = function(controlId, items, startString, jsItemFunction, endString, targetElementId, onAdd)
{
	Wigbi.executeFunction('ObjectList', null, 'add', [controlId, [], startString, '', endString, onAdd], function(result)
	{
		//Add, create and init the control
		$('#' + targetElementId).html(result);
		new ObjectList(controlId);
		Wigbi.getControl(controlId).refresh(items, startString, jsItemFunction, endString);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add an ObjectList control to the page.
	 * 
	 * The PHP item functions can be used to build a string for each list
	 * item. It must take an object and an index integer as parameters and
	 * must return a string, which will represent the object in the list.
	 * 
	 * The JavaScript function also takes an object and an index integer,
	 * and must also return a string that represents the object. However,
	 * the JavaScript function will only apply when new objects are added
	 * to the list with the JavaScript refresh function.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId			The unique control ID.
	 * @param	array	$items				The items to display in the list.
	 * @param	string	$startString		The string to begin the item listing with, e.g. <ul>.
	 * @param	string	$phpItemFunction	The name of the PHP item function.
	 * @param	string	$jsItemFunction		The name of the JavaScript item function, if any.
	 * @param	string	$endString			The string to end the item listing with, e.g. </ul>.
	 * 
	 */
	public static function add($controlId, $items, $startString, $phpItemFunction, $jsItemFunction, $endString)
	{
		BaseControl::openForm("ObjectList", $controlId);
		?>
			<input type="hidden" name="startString" value="<?php print $startString; ?>" />
			<input type="hidden" name="endString" value="<?php print $endString; ?>" />
			
			<div id="<?php print $controlId ?>-container">
				<?php
				print $startString;
				for ($i=0; $i<sizeof($items); $i++)
					print call_user_func($phpItemFunction, $items[$i], $i);
				print $endString;
				?>	
			</div>
			
			<script type="text/javascript">
				new ObjectList("<?php print $controlId ?>");
				Wigbi.getControl("<?php print $controlId ?>").setItemFunction(<?php print $jsItemFunction ?>);
			</script>
		<?php
		BaseControl::closeForm();
	}
}
?>