<?php

/**
 * Wigbi.Plugins.UI.YouTubePlayer PHP class file.
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
 * The Wigbi.Plugins.UI.YouTubePlayer PHP class.
 * 
 * This plugin can be used to display a YouTube player with a movie.
 * This plugin supports the old embed format. A new version will be
 * added soon.
 * 
 * 
 * JAVASCRIPT ********************
 * 
 * This plugin has the following JavaScript functionality:
 * 
 * 	<ul>
 * 		<li>[AJAX] public void add(string id, string redirectUrl, string targetContainerId, function onAdd())</li>
 * 	</ul>
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2009-2011, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	Plugins.UI
 * @version			1.0.2
 */
class YouTubePlayer extends WigbiUIPlugin
{
	/**
	 * Create an instance of the class. 
	 * 
	 * @access	public
	 * 
	 * @param	string	$id	The unique plugin instance ID.
	 */
	public function __construct($id)
	{
		parent::__construct($id);
	}
	
	
	
	/**
	 * Add a YouTubePlayer to the page.
	 * 
	 * @access	public
	 * 
	 * @param		string	$id						The unique plugin instance ID.
	 * @param		string	$movieUrl			The URL of the YouTube movie clip.
	 */
	public static function add($id, $movieUrl, $width, $height)
	{
		$plugin = new YouTubePlayer($id);
		
		$plugin->beginPlugin(); ?>
		
			<object width="<?php print $width ?>" height="<?php print $height ?>">
				<param name="movie" value="<?php print $movieUrl ?>"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				
				<embed src="<?php print $movieUrl ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php print $width ?>" height="<?php print $height ?>"></embed>
			</object>
		
			<script type="text/javascript">
				var <?print $id ?> = new YouTubePlayer("<?print $id ?>", "<?php print $redirectUrl; ?>");
			</script>
			
		<?php return $plugin->endPlugin();
	}
}

?>