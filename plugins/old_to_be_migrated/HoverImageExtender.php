<?php
/**
 * Wigbi.PHP.Controls.HoverImageExtender class file.
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
 * The HoverImageExtender extender class.
 * 
 * This extender can be used to toggle the image of an image element
 * when the mouse pointer moves over it.
 * 
 * The extender can be added to the page with the PHP and JavaScript
 * add functions. It is not added to the Wigbi control collection.
 * 
 * Although the extender adds an href attribute to the image element,
 * make sure to set a default href anyway! If not, some browsers will
 * interpret the blank href as the image url and load it, which will
 * make them load the default folder page and thus burden the system.
 * 
 * 
 * JAVASCRIPT ********************************
 * 
 * Functions:
 *	<ul>
 * 		<li>public static void add(string imageId, string imageUrl, string hoverImageUrl)</li>
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
 * @todo		jQuerify the JavaScript code.
 */
class HoverImageExtender extends BaseControl
{
	//Constructor ******************
	
	/**
	 * Create an instance of the extender.
	 * 
	 * This constructor is only to be used by Wigbi at startup.
	 * 
	 * @access	public
	 */
	public function __construct()
	{
		//Register the general JavaScript control code
		$this->registerJavaScript(@"
HoverImageExtender = Class({});


/* Static functions ********/

//Add a HoverImageExtender extender to the page
HoverImageExtender.add = function(imageId, imageUrl, hoverImageUrl)
{
	$('#' + imageId).attr('src', imageUrl).unbind('mouseover').mouseover(function() {
		$('#' + imageId).attr('src', hoverImageUrl);
    }).unbind('mouseout').mouseout(function() {
    	$('#' + imageId).attr('src', imageUrl);
    });
};");
	}
	
	
	//Functions ********************
	
	/**
	 * Add a HoverImageExtender extender to the page.
	 * 
	 * @access	public
	 * @static
	 * 
	 * @param	string	$imageId		The ID of the image element to affect.
	 * @param	string	$imageUrl		The default image url.
	 * @param	string	$hoverImageUrl	The hover image url.
	 */
	public static function add($imageId, $imageUrl, $hoverImageUrl)
	{
		?><script type="text/javascript">
			HoverImageExtender.add('<?php print $imageId; ?>', '<?php print $imageUrl; ?>', '<?php print $hoverImageUrl; ?>');
		</script><?php
	}
}
?>