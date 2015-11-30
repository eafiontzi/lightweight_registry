<?php
require_once("../../libraries/lib.php");
include_once("Mail.php");


$u_name   		= addslashes($_POST['name']);
$u_nickname	 	= addslashes($_POST['username']);
$u_pass  		= $_POST['password'];
$u_pass2 		= $_POST['confirmPassword'];
$u_email 		= addslashes($_POST['email']);

$sql_query_check = "SELECT `nickname`, `email` FROM users";
$sql_query_results_check = mysql_query($sql_query_check,$db) or die(mysql_error());
while($sql_result_check = mysql_fetch_array($sql_query_results_check)) {
	$c_uname	= $sql_result_check['nickname'];
	$c_email 	= $sql_result_check['email'];
	
	if ($c_uname==$u_name) $name_exists=1; else $name_exists="0";
	if ($c_email==$u_email) $email_exists=1; else $email_exists="0";
	
}
echo $name_exists." ".$email_exists."<br/>";

if ($name_exists>0) header("Location: ../../index.php?op=register&status=3");
if ($email_exists>0) header("Location: ../../index.php?op=register&status=4");
	
if ($name_exists==0 && $email_exists==0) {
	$sql_query_mail_link = "SELECT * FROM users";
	$sql_query_results_mail_link = mysql_query($sql_query_mail_link,$db) or die(mysql_error());
	while($sql_result_mail_link = mysql_fetch_array($sql_query_results_mail_link)) {
		$u_id				= $sql_result_mail_link['id'];
		$u_email2 			= $sql_result_mail_link['email'];
	}
	if($u_id>0) {
		
		$hash = "";
		//Generate the random string
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k",
					   "K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U",
					   "v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
		$length = 50;
		$hash = "";
		for ($i=0; $i<$length; $i++) {
			$hash .= $chars[rand(0, count($chars)-1)];
		}

		if(strlen(trim($u_name))>0 && strlen(trim($u_nickname))>0) {
			$sql_query1 = "INSERT INTO accounts(`name`) VALUES ('".$u_name."')";
			//echo $sql_query1;
			$sql_results1 = mysql_query($sql_query1,$db) or die(mysql_error());
			$acc_id = mysql_insert_id();
			
			$sql_query = "INSERT INTO users(`name`,`nickname`,`email`,`hash`,`password`,`account_id`,`signup_tstamp`) VALUES ( "
									."'".$u_name."', "
									."'".$u_nickname."', "
									."'".$u_email."', "
									."'".$hash."', "
									."MD5('".$u_pass."'), "
									."'".$acc_id."', "
									." NOW() "
									.")";
			//echo $sql_query;
			$sql_results = mysql_query($sql_query,$db) or die(mysql_error());
			$id = mysql_insert_id();

			$url = "http://schemas.cloud.dcu.gr/registry/index.php?op=register&hash=".$hash;
			$subject="DCAT Registry - New member registration confirmation";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "From: ariadne-registry@dcu.gr\r\n";
			$message = "<html><body>";
			$message .= "Please follow this link to activate your account<br/><br/>";		
			$message .= "<a href='".$url."'>Confirm registration</a><br/>";
			$message .= "</body></html>";	
				

			
			mail($u_email, $subject,$message,$headers);
			
			echo $u_email."<br/>".$subject."<br/>".$message."<br/>".$headers;
		}
	}

	header("Location: ../../index.php?op=register&status=1");
}

?>