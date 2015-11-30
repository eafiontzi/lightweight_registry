<?php
	require_once("libraries/lib.php");
	$user_id = intval(getUserId());
	destroy_session();	
	header("Location: login.php");
?>