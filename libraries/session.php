<?php
	session_start(); 

	
	// ==============================================================
	// ==============================================================
	function check_session() {
		global $db;
		$uid = intval($_SESSION['uid']);
		$sid = esc($_SESSION['sid']);
		$sip = esc($_SERVER['REMOTE_ADDR']);
   	
   		if(strlen($sid)!=50) {
   			return false;
   		}
   		if($sip!="::1" && strlen($sip)<7) {
   			return false;
   		}
   		if(intval($uid)<=0) {
   			return false;
   		}
   	
   		$results = mysql_query("SELECT COUNT(*) AS C FROM users_sessions WHERE ip_address='$sip' AND session_id='$sid' AND user_id='$uid' AND status='LOGGED_IN' AND TO_DAYS(NOW()) - TO_DAYS(login_tstamp) < 1",$db) or die(mysql_error());
   		$result = mysql_fetch_array($results) or die(mysql_error());
   		$count = $result['C'];
   		if($count==0) {
   			return false;
   		} else {
   			return true;
   		}
  		return false;
	}



	// ==============================================================
	// ==============================================================
  	function validate_credentials() {
  		global $db;
		$user_id=0;
		$uname = esc($_POST['uname']);
		$upass = esc($_POST['upass']);
		if(strlen($uname)<1) return $user_id;
		if(strlen($upass)<1) return $user_id;
		
 		$results = mysql_query("SELECT id FROM users WHERE nickname='$uname' AND password=MD5('".$upass."')",$db);
 		if(mysql_num_rows($results)>0) {
   			$result = mysql_fetch_array($results);
   			$user_id = $result['id'];
   			return $user_id;
   		}
   		return $user_id;
	}


	// ==============================================================
	// ==============================================================
	function create_session($uid) {
		global $db;
		$uid = intval($uid);
		$sid = esc($_SESSION['sid']);
		$sip = esc($_SERVER['REMOTE_ADDR']);
		
		//Generate the random string
   		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k",
                   "K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U",
                   "v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
   		$length = 50;
   		$hash = "";
   		for ($i=0; $i<$length; $i++) {
    		$hash .= $chars[rand(0, count($chars)-1)];
   		}
   	
 		$results = mysql_query("SELECT name,nickname,email,language,account_id FROM users WHERE id='$uid'",$db);
 		$result = mysql_fetch_array($results);
 		$user_nickname = $result['nickname'];
 		$user_fullname = $result['name'];
 		$user_language = $result['language'];
 		$user_email = $result['email'];
   		$user_account = $result['account_id'];
   		
   		mysql_query("INSERT INTO users_sessions(session_id,ip_address,user_id,status,login_tstamp,last_tstamp) VALUES("
							 ."'".$hash."', '".$sip."', '".$uid."', 'LOGGED_IN', NOW(), NOW())",$db) or die(mysql_error());
		$_SESSION['sid'] = $hash;
		$_SESSION['uid'] = $uid;
		$_SESSION['user_nickname'] = $user_nickname;
		$_SESSION['user_fullname'] = $user_fullname;
		$_SESSION['user_language'] = $user_language;
		$_SESSION['user_email'] = $user_email;
		$_SESSION['user_role'] = $user_role;
		$_SESSION['user_account'] = $user_account;
		
		return $hash;
	}


	// ==============================================================
	// ==============================================================
	function destroy_session() {
		global $db;
		$uid = intval($_SESSION['uid']);
		$sid = esc($_SESSION['sid']);
		$sip = esc($_SERVER['REMOTE_ADDR']);
		
 		$results = mysql_query("SELECT id FROM users_sessions WHERE session_id='$sid' AND ip_address='$sip' AND user_id='$uid' AND status='LOGGED_IN'",$db);
   		if(mysql_num_rows($results)>0) {
   			$result = mysql_fetch_array($results);
   			$id = $result['id'];
   			mysql_query("UPDATE users_sessions SET status='LOGGED_OUT', last_tstamp=NOW() WHERE id='$id'",$db);
   		}
   	
		unset($_SESSION['uid']);
		unset($_SESSION['sid']);
		unset($_SESSION['user_nickname']);
		unset($_SESSION['user_fullname']);
		unset($_SESSION['user_language']);
		unset($_SESSION['user_email']);
		unset($_SESSION['user_account']);	
	}
	
	
	// ==============================================================
	// ==============================================================
	function KeepAliveSession() {
		global $db;
		$uid = intval($_SESSION['uid']);
		$sid = esc($_SESSION['sid']);
		$sip = esc($_SERVER['REMOTE_ADDR']);
		
 		$results = mysql_query("SELECT id FROM users_sessions WHERE session_id='$sid' AND ip_address='$sip' AND user_id='$uid' AND status='LOGGED_IN'",$db) or die(mysql_error());
   		if(mysql_num_rows($results)>0) {
   			$result = mysql_fetch_array($results);
   			$id = $result['id'];
   			mysql_query("UPDATE users_sessions SET last_tstamp=NOW() WHERE id='$id'",$db) or die(mysql_error());
   		}
	}












		
?>