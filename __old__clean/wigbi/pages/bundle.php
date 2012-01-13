<?php

/************************************************************************
 * CSS and Javascript Combinator 0.5
 * Copyright 2006 by Niels Leenheer
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 *
 * Note (Daniel Saidi, August 2010):
 * This is a little tweak of the original PHP script, that can be found at 
 * http://rakaz.nl/2006/12/make-your-pages-load-faster-by-combining-and-compressing-javascript-and-css-files.html
 * 
 * The original script requires that css/js files are placed in a specific
 * folder (to which the script file must be modified to point). This tweak
 * makes it possible to pass in files and folders to the script instead.
 * 
 * Furthermore, this version of the script rewrites all the url(...) parts
 * of a css file so that they are correct when the file is executed at the
 * bundle url.   
 * 
 * This file is intended to be used in Wigbi (http://www.wigbi.com), where
 * it is placed in ~/wigbi/pages folder. If it is placed in another folder
 * structure, the $root variable must be modified.
 * 
 * The file is used as such (file and folder paths must be relative to the
 * application root):
 * 		
 *		<filePath>?type=[css|js]&elements=["file1","folder","file2" etc.]
 *
 * or, thanks to the wigbi/.htaccess file:
 *
 * 		<root path>wigbi/bundle/css:[comma-separated css files/folders]
 * 		<root path>wigbi/bundle/js:[comma-separated js files/folders]
 */

//Define base url 
$base = "../../";

//Get the bundle type (js|css)
$type = $_GET['type'];

//Set the correct content type
$contentType = $type;
if ($contentType == "js")
	$contentType = "javascript";

//Split all provided elements into an array
$elements = explode(',', $_GET['elements']);
for ($i=0; $i<sizeof($elements); $i++)
	$elements[$i] = $base . $elements[$i];

//Init file array
$files = array();

//Loop through each element
foreach ($elements as $element)
{
	//If the element is a folder, get all files
	if (is_dir($element))
		foreach (glob($element . "/*." . $type) as $folderFile)
			array_push($files, $folderFile);

	//If the element is a file, just add it
	else
		array_push($files, $element);
} 

//Determine last modification dates
$lastmodified = 0;
while (list(,$file) = each($files))
{
	//Invalid file types cause the bundling to abort
	if (($type == 'js' && substr($file, -3) != '.js') || ($type == 'css' && substr($file, -4) != '.css'))
	{
		header ("HTTP/1.0 403 Forbidden");
		exit;	
	}
	
	//Non-existing files cause the bundling to abort
	if (!file_exists($file))
	{
		header("HTTP/1.0 404 Not Found");
		exit;
	}
	
	//Get the most recent last modified date
	$lastmodified = max($lastmodified, filemtime($file));
}

//Send Etag hash according to the last modified date
$hash = $lastmodified . '-' . md5($_GET['elements']);
header("Etag: \"" . $hash . "\"");


//If no modifications have been done since the last time, do not send anything
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"') 
{
	header("HTTP/1.0 304 Not Modified");
	header('Content-Length: 0');
	exit;
}

//Init the resulting, displayed content
$contents = '';

//Reset file array
reset($files);
	
//Parse each file
while (list(,$file) = each($files))
{
	//Get file content and app relative directory path (remove previously added root)
	$fileContent = file_get_contents($file);
	$dirname = str_replace("../", "", dirname($file));
	
	//For CSS files, parse each url(...)
	if ($type == "css")
	{
		if (preg_match_all("/url\(.*\)/", $fileContent, $matches))
		{
			foreach ($matches[0] as $match)
			{
				//Extract the url(...) url
				$url = str_replace("url(", "", $match);
				$url = str_replace(")", "", $url);
				
				//Count the number of ../
				$backCount =  substr_count($url, "../");
				
				//Remove a folder per ../ from the file folder
				$urlDir = $dirname;
				for ($i=0; $i<$backCount; $i++)
					$urlDir = substr($urlDir, 0, strrpos($urlDir, "/"));
				
				//Add the base and result directory to the url (without ../)
				$url = $base . $urlDir . "/" . str_replace("../", "", $url);
				
				//OBS - Add a ../ for each / in the query string (CSS bug?)
				$url = "../../" . $url;
				
				//Replace the url section in the content
				$fileContent = str_replace($match, "url(" . $url . ")", $fileContent);
			}
		}
	}
	
	//Add the resulting file content to output
	$contents .= $fileContent . "\n\n";
}

//Send Content-Type
header("Content-Type: text/" . $contentType);

//Send contents, either compressed or regular
if (isset($encoding) && $encoding != 'none') 
{
	$contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE);
	header ("Content-Encoding: " . $encoding);
	header ('Content-Length: ' . strlen($contents));
	echo $contents;
} 
else 
{
	header ('Content-Length: ' . strlen($contents));
	echo $contents;
} 
