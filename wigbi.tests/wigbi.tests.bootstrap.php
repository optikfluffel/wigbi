<?php

require("php/io/FakeFileIncluder.php");

$wigbi_test_config = array();

$wigbi_test_config["application"] = array();
$wigbi_test_config["application"]["name"] = "application";
$wigbi_test_config["application"]["clientRoot"] = "/wigbi_dev/";

Wigbi::configuration(new ArrayBasedConfiguration($wigbi_test_config));

Wigbi::cache(new MemoryCache());
Wigbi::cookies(new Cookies("application"));
Wigbi::fileIncluder(new FakeFileIncluder());
Wigbi::logger(new NonLogger());
Wigbi::session(new Session("application"));
Wigbi::translator(new ArrayBasedTranslator($wigbi_test_config));

?>