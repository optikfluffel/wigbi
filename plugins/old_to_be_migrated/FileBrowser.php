<?php
/**
 * Wigbi.PHP.Controls.FileBrowser class file.
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
 * The FileBrowser control class.
 *  
 * This control can be used to view files that have been uploaded to
 * a certain folder on the server.
 * 
 * The control can be added to the page with the PHP and JavaScript
 * add functions and can then be retrieved with Wigbi.getControl(id).
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * FileBrowser : BaseControl
 * 
 * Properties:
 *	<ul>
 * 		<li>public string fileFilter()</li>
 * 		<li>public void setFileFilter(string newVal)</li>
 * 		<li>public string folder()</li>
 * 		<li>public void setFolder(string newVal)</li>
 * 	</ul>
 * 
 * Functions:
 *	<ul>
 * 		<li>[ASYNC] public static void add(string controlId, string folder, string fileFilter, string targetElementId, function onAdd())</li>
 * 	</ul>
 * 
 * Events:
 *  <ul>
 * 		<li>public array onFileSelected(string fileName)</li>
 *  </ul>
 * 
 * Override the onFileSelected event to set what to do when a file
 * is selected. By default, the browser is redirected to the file.
 * 
 * 
 * @author		Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright	Copyright (c) 2009, Daniel Saidi
 * @link		http://www.wigbi.com
 * @license		http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Wigbi
 * @subpackage	PHP.Controls
 * @since		Version 0.99
 * @version		0.99.2
 */
class FileBrowser extends BaseControl
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
FileBrowser = Class({ Extends: BaseControl,
	
	/* Constructor ************/
	
	//Create an instance of the class.
	initialize: function(controlId)
	{
		//Call base contructor
		this.parent(controlId);
	},
	
	
	/* Properties *************/
	
	//Get/set the filter to apply to the file list.
	fileFilter: function() { return this.form().fileFilter.value; },
	setFileFilter: function(newVal) { this.form().fileFilter.value = newVal; },
	
	//Get/set the browse folder
	folder: function() { return this.form().folder.value; },
	setFolder: function(newVal) { this.form().folder.value = newVal; },
	
	
	/* Events *****************/
	
	//Get the currently selected files
	onFileSelected: function(fileName)
	{
		location.href = fileName;
	}
});


/* Static functions ********/

//Add a new control instance to the page with AJAX
FileBrowser.add = function(controlId, folder, fileFilter, targetElementId, onAdd)
{
	Wigbi.executeFunction('FileBrowser', null, 'add', [controlId, folder, fileFilter], function(result)
	{
		//Create and add the control
		new FileBrowser(controlId);
		$('#' + targetElementId).html(result);
		
		//Raise the onAdd event
		if (onAdd)
			onAdd();
	});
};
");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a FileBrowser control to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$controlId		The unique control ID.
	 * @param	string	$folder			The application relative folder from which to retrieve files.
	 * @param	string	$fileFilter		The filter to apply to the file list, e.g. *.gif; default null.
	 */
	public static function add($controlId, $folder, $fileFilter = "*.*")
	{
		//Reset file filter, if needed
		if (!$fileFilter)
			$fileFilter = "*.*";
		
		//Add form
		BaseControl::openForm("FileBrowser", $controlId);
		?>
			<input type="hidden" name="folder" id="<?php print $controlId ?>-folder" value="<?php print $folder ?>" />
			<input type="hidden" name="fileFilter"  id="<?php print $controlId ?>-fileFilter" value="<?php print $fileFilter ?>" />
			
			<ul>
				<?php
				$odd = true;
				foreach (FileBrowser::getFiles($folder, $fileFilter) as $fileName) { ?>
					<li <?php print $odd ? "" : " class='even'" ?>>
						<a href="" onclick="Wigbi.getControl('<?php print $controlId; ?>').onFileSelected('<?php print Wigbi::webRoot() . $folder . "/" . $fileName ?>'); return false;">
							<?php print $fileName ?>
						</a>
					</li>
				<?php $odd = !$odd; } ?>
			</ul>
		
			<script type="text/javascript">
				new FileBrowser("<?php print $controlId ?>");
			</script>
		<?php
		BaseControl::closeForm();
	}
	
	/**
	 * Get a list of files that exist in a certain server folder.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$folder			The application relative folder path.
	 * @param	string	$fileFilter		The file filter, e.g. *.gif; default *.*.
	 * @return	array					A list of file names.
	 */
	public static function getFiles($folder, $fileFilter = "*.*")
	{
		//Make the folder application relative
		$folder = Wigbi::serverRoot() . $folder;
		
		//Add each matching file to the returned array
		$result = array();
		foreach (glob($folder . "/" . $fileFilter) as $file)
			array_push($result, str_replace($folder . "/", "", $file));
		return $result;
	}
}
?>