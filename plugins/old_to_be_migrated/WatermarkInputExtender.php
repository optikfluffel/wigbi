<?php
/**
 * Wigbi.PHP.Controls.WatermarkInputExtender class file.
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
 * The WatermarkInputExtender extender class.
 * 
 * This extender can be used to add watermark text to input elements.
 * The text appears if no text is entered into the input element and
 * disappears when the control is focused.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * WatermarkInputExtender : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public get string elementId()</li>
 * 		<li>private string originalColor()</li>
 * 		<li>private void setOriginalColor(string newVal)</li>
 * 		<li>public string watermarkColor()</li>
 * 		<li>public void setWatermarkColor(string newVal)</li>
 * 		<li>public string watermarkText()</li>
 * 		<li>public void setWatermarkText(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>public static void add(string elementId, string watermarkText, string watermarkColor)</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.9
 * @version		0.99.2
 */
class WatermarkInputExtender extends BaseControl
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
		//Register the general JavaScript control code
		$this->registerJavaScript(@"
WatermarkInputExtender = Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	_elementId: '',
	_originalColor: '',
	_watermarkColor: '',
	_watermarkText: '',
	
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId, elementId, watermarkText, watermarkColor)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Set variables
		var _this = this;
		this._elementId = elementId;
		this._watermarkColor = watermarkColor;
		this._watermarkText = watermarkText;
		
		//Get element and original color
		var element = document.getElementById(elementId);
		this._originalColor = element.style.color;
		
		//Add watermark behavior
		element.onfocus = function()
		{
			if (element.value == _this.watermarkText())
			{
				element.value = '';
				element.style.color = _this.originalColor();
			};
		};
		
		//Add watermark behavior
		element.onblur = function()
		{
			if (element.value.trim().length == 0)
			{
				element.value = _this.watermarkText();
				element.style.color = _this.watermarkColor();
			};
		};
		
		//Initially blur the element
		element.blur();
		element.value = watermarkText;
		element.style.color = watermarkColor;
	},
	
	
	/* Properties *************/
	
	//Get the element ID
	elementId: function() { return this._elementId; },
	
	//Get/set the watermark color
	originalColor: function() { return this._originalColor; },
	setOriginalColor: function(newVal) { this._originalColor = newVal; },
	
	//Get/set the watermark color
	watermarkColor: function() { return this._watermarkColor; },
	setWatermarkColor: function(newVal)
	{
		this._watermarkColor = newVal;
		document.getElementById(this.elementId()).value = '';
		document.getElementById(this.elementId()).onblur();
	},
	
	//Get/set the watermark text
	watermarkText: function() { return this._watermarkText; },
	setWatermarkText: function(newVal)
	{
		this._watermarkText = newVal;
		document.getElementById(this.elementId()).value = '';
		document.getElementById(this.elementId()).onblur();
	}
});


/* Static functions ********/

//Add a new extender instance to the page with AJAX
WatermarkInputExtender.add = function(controlId, inputElementId, watermarkText, watermarkColor)
{
	new WatermarkInputExtender(controlId, inputElementId, watermarkText, watermarkColor);
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a WatermarkInputExtender extender to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	string	$elementId		The ID of the target element.
	 * @param	string	$watermarkText	The text to display when the element has no input value.
	 * @param	string	$watermarkColor	The text color to use when the element has no input value; default black.
	 */
	public static function add($controlId, $elementId, $watermarkText, $watermarkColor = "#000000")
	{
		?><script type="text/javascript">
			WatermarkInputExtender.add('<?php print $controlId; ?>', '<?php print $elementId; ?>', '<?php print $watermarkText; ?>', '<?php print $watermarkColor; ?>');
		</script><?php
	}
}
?>