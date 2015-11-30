<?php 
	require_once("libraries/lib.php");
	global $db;
	
	$sql_query = "SELECT * FROM users WHERE id='".getUserId()."'";
	$results = mysql_query($sql_query,$db);
	while($result = mysql_fetch_array($results)) {
		$fullname	=	$result['name'];
		$nickname	=	$result['nickname'];
		$email		=	$result['email'];
		$key		= 	$result['key'];
	}
?>

<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div></br></div>
	</div>
	<div class="col-xs-12 col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Settings</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">

<?php 
	$error=$_GET['error'];
	$status=$_GET['status'];
	
	if ($error==1) echo "<p>There has been an error.</p>";
	if ($error==2) echo "<p>A User with the same nickname already exists.</p>";
	if ($error==3) echo "<p>A User with the same email address already exists.</p>";
	if ($status==1) echo "<p>Your data have been saved.</p>";
	
?>
				<form id="defaultForm" name='settingsForm' action='components/settings/op_settings.php' method='post' class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 col-sm-offset-2 control-label">Name</label>
						<div class="col-sm-4">
							<input type="text" name='name' class="form-control" placeholder="Name" value='<?php echo $fullname; ?>'>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-offset-2 control-label">Email</label>
						<div class="col-sm-4">
							<input type="text" name='email' class="form-control" placeholder="Email" value='<?php echo $email; ?>'>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-2 col-sm-offset-2 control-label">Username</label>
						<div class="col-sm-4">
							<input type="text" name='uname' class="form-control" placeholder="Username" value='<?php echo $nickname; ?>' disabled>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 col-sm-offset-2 control-label">Password</label>
						<div class="col-sm-4">
							<input type="password" name='password' class="form-control" placeholder="Password" >
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 col-sm-offset-2 control-label">Retype Password</label>
						<div class="col-sm-4">
							<input type="password" name='confirmPassword' class="form-control" placeholder="Retype Password">
						</div>
					</div>							
					<div class="clearfix"></div>
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-4">
							<button type="submit" class="btn btn-primary btn-label-left">
							<span><i class="fa fa-clock-o"></i></span>
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {

	// Load example of form validation
	LoadBootstrapValidatorScript(DemoFormValidator);
	// Add drag-n-drop feature to boxes
	WinMove();
});
</script>