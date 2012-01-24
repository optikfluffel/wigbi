<?php

	class JavaScriptRunnerBehavior extends UnitTestCase
	{
		private $_runner;
		
		
		function setUp()
		{
			$this->_runner = new JavaScriptRunner();
		}
		
		
		function test_alert_shouldAppendCodeWithTags()
		{
			ob_start();
			$this->_runner->alert("foo");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\">alert('foo');</script>");
		}
		
		function test_alert_shouldAppendCodeWithoutTags()
		{
			ob_start();
			$this->_runner->alert("foo", false);
			$result = ob_get_clean();
			
			$this->assertEqual($result, "alert('foo');");
		}
		
		function test_redirect_shouldAppendCodeWithTags()
		{
			ob_start();
			$this->_runner->redirect("http://www.foo.com");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\">location.href=\"http://www.foo.com\";</script>");
		}
		
		function test_redirect_shouldAppendCodeWithoutTags()
		{
			ob_start();
			$this->_runner->redirect("http://www.foo.com", false);
			$result = ob_get_clean();
			
			$this->assertEqual($result, "location.href=\"http://www.foo.com\";");
		}
		
		function test_run_shouldAppendCodeWithTags()
		{
			ob_start();
			$this->_runner->run("var foo = bar;");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\">var foo = bar;</script>");
		}
		
		function test_run_shouldAppendCodeWithoutTags()
		{
			ob_start();
			$this->_runner->run("var foo = bar;", false);
			$result = ob_get_clean();
			
			$this->assertEqual($result, "var foo = bar;");
		}
	}

?>