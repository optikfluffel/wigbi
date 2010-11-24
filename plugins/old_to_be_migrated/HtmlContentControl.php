<?php
/**
 * Wigbi.PHP.Controls.HtmlContentControl class file.
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
 * The HtmlContentControl control class.
 * 
 * This control can be used to display HtmlContent objects. It can
 * also be used to edit objects, using an embedded HtmlContentForm.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * It requires the HtmlContent seed and the HtmlContentForm control.
 * 
 * The control will convert all ~/ in the loaded content to the web
 * root string, so add an ~/ before an application relative path to
 * make the control automatically convert it.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * HtmlContentForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public HtmlContentForm formControl()</li>
 * 		<li>public string objectId()</li>
 * 		<li>public void setObject(HtmlContent obj)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string objectIdOrName, bool embedForm, string targetElementId, function onAdd())</li>
 *	</ul>
 * 
 * 
 * LANGUAGE HANDLING *************************
 * 
 * The following language parameters are used by the control:
 * 
 *	<ul>
 * 		<li>[controlId] HtmlContentControl view</li>
 * 		<li>[controlId] HtmlContentControl edit</li>
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
class HtmlContentControl extends BaseControl
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
HtmlContentControl = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Init the form control, if any
		if (this.formControl())	
			this.initViewEditBehavior(controlId, controlId + 'Form', controlId + '-divView', controlId + '-divEdit', controlId + '-btnView', controlId + '-btnEdit');
	},
	
	
	/* Properties *************/
	
	//Get the embedded form, if any
	formControl: function()
	{
		if (document.getElementById(this.controlId() + '-divEdit') != null)
			return Wigbi.getControl(this.controlId() + 'Form');
		return null;
	},
	
	//Get the ID of the object that is currently handled by the control.
	objectId: function() { return this.form().objectId.value; },
	
	//Set the object that is to be handled by the control.
	setObject: function(obj)
	{
		//Update the control
		var htmlContent = obj.content();
		htmlContent = htmlContent.replace(/~\//g, Wigbi.webRoot());
		$('#' + this.controlId() + '-divContent').html(htmlContent);
		this.form().objectId.value = obj.id();
		
		//Affect the form as well, if any
		if (this.formControl() != null)
			this.formControl().setObject(obj);
	}
});


/* Static functions *******/

//Add a new control instance to the page with AJAX
HtmlContentControl.add = function(controlId, objectId, embedForm, targetElementId, onAdd)
{
	Wigbi.executeFunction('HtmlContentControl', null, 'add', [controlId, objectId, embedForm], function(result)
	{
		//Add and create the control(s)
		$('#' + targetElementId).html(result);
		new HtmlContentControl(controlId);
		if (embedForm)
			new HtmlContentForm(controlId + 'Form');

		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a HtmlContentControl control to the page.
	 * 
	 * The control will only embed an edit form if embedForm is true.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId	The unique control ID.
	 * @param	mixed	$object		The object itself or its ID or name, if any; default null.
	 * @param	bool	$embedForm	Whether or not an HtmlContentForm should be added; default false.
	 */
	public static function add($controlId, $object = null, $embedForm = false)
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
		
		//Set content
		$content = $tmpObj ? $tmpObj->content() : "";
		$content = str_replace("~/", Wigbi::webRoot(), $content); 
				
		//Add form
		?>
			<div id="<?php print $controlId?>-divView">
			<?php BaseControl::openForm("HtmlContentControl", $controlId); ?>
			
				<input type="hidden" name="objectId" id="<?php print $controlId?>-objectId" value="<?php print $tmpObj->id() ?>" />
			
				<?php if ($embedForm) {?>
					<div style="text-align:right">
						<a href="" id="<?php print $controlId?>-btnEdit" class="editButton">
							<span><?php print LanguageHandler::translate("$controlId HtmlContentControl edit"); ?></span>
						</a>
					</div>
				<?php } ?>
				<div id="<?php print $controlId?>-divContent">
					<div id="<?php print $controlId?>-content">
						<?php print $content; ?>
					</div>
				</div>
			<?php BaseControl::closeForm(); ?>
			</div>
		<?php
		
		//Only display the form if edit mode is enabled
		if ($embedForm) { ?>
			<div id="<?php print $controlId?>-divEdit" style="display:none">
				<div style="text-align:right">
					<a href="" id="<?php print $controlId?>-btnView" class="viewButton">
						<span><?php print LanguageHandler::translate("$controlId HtmlContentControl view"); ?></span>
					</a>
				</div>
				<div>
					<?php HtmlContentForm::add($controlId . "Form", $tmpObj); ?>
				</div>
			</div>
		<?php }
		
		//Init JavaScript object
		?>
			<script type="text/javascript">
				new HtmlContentControl("<?php print $controlId ?>");
			</script>
		<?php
	}
}
?>