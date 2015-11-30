<?php


if(strlen(trim($hash))==50) {
	
	$sql_query = "SELECT COUNT(*) AS c FROM users WHERE `hash`='".$hash."'";
	$sql_results = mysql_query($sql_query,$db) or die(mysql_error());
	$sql_result = mysql_fetch_array($sql_results);
	$c = $sql_result['c'];		

	if($c==1) {
	
		$sql_query = "SELECT * FROM users WHERE `hash`='".$hash."'";
		$sql_results = mysql_query($sql_query,$db) or die(mysql_error());
		$sql_result = mysql_fetch_array($sql_results);
		$u_name = $sql_result['name'];	
		$u_id = $sql_result['id'];	
		
		/*$sql_query = "INSERT INTO foafAgent(name,agent_id,cr_tstamp,cr_uid) VALUES('".$u_name."','0',NOW(),'".$u_id."')";
		$results = mysql_query($sql_query,$db);
		$agent_id = mysql_insert_id();*/
		
		$sql_query = "UPDATE users SET active=1 WHERE `hash`='".$hash."'";
		$sql_results = mysql_query($sql_query,$db) or die(mysql_error());

		//header("Location: ../../../index.php?p=register&status=2");
		//die();
	}
}


?>