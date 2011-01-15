<?php

/**
 * Wigbi.PHP.Core.WigbiUIPlugin class file.
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
 * The Wigbi.PHP.Core.WigbiUIPlugin class.
 * 
 * A Wigbi UI plugin is a modular component that can be easily added
 * to a page, such as a login form, music player, Tiny MCE code etc.
 * 
 * A UI plugin consists of a .php and a .js file. To use a UI plugin,
 * simply place the two class files in the wigbi/plugins/ui folder.
 * 
 * Wigbi will automatically bundle and obfuscate the JavaScript code
 * from all the UI plugin JavaScript files that are added to a Wigbi
 * application, as long as RTB is enabled in the main config file. 
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	PHP.Core
 * @version			1.0.0
 * 
 * @abstract
 */
abstract class WigbiUIPlugin
{
	/**#@+
	 * @ignore
	 */
	private $_id = 0;


		
	/**
	 * Create an instance of the class.
	 * 
	 * If used, the id parameter must be unique to make sure that it
	 * can be used to identify the plugin. However, it can be unused. 
	 * 
	 * @access	public
	 * 
	 * @param	string	$id	The unique plugin instance ID; default blank.
	 */
	public function __construct($id = "")
	{
		$this->_id = $id;
	}
	
	
	
	/**
	 * Get the plugin ID, which is set by the constructor.
	 * 
	 * @access	public
	 * 
	 * @return	string	The plugin ID.
	 */
	public function id()
	{
		return $this->_id;
	}
	
	
	
	/**
	 * Begin rendering the edit part of a view/edit plugin.
	 * 
	 * @access	public
	 * 
	 * @param	bool	$visible	Whether or not the div is visible from start; default false.
	 */
	public function beginEditDiv($visible = false)
	{
		?><div id="<?php print $this->id() ?>-editPanel" class="editPanel" <?php if (!$visible) print 'style="display:none"' ?>>
			<div class="editButton" style="text-align:right">
				<a href="" onclick="$('#<?php print $this->id() ?>-editPanel').slideUp('fast');$('#<?php print $this->id() ?>-viewPanel').slideDown('fast');return false;">
					<?php print $this->translate("view"); ?>
				</a>
			</div>
		<?php
	}
	
	/**
	 * Begin building the plugin.
	 * 
	 * This method will start the output cache, which is then
	 * handled correctly by calling endPlugin when it is done.
	 * 
	 * @access	public
	 */
	public function beginPlugin()
	{
		ob_start();
	}
	
	/**
	 * Begin embedding the plugin within an div structure.
	 * 
	 * @access	public
	 */
	public function beginPluginDiv()
	{
		?><div id="<?php print $this->id() ?>" class="WigbiUIPlugin <?php print get_class($this) . ' ' . $this->id() ?>"><?php
	}
	
	/**
	 * Begin rendering the view part of a view/edit plugin.
	 * 
	 * @access	public
	 * 
	 * @param	bool	$visible	Whether or not the div is visible from start; default true.
	 */
	public function beginViewDiv($visible = true)
	{
		?><div id="<?php print $this->id() ?>-viewPanel" class="viewPanel" <?php if (!$visible) print 'style="display:none"' ?>>
			<div class="viewButton" style="text-align:right">
				<a href="" onclick="$('#<?php print $this->id() ?>-editPanel').slideDown('fast');$('#<?php print $this->id() ?>-viewPanel').slideUp('fast');return false;">
					<?php print $this->translate("edit"); ?>
				</a>
			</div>
		<?php
	}
	
	/**
	 * End rendering the edit part of a view/edit plugin.
	 * 
	 * @access	public
	 */
	public function endEditDiv()
	{
		?></div><?php
	}
	
	/**
	 * End building the plugin.
	 * 
	 * This method will end output buffering and print the final HTML
	 * result to the page, but only if the request is a non-AJAX one.
	 * If the request is an AJAX one, the result is returned instead.
	 * 
	 * Remember to always return the return value from this function
	 * if it should be possible to add the plugin with AJAX.  
	 * 
	 * @access	public
	 * 
	 * @return	string	HTML result.
	 */
	public function endPlugin()
	{
		$result = ob_get_clean();
		
		if (!Wigbi::isAjaxPostback())
			print $result;
		return $result;
	}
	
	/**
	 * End embedding the plugin within a div structure.
	 * 
	 * @access	public
	 */
	public function endPluginDiv()
	{
		?></div><?php
	}
	
	/**
	 * End rendering the view part of a view/edit plugin.
	 * 
	 * @access	public
	 */
	public function endViewDiv()
	{
		?></div><?php
	}
	
	/**
	 * Get the id string for a certain child element.
	 * 
	 * @access	public
	 * 
	 * @param		string	$elementId	The ID of the element.
	 * @return	string							The resulting id string.
	 */
	public function getChildId($elementId)
	{
		return $this->id() . '-' . $elementId;
	}
	
	/**
	 * Translate a string, using the Wigbi languageHandler instance.
 
	 * This function applies the correct prefix to the string so that
	 * is can be customized. Before being translated, it is converted
	 * to "<id> <className> <originalString>".
	 * 
	 * @access	public
	 * 
	 * @param		string	$str	The string to translate.
	 * @return	string				The translation.
	 */
	public function translate($str)
	{
		return Wigbi::languageHandler()->translate($this->id() . " " . get_class($this) . " " . $str);
	}
}

?>