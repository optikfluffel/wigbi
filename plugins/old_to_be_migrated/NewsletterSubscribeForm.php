<?php
/**
 * Wigbi.PHP.Controls.NewsletterSubscribeForm class file.
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
 * The NewsletterSubscribeForm control class.
 * 
 * This control can be used to add and remove subscribers to and from
 * a certain newsletter.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the Newsletter and NewsletterSubscriber seeds.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * MailForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string message()</li>
 * 		<li>public void setMessage(string newVal)</li>
 * 		<li>public Newsletter object()</li>
 * 		<li>public void setObject(Newsletter obj)</li>
 * 		<li>public string subject()</li>
 * 		<li>public void setSubject(bool newVal)</li>
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
 * has finished. By default, it alerts that the operation succeeded.
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
 * 		<li>[controlId] NewsletterSubscribeForm email</li>
 * 		<li>[controlId] NewsletterSubscribeForm emailInvalid</li>
 * 		<li>[controlId] NewsletterSubscribeForm emailNotExists</li>
 * 		<li>[controlId] NewsletterSubscribeForm emailRequired</li>
 * 		<li>[controlId] NewsletterSubscribeForm idRequired</li>
 * 		<li>[controlId] NewsletterSubscribeForm submit</li>
 * 		<li>[controlId] NewsletterSubscribeForm subscribeError</li>
 * 		<li>[controlId] NewsletterSubscribeForm subscribeErrorMessage</li>
 * 		<li>[controlId] NewsletterSubscribeForm subscribeMessage</li>
 * 		<li>[controlId] NewsletterSubscribeForm subscribed</li>
 * 		<li>[controlId] NewsletterSubscribeForm subscribing</li>
 * 		<li>[controlId] NewsletterSubscribeForm unsubscribe</li>
 * 		<li>[controlId] NewsletterSubscribeForm unsubscribeError</li>
 * 		<li>[controlId] NewsletterSubscribeForm unsubscribeErrorMessage</li>
 * 		<li>[controlId] NewsletterSubscribeForm unsubscribeMessage</li>
 * 		<li>[controlId] NewsletterSubscribeForm unsubscribed</li>
 * 		<li>[controlId] NewsletterSubscribeForm unsubscribing</li>
 * 	</ul>
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.95
 * @version		0.99.3
 */
class NewsletterSubscribeForm extends BaseControl
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
NewsletterSubscribeForm = Class({ Extends: BaseControl,
	
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
	
	//Get/set the e-mail to register/unregister
	email: function() { return this.form().email.value; },
	setEmail: function(newVal) { this.form().email.value = newVal; },
	
	//Get/set the bound object.
	object: function()
	{
		var tmpObj = new Newsletter();
		\$extend(tmpObj, JSON.decode(this.form().object.value));
		return tmpObj;
	},
	setObject: function(obj) 
	{
		this.form().object.value = JSON.encode(obj);
	},
	
	//Get/set if the submit operation will unsubscribe the e-mail address
	unsubscribe: function() { return this.form().unsubscribe.checked; },
	setUnsubscribe: function(newVal) { this.form().unsubscribe.checked = newVal; },
	
	
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

		//Init display string
		var prefix = '';
		if (this.unsubscribe())
			prefix = 'un';
	
		//Disable the submit button
		form.submit.disabled = true;
		form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterSubscribeForm ' + prefix + 'subscribing');
		
		//Define the onSubmitDone function
		function onSubmitDone(errorList)
		{
			//Raise the onValidate event
			_this.onValidate(errorList);
			
			//Handle any possible errors
			if (errorList.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterSubscribeForm ' + prefix + 'subscribeError');
				
				//Raise the onSubmitError event
				_this.onSubmitError(errorList);
			}
			else
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterSubscribeForm ' + prefix + 'subscribed');
				
				//Raise the onSubmit event
				_this.onSubmit();
				
				//Reset the form
				_this.reset();
			}

			//Enable the submit button and set final event
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' NewsletterSubscribeForm submit'); }, 1000);
		}
				
		//Perform the correct operation
		if (this.unsubscribe())
			this.object().removeSubscriber(this.email(), onSubmitDone);
		else
			this.object().addSubscriber(this.email(), onSubmitDone);
	},
	
	
	/* Events *****************/
	
	//Raised before the form is submitted
	onPreSubmit: function(form) { return true; },
	
	//Raised when the control is correctly submitted
	onSubmit: function()
	{
		//Init display string
		var prefix = '';
		if (this.unsubscribe())
			prefix = 'un';

		//alert that the operation succeeded			
		alert(LanguageHandler.translate(this.controlId() + ' NewsletterSubscribeForm ' + prefix + 'subscribeMessage'));
	},
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		//Init display string
		var prefix = '';
		if (this.unsubscribe())
			prefix = 'un';
			
		//Alert all errors
		var message = LanguageHandler.translate(this.controlId() + ' NewsletterSubscribeForm ' + prefix + 'subscribeErrorMessage') + ':\\n';
		for (var i=0; i<errorList.length; i++)
			message += '   ' + LanguageHandler.translate(this.controlId() + ' NewsletterSubscribeForm ' + errorList[i]) + '\\n';
		alert(message);
	},
	
	//Raised when the control has been validated 
	onValidate: function(errorList)
	{
		this.bindValidationResult('NewsletterSubscribeForm', ['email'], errorList);
	}
});

	
/* Static functions *******/
	
//Add a new control instance to the page
NewsletterSubscribeForm.add = function(controlId, objectIdOrName, targetElementId, onAdd)
{
	Wigbi.executeFunction('NewsletterSubscribeForm', null, 'add', [controlId, objectIdOrName], function(result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new NewsletterSubscribeForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a NewsletterSubscribeForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @param	mixed	$object		The object itself or its ID or name, if any; default null.
	 */
	public static function add($controlId, $object)
	{
		//Create a working object
		$tmpObj = $object;
		if (!$tmpObj)
		{
			$tmpObj = new Newsletter();
			$tmpObj->reset();
		}
		
		//Handle id/name if object is a string
		if (gettype($object) == "string")
		{
			//Init object and load by id
			$tmpObj = new Newsletter();
			$tmpObj->load($object);
				
			//Second, load by name
			if ($tmpObj->id() != $object)
			{
				$tmpObj->loadBy("name", $object);
				$tmpObj->setName($object);
			}
		}
		
		//Add form
		BaseControl::openForm("NewsletterSubscribeForm", $controlId, $tmpObj);
		?>
			<div class="control-body">
				<div class="email">
					<?php print LanguageHandler::translate("$controlId NewsletterSubscribeForm email") ?>:<br/>
					<input type="text" id="<?php print $controlId ?>-email" name="email" value="" />
				</div>
				<div class="unsubscribe">
					<input type="checkBox" id="<?php print $controlId ?>-unsubscribe" name="unsubscribe" />
					<?php print LanguageHandler::translate("$controlId NewsletterSubscribeForm unsubscribe"); ?>
				</div>
			</div>

			<div class="control-footer">
				<input type="reset" id="<?php print $controlId ?>-reset" name="reset" style="display:none" />
				<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId NewsletterSubscribeForm submit"); ?>" />
			</div>
			
			<script type="text/javascript">
				new NewsletterSubscribeForm("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
}
?>