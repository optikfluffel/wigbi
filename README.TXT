Wigbi
=====

Author: Daniel Saidi [daniel.saidi@gmail.com]

Wigbi is a minimalistic, open source PHP/JavaScript framework that
helps you create web sites and web-based applications. It is quick
to setup, easy to learn and can easily be extended with plugins as
well as with your own classes.

The basic Wigbi release contains:
	* controllers/ - Basic controller setup and a home controller
	* wigbi/ - The latest Wigbi version, with everything you need
	* plugins/ - Fully working Wigbi data and UI plugin templates
	* views/ - A default home index view as well as a master page
	* REMOVE_FILE_NAME.htaccess - A .htaccess file used by Wigbi MVC

Wigbi is developed with TDD, but the unit tests suite are not part
of the release bundle. To get your hands on the unit tests, go and
fork the source code on http://github.com/danielsaidi/wigbi.


Getting started
===============

To get started with Wigbi, the easiest thing is to rename the file
REMOVE_FILE_NAME.htaccess to .htaccess (remove the file name, just
like the file name says). 

Depending on your OS setup, the .htaccess file could become hidden
when you change the file name, but you probably already know how a
hidden file can be changed, if you need to do so ;)

You can now visit to the root folder in your web browser (provided
that you have URL rewriting enabled). It will display a Wigbi page
that checks if Wigbi is properly setup.

If Wigbi is NOT properly setup (which it will not be from scratch),
you will receive a bunch of exceptions. All you have to do is to:

	* open wigbi/config.ini	(is auto-generated if it does not exist)
	* enter a value for application.name		(a name of your choice)
	* enter a value for application.webRoot (the web site root URL)

That's it! If you reload the page, it should not throw any more of
these annoying exceptions. For now, the start poage is simple, but
I will extend it...in due time :)


Contact & downloads
===================

You will always find the latest source code and releases at GitHub:
http://github.com/danielsaidi/wigbi

If you feel like helping out, contact me at daniel.saidi@gmail.com
or visit http://www.wigbi.com

Since no one has taken contact with me yet, I assume that I can be
lazy and work in a slooow pace that fits me :)
