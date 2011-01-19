Wigbi
=====

Author: Daniel Saidi [daniel.saidi@gmail.com]

Wigbi is a minimalistic, open source PHP/JavaScript framework that
helps you create web sites and web-based applications. It is quick
to setup, easy to learn and can easily be extended with plugins as
well as with your own classes.

The basic Wigbi release contains:

	* wigbi/ - The latest version with everything you need
	* plugins/ - Wigbi data and UI plugins to help you get started
	* index-wigbi.php - A simple page that verifies that Wigbi works

Wigbi is developed with TDD, which means that basically everything
is tested. The unit test bundle is not part of the release. To get
it, fork the source code on http://github.com/danielsaidi/wigbi.


Getting started
===============

To get started with Wigbi, navigate to index_wigbi.php in your web
browser. You will receive a bunch of exceptions since Wigbi is not
properly configured. All you have to do now is to:

	* open wigbi/config.ini	(is auto-generated if it does not exist)
	* enter a value for application.name		(a name of your choice)
	* enter a value for application.webRoot (the web site root URL)

That's it! If you reload the page, it should not throw any more of
these annoying exceptions. For now, index_wigbi.php is simple, but
I will use it to display how Wigbi is currently setup. In due time :)


Contact & downloads
===================

You will always find the latest source code and releases at GitHub:
http://github.com/danielsaidi/wigbi

If you feel like helping out, contact me at daniel.saidi@gmail.com
or visit http://www.wigbi.com

Since no one has taken contact with me yet, I assume that I can be
lazy and work in a slooow pace that fits me :)
