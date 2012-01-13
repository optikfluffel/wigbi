<?php
/**
 * Wigbi.PHP.Controls.SeedSearchForm class file.
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
 * The SeedSearchForm control class.
 * 
 * This control can be used for to search for all kinds of seeds. It
 * can base the search operation on all class properties of the seed
 * class as well as a custom search filter.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the seeds that it is to search for.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * MailForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string searchFilter()</li>
 * 		<li>public void setSearchFilter(string newVal)</li>
 * 		<li>public array searchProperties()</li>
 * 		<li>public void setSearchProperties(array newVal)</li>
 * 		<li>public string seedClass()</li>
 * 		<li>public void setSeedClass(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string seedClass, array searchProperties, string searchFilter, string targetElementId, function onAdd())</li>
 * 		<li>public void reset()</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public bool onPreSubmit()</li>
 * 		<li>public void onSubmit(array searchResult)</li>
 * 	</ul>
 * 
 * Override onPreSubmit to set what to do before the form is being
 * submitted. If it returns false, the submit operation will abort.
 * 
 * Override onSubmit to set what to do when the submit operation
 * has finished. By default, it alerts that the mail has been sent.
 * 
 * 
 * LANGUAGE HANDLING *************************
 * 
 * The following language parameters are used by the control:
 * 
 *	<ul>
 *		<li>[controlId] SeedSearchForm submit</li>
 *		<li>[controlId] SeedSearchForm submitted</li>
 *		<li>[controlId] SeedSearchForm submitting</li>
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
class SeedSearchForm extends BaseControl
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
		$this->registerJavaScript("
SeedSearchForm = Class({ Extends: BaseControl,
	
	/* Private variables ******/
	
	//The search object
	_searchObject: null,


	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Bind form submit event
		var _this = this;
		this.form().onsubmit = function() { _this.submit(); return false; };
		
		//Disable textbox autocomplete
		this.form().searchText.setAttribute('autocomplete', 'off');
	},
	
	
	/* Properties *************/
	
	//Get/set the search filter
	searchFilter: function() { return this.form().searchFilter.value; },
	setSearchFilter: function(newVal) { this.form().searchFilter.value = newVal; },
	
	//Get/set the search properties
	searchProperties: function() { return JSON.decode(this.form().searchProperties.value); },
	setSearchProperties: function(newVal) { this.form().searchProperties.value = JSON.encode(newVal); },
	
	//Get/set the search text
	searchText: function() { return this.form().searchText.value; },
	setSearchText: function(newVal) { this.form().searchText.value = newVal; },
	
	//Get/set the seed class
	seedClass: function() { return this.form().seedClass.value; },
	setSeedClass: function(newVal) { this.form().seedClass.value = newVal; },
	
	
	/* Functions **************/
	
	//Reset the control form
	reset: function()
	{
		this.form().textBox.value = '';
	},
	
	//Submit the control form
	submit: function()
	{
		//Create private variables
		var _this = this;
		var form = this.form();
		
		//Raise the onPreSubmit event
		if (!this.onPreSubmit())
			return false;
	
		//Disable the submit button
		form.submit.disabled = true;
		form.submit.value = LanguageHandler.translate(this.controlId() + ' SeedSearchForm submitting') + '...';
		
		//Bind the search string to any properties
		query = '';
		var searchProperties = this.searchProperties();
		for (var i=0; i<searchProperties.length; i++)
		{
			if (i > 0)
				query += ' OR ';
			query += searchProperties[i] + ' LIKE \'%' + this.searchText() + '%\'';			
		}
		
		//Wrap any parameters with a paranthesis, then add any filter
		if (searchProperties.length > 0)
			query = '(' + query + ')';
		if (this.searchFilter())
			query += (searchProperties.length > 0) ?  this.searchFilter().replace('WHERE', 'and') : this.searchFilter();

		//Perform the search
		eval('var tmpObj = new ' + _this.seedClass());
		tmpObj.search(' WHERE ' + query, function(result)
		{
			//Set submit button text
			form.submit.value = LanguageHandler.translate(_this.controlId() + ' SeedSearchForm submitted');
			
			//Raise the onSubmit event
			_this.onSubmit(result);
						
			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' SeedSearchForm submit'); }, 1000);
		});
	},
	
	
	/* Events *****************/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function(searchResults) { }
});

//Add a new control instance to the page
SeedSearchForm.add = function(controlId, seedClass, searchProperties, searchFilter, targetElementId, onAdd)
{
	Wigbi.executeFunction('SeedSearchForm', null, 'add', [controlId, seedClass, searchProperties, searchFilter], function(result)
	{	
		//Add and create the control
		$('#' + targetElementId).html(result);
		new SeedSearchForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}

	
	//Functions ********************
	
	/**
	 * Add a SeedSearchForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId			The unique control ID.
	 * @param	string	$seedClass			The seed class that is to be handled by the control.
	 * @param	array	$searchProperties	The search properties that the search text is to match.
	 * @param	string	$searchFilter		The search filter that is to complete the free text search; default blank.
	 */
	public static function add($controlId, $seedClass, $searchProperties, $searchFilter = "")
	{
		BaseControl::openForm("SeedSearchForm", $controlId);
		?>
			<div class="control-body">
				<input type="hidden" id="<?php print $controlId ?>-seedClass" name="seedClass" value="<?php print $seedClass; ?>" />
				<input type="hidden" id="<?php print $controlId ?>-searchProperties" name="searchProperties" value='<?php print json_encode($searchProperties); ?>' />
				<input type="hidden" id="<?php print $controlId ?>-searchFilter" name="searchFilter" value="<?php print $searchFilter; ?>" />
				
				<div class="searchText">
					<input type="text" id="<?php print $controlId ?>-searchText" name="searchText" />
				</div>
			</div>
			<div class="control-footer">
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId SeedSearchForm submit") ?>" />
			</div>
			
			<script type="text/javascript">
				new SeedSearchForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
}
?>