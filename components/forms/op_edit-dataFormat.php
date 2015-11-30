<?php
	require_once("../../libraries/lib.php");
	
	$id = intval($_POST['id']);
	$name = ($_POST['name']);

	if($id==0) {
		$sql_query = "INSERT INTO DataFormat(`name`,account_id,cr_tstamp,cr_uid) VALUES('".$name."','".getUserAccount_PerUser(getUserId())."',NOW(),'".getUserId()."')";
		echo $sql_query;
		$results = mysql_query($sql_query,$db);
		$id = mysql_insert_id();
	}
	
	if($id>0) {
		
		$fields = array("characterSet","XSD","expressedIn","dct_description","usesVocabulary");
		$table = "DataFormat";
		saveFormFields($table,$fields,$id,$name);
		 
	}
	
	header("Location: ../../index.php?op=edit-dataFormat&id=$id");
	die();
?>