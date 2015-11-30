<?php

require_once("../../libraries/lib.php");

$id = getUserId();
$name = addslashes($_POST['name']);
$email = addslashes($_POST['email']);
//$uname = addslashes($_POST['uname']);
$upass = addslashes($_POST['password']);
$upass2 = addslashes($_POST['confirmPassword']);

if ($upass!="" && $upass2!="" && $upass != $upass2) header("Location: ../../index.php?op=settings&error=1");

if ($id>0 && $name !="" && $email!="") {	

	// UPDATE USER
	$sql_query3 = "UPDATE users SET name='".$name."', email='".$email."' WHERE id='".$id."'";
	$results3 = mysql_query($sql_query3,$db);	

	if(strlen(trim($upass))>0) {
		// UPDATE PASS
		$sql_query3 = "UPDATE users SET password=MD5('".$upass."')  WHERE id='".$id."'";
		$results3 = mysql_query($sql_query3,$db);		
	}
	
	header("Location: ../../index.php?op=settings&status=1");
}
?>