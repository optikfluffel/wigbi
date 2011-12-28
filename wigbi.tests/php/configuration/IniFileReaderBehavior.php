<?php

	class IniFileReaderBehavior extends UnitTestCase
	{
		public function test_readfile_shouldReturnNullForNonExistingFile()
		{
			$reader = new IniFileReader();
			
			$result = $reader->readFile("foo/bar");
			
			$this->assertNull($result);
		}
	}

?>