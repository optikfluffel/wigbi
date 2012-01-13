<?php
/**
 * Wigbi.PHP.Controls.AutoCompleteExtender class file.
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
 * The AutoCompleteExtender extender class.
 * 
 * This extender can be used to connect an input element to a select
 * element. By providing it with a search function, it automatically
 * populates the select element as text is typed in the input field.
 * 
 * The extender can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * The extender initially hides the select element and shows it when
 * the search function executes.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * AutoCompleteExtender : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string inputId()</li>
 * 		<li>public string selectId()</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>public static void add(string controlId, string inputId, string selectId)</li>
 * 		<li>private void hide()</li>
 * 		<li>public virtual void search(function onSearch(Option[] result))</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public void onSelect(Option option)</li>
 * 	</ul>
 * 
 * Override the search function to define how to search for objects.
 * The search function must pass an array to the onSearch parameter.
 * 
 * Override onSelect to set what to do when an element is selected
 * in the list. By default, it does nothing.
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
 * @todo		Refactor and jQuerify the JavaScript code even more.
 * @todo		Replace the select element with an ul list to simplify css. 
 */
class AutoCompleteExtender extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the extender.
	 * 
	 * This constructor is only to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct()
	{	
		//Register the general JavaScript
		$this->registerJavaScript("
AutoCompleteExtender = Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	_inputId: null,
	_selectId: null,
	_timeout: null,
	
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId, inputId, selectId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Init variables
		this._inputId = inputId;
		this._selectId = selectId;
		
		//Set local this reference
		var _this = this;
		
		//Get elements
		var textBox = document.getElementById(inputId);
		var select = document.getElementById(selectId);
		
		//Disable textbox autocomplete and assure a multiple select
		textBox.setAttribute('autocomplete', 'off');

		//Setup text box behavior
		textBox.onkeyup = function(event)
		{
			//Make sure an event exists
			if (!event)
				event = window.event; 

			//Clear the auto complete timer
			clearTimeout(_this.timeout);
			
			//ESCAPE/EMPTY - Abort
			if (this.value.length == 0 || event.keyCode == 27)
			{
				_this.hide();
				return false;
			}			
			
			//A list of keys to ignore
			//LEFT, UP, RIGHT
			var ignore = [37, 38, 39];
			
			//Do not handle ignored keys
			for (var i=0; i<ignore.length; i++)
				if (ignore[i] == event.keyCode)
					return false;
			
			//DOWN - Move focus to the select element if visible and has items
			if (event.keyCode == 40 && select.style.display == '' && select.options.length > 0)
			{
				select.focus();
				select.options[0].selected = true;
				return false;
			}

			//Delay the auto complete
			if (this.value.length > 0)
			{
				_this.timeout = setTimeout(function()
				{
					//Perform a search
					Wigbi.getControl(controlId).search(function(options)
					{
						//Reset and show select box
						select.options.length = 0;
						select.style.display = '';
						select.style.zIndex = 1000;
						select.style.position = 'absolute'; 
						
						//Position the select element
						$('#' + selectId).css('top', $('#' + inputId).position().top + 21);
						$('#' + selectId).css('left', $('#' + inputId).position().left);
						$('#' + selectId).width($('#' + inputId).width() + 5);				
						
						//Add result items
						for (var i=0; i<options.length; i++)
							select.options[select.options.length] = new Option(options[i].text, options[i].value); 
						
						//Enable select mouse behavior
						select.onclick = function(e)
						{
							//Get the selected option and raise event
							for (var i=0; i<this.options.length; i++)
								if (this.options[i].selected)
									Wigbi.getControl(controlId).onSelect(this.options[i]);
		
							//Hide the select element
							_this.hide();
						};
							
						//Setup select key behaviour
						select.onkeyup = function(e)
						{
							//Make sure an event exists
							if (!e)
								e = window.event; 							
							
							//ENTER
							if (e.keyCode == 13)
							{
								//Get the selected option and raise event
								for (var i=0; i<this.options.length; i++)
									if (this.options[i].selected)
										Wigbi.getControl(controlId).onSelect(this.options[i]);
			
								//Hide the select element
								_this.hide();
							}
							
							//ESCAPE
							else if (e.keyCode == 27)
								_this.hide();
						};
					});
				}, 500);
			}
		};
		
		//Initially hide the select
		this.hide();
	},
	
	
	/* Properties *************/
	
	//Get the ID of the input element.
	inputId: function() { return this._inputId; },
	
	//Get the ID of the select element.
	selectId: function() { return this._selectId; },
	
	
	/* Functions **************/
	
	//Hide the select element
	hide: function()
	{
		$('#' + this.selectId()).hide();
		$('#' + this.inputId()).focus();	
	},
	
	//Virtual search function, where onSearch takes an option array
	search: function(onSearch)
	{
		if (onSearch)
			onSearch([]);
	},
	
	
	/* Events *****************/
	
	//Raised when a select item is chosen
	onSelect: function(option) { }
});

//Add an AutoCompleteExtender extender to the page
AutoCompleteExtender.add = function(controlId, inputId, selectId)
{
	new AutoCompleteExtender(controlId, inputId, selectId);
};
");
	}
	

	//Functions ********************
	
	/**
	 * Add an AutoCompleteExtender extender to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @param	string	$inputId	The ID of the input element.
	 * @param	string	$selectId	The ID of the select element.
	 */
	public static function add($controlId, $inputId, $selectId)
	{
		?>
			<script type="text/javascript">
				new AutoCompleteExtender("<?php print $controlId ?>", "<?php print $inputId ?>", "<?php print $selectId ?>");
			</script>
		<?php
	}
}
?>