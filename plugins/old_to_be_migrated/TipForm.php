<?php
/**
 * Wigbi.PHP.Controls.TipForm class file.
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
 * The TipForm control class.
 * 
 * This control can be used to let visitors send a tip about anything
 * at all. It is general and can be used for all kinds of tips.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * In order to send a tip to multiple recipients, define recipients
 * as a comma-separated string of e-mail addresses.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * TipForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string customMessage()</li>
 * 		<li>public void setCustomMessage(string newVal)</li>
 * 		<li>public string fromMail()</li>
 * 		<li>public void setFromMail(string newVal)</li>
 * 		<li>public string fromName()</li>
 * 		<li>public void setFromName(string newVal)</li>
 * 		<li>public string messageFile()</li>
 * 		<li>public void setMessageFile(string newVal)</li>
 * 		<li>public string subject()</li>
 * 		<li>public void setSubject(string newVal)</li>
 * 		<li>public string toMail()</li>
 * 		<li>public void setToMail(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string messageFile, string subject, string targetElementId, function onAdd())</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 		<li>public void reset()</li>
 * 		<li>[ASYNC] public static void sendTip(string messageFile, string subject, string customMessage, string fromMail, string fromName, string toMail, function onSendTip(string[] errorCodes))</li>
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
 * has finished. By default, it alerts that the mail has been sent.
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
 * 		<li>[controlId] TipForm customMessage</li>
 * 		<li>[controlId] TipForm fromMail</li>
 * 		<li>[controlId] TipForm fromMailInvalid</li>
 * 		<li>[controlId] TipForm fromMailRequired</li>
 * 		<li>[controlId] TipForm fromName</li>
 * 		<li>[controlId] TipForm fromNameRequired</li>
 * 		<li>[controlId] TipForm mailError</li>
 * 		<li>[controlId] TipForm messageFileInvalid</li>
 * 		<li>[controlId] TipForm reset</li>
 * 		<li>[controlId] TipForm subjectRequired</li>
 * 		<li>[controlId] TipForm submit</li>
 * 		<li>[controlId] TipForm submitError</li>
 * 		<li>[controlId] TipForm submitErrorMessage</li>
 * 		<li>[controlId] TipForm submitMessage</li>
 * 		<li>[controlId] TipForm submitted</li>
 * 		<li>[controlId] TipForm submitting</li>
 * 		<li>[controlId] TipForm toMail</li>
 * 		<li>[controlId] TipForm toMailInvalid</li>
 * 		<li>[controlId] TipForm toMailRequired</li>
 * 	</ul>
 * 
 * The subject variable can use the following parameters:
 * 
 * 	<ul>
 * 		<li>[fromMail]		- The e-mail of the person who sent the tip.
 * 		<li>[fromName]		- The name of the person who sent the tip.
 * 	</ul>
 * 
 * The message file can use the following parameters:
 * 
 * 	<ul>
 * 		<li>[fromMail]		- The e-mail of the person who sent the tip.
 * 		<li>[fromName]		- The name of the person who sent the tip.
 * 		<li>[customMessage]	- The custom user message, if any.
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
class TipForm extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only intended to be used by Wigbi at startup.
	 * 
	 * @access	public
	 * 
	 * @param	string	$controlId	The unique control ID.
	*/
	public function __construct()
	{
		//Register the general JavaScript
		$this->registerJavaScript(@"
TipForm = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Bind form submit event
		var _this = this;
		this.form().onsubmit = function() { _this.submit(); return false; };
		
		//Remove any default text in the textarea
		this.setCustomMessage('');
	},
	
	
	/* Properties *************/
	
	// Get/set the custom user message
	customMessage: function() { return this.form().customMessage.value; },
	setCustomMessage: function(newVal) { this.form().customMessage.value = newVal; },
	
	// Get/set the e-mail address of the user
	fromMail: function() { return this.form().fromMail.value; },
	setFromMail: function(newVal) { this.form().fromMail.value = newVal; },
	
	// Get/set the name of the user
	fromName: function() { return this.form().fromName.value; },
	setFromName: function(newVal) { this.form().fromName.value = newVal; },
	
	// Get/set the application relative path to the file that contains the e-mail message template.
	messageFile: function() { return this.form().messageFile.value; },
	setMessageFile: function(newVal) { this.form().messageFile.value = newVal; },
	
	// Get/set the application relative mail template file
	subject: function() { return this.form().subject.value; },
	setSubject: function(newVal) { this.form().subject.value = newVal; },
	
	// Get/set the recipient mail address(es)
	toMail: function() { return this.form().toMail.value; },
	setToMail: function(newVal) { this.form().toMail.value = newVal; },
	
	
	/* Functions **************/
	
	//Reset the control
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
		form.submit.value = LanguageHandler.translate(this.controlId() + ' TipForm submitting') + '...';
		
		//Try to send a tip
		TipForm.sendTip(this.messageFile(), this.subject(), this.customMessage(), this.fromMail(), this.fromName(), this.toMail(), function(errorList)
		{	
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Handle any possible errors
			if (errorList.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' TipForm submitError');
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
			}
			else
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' TipForm submitted');
				
				//Raise the onSubmit event
				_this.onSubmit();
					
				//Reset the form
				_this.reset();
			}
						
			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function()
			{
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' TipForm submit');
			}, 1000);
		});
	},
		
	
	/* Events ***********/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function()
	{
		alert(LanguageHandler.translate(this.controlId() + ' TipForm submitMessage'));
	},
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		if (errorList && errorList.length > 0)
		{
			var message = LanguageHandler.translate(this.controlId() + ' TipForm submitErrorMessage') + ':\\n';
			for (var i=0; i<errorList.length; i++)
				message += '   ' + LanguageHandler.translate(this.controlId() + ' TipForm ' + errorList[i]) + '\\n';
			alert(message);
		}	
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('TipForm', ['fromName', 'fromMail', 'toMail', 'customMessage'], errorList);
	}
});


/* Static functions ********/

//Add a new control instance to the page with AJAX
TipForm.add = function(controlId, messageFile, subject, targetElementId, onAdd)
{
	Wigbi.executeFunction('TipForm', null, 'add', [controlId, messageFile, subject], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new TipForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};

//Try to register a new user
TipForm.sendTip = function(messageFile, subject, customMessage, fromMail, fromName, toMail, onSendTip)
{
	Wigbi.executeFunction('TipForm', null, 'sendTip', [messageFile, subject, customMessage, fromMail, fromName, toMail, customMessage], onSendTip);
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a TipForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	string	$messageFile	The application relative path to the message template file.
	 * @param	string	$subject		The subject of the e-mail.
	 */
	public static function add($controlId, $messageFile, $subject)
	{
		BaseControl::openForm("TipForm", $controlId);
		?>
			<input type="hidden" id="<?php print $controlId ?>-messagFile" name="messageFile" value="<?php print $messageFile ?>" />
			<input type="hidden" id="<?php print $controlId ?>-subject" name="subject" value="<?php print $subject ?>" />
			
			<div class="control-body">
				<div class="fromName">
					<?php print LanguageHandler::translate("$controlId TipForm fromName");?>:<br/>
					<input type="text" id="<?php print $controlId ?>-fromName" name="fromName" value="" />
				</div>
				<div class="fromMail">
					<?php print LanguageHandler::translate("$controlId TipForm fromMail");?>:<br/>
					<input type="text" id="<?php print $controlId ?>-fromMail" name="fromMail" value="" />
				</div>
				<div class="toMail">
					<?php print LanguageHandler::translate("$controlId TipForm toMail");?>:<br/>
					<input type="text" id="<?php print $controlId ?>-toMail" name="toMail" value="" />
				</div>
				<div class="customMessage">
					<?php print LanguageHandler::translate("$controlId TipForm customMessage") ?>:<br/>
					<textarea id="<?php print $controlId ?>-customMessage" name="customMessage" cols="20" rows="10">&nbsp;</textarea>
				</div>
			</div>
			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" value="<?php print LanguageHandler::translate("$controlId TipForm reset"); ?>" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId TipForm submit"); ?>" />
			</div>
			
			<script type="text/javascript">
				new TipForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
	
	/**
	 * Try to send a tip to the provided recipients.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$messageFile	The application relative path to the message template file.
	 * @param	string	$subject		The subject of the e-mail.
	 * @param	string	$fromMail		The e-mail address of the tip sender.
	 * @param	string	$fromName		The name of the tip sender.
	 * @param	string	$toMail			The e-mail address(es) of the tip receiver(s).
	 * @param	string	$customMessage	The custom customMessage of the tip sender, if any.
	 * @return	array					A list of error codes; empty if no error occured.
	 */
	public static function sendTip($messageFile, $subject, $customMessage, $fromMail, $fromName, $toMail)
	{
		//Set local variables
		$result = array();
		$toMailCorrect = true;
		$mailBody = "";
		
		//Check that the template file exists and that a subject is set
		if (!is_file(Wigbi::serverRoot() . $messageFile))
			return array("messageFileInvalid");
		if (!trim($subject))
			return array("subjectRequired");
		
		//Check so that all values are set
		if (!trim($fromName))
			array_push($result, "fromNameRequired");
		if (!trim($fromMail))
			array_push($result, "fromMailRequired");
		else if (!ValidationHandler::isEmail($fromMail))
			array_push($result, "fromMailInvalid");
		if (!trim($toMail))
			array_push($result, "toMailRequired");
		else foreach(split(",", $toMail) as $email)
			if (!ValidationHandler::isEmail($email))
				$toMailCorrect = false;
		if (!$toMailCorrect)
			array_push($result, "toMailInvalid");
			
		//Abort if any errors have been fetched
		if (sizeof($result) > 0)
			return $result;
		
		//Open and read mail body template file
		$file = fopen(Wigbi::serverRoot() . $messageFile, "r");
		$mailBody = fread($file, filesize(Wigbi::serverRoot() . $messageFile));
		fclose($file);	
		
		//Replace subject tags with variables
		$subject = str_replace("[fromMail]", $fromMail, $subject);
		$subject = str_replace("[fromName]", $fromName, $subject);
		
		//Replace message tags with variables
		$mailBody = str_replace("[customMessage]", $customMessage, $mailBody);
		$mailBody = str_replace("[fromMail]", $fromMail, $mailBody);
		$mailBody = str_replace("[fromName]", $fromName, $mailBody);
		
		//Try to send the mail
		if (!mail($toMail, $subject, $mailBody, "From: " . $fromMail))
			return array("mailError");
			
		//Return success
		return array();
	}
}
?>