<?php

if(!isset($db_host) || !isset($db_user) || !isset($db_pass) || !isset($db_name)) {
	echo "ERROR: database parameters NOT SET.";
	die();
}
	
$db = mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error());
mysql_select_db($db_name, $db) or die(mysql_error());
mysql_query("SET NAMES 'utf8'", $db) or die(mysql_error());

?>