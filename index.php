<?php 
	require_once("libraries/lib.php");
	session_start(); 
	
	if($op=="logout") { header("Location: op_logout.php"); }
	
	
	if(!check_session()) {
		// Login
		if($op!="register") require_once("login.php");
		if($op=="register") include_once("components/login/register.php");

	} else {

		require_once("header.php");
		require_once("components/menu/menu.php");
		if(check_session()) KeepAliveSession();
		
		$op = addslashes($_GET['op']);
	
		if($op=="" || $op=="dashboard") include_once("components/content/dashboard.php");
	
		if($op=="list-datasets") include_once("components/list-items/list-datasets.php");	
		if($op=="edit-dataset") include_once("components/forms/edit-dataset.php");
		if($op=="list-dataFormat") include_once("components/list-items/list-dataFormat.php");
		if($op=="edit-dataFormat") include_once("components/forms/edit-dataFormat.php");
		if($op=="list-metadataSchema") include_once("components/list-items/list-metadataSchema.php");
		if($op=="edit-metadataSchema") include_once("components/forms/edit-metadataSchema.php");
	
		if($op=="settings") include_once("components/settings/settings.php");
		//if($op=="login") include_once("components/login/login.php");
		
		if($op=="maps") include_once("components/content/maps.php");
	
		require_once("footer.php");
	}
?>
