<?php
/**
 * Wigbi.PHP.Controls.UserPasswordResetForm class file.
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
 * The UserPasswordResetForm control class.
 * 
 * This control can be used to reset the password of a certain user.
 * It generates a new, random password and e-mails it to the user.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the User seed.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * UserPasswordResetForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string fromMail()</li>
 * 		<li>public void setFromMail(string newVal)</li>
 * 		<li>public string messageFile()</li>
 * 		<li>public void setMessageFile(string newVal)</li>
 * 		<li>public string subject()</li>
 * 		<li>public void setSubject(string newVal)</li>
 * 		<li>public string userNameOrEmail()</li>
 * 		<li>public void setUserNameOrEmail(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string messageFile, string subject, string fromMail, string targetElementId, function onAdd)</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 		<li>public void reset()</li>
 * 		<li>[ASYNC] public static void resetPassword(string messageFile, string subject, string fromMail, string userNameOrEmail, function onResetPassword(string[] errorCodes))</li>
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
 * successfully reset and that a mail has been sent.
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
 * 		<li>[controlId] UserPasswordResetForm mailError</li>
 * 		<li>[controlId] UserPasswordResetForm messageFileInvalid</li>
 * 		<li>[controlId] UserPasswordResetForm reset</li>
 * 		<li>[controlId] UserPasswordResetForm subjectRequired</li>
 * 		<li>[controlId] UserPasswordResetForm submit</li>
 * 		<li>[controlId] UserPasswordResetForm submitError</li>
 * 		<li>[controlId] UserPasswordResetForm submitErrorMessage</li>
 * 		<li>[controlId] UserPasswordResetForm submitMessage</li>
 * 		<li>[controlId] UserPasswordResetForm submitted</li>
 * 		<li>[controlId] UserPasswordResetForm submitting</li>
 * 		<li>[controlId] UserPasswordResetForm toMailInvalid</li>
 * 		<li>[controlId] UserPasswordResetForm toMailRequired</li>
 * 		<li>[controlId] UserPasswordResetForm userNameOrEmail</li>
 * 		<li>[controlId] UserPasswordResetForm userNameOrEmailInvalid</li>
 * 		<li>[controlId] UserPasswordResetForm userNameOrEmailRequired</li>
 * 	</ul>
 * 
 * The message file content can use the following parameters:
 * 
 * 	<ul>
 * 		<li>[userName]		- The name of the user.
 * 		<li>[password]		- The new, auto-generated password.
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
 * @version		0.99.3
 */
class UserPasswordResetForm extends BaseControl
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
UserPasswordResetForm = Class({ Extends: BaseControl,
	
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
	
	//Get/set the control's submitting e-mail address
	fromMail: function() { return this.form().fromMail.value; },
	setFromMail: function(newVal) { this.form().fromMail.value = newVal; },
	
	//Get/set the application relative path to the e-mail message template file
	messageFile: function() { return this.form().messageFile.value; },
	setMessageFile: function(newVal) { this.form().messageFile.value = newVal; },
	
	//Get/set the mail subject
	subject: function() { return this.form().subject.value; },
	setSubject: function(newVal) { this.form().subject.value = newVal; },
	
	//Get/set the user name or e-mail address
	userNameOrEmail: function() { return this.form().userNameOrEmail.value; },
	setUserNameOrEmail: function(newVal) { this.form().userNameOrEmail.value = newVal; },
	
	
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
		form.submit.value = LanguageHandler.translate(this.controlId() + ' UserPasswordResetForm submitting') + '...';
		
		//Try to register the user
		UserPasswordResetForm.resetPassword(this.messageFile(), this.subject(), this.fromMail(), this.userNameOrEmail(), function(errorList)
		{	
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Handle any possible errors
			if (errorList.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserPasswordResetForm submitError');
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
			}
			else
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserPasswordResetForm submitted');
				
				//Raise the onSubmit event
				_this.onSubmit();
					
				//Reset the form
				_this.reset();
			}
						
			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' UserPasswordResetForm submit'); }, 1000);
		});
	},
		
	
	/* Events ***********/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function()
	{
		alert(LanguageHandler.translate(this.controlId() + ' UserPasswordResetForm submitMessage'));
	},
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		var message = LanguageHandler.translate(this.controlId() + ' UserPasswordResetForm submitErrorMessage') + ':\\n';
		for (var i=0; i<errorList.length; i++)
			message += '   ' + LanguageHandler.translate(this.controlId() + ' UserPasswordResetForm ' + errorList[i]) + '\\n';
		alert(message);
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('UserPasswordResetForm', ['userNameOrEmail'], errorList);
	}
});


/* Static functions ********/

//Add a new control instance to the page
UserPasswordResetForm.add = function(controlId, messageFile, subject, fromMail, targetElementId, onAdd)
{
	Wigbi.executeFunction('UserPasswordResetForm', null, 'add', [controlId, messageFile, subject, fromMail], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new UserPasswordResetForm(controlId);
		
		//Raise the onAadd event
		if (onAdd)
			onAdd();
	});
};

//Try to register a new user
UserPasswordResetForm.resetPassword = function(messageFile, subject, fromMail, userNameOrEmail, onResetPassword)
{
	Wigbi.executeFunction('UserPasswordResetForm', null, 'resetPassword', [messageFile, subject, fromMail, userNameOrEmail], onResetPassword);
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a UserPasswordResetForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	string	$messageFile	The application relative path to the message template file.
	 * @param	string	$subject		The subject of the e-mail.
	 * @param	string	$fromMail		The e-mail address that will be specified as the sender.
	 */
	public static function add($controlId, $messageFile, $subject, $fromMail)
	{
		BaseControl::openForm("UserPasswordResetForm", $controlId);
		?>
			<input type="hidden" id="<?php print $controlId ?>-messageFile" name="messageFile" value="<?php print $messageFile ?>" />
			<input type="hidden" id="<?php print $controlId ?>-subject" name="subject" value="<?php print $subject ?>" />
			<input type="hidden" id="<?php print $controlId ?>-fromMail" name="fromMail" value="<?php print $fromMail ?>" />
			
			<div class="control-body">
				<div class="userNameOrEmail">
					<?php print LanguageHandler::translate("$controlId UserPasswordResetForm userNameOrEmail") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-userNameOrEmail" name="userNameOrEmail" value="" />
				</div>
			</div>
			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" style="display:none" name="reset" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId UserPasswordResetForm submit"); ?>" />
			</div>
			
			<script type="text/javascript">
				new UserPasswordResetForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
	
	/**
	 * Reset the password of a certain user.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$messageFile		The application relative path to the message template file.
	 * @param	string	$subject			The subject of the e-mail.
	 * @param	string	$fromMail			The e-mail address that will be specified as the sender.
	 * @param	string	$userNameOrEmail	The user name or e-mail address of the user to reset.
	 * @return	array						A list of error codes; empty if no error occured.
	 */
	public static function resetPassword($messageFile, $subject, $fromMail, $userNameOrEmail)
	{
		//Check so that the mail body template file exists
		if (!is_file(Wigbi::serverRoot() . $messageFile))
			return array('messageFileInvalid');

		//Check so that all values are set
		if (!trim($userNameOrEmail))
			return array("userNameOrEmailRequired");
			
		//Abort if the user does not exists
		$user = new User();
		$user->loadBy("userName", $userNameOrEmail);
		if (!$user->id())
			$user->loadBy("email", $userNameOrEmail);
		if (!$user->id())
			return array("userNameOrEmailInvalid");
		
		//Abort if the user has no or an invalid e-mail address
		if (!trim($user->email()))
			return array("toMailRequired");
		else if (!ValidationHandler::isEmail($user->email()))
			return array("toMailInvalid");

		//Open and read mail body template file
		$mailBody = "";
		$file = fopen(Wigbi::serverRoot() . $messageFile, "r");
		$mailBody = fread($file, filesize(Wigbi::serverRoot() . $messageFile));
		fclose($file);
		
		//Generate a new, random password
		$password = strrev(substr(sha1(rand(0, 10000)), 12, 10));
		$user->setPassword($password);
		$user->save();
		
		//Replace mail body variables
		$mailBody = str_replace("[userName]", $user->userName(), $mailBody);
		$mailBody = str_replace("[password]", $password, $mailBody);
		
		//Finally, try to send the mail
		if (!mail($user->email(), $subject, $mailBody, "From: " . $fromMail))
			return array("mailError");
		return array();
	}
}
?>