<?php

require("php/io/FakePhpFileIncluder.php");

$wigbi_test_config = array();

$wigbi_test_config["application"] = array();
$wigbi_test_config["application"]["name"] = "application";
$wigbi_test_config["application"]["clientRoot"] = "/wigbi_dev/";

Wigbi::configuration(new ArrayBasedConfiguration($wigbi_test_config));

Wigbi::cache(new MemoryCache());
Wigbi::cookies(new Cookies("application"));
Wigbi::logger(new NonLogger());
Wigbi::phpFileIncluder(new FakePhpFileIncluder());
Wigbi::session(new Session("application"));
Wigbi::translator(new ArrayBasedTranslator($wigbi_test_config));

?>