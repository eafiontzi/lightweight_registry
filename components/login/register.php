<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>DCAT Registry</title>
		<meta name="description" content="description">
		<meta name="author" content="DCU">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href="css/style.css" rel="stylesheet">
		
		<link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
		<link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">	
		<script src="plugins/jquery/jquery-2.1.0.min.js"></script>
		<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
		<script src="plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>
		<script src="plugins/tinymce/tinymce.min.js"></script>
		<script src="plugins/tinymce/jquery.tinymce.min.js"></script>
		<script src="plugins/bootstrap/bootstrap.min.js"></script>
		<script src="js/devoops.js"></script>
				
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
		$(document).ready(function() {
			// Load example of form validation
			LoadBootstrapValidatorScript(DemoFormValidator);

		});
		</script>		
	</head>
<body>
<div class="container-fluid">
	<div id="page-login" class="row">
		<div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div class="text-right">
				<a href="index.php?op=login" class="txt-default">Already have an account?</a>
			</div>
			<div class="box">
				<div class="box-content">
					<div class="text-center">
						<h3 class="page-header">DCAT Registry - Register Page</h3>
					</div>
<?php 
	$status=$_GET['status'];
	$hash = $_GET['hash'];
	if ($hash!="") include_once("components/login/op_verify.php");

	if ($status == 1) echo "<p align='center'>An email containing a confirmation link has been sent to your email address. <br/>Please follow the instructions to activate your account.</p>";
	else if ($hash !="") echo "<p align='center'>Your account has been activated. <br/>Please login to start using you account. </p>";
	else {	
		if ($status == 3) echo "<p align='center'>This <b>Username</b> is already in use.</p>";
		if ($status == 4) echo "<p align='center'>An account with this email address already exists.</p>";
?>					
					<form id="defaultForm" action='components/login/op_register.php' method='post'>				
						<div class="form-group">
							<label class="control-label">Name</label>
							<input type="text" class="form-control"  name="name" />
						</div>					
						<div class="form-group">
							<label class="control-label">Username</label>
							<input type="text" class="form-control"  name="username" />
						</div>
						<div class="form-group">
							<label class="control-label">*E-mail</label>
							<input type="text" class="form-control" name="email" />
						</div>
						<div class="form-group">
							<label class="control-label">Password</label>
							<input type="password" class="form-control"  name="password" />
						</div>
						<div class="form-group">
							<label class="control-label">Retype Password</label>
							<input type="password" class="form-control"  name="confirmPassword" />
						</div>					
						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-label-left">Register</button>
						</div>
					</form>							
					</br>
					<p>*You must fill-in a valid email address in order to receive a confirmation email</p>
<?php } ?>					
				</div>
			</div>
		</div>
	</div>
</div>
	
</body>
</html>
