<?php
/**
 * Wigbi.PHP.Controls.UserPasswordChangeForm class file.
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
 * The UserPasswordChangeForm control class.
 * 
 * This control can be used to change the password of a certain user.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the User seed.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * UserPasswordChangeForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string userId()</li>
 * 		<li>public void setUserId(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string userId, string targetElementId, function onAdd())</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 		<li>public void reset()</li>
 * 		<li>[ASYNC] public static void updatePassword(string userId, string oldPassword, string newPassword, string newPasswordConfirm, function onUpdatePassword(string[] errorCodes))</li>
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
 * has finished. By default, it alerts that the password has been
 * updated.
 * 
 * Override onSubmitError to set what to do when a submit operation
 * fails. By default, it alerts all errors in the error list.
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
 * 		<li>[controlId] UserPasswordChangeForm confirmPassword</li>
 * 		<li>[controlId] UserPasswordChangeForm confirmPasswordInvalid</li>
 * 		<li>[controlId] UserPasswordChangeForm confirmPasswordRequired</li>
 * 		<li>[controlId] UserPasswordChangeForm newPassword</li>
 * 		<li>[controlId] UserPasswordChangeForm newPasswordInvalid</li>
 * 		<li>[controlId] UserPasswordChangeForm newPasswordRequired</li>
 * 		<li>[controlId] UserPasswordChangeForm oldPassword</li>
 * 		<li>[controlId] UserPasswordChangeForm oldPasswordInvalid</li>
 * 		<li>[controlId] UserPasswordChangeForm oldPasswordRequired</li>
 * 		<li>[controlId] UserPasswordChangeForm reset</li>
 * 		<li>[controlId] UserPasswordChangeForm submit</li>
 * 		<li>[controlId] UserPasswordChangeForm submitError</li>
 * 		<li>[controlId] UserPasswordChangeForm submitErrorMessage</li>
 * 		<li>[controlId] UserPasswordChangeForm submitMessage</li>
 * 		<li>[controlId] UserPasswordChangeForm submitted</li>
 * 		<li>[controlId] UserPasswordChangeForm submitting</li>
 * 		<li>[controlId] UserPasswordChangeForm userIdInvalid</li>
 * 		<li>[controlId] UserPasswordChangeForm userIdRequired</li>
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
class UserPasswordChangeForm extends BaseControl
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
UserPasswordChangeForm = Class({ Extends: BaseControl,
	
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
	
	// Get/set the user ID.
	userId: function() { return this.form().userId.value; },
	setUserId: function(newVal) { this.form().userId.value = newVal; },
	
	
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
		
		//Raise the onPreSubmit event
		if (!this.onPreSubmit())
			return false;
	
		//Disable the submit button
		form.submit.disabled = true;
		form.submit.value = LanguageHandler.translate(this.controlId() + ' UserPasswordChangeForm submitting') + '...';
		
		//Try to register the user
		UserPasswordChangeForm.updatePassword(this.userId(), form.oldPassword.value, form.newPassword.value, form.confirmPassword.value, function(errorList)
		{	
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Handle any possible errors
			if (errorList.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserPasswordChangeForm submitError');
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
			}
			else
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserPasswordChangeForm submitted');
				
				//Raise the onSubmit event
				_this.onSubmit();
					
				//Reset the form
				_this.reset();
			}
						
			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserPasswordChangeForm submit'); }, 1000);
		});
	},
	
	
	/* Events ***********/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function()
	{
		alert(LanguageHandler.translate(this.controlId() + ' UserPasswordChangeForm submitMessage'));
	},
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		var message = LanguageHandler.translate(this.controlId() + ' UserPasswordChangeForm submitErrorMessage') + ':\\n';
		for (var i=0; i<errorList.length; i++)
			message += '   ' + LanguageHandler.translate(this.controlId() + ' UserPasswordChangeForm ' + errorList[i]) + '\\n';
		alert(message);
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('UserPasswordChangeForm', ['oldPassword', 'newPassword', 'confirmPassword'], errorList);
	}
});


/* Static functions ********/

//Add a new control instance to the page
UserPasswordChangeForm.add = function(controlId, userId, targetElementId, onAdd)
{
	Wigbi.executeFunction('UserPasswordChangeForm', null, 'add', [controlId, userId], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new UserPasswordChangeForm(controlId);
		
		//Raise the onAadd event
		if (onAdd)
			onAdd();
	});
};

//Try to register a new user
UserPasswordChangeForm.updatePassword = function(userId, oldPassword, newPassword, newPasswordConfirm, onUpdatePassword)
{
	Wigbi.executeFunction('UserPasswordChangeForm', null, 'updatePassword', [userId, oldPassword, newPassword, newPasswordConfirm], onUpdatePassword);
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a UserPasswordChangeForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @param	string	$userId		The ID of the user to which the form will apply.
	 */
	public static function add($controlId, $userId)
	{
		BaseControl::openForm("UserPasswordChangeForm", $controlId);
		?>
			<input type="hidden" name="userId" id="<?php print $controlId ?>-userId" value="<?php print $userId; ?>" />
			
			<div class="control-body">
				<div class="oldPassword">
					<?php print LanguageHandler::translate("$controlId UserPasswordChangeForm oldPassword") ?>:<br/>
					<input type="password" id="<?php print $controlId ?>-oldPassword" name="oldPassword" value="" />
				</div>
				<div class="newPassword">
					<?php print LanguageHandler::translate("$controlId UserPasswordChangeForm newPassword") ?>:<br/>
					<input type="password" id="<?php print $controlId ?>-newPassword" name="newPassword" value="" />
				</div>
				<div class="newPasswordConfirm">
					<?php print LanguageHandler::translate("$controlId UserPasswordChangeForm confirmPassword") ?>:<br/>
					<input type="password" id="<?php print $controlId ?>-confirmPassword" name="confirmPassword" value="" />
				</div>
			</div>
			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" value="<?php print LanguageHandler::translate("$controlId UserPasswordChangeForm reset"); ?>" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId UserPasswordChangeForm submit"); ?>" />
			</div>
			
			<script type="text/javascript">
				new UserPasswordChangeForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
	
	/**
	 * Update the password of a certain user.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$userId				The ID of the user to affect.
	 * @param	string	$oldPassword		The old password of the user.
	 * @param	string	$newPassword		The desired new password.
	 * @param	string	$newPasswordConfirm	The desired new password, required for confirmation purposes.
	 * @return	array						A list of error codes; empty if no error occured.
	 */
	public static function updatePassword($userId, $oldPassword, $newPassword, $confirmPassword)
	{
		//Init result
		$result = array();
			
		//Check so that all values are set
		if (!trim($userId))
			return array("userIdRequired");
		if (!trim($oldPassword))
			array_push($result, "oldPasswordRequired");
		if (!trim($newPassword))
			array_push($result, "newPasswordRequired");
		else if (!trim($confirmPassword))
			array_push($result, "confirmPasswordRequired");
			
		//Abort if any errors have been fetched
		if (sizeof($result) > 0)
			return $result;
			
		//Check if a user with the user name exists, abort if not
		$user = new User();
		$user->load($userId);
		if ($user->id() != $userId)
			return array("userIdInvalid");
			
		//Check if the old password is correct, abort if not
		if (sha1($oldPassword) != $user->password())
			return array("oldPasswordInvalid");
			
		//Check if the new password meet the validation criteria, abort if not
		if (strlen(trim($newPassword)) < 6)
			return array("newPasswordInvalid");
			
		//Compare the two new passwords, abort if not identical
		if ($newPassword != $confirmPassword)
			return array("confirmPasswordInvalid");

		//Update the password
		$user->setPassword(trim($newPassword));
		$user->save();
			
		//Return success
		return array();
	}
}
?>