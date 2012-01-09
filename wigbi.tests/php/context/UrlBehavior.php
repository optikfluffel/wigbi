<?php

	class UrlBehavior extends UnitTestCase
	{
		private $_context;
		
		
		function setUp() { }
		
		function tearDown() { } 
		
		
		public function test_ctor_shouldParseUrl()
		{
			$urlString = "http://username:password@www.foo.bar:1234/foo/bar?foo=bar#start";
			$url = new Url($urlString);
			
			$this->assertEqual($url->scheme(), "http");
			$this->assertEqual($url->user(), "username");
			$this->assertEqual($url->password(), "password");
			$this->assertEqual($url->host(), "www.foo.bar");
			$this->assertEqual($url->port(), "1234");
			$this->assertEqual($url->path(), "/foo/bar");
			$this->assertEqual($url->query(), "foo=bar");
			$this->assertEqual($url->query(), "foo=bar");
			$this->assertEqual($url->fragment(), "start");
		}
		
		
		public function test_current_shouldReturnCurrentUrl()
		{
			$url = Url::current();
			
			$this->assertEqual($url->scheme(), "http");
			$this->assertEqual($url->user(), null);
			$this->assertEqual($url->password(), null);
			$this->assertEqual($url->host(), "localhost");
			$this->assertEqual($url->port(), "8888");
			$this->assertEqual($url->path(), "/wigbi_dev/wigbi.tests/default.php");
			$this->assertEqual($url->query(), null);
			$this->assertEqual($url->query(), null);
			$this->assertEqual($url->fragment(), null);
		}
	}

?>