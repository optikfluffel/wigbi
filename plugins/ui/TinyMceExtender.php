<?php

/**
 * Wigbi.Plugins.UI.TinyMceExtender PHP class file.
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
 * The Wigbi.Plugins.UI.TinyMceExtender PHP class.
 * 
 * This plugin can be used to apply Tiny MCE, which turns text area
 * elements into WYSIWYG (What You See Is What You Get) editors.
 * 
 * To be affected by the plugin, text area elements must either use
 * the "wysiwyg advanced" or the "wysiwyg simple" CSS class. If any
 * such elements are loaded into the page with AJAX, after Tiny MCE
 * has been applied, Tiny MCE must be re-applied with JavaScript.
 * 
 * Before this plugin can be used, Tiny MCE must be downloaded from
 * the official site and added to the application. It is not a part
 * of Wigbi. To make this plugin easy to use, the number of setting
 * parameters have been kept to a minimum. If the basic behavior of
 * Tiny MCE should be modified, edit the JavaScript class file. 
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This UI plugin has the following JavaScript functionality besides
 * what is provided by the WigbiUIPlugin base class:
 * 
 * 	<ul>
 * 		<li>public void add()</li>
 * 	</ul>
 * 
 * Note that no AJAX is used when applying Tiny MCE with JavaScript.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @link				http://tinymce.moxiecode.com/
 * @package			Wigbi
 * @subpackage	Plugins.UI
 * @version			1.0.0
 * 
 * @static
 */
class TinyMceExtender extends WigbiUIPlugin
{
	/**
	 * Apply TinyMceExtender to the page.
	 * 
	 * @access	public
	 * 
	 * @param		string	$jqueryScriptFile	Path to the Tiny MCE jquery.tinymce.js file.
	 * @param		string	$scriptFile				Path to the Tiny MCE tiny_mce.js file.
	 * @param		string	$cssFile					Path to a CSS file that should be used by Tiny MCE; default blank.
	 */
	public static function add($jqueryScriptFile, $scriptFile, $cssFile = "")
	{
		?>
			<script type="text/javascript" src="<?php print $jqueryScriptFile; ?>"></script>
			<script type="text/javascript">
				TinyMceExtender.scriptFile = "<?php print $scriptFile; ?>";
				TinyMceExtender.cssFile = "<?php print $cssFile; ?>"; 
				TinyMceExtender.add();
			</script>
		<?php
	}
}

?>