<?php
/**
 * Wigbi.PHP.Controls.InputValidatorExtender class file.
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
 * The InputValidatorExtender extender class.
 * 
 * This extender can be used to enable input element validation. It
 * supports several validation formats, e.g. e-mail address, float,
 * integer etc. It can also use various modes, like validating when
 * focus is lost, when text is entered, restrict invalid input etc.
 * 
 * The extender can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * The following validation formats are supported as of now:
 * 
 * 	<ul>
 * 		<li>alpha - only letters, like "helloworld"</li>
 * 		<li>alphaNumeric - letters and digits, like "helloworld123"</li>
 * 		<li>commaFloat - a whole or float number with an optional comma separator, like 145 or 14,5</li>
 * 		<li>dotFloat - a whole or float number with an optional dot separator, like 145 or 14.5</li>
 * 		<li>email - an email address, like john.doe@johndoe.com</li>
 * 		<li>integer - a whole number, like 145</li>
 * 		<li>regexp - any regular expression</li>
 * 		<li>required - requires that the input has an entered value</li>
 * </ul>
 * 
 * The alpha and alphaNumeric format can be set to support even more
 * characters. For instance, define "alpha" as "alpha_", to make the
 * format allow underlines as well.
 * 
 * The following validation modes are supported as of now:
 * 
 * 	<ul>
 * 		<li>focus - validation occurs when the input element loses focus</li>
 * 		<li>keyup - validation occurs each time a character is entered into the input field</li>
 * 		<li>restrict - invalid characters are restricted from being typed in at all</li>
 * 	</ul>
 * 
 * The "restrict" validation mode only works with validation formats
 * that can validate chars separately, like alphaNumeric, regexp etc.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * InputValidatorExtender : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public get string elementId()</li>
 * 		<li>public string format()</li>
 * 		<li>public void setFormat(string newVal)</li>
 * 		<li>public string mode()</li>
 * 		<li>public void setMode(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>public static void add(string controlId, string inputElementId, string format, string mode)</li>
 * 		<li>public static void cleanUp(string text, string format)</li>
 * 		<li>public static string getRegExp(string format)</li>
 * 		<li>private void reset()</li>
 * 		<li>public static bool validate(string text, string format)</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public void onValidate(bool result)</li>
 * 	</ul>
 * 
 * Override onValidate to set what to do when the input has been
 * validated. By default, it does nothing.
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
 * 
 * @todo		Improve the key press/down/up handling.
 * @todo		Embed a jQuery plugin that already has this functionality.
 */
class InputValidatorExtender extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the extender.
	 * 
	 * This constructor is only intended to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct()
	{
		//Register the general JavaScript control code
		$this->registerJavaScript(@"
InputValidatorExtender = Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	_elementId: '',
	_format: '',
	_mode: '',
	
	
	/* Constructor ************/
	
	// Create an instance of the class.
	initialize: function(controlId, elementId, format, mode)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Set variables
		this._elementId = elementId;
		this._format = format;
		this._mode = mode;
		
		//Reset the extender behavior
		this.reset();
	},
	
	
	/* Properties *************/
	
	// Get the element ID.
	elementId: function() { return this._elementId; },
	
	// Get/set the validation format.
	format: function() { return this._format; },
	setFormat: function(newVal)
	{
		this._format = newVal;
		this.reset();
	},
	
	// Get/set the validation mode
	mode: function() { return this._mode; },
	setMode: function(newVal)
	{
		this._mode = newVal;
		this.reset();
	},
	
	
	/* Functions **************/
	
	//Reset the control behavior
	reset: function()
	{
		//Get the element
		var element = document.getElementById(this.elementId());
		
		//Reset the element behavior
		element.onblur = function() {};
		element.onkeyup = function() {};
		
		//Get local this reference
		var _this = this;
			
		//Enable the correct mode
		if (this.mode() == 'focus')
		{
			element.onblur = function()
			{
				_this.onValidate(InputValidatorExtender.validate(this.value, _this.format()));
			}
		}
		else if (this.mode() == 'keyup' || this.mode() == 'restrict')
		{
			element.onkeyup = function()
			{
				//Get validation result
				var result = InputValidatorExtender.validate(this.value, _this.format());
				
				//Restrict input if restrict mode is used
				if (_this.mode() == 'restrict' && !result)
					this.value = InputValidatorExtender.cleanUp(this.value, _this.format());
				
				//Raise the onValidate event
				_this.onValidate(result);
			}
		}
	},
	
	
	/* Events *****************/
	
	//Raised when the element has been validated
	onValidate: function(result) { }
});


/* Static functions ********/

//Add a InputValidatorExtender control to the page
InputValidatorExtender.add = function(controlId, inputElementId, format, mode)
{
	new InputValidatorExtender(controlId, inputElementId, format, mode);
};

//Clean up an input element from any invalid input; for now only supported by alpha, alphaNumeric and integer
InputValidatorExtender.cleanUp = function(text, format)
{
	//Abort if true
	if (InputValidatorExtender.validate(text, format))
		return text;
	
	//Remove each invalid character
	for (var i=0; i<text.length; i++)
	{	
		if (!InputValidatorExtender.validate(text[i], format))
		{
			text = text.substr(0, i) + text.substr(i+1, text.length);
			i--;
		}
	}
	
	//Return text
	return text;
};

//Get the corresponding regular expression of a format
InputValidatorExtender.getRegExp = function(format)
{
	if (format.contains('alphaNumeric'))
		format = '^[a-zA-Z0-9' + format.replace('alphaNumeric', '') + ']*$';
	else if (format.contains('alpha'))
		format = '^[a-zA-Z' + format.replace('alpha', '') + ']*$';
	else if (format == 'commaFloat')
		format = '^\\\\d+(\\\\,\\\\d?)?$';
	else if (format == 'dotFloat')
		format = '^\\\\d+(\\\\.\\\\d?)?$';
	else if (format == 'email')
		format = '^([a-zA-Z0-9_\\\\.\\\\-])+\\\\@(([a-zA-Z0-9\\\\-])+\\\\.)+([a-zA-Z0-9]{2,4})+$';
	else if (format == 'integer')
		format = '^\\\\d+$';
	return format;
};

//Validate an input element value
InputValidatorExtender.validate = function(text, format)
{
	//Init result
	var result = false;
	
	//Handle non-regexp-based validation (tmp)
	if (format == 'required')
		result = text.trim().length > 0;
		
	//Handle regexp-based validation
	else 
		result = text.test(InputValidatorExtender.getRegExp(format));

	//Return result
	return result;
};");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a InputValidatorExtender extender to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	string	$elementId		The ID of the target element.
	 * @param	string	$format			The validation format; default "regexp".
	 * @param	string	$mode			The validation mode; default "focus". 
	 */
	public static function add($controlId, $elementId, $format = "regexp", $mode = "focus")
	{
		?><script type="text/javascript">
			InputValidatorExtender.add('<?php print $controlId; ?>', '<?php print $elementId; ?>', '<?php print $format; ?>', '<?php print $mode; ?>');
		</script><?php
	}
}
?>