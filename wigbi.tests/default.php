<?php

$wigbi_bootstrapper = "wigbi.tests/wigbi.tests.bootstrap.php";

require("tools/SimpleTest_1_1/autorun.php");
require("../wigbi/wigbi.php");
require($wigbi_globals["root"] . "wigbi.tests/wigbi.tests.include.php");

SimpleTest::ignore('CookieBehavior');
SimpleTest::ignore('UrlExistsValidatorgBehavior');

?>