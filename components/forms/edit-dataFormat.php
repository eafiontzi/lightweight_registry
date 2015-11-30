<?php	
	require_once("libraries/lib.php");
	
	if(isset($_GET['id'])) 	$DataFormatId = intval($_GET['id']);
	if(isset($_POST['id'])) $DataFormatId = intval($_POST['id']);
	
	$name="";
	if($DataFormatId>0) {
		$sql_query = "SELECT name FROM DataFormat WHERE id='".$DataFormatId."'";
		$results = mysql_query($sql_query,$db);
		while($result = mysql_fetch_array($results)) {
			$name = $result['name'];
		}
	}	
	
?>

<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="index.php?op=dashboard">Dashboard</a></li>
				<li><a href="#">Data Format</a></li>
				<li><a href="#">Create new Data Format</a></li>
			</ol>
		</div>
	</div>
	<div class="row">
		
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-sign-in"></i>
						<span>New Instance</span>
					</div>
					<div class="box-icons pull-right">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="expand-link">
							<i class="fa fa-expand"></i>
						</a>
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content">
					<div id="tabs">
						<ul>
							<li><a href="#tabs-1"><i class="fa fa-tag"></i> General</a></li>
							<li><a href="#tabs-2"><i class="fa fa-chain"></i> Associations</a></li>
						</ul>
						<form id="defaultForm1" class="form-horizontal" role="form" name="editDataset"  action='components/forms/op_edit-dataFormat.php' method='post' enctype='multipart/form-data' >
							<input type="hidden" name="id" value='<?php echo $DataFormatId; ?>' />
							<div id="tabs-1">
								<div class="box-content">
									<div class="row">
										<div class="col-md-7">								
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:title</label>
												<div class="col-sm-6">
													<input type="text" name="name" id="name" value='<?php echo $name;?>' class="form-control" placeholder="Title" data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("DataFormat","name");?>" >
												</div>
											</div>
											<div class="form-group has-feedback">
												<label class="col-sm-4 control-label">:characterSet</label>
												<div class="col-sm-6">
													<input type="text" id=":characterSet" name="characterSet[]" value="<?php echo getElementValue("DataFormat",$DataFormatId,"characterSet");?>" class="form-control" placeholder="Character Set"  data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("DataFormat","characterSet");?>" >
													<span class="fa fa-font form-control-feedback"></span>									
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4 control-label">:XSD</label>
												<div class="col-sm-6">
													<input type="text" id=":XSD" name="XSD[]" value="<?php echo getElementValue("DataFormat",$DataFormatId,"XSD");?>" class="form-control" placeholder="XSD"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("DataFormat","XSD");?>">
												</div>
											</div>			
											<div class="form-group">
												<label class="col-sm-4 control-label">*:expressedIn</label>
												<div class="col-sm-6">
													<input type="text" id="expressedIn" name="expressedIn[]" value="<?php echo getElementValue("DataFormat",$DataFormatId,"expressedIn");?>" class="form-control" placeholder="Expressed In"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("DataFormat","expressedIn");?>">
												</div>
											</div>	
										</div>	
										<div class="col-md-5">												
											<div class="form-group">										
												<label class="col-sm-offset-1 col-xs-9 control-label">dct:description</label>
												<div class="col-sm-10">
													<textarea class="form-control" rows="8" id="dct_description" name="dct_description[]" placeholder="Description"  data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("DataFormat","dct_description");?>"><?php echo getElementValue("DataFormat",$DataFormatId,"dct_description");?></textarea>
												</div>
											</div>	
										</div>			
									</div>
								</div>
							</div>
							<div id="tabs-2">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">:usesVocabulary</label>
										<div class="col-sm-6">
											<select name="usesVocabulary[]" id="usesVocabulary" multiple="multiple" class="populate placeholder">
												<?php 
												$sql_query = "SELECT * FROM Vocabulary";
												$results = mysql_query($sql_query,$db);
												while($result = mysql_fetch_array($results)) {
													$voc_name = $result['name'];
													$voc_id = $result['id'];
													if(getSelectedValue("DataFormat",$DataFormatId,"usesVocabulary",$voc_id)>0) $sel="selected"; else $sel="";	
													echo "<option value='".$voc_id."' $sel>".$voc_name."</option>\n";
												}												
												?>
											</select>
										</div>
									</div>									
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-2">
									<button type="cancel" style="font-size:11px; " class="btn btn-default btn-label-left">
									<span><i class="fa fa-trash-o txt-danger"></i></span>
										Delete
									</button>
								</div>
								<div class="col-sm-2">
									<button type="submit" style="font-size:11px; " class="btn btn-primary btn-label-left">
									<span><i class="fa fa-save"></i></span>
										Save
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>
<!--End Content-->
<script type="text/javascript">
function DemoSelect2(){
	$('#usesVocabulary').select2({placeholder: "Select Vocabulary"});
}
$(document).ready(function() {
	// Create Wysiwig editor for textare
	//TinyMCEStart('#dct_description', null);
	// Create jQuery-UI tabs
	$("#tabs").tabs();
	// Add tooltip to form-controls
	$('.form-control').tooltip();
	// Load example of form validation
	LoadBootstrapValidatorScript(DemoFormValidator);
	// Add drag-n-drop feature to boxes
	WinMove();
	LoadSelect2Script(DemoSelect2);
});
</script>

