/**
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
 * The Wigbi.JS.LanguageHandler class.
 * 
 * This class is fully described in the class documentation that can
 * be found at http://www.wigbi.com/documentation or downloaded as a
 * part of the Wigbi source code download.
 *  
 * 
 * @author			Daniel Saidi <daniel.saidi@gmail.com>
 * @copyright		Copyright © 2010, Daniel Saidi
 * @link				http://www.wigbi.com
 * @package			Wigbi
 * @subpackage	JS
 * @version			1.0.0
 */
function LanguageHandler(languageData)
{
	//Inherit IniHandler
	$.extend(this, new IniHandler(languageData));
	

	//Translate a language parameter
	this.translate = function(parameter, section)
	{
		//Remove term from left to right until a translation is found
		var parameterArray = parameter.split(" ");
		while (parameterArray.length > 0)
		{
			//Load the current term from the language object
			tmpParameter = parameterArray.join(" ");
			
			//Return the translation, if any
			var tmpTranslation = this.get(tmpParameter, section);
			if (tmpTranslation)
				return tmpTranslation;
				
			//If no translation was found, remove the leftmost word and continue
			parameterArray.splice(0, 1);
		}
		
		//If no translation was found, return the initial parameter
		return parameter;
	};
};