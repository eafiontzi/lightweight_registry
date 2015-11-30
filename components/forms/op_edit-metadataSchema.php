<?php
	require_once("../../libraries/lib.php");
	
	$id = intval($_POST['id']);
	$name = ($_POST['name']);
	
	if($id==0) {
		$sql_query = "INSERT INTO MetadataSchema(`name`,account_id,cr_tstamp,cr_uid) VALUES('".$name."','".getUserAccount_PerUser(getUserId())."',NOW(),'".getUserId()."')";
		//echo $sql_query;
		$results = mysql_query($sql_query,$db);
		$id = mysql_insert_id();
	}
	
	if($id>0) {
		$fields = array("dct_description","dct_issued","dct_modified","originalId","dct_identifier","dcat_keyword","dct_language","dct_landingPage","accessPolicy",
						"dct_publisher","dct_creator","owner","legalResponsible","scientificResponsible","technicalResponsible",
						"dct_subject","dct_accessRights","dct_rights",
						"dct_audience","isRealizedBy","usedby",
						"standardUsed","proprietaryFormatDesc","foaf_homepage");	
		$table = "MetadataSchema";
		saveFormFields($table,$fields,$id,$name);		
	}
	
	header("Location: ../../index.php?op=edit-metadataSchema&id=$id");
	die();
?>