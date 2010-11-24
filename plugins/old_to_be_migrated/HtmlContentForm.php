<?php
/**
 * Wigbi.PHP.Controls.HtmlContentForm class file.
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
 * The HtmlContentForm control class.
 * 
 * This control can be used edit or create HtmlContent objects. It can
 * be used separately or embedded within an HtmlContentControl.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the HtmlContent seed.
 * 
 * In order to convert the textarea to a WYSIWYG editor, make sure to
 * enable Tiny MCE with the TinyMceExtender control.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * HtmlContentForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public HtmlContent object()</li>
 * 		<li>public void setObject(HtmlContent obj)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string objectIdOrName, string targetElementId, function onAdd())</li>
 * 		<li>public void reset()</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public bool onPreSubmit()</li>
 * 		<li>public void onSubmit()</li>
 * 		<li>public void onSubmitError(string[] errorList)</li>
 * 		<li>public void onValidate(string[] errorList)</li>
 * 	</ul>
 * 
 * Override onPreSubmit to set what to do before the form is being
 * submitted. If it returns false, the submit operation will abort.
 * 
 * Override onSubmit to set what to do when the submit operation
 * has finished. By default, it does nothing.
 * 
 * Override onSubmitError to set what to do when a submit operation
 * fails. By default, it does nothing.
 * 
 * Override onValidate to set what to do when the object has been
 * validated. By default, it binds the result to the form.
 * 
 * 
 * LANGUAGE HANDLING *************************
 * 
 * The following language parameters are used by the control:
 * 
 *	<ul>
 * 		<li>[controlId] HtmlContentForm content</li>
 * 		<li>[controlId] HtmlContentForm name</li>
 * 		<li>[controlId] HtmlContentForm nameExists</li>
 * 		<li>[controlId] HtmlContentForm nameRequired</li>
 * 		<li>[controlId] HtmlContentForm reset</li>
 * 		<li>[controlId] HtmlContentForm resetConfirm</li>
 * 		<li>[controlId] HtmlContentForm submit</li>
 * 		<li>[controlId] HtmlContentForm submitError</li>
 * 		<li>[controlId] HtmlContentForm submitted</li>
 * 		<li>[controlId] HtmlContentForm submitting</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.99.3
 * @version		0.99.3
 */
class HtmlContentForm extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct()
	{	
		//Register the general JavaScript
		$this->registerJavaScript(@"
HtmlContentForm = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Bind form submit event
		var _this = this;
		this.form().onsubmit = function() { _this.submit(); return false; };
	},
	
	
	/* Properties *************/
	
	//Get/set the bound object.
	object: function()
	{
		var tmpObj = new HtmlContent();
		\$extend(tmpObj, JSON.decode(this.form().object.value));
		return tmpObj;
	},
	setObject: function(obj)
	{
		//Set object
		this.form().object.value = JSON.encode(obj);
		
		//Refresh the control
		this.form().name.value = obj.name();
		this.form().content.value = obj.content();
			try { (tinyMCE.get(this.form().content.id).setContent(obj.content())); }
			catch(e) { }
	},
	
	
	/* Functions **************/
	
	//Reset the control form
	reset: function()
	{
		this.form().reset.click();
	},
	
	//Submit the control form
	submit: function()
	{
		//Create private variables
		var _this = this;
		var form = this.form();
		var obj = this.object();
		
		//Raise the onPreSubmit event
		if (!this.onPreSubmit())
			return false;

		//Disable the submit button
		this.form().submit.disabled = true;
		this.form().submit.value = LanguageHandler.translate(_this.controlId() + ' HtmlContentForm submitting') + '...';
				
		//Setup target object
		obj.setName(form.name.value);
		obj.setContent(form.content.value); 
			try { obj.setContent(tinyMCE.get(this.form().content.id).getContent()); }
			catch(e) { }
			
		//Validate the object
		obj.validate(function(errorList)
		{
			//Call the onValidate event
			_this.onValidate(errorList);
			
			//Abort if the object is invalid
			if (errorList.length > 0)
			{	
				//Enable the submit button
				form.submit.disabled = false;
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' HtmlContentForm submitError');
				setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' HtmlContentForm submit'); }, 1000);
			
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
					
				//Abort the operation
				return;
			}
			
			//Save the target object
			obj.save(function()
			{
				//Save down the saved object
				form.object.value = JSON.encode(obj);
	
				//Display that the save succeeded
				form.submit.disabled = false;
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' HtmlContentForm submitted');
				setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' HtmlContentForm submit'); }, 1000);
	
				//Raise the onSubmit event
				_this.onSubmit();
			});
		});
	},
	
	
	/* Events *****************/
	
	//Raised before the control is submitted
	onPreSubmit: function() { return true; },
	
	//Raised when the control has been submitted
	onSubmit: function() { },
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList) { },
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('HtmlContentForm', ['name'], errorList);
	}
});

	
/* Static functions *******/
	
//Add a new control instance to the page with AJAX
HtmlContentForm.add = function(controlId, obj, targetElementId, onAdd)
{	
	Wigbi.executeFunction('HtmlContentForm', null, 'add', [controlId, obj], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new HtmlContentForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a HtmlContentForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @param	mixed	$object		The object itself or its ID or name, if any; default null.
	 */
	public static function add($controlId, $object=null)
	{
		//Create temp object
		$tmpObj = new HtmlContent();
		$tmpObj->reset();
		
		//Use the provided object, if any
		if ($object)
			$tmpObj = $object;

		//Handle id/name if object is a string
		if (gettype($object) == "string")
		{
			//First, load by ID
			$tmpObj = new HtmlContent();
			$tmpObj->load($object);
				
			//Second, load by name if needed
			if ($tmpObj->id() != $object)
			{
				$tmpObj->loadBy("name", $object);
				$tmpObj->setName($object);
			}
		}
		
		//Add form
		BaseControl::openForm("HtmlContentForm", $controlId, $tmpObj);
		?>
			<div class="control-body">					
				<div class="name">
					<?php print LanguageHandler::translate("$controlId HtmlContentForm name") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-name" name="name" value="<?php print $tmpObj->name(); ?>" />
				</div>
				<div class="content">
					<?php print LanguageHandler::translate("$controlId HtmlContentForm content") ?>:<br/>
					<textarea cols="30" rows="10" id="<?php print $controlId ?>-content-<?php print date('his') ?>" name="content" id="<?php print $controlId; ?>_content" class="tinyMce"><?php print $tmpObj->content(); ?></textarea>
				</div>
			</div>

			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" onclick="return confirm(LanguageHandler.translate(<?php print $controlId; ?> + 'HtmlContentForm resetConfirm'));" value="<?php print LanguageHandler::translate($controlId . ' HtmlContentForm reset'); ?>" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate($controlId . ' HtmlContentForm submit'); ?>" />
			</div>
			
			<script type="text/javascript">
				new HtmlContentForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
}
?>