<?php
/**
 * Wigbi.PHP.Controls.FileUploadForm class file.
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
 * The FileUploadForm control class.
 * 
 * This control can be used to upload files to a folder on the server.
 * Files are uploaded asynchronously, without reloading the page.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id). 
 * 
 * This control differs a bit from other controls, since it makes the
 * form enable file handling. Thus, it is the only "official" control
 * that uses the automated submit handling of the control base class.
 * To make this work for AJAX added controls, the following must apply:
 * 
 * <ul>
 * 	<li>
 * 		The page MUST have a dummy control with the same ID as the
 * 		real control that is to be added with AJAX. Otherwise, the
 * 		upload will be posted to a page without a control and fail. 
 * 	</li>
 * 	<li>
 * 		The dummy control MUST be placed INSIDE the target container
 * 		to which the AJAX-added upload form will be added. Otherwise,
 * 		two controls with the same ID will exist on the page.
 *	</li>
 * </ul>
 * 
 * Note that the max file size is limited to the smallest value of
 * the maxFileSize property or post_max_size in the php.ini file.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * FileUploadForm : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string fileTag()</li>
 * 		<li>public void setFileTag(string newVal)</li>
 * 		<li>public int maxFileSize()</li>
 * 		<li>public void setMaxFileSize(int newVal)</li>
 * 		<li>public int numUploads()</li>
 * 		<li>public void setNumUploads(int newVal)</li>
 * 		<li>public string uploadFolder()</li>
 * 		<li>public void setUploadFolder(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string uploadFolder, string fileTag, int numUploads, int maxFileSize, string targetElementId, function onAdd())</li>
 * 		<li>[ASYNC] public void submit()</li>
 * 	</ul>
 * 
 * Events:
 *	<ul>
 * 		<li>public bool onPreSubmit()</li>
 * 		<li>public void onSubmit(string[] uploadedFiles)</li>
 * 		<li>public void onSubmitError(string[] errorList)</li>
 * 	</ul>
 * 
 * Override onPreSubmit to set what to do before the form is being
 * submitted. If it returns false, the submit operation will abort.
 * 
 * Override onSubmit to set what to do when the submit operation
 * has finished. By default, it does nothing.
 * 
 * Override onSubmitError to set what to do when a submit operation
 * fails. By default, it alerts all errors in the error list.
 * 
 * 
 * LANGUAGE HANDLING *************************
 * 
 * The following language parameters are used by the class:
 * 
 *	<ul>
 * 		<li>[controlId] FileUploadForm fileNotSubmitted</li>
 * 		<li>[controlId] FileUploadForm filePartiallyUploaded</li>
 * 		<li>[controlId] FileUploadForm fileTooLarge_php</li>
 * 		<li>[controlId] FileUploadForm fileTooLarge_form</li>
 * 		<li>[controlId] FileUploadForm noFile</li>
 * 		<li>[controlId] FileUploadForm noWriteAccess</li>
 * 		<li>[controlId] FileUploadForm reset</li>
 *		<li>[controlId] FileUploadForm submit</li>
 * 		<li>[controlId] FileUploadForm submitError</li>
 * 		<li>[controlId] FileUploadForm submitErrorMessage</li>
 * 		<li>[controlId] FileUploadForm submitted</li>
 * 		<li>[controlId] FileUploadForm submitting</li>
 * 		<li>[controlId] FileUploadForm tempFolderMissing</li>
 * 		<li>[controlId] FileUploadForm uploadFolderInvalid</li>
 * 		<li>[controlId] FileUploadForm uploadFolderRequired</li>
 * 		<li>[controlId] FileUploadForm uploadStopped</li>
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
 * 
 * @todo		Refactor and jQuerify the JavaScript code.
 * @todo		Remove the need for a dummy form for AJAX add.
 */
class FileUploadForm extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the control.
	 * 
	 * This constructor is only to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct($controlId)
	{
		//Register the general JavaScript
		$this->registerJavaScript(@"
FileUploadForm = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
		
		//Bind form submit event
		var _this = this;
		this.form().onsubmit = function() { _this.submit(); };
	},
	
	
	/* Properties *************/
	
	//Get/set the maximum allowed file size
	fileTag: function() { return this.form().fileTag.value; },
	setFileTag: function(newVal) { this.form().fileTag.value = newVal; },
	
	//Get/set the maximum allowed file size
	maxFileSize: function() { return parseInt(this.form().MAX_FILE_SIZE.value); },
	setMaxFileSize: function(newVal) { this.form().MAX_FILE_SIZE.value = newVal; },
	
	//Get/set the number of files to upload
	numUploads: function() { return $('#' + this.controlId() + '-files').children().size(); },
	setNumUploads: function(newVal)
	{
		var element = $('#' + this.controlId() + '-files');
		element.html('');
		for (var i=0; i<newVal; i++)
			element.html(element.html() + '<div class=\"file' + i + '\"><input type=\"file\" name=\"file' + i + '\" value=\"\" /></div>');
	},
	
	//Get/set the target upload folder
	uploadFolder: function() { return this.form().uploadFolder.value; },
	setUploadFolder: function(newVal) { this.form().uploadFolder.value = newVal; },
	
	
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
				
		//Set static variable (TEMP)
		FileUploadForm_currentControl = this;
		FileUploadForm_currentForm = form;
	
		//Disable the submit button
		form.submit.disabled = true;
		form.submit.value = LanguageHandler.translate(_this.controlId() + ' FileUploadForm submitting') + '...';

		//Remove any previously created iframe elements
		frameId = this.controlId() + '_uploadFrame';
	    $('#' + frameId).remove();

		//Create new iframe element
        var div = document.createElement('DIV');
        div.innerHTML = '<iframe style=\"display:none\" onload=\"FileUploadForm.submitDone(\'' + frameId + '\')\" src=\"about:blank\" id=\"'+ frameId +'\" name=\"'+ frameId +'\"></iframe>';	
		document.body.appendChild(div);
		iFrame = document.getElementById(this.controlId() + '_uploadFrame');

		//Add onComplete event to the iframe
		iFrame.onComplete = function()
		{
			//Retrieve the iFrame content
			var doc;
	        if (iFrame.contentDocument)
				doc = iFrame.contentDocument;
			else if (iFrame.contentWindow)
				doc = iFrame.contentWindow.document;
			else
				doc = window.frames[frameId].document;
			
			//Extract the return value
			var html = doc.body.innerHTML;
			html = html.substring(html.indexOf('FILE_UPLOAD_FORM') + 16);
			html = html.substring(0, html.indexOf('FILE_UPLOAD_FORM'));
			
			//Separate the return value into file and error data
			var result = html.split(',');
			var files = [];
			var errors = [];
			for (var i=0; i<result.length; i++)
			{
				//Add files to file list
				if (result[i].contains('.') || result[i].contains('/'))
					files[files.length] = result[i];
				
				//Add errors to error list
				else
					errors[errors.length] = result[i];
			}
			
			//Handle any errors
			if (errors.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' FileUploadForm submitError');
			
				//Raise the onSubmitError event
				_this.onSubmitError(errors);
			}
				
			//Handle any files
			if (files.length > 0)
			{
				//Set submit button text
				form.submit.value = LanguageHandler.translate(_this.controlId() + ' FileUploadForm submitted');
				
				//Raise the onSubmit event
				_this.onSubmit(files);
			}
			
			//Reset the form and enable the submit button
			_this.reset();
			form.submit.disabled = false;
			setTimeout(function() { form.submit.value = LanguageHandler.translate(_this.controlId() + ' FileUploadForm submit'); }, 1000);
		};

		//Bind the form to the created iFrame and set onLoad event
		form.setAttribute('target', frameId);
	},
	
	
	/* Events *****************/
	
	//Raised before the form is submitted
	onPreSubmit: function() { return true; },
	
	//Raised when the control is successfully submitted
	onSubmit: function(uploadedFiles) { },
	
	//Raised when the control is incorrectly submitted
	onSubmitError: function(errorList)
	{
		if (errorList)
		{		
			var message = LanguageHandler.translate(this.controlId() + ' FileUploadForm submitErrorMessage') + ':\\n';
			for (var i=0; i<errorList.length; i++)
				message += '   ' + LanguageHandler.translate(this.controlId() + ' FileUploadForm ' + errorList[i]) + '\\n';
			alert(message);
		}	
	}
});


/* Static functions ********/

//Add a new control instance to the page with AJAX
FileUploadForm.add = function(controlId, uploadFolder, fileTag, numUploads, maxFileSize, targetElementId, onAdd)
{
	Wigbi.executeFunction('FileUploadForm', null, 'add', [controlId, uploadFolder, fileTag, numUploads, maxFileSize], function (result)
	{
		//Add and create the control
		$('#' + targetElementId).html(result);
		new FileUploadForm(controlId);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
 
//Internal function that is called by the iFrame when the submit is done
FileUploadForm.submitDone = function(frameId)
{
	document.getElementById(frameId).onComplete();
};
");
		
		//Call the parent constructor
		parent::__construct($controlId);
	}
	
	
	//Functions ********************
	
	/**
	 * Add a FileUploadForm control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	string	$uploadFolder	The application relative upload folder.
	 * @param	string	$fileTag			The tag to add to each uploaded file; default blank.
	 * @param	int			$numUploads		The number of file uploads to support; default 1.
	 * @param	int			$maxFileSize	The maximum supported file upload size; default 100000000 bytes.
	 */
	public static function add($controlId, $uploadFolder,  $fileTag = "", $numUploads = 1, $maxFileSize = 100000000)
	{
		//Add a form instance to enable automated submit handling
		$tmpForm = new FileUploadForm($controlId);
		
		//This control requires full rendering control due to the form type
		?>
			<div class='<?php print "control FileUploadForm $controlId"?>'>
				<form id="<?php print $controlId ?>" enctype="multipart/form-data" action="" method="post">
					<div class="control-body">
						<input type="hidden" name="controlId" id="<?php print $controlId ?>-controlId" value="<?php print $controlId; ?>" />
						<input type="hidden" name="fileTag" id="<?php print $controlId ?>-fileTag" value="<?php print $fileTag; ?>" />
						<input type="hidden" name="numUploads" id="<?php print $controlId ?>-numUploads" value="<?php print $numUploads; ?>" />
						<input type="hidden" name="uploadFolder" id="<?php print $controlId ?>-uploadFolder" value="<?php print $uploadFolder; ?>" />
						<input type="hidden" name="MAX_FILE_SIZE" id="<?php print $controlId ?>-MAX_FILE_SIZE" value="<?php print $maxFileSize; ?>" />
						
						<div id="<?php print $controlId; ?>-files" class="files">
							<?php for ($i=0; $i<$numUploads; $i++) { ?>
								<div id="<?php print $controlId ?>-file<?php print $i; ?>-div" class="file file">
									<input type="file" name="file<?php print $i; ?>" id="<?php print $controlId ?>-file<?php print $i; ?>" value="" />
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="control-footer">
						<input type="reset" id="<?php print $controlId ?>-reset" name="reset" value="<?php print LanguageHandler::translate("$controlId FileUploadForm reset") ?>" />
						<input type="submit" id="<?php print $controlId ?>-submit" name="submit" value="<?php print LanguageHandler::translate("$controlId FileUploadForm submit") ?>" />
					</div>
				</form>
			</div>
			
			<script type="text/javascript">
				new FileUploadForm("<?php print $controlId ?>");
			</script>
		<?php
	}
	
	/**
	 * The main submit function.
	 * 
	 * @access	protected
	 */
	protected function submit()
	{
		//Set upload files property
		$this->_uploadedFiles = FileUploadForm::upload($_FILES, $_POST["uploadFolder"], $_POST["fileTag"]);
		
		//Print upload data in a special format
		print "FILE_UPLOAD_FORM";
		print join(",", $this->_uploadedFiles);
		print "FILE_UPLOAD_FORM";
	}
	
	/**
	 * Upload files to the server.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The ID of the submitting control, is any; set to blank if none.
	 * @param	mixed	$files			The uploaded files; has to be passed as the $_FILE object.
	 * @param	string	$uploadFolder	The application relative upload folder.
	 * @param	string	$fileTag		The tag to add to each uploaded file; default blank.
	 * @return	array					A list of error codes; empty if no error occured.
	 */
	public static function upload($files, $uploadFolder, $fileTag = "")
	{
		//Init result array
		$result = array();
		
		//Set default upload folder and bind it to the root, abort if no folder
		if (!$uploadFolder)
			return array("uploadFolderRequired");
		$uploadFolder = Wigbi::serverRoot() . $uploadFolder . "/";
		
		//Try to create the folder, abort if it fails
		if (!is_dir($uploadFolder))
			mkdir($uploadFolder);
		if (!is_dir($uploadFolder))
			return array("uploadFolderInvalid");

		//Upload each file
		foreach ($files as $key=>$value)
		{
			if (($files[$key]["name"]))
			{				
				//Trace any errors
		        if ($files[$key]['error'] != 0)
				{
		            switch ($files[$key]['error'])
					{
						case 1:
							array_push($result, "fileTooLarge_php");
							break;
		                case 2:
							array_push($result, "fileTooLarge_form");
		                    break;
		                case 3:
							array_push($result, "filePartiallyUploaded");
		                    break;
		                case 4:
		                    array_push($result, "fileNotSubmitted");
		                    break;
		                case 6:
		                    array_push($result, "tempFolderMissing");
		                    break;
		                case 7:
							array_push($result, "noWriteAccess");
		                    break;
		                case 8:
							array_push($result, "uploadStopped");
		                    break;
		            }
		        }
				else
				{
					//Get file name and type
					$fileName = $files[$key]['name'];
					$fileType = "";
					
					//Separate name and type
					$pos = strripos($fileName, ".");
					if($pos != false)
					{
						$fileName = substr($fileName, 0, $pos);
						$fileType = substr($files[$key]['name'], $pos, strlen($files[$key]['name']) - $pos);
    				}
					
					//Add dots to file tag
					$fileTag = $fileTag ? "." . $fileTag : "";
					
					//Define final file path (minus tag and type)
					$targetFile = $uploadFolder . basename($fileName) . $fileTag . $fileType;
					
					//Avoid duplicate files
					$i = 1;
					while (sizeof(glob($targetFile)) > 0)
						$targetFile = $uploadFolder . basename($fileName) . "_" . $i++ . $fileTag . $fileType;
					
					//Try to upload the file
					if (move_uploaded_file($files[$key]['tmp_name'], $targetFile))
						array_push($result, $targetFile);
				}
			}			
		}
		
		//Return result
		return $result;
	}
}
?>