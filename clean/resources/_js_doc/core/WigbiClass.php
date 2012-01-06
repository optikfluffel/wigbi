<?php
/**
 * Wigbi.JS.WigbiClass class file.
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
 * The Wigbi.JS.Core.WigbiClass class.
 * 
 * This base class is inherited by all Wigbi JavaScript classes. For
 * now, it only provides its descendants with a className() property,
 * which is convenient to use when using the Wigbi ajax() method.
 * 
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS.Core
 * @version			1.0.0
 * 
 * @abstract
 */
abstract class WigbiClass_
{
	/**
	 * Get the class name of the object.
	 * 
	 * This property returns the "real" class name of the object and
	 * not "object", which is returned by typeof(...).
	 * 
	 * @access	public
	 * 
	 * @return	string	The class name of the object.
	 */
	public function className() { return ""; }
}
?>