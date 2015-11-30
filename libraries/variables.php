<?php

	// ====== PARSE GET & POST VARIABLES ======
	reset($_GET);
	while(list($key,$val)=each($_GET)){${$key} = $val;}
	reset($_POST);
	while(list($key,$val)=each($_POST)){${$key}=$val;}
	
?>