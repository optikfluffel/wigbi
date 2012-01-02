<?php

	class JavaScriptBehavior extends UnitTestCase
	{
		function test_alert_shouldAppendCorrectCode()
		{
			ob_start();
			JavaScript::alert("foo");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type=\"text/javascript\">alert('foo');</script>");
		}
		
		function test_redirect_shouldAppendCorrectCode()
		{
			ob_start();
			JavaScript::redirect("http://www.foo.com");
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type='text/javascript'>location.href='http://www.foo.com';</script>");
		}
		
		function test_reload_shouldAppendCorrectCode()
		{
			ob_start();
			JavaScript::reload();
			$result = ob_get_clean();
			
			$this->assertEqual($result, "<script type='text/javascript'>location.reload();</script>");
		}
	}

?>