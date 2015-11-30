<?php
	require_once("../../libraries/lib.php");
	
	$id = intval($_POST['id']);
	$name = ($_POST['name']);
	
	if($id==0) {
		$sql_query = "INSERT INTO Dataset(`name`,account_id,cr_tstamp,cr_uid) VALUES('".$name."','".getUserAccount_PerUser(getUserId())."',NOW(),'".getUserId()."')";
		//echo $sql_query;
		$results = mysql_query($sql_query,$db);
		$id = mysql_insert_id();
	}
	
	if($id>0) {
		$fields = array("dct_description","dct_issued","dct_modified","originalId","dct_identifier","dcat_keyword","dct_language","dct_accrualPeriodicity","dct_landingPage","accessPolicy",
						"dct_publisher","dct_creator","owner","legalResponsible","scientificResponsible","technicalResponsible",
						"dct_subject","dct_accessRights","dct_rights",
						"dct_extent","dct_audience","Distribution",
						"period_name","from_bc","from_year","from_month","from_day","to_bc","to_year","to_month","to_day",
						"place_name","geonameid","lat_lon","boxminlat","boxminlon","boxmaxlat","boxmaxlon","address","numinroad","postcode","country");	
		$table = "Dataset";
		saveFormFields($table,$fields,$id,$name);		
		
		/*$sql_query = "UPDATE Dataset SET name='".$name."', last_tstamp=NOW(), last_uid='".getUserId()."' WHERE id='".$id."'";
		$results = mysql_query($sql_query,$db);	
		
		$sql_query = "DELETE FROM DatasetProperties WHERE DatasetId='".$id."'";
		$results = mysql_query($sql_query,$db);
		
		for($i=0; $i<count($fields); $i++) {
			$fName = $fields[$i];
			foreach ( $_POST[$fName] as $fValue ) {
				if(strlen(trim($fValue))>0) {
					$sql_query = "INSERT INTO DatasetProperties(DatasetId,propertyName,propertyValue) VALUES('".$id."','".$fName."','".addslashes($fValue)."')";
					$results = mysql_query($sql_query,$db);
				}
			}
		}	*/
	}
	
	header("Location: ../../index.php?op=edit-dataset&id=$id");
	die();
?>