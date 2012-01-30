<?php

$wigbi_bootstrapper = "wigbi.tests/wigbi.tests.bootstrap.php";
require("../wigbi/wigbi.php");
require($wigbi_root . "wigbi.tests/wigbi.tests.include.php");

SimpleTest::ignore('CookiesBehavior');
SimpleTest::ignore('MySqlDatabaseConnectionBehavior');
SimpleTest::ignore('UrlExistsValidatorgBehavior');

?>