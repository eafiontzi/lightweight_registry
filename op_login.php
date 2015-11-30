<?php
require_once("libraries/lib.php");

$uname = esc($_POST['uname']);
$upass = esc($_POST['upass']);
if(strlen(trim($uname))>0 && strlen(trim($upass))>0) {
	$user_id = validate_credentials();
	if($user_id>0) create_session($user_id);
	
	header("Location: index.php?op=dashboard");
}
?>