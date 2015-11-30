<?php
	
	function esc($str) {
		return mysql_real_escape_string($str);
	}
	
	function getUserId() {
		return $_SESSION['uid'];
	}
		
	function getUserName() {
		return $_SESSION['user_nickname'];
	}
	
	function getUserEmail() {
		return $_SESSION['user_email'];
	}
	
	function getUserAccount() {
		return $_SESSION['user_account'];
	}
	
	function getUserRole() {
		return $_SESSION['user_role'];
	}
	
	function getUserFullName() {
		return $_SESSION['user_fullname'];
	}
	
	function getSessionId() {
		return $_SESSION['sid'];
	}
	
	function getUserLanguage() {
		return $_SESSION['user_language'];
	}

	function getUserProfilePhoto() {
		return "images/user_".getUserId().".png";
	}

	
	function getUserLogo() {
		if(file_exists("img/users/".getUserId().".png")) 
			return "img/users/".getUserId().".png";
		else
			return "img/avatar5.png";
	}
	

	function generateKey() {
		//Generate the random string
   		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k",
                   "K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U",
                   "v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
   		$length = 20;
   		$hash = "";
   		for ($i=0; $i<$length; $i++) {
    		$hash .= $chars[rand(0, count($chars)-1)];
   		}
   		return $hash;
	}
	
	
	function getUserAccount_PerUser($user_id) {
		global $db;
		$results = mysql_query("SELECT account_id FROM users WHERE id='".getUserId()."'",$db);
 		if(mysql_num_rows($results)>0) {
   			$result = mysql_fetch_array($results);
   			$c = $result['account_id'];
   			return $c;
   		}
   		return 0;
	}	
	
		
	function getUserAccountId() {
		return $_SESSION['user_provider'];
	}	
	
	function getProviderName($provider_id) {
		global $db;
		$results = mysql_query("SELECT name FROM accounts WHERE id='".$provider_id."'",$db);
 		if(mysql_num_rows($results)>0) {
   			$result = mysql_fetch_array($results);
   			$account_name = $result['name'];
   			return $account_name;
   		}
	}
	
	
	function getUserLanguageLangFileName() {
		global $db;
		$results = mysql_query("SELECT lang_file_name FROM languages WHERE id='".getUserLanguage()."'",$db);
 		if(mysql_num_rows($results)>0) {
   			$result = mysql_fetch_array($results);
   			$lang_file_name = $result['lang_file_name'];
   			return $lang_file_name;
   		}
	}
	
	function getParameter($key) {
		global $db;
		$results = mysql_query("SELECT `value` FROM parameters WHERE `key`='$key'",$db);
 		if(mysql_num_rows($results)>0) {
   			$result = mysql_fetch_array($results);
   			$val = $result['value'];
   			return $val;
   		}
	}

		
	
	function convertDateToSQL($date) {
	   $date_ar = explode(" ",$date);
	   if(count($date_ar)==1) { $date_date=$date_ar[0]; $date_time=""; }
	   else if(count($date_ar)==2) { $date_date=$date_ar[0]; $date_time=$date_ar[1]; }
	   else return $date;
	   
	   $date_ar = explode("-",$date_date);
	   if(count($date_ar)!=3) return $date;
	   else return $date_ar[2]."-".$date_ar[1]."-".$date_ar[0] ." ". $date_time;
	}
	
	function convertDateFromSQL($date) {
	   $date_ar = explode(" ",$date);
	   if(count($date_ar)==1) { $date_date=$date_ar[0]; $date_time=""; }
	   else if(count($date_ar)==2) { $date_date=$date_ar[0]; $date_time=$date_ar[1]; }
	   else return $date;
	   
	   $date_ar = explode("-",$date_date);
	   if(count($date_ar)!=3) return $date;
	   else return $date_ar[2]."-".$date_ar[1]."-".$date_ar[0] ." ". $date_time;
	}

	function saveFormFields($table,$fields,$id,$name){
		global $db;
		$sql_query = "UPDATE ".$table." SET name='".$name."', up_tstamp=NOW(), up_uid='".getUserId()."' WHERE id='".$id."'";
		echo $sql_query."</br>";
		$results = mysql_query($sql_query,$db);	
		
		$sql_query = "DELETE FROM  ".$table."Properties WHERE instance_id='".$id."'";
		//echo $sql_query."</br>";
		$results = mysql_query($sql_query,$db);
	
		for($i=0; $i<count($fields); $i++) {
			$fName = $fields[$i];
			//echo $fName."</br>";
			foreach ( $_POST[$fName] as $fValue ) {
				if(strlen(trim($fValue))>0) {
					$sql_query = "INSERT INTO ".$table."Properties(instance_id,propertyName,propertyValue) VALUES('".$id."','".$fName."','".addslashes($fValue)."')";
					//echo $sql_query."</br>";
					$results = mysql_query($sql_query,$db);
				}
			}
		}
	}

	function getElementValue($table,$id,$propertyName){	
		global $db;
		if ($id>0){
			$sql_query = "SELECT * FROM ".$table."Properties WHERE instance_id='".$id."' AND propertyName='".$propertyName."'";
			$results = mysql_query($sql_query,$db);
			while($result = mysql_fetch_array($results)) {
				$propertyValue = $result['propertyValue'];
			}
			return $propertyValue;
		}
	}
	
	function getSelectedValue($table,$id,$propertyName,$propertyValue) {
		global $db;
		$sql_query = "SELECT COUNT(*) AS c FROM ".$table."Properties WHERE instance_id='".$id."' AND propertyName='".$propertyName."' AND propertyValue='".$propertyValue."'";
		$results = mysql_query($sql_query,$db);
   		$c=0;
   		while($result = mysql_fetch_array($results)) {
   			$c = $result['c'];
   		}
   		return $c;
	}
	
	function getFoafAgents($table,$id,$propertyName) {
		global $db;
		$sql_query = "SELECT * FROM foafAgent";
		$results = mysql_query($sql_query,$db);
		while($result = mysql_fetch_array($results)) {
			$foaf_name = $result['name'];
			$foaf_id = $result['id'];
			if(getSelectedValue($table,$id,$propertyName,$foaf_id)>0) $sel="selected"; else $sel="";	
			echo "<option value='".$foaf_id."' $sel>".$foaf_name."</option>\n";
		}
	}
	
	function getDescription($table,$propertyName){
		global $db;
		$sql_query = "SELECT propertyDescription FROM ".$table."Descriptions WHERE propertyName='".$propertyName."'";
		$results = mysql_query($sql_query,$db);
   		while($result = mysql_fetch_array($results)) {
   			$c = $result['propertyDescription'];
   		}
   		return $c;	
	}
?>