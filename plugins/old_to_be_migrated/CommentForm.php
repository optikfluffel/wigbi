<?php
/**
 * Wigbi.PHP.Controls.CommentForm class file.
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
 * The CommentForm control class.
 * 
 * This control can be used to comment just about anything. It is to
 * be used when the author is unknown, since it has elements to set
 * the name, e-mail address and web site of the author. 
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the Comment seed.
 * 
 * The form will mostly be used to post new comments and not to edit
 * old ones. To make it behave in this way, set resetOnSubmit to true. 
 * 
 * If the groupName property is set, it will only be applied to new
 * comments, not old ones.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * CommentForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string groupName()</li>
 * 		<li>public void setGroupName(string newVal)</li>
 * 		<li>public Comment object()</li>
 * 		<li>public void setObject(Comment obj)</li>
 * 		<li>public bool resetOnSubmit()</li>
 * 		<li>public void setResetOnSubmit(bool newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string objectId, string groupName, bool resetOnSubmit, string targetElementId, function onAdd())</li>
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
 * 		<li>[controlId] CommentForm authorEmail</li>
 * 		<li>[controlId] CommentForm authorEmailInvalid</li>
 * 		<li>[controlId] CommentForm authorName</li>
 * 		<li>[controlId] CommentForm authorUrl</li>
 * 		<li>[controlId] CommentForm authorUrlInvalid</li>
 * 		<li>[controlId] CommentForm reset</li>
 * 		<li>[controlId] CommentForm resetConfirm</li>
 * 		<li>[controlId] CommentForm submit</li>
 * 		<li>[controlId] CommentForm submitError</li>
 * 		<li>[controlId] CommentForm submitted</li>
 * 		<li>[controlId] CommentForm submitting</li>
 * 		<li>[controlId] CommentForm text</li>
 * 		<li>[controlId] CommentForm textRequired</li>
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
class CommentForm extends BaseControl
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
CommentForm = Class({ Extends: BaseControl,
	
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
	
	//Get/set the author e-mail address
	authorEmail: function() { return this.form().authorEmail.value; },
	setAuthorEmail: function(newVal) { this.form().authorEmail.value = newVal; },
	
	//Get/set the author name
	authorName: function() { return this.form().authorName.value; },
	setAuthorName: function(newVal) { this.form().authorName.value = newVal; },
	
	//Get/set the author URL
	authorUrl: function() { return this.form().authorUrl.value; },
	setAuthorUrl: function(newVal) { this.form().authorUrl.value = newVal; },
	
	//Get/set which group name, if any, that should be applied to new objects
	groupName: function() { return this.form().groupName.value; },
	setGroupName: function(newVal) { this.form().groupName.value = newVal; },
	
	//Get/set the bound object.
	object: function()
	{
		var tmpObj = new Comment();
		\$extend(tmpObj, JSON.decode(this.form().object.value));
		return tmpObj;
	},
	setObject: function(obj)
	{
		//Set object
		this.form().object.value = JSON.encode(obj);
		
		//Refresh the control
		this.form().authorName.value = obj.authorName();
		this.form().authorEmail.value = obj.authorEmail();
		this.form().authorUrl.value = obj.authorUrl();
		this.form().text.value = obj.text();
			try { (tinyMCE.get(this.form().text.id).setContent(obj.text())); }
			catch(e) { }
	},
	
	//Get/set whether or not to clear the object once onSubmit is executed
	resetOnSubmit: function() { return JSON.decode(this.form().resetOnSubmit.value); },
	setResetOnSubmit: function(newVal) { this.form().text.value = JSON.encode(newVal); },
	
	//Get/set the author URL
	text: function() { return this.form().text.value; },
	setText: function(newVal) { this.form().text.value = newVal; },
	
	
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
		form.submit.disabled = true;
		form.submit.value = LanguageHandler.translate(_this.controlId() + ' CommentForm submitting') + '...';
				
		//Setup target object
		obj.setAuthorName(form.authorName.value.trim());
		obj.setAuthorEmail(form.authorEmail.value.trim());
		obj.setAuthorUrl(form.authorUrl.value.trim());
		obj.setText(form.text.value.trim());
			try { obj.setText(tinyMCE.get(this.form().text.id).getContent()); }
			catch(e) { }
			
		//Add a group name if the object has no id
		if (!obj.id())
			obj.setGroupName(this.groupName());
			
		//Validate the object
		obj.validate(function(errorList)
		{
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Abort if the object is invalid
			if (errorList.length > 0)
			{	
				//Enable the submit button
				form.submit.disabled = false;
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' CommentForm submitError');
				setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' CommentForm submit'); }, 1000);
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
				
				//Abort the operation
				return;
			}
			
			//Save the object
			obj.save(function()
			{
				//Save down the saved object
				form.object.value = JSON.encode(obj);
	
				//Display that the save succeeded
				form.submit.disabled = false;
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' CommentForm submitted');
				setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' CommentForm submit'); }, 1000);
	
				//Raise the onSubmit event
				_this.onSubmit();
					
				//Clear the object if needed
				if (_this.resetOnSubmit())
					_this.setObject(new Comment());
			});
		});
	},
	
	
	/* Events *****************/
	
	//Raised before the control is submitted
	onPreSubmit: function() { return true; },
	
	//Raised when the control has been submitted
	onSubmit: function() { },
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList) {
		
		alert(JSON.encode(errorList));
		
		
		 },
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('CommentForm', ['authorEmail', 'authorUrl', 'text'], errorList);
	}
});

	
/* Static functions *******/
	
//Add a new control instance to the page with AJAX
CommentForm.add = function(controlId, objectId, groupName, resetOnSubmit, targetElementId, onAdd)
{	
	Wigbi.executeFunction('CommentForm', null, 'add', [controlId, objectId, groupName, resetOnSubmit], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new CommentForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a CommentForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	mixed	$object			The object itself or its ID, if any; default null.
	 * @param	string	$groupName		The group name to apply to new object, if any; default blank.
	 * @param	bool	$resetOnSubmit	Whether or not to reset the form after onSubmit; default false.
	 */
	public static function add($controlId, $object=null, $groupName="", $resetOnSubmit=false)
	{
		//Create temp object
		$tmpObj = new Comment();
		$tmpObj->reset();
		
		//Use the provided object, if any
		if ($object)
			$tmpObj = $object;

		//Load by id if object is a string
		if (gettype($object) == "string")
		{
			$tmpObj = new Comment();
			$tmpObj->load($object);
		}
		
		//Add form
		BaseControl::openForm("CommentForm", $controlId, $tmpObj);
		?>
			<input type="hidden" name="groupName" value="<?php print $groupName; ?>" />
			<input type="hidden" name="resetOnSubmit" value="<?php print json_encode($resetOnSubmit); ?>" />
		
			<div class="control-body">					
				<div class="authorName">
					<?php print LanguageHandler::translate("$controlId CommentForm authorName") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-authorName" name="authorName" value="<?php print $tmpObj->authorName(); ?>" />
				</div>
				<div class="authorEmail">
					<?php print LanguageHandler::translate("$controlId CommentForm authorEmail") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-authorEmail" name="authorEmail" value="<?php print $tmpObj->authorEmail(); ?>" />
				</div>
				<div class="authorUrl">
					<?php print LanguageHandler::translate("$controlId CommentForm authorUrl") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-authorUrl" name="authorUrl" value="<?php print $tmpObj->authorUrl(); ?>" />
				</div>
				<div class="text">
					<?php print LanguageHandler::translate("$controlId CommentForm text") ?>:<br/>
					<textarea class="tinyMce_simple" cols="30" rows="10" id="<?php print $controlId ?>-text-<?php print date('his') ?>" name="text" id="<?php print $controlId; ?>-text"><?php print $tmpObj->text(); ?></textarea>
				</div>
			</div>

			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" onclick="return confirm(LanguageHandler.translate(<?php print $controlId; ?> + 'CommentForm resetConfirm'));" value="<?php print LanguageHandler::translate($controlId . ' CommentForm reset'); ?>" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate($controlId . ' CommentForm submit'); ?>" />
			</div>
			
			<script type="text/javascript">
				new CommentForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
}
?>