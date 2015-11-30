<?php	
	require_once("libraries/lib.php");
	
	if(isset($_GET['id'])) 	$metadataSchemaId = intval($_GET['id']);
	if(isset($_POST['id'])) $metadataSchemaId = intval($_POST['id']);
	
	$name="";
	if($metadataSchemaId>0) {
		$sql_query = "SELECT name FROM MetadataSchema WHERE id='".$metadataSchemaId."'";
		$results = mysql_query($sql_query,$db);
		while($result = mysql_fetch_array($results)) {
			$name = $result['name'];
		}
	}
?>	
<script type='text/javascript'>
	function split( val ) {
	  return val.split( /,\s*/ );
	}
	function extractLast( term ) {
	   return split( term ).pop();
	}
	$(document).ready(function() {

		$("#dct_subject").autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "http://thema.dcu.gr:8080/thema/search",
					dataType: "jsonp",
					data: {
						ns: "englishHeritage_ehtbm",
						term: extractLast(request.term)
					},
					success: function( data ) {
						//console.log(data);
						response($.each( data.results, function(index, d) {
							//console.log(d);
							return {
								label: d.label,
								value: d.id
							}
						}));
					}
				});
			},
			minLength:1,
			focus: function() {
				return false;
			},
			select: function( event, ui ) {
			var terms = split( this.value );
			  // remove the current input
			  terms.pop();
			  // add the selected item
			  terms.push( ui.item.value );
			  // add placeholder to get the comma-and-space at the end
			  terms.push( "" );
			  this.value = terms.join( ", " );
			  return false;
			}			
			/*select: function( event, ui ) {
               //console.log(ui);
			   //var input = $("<input type=\"hidden\" value=\"" + ui.item.id + "\" name=\"keywords_uri\" />");
			   //$('#keywords_uri').val(ui.item.id);
            },
			open: function(event, ui) {
				$(".ui-autocomplete").css("z-index", 1000000);
			}	*/
		});
		
	});

</script>		

<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="index.php?op=dashboard">Dashboard</a></li>
				<li><a href="#">Metadata Schema</a></li>
				<li><a href="#">Create a new Metadata Schema</a></li>
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
							<li><a href="#tabs-2"><i class="fa fa-spinner"></i> Standard</a></li>
							<li><a href="#tabs-3"><i class="fa fa-minus-circle"></i> Rights</a></li>
							<li><a href="#tabs-4"><i class="fa fa-user"></i> Ownership</a></li>
							<li><a href="#tabs-5"><i class="fa fa-chain"></i> Associations</a></li>							
						</ul>
						<form id="defaultForm1" class="form-horizontal"  name="editDataset"  action='components/forms/op_edit-metadataSchema.php' method='post' enctype='multipart/form-data' >
							<input type="hidden" name="id" value='<?php echo $metadataSchemaId; ?>' />
							<div id="tabs-1">
								<div class="box-content">
									<div class="row">
										<div class="col-md-7">								
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:title</label>
												<div class="col-sm-6">
													<input type="text" name="name" id="name" value='<?php echo $name;?>' class="form-control" placeholder="Title" data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","name");?>">
												</div>
											</div>
											<div class="form-group has-feedback">
												<label class="col-sm-4 control-label">dct:issued</label>
												<div class="col-sm-6">
													<input type="text" id="dct_issued" name="dct_issued[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_issued");?>" class="form-control" placeholder="Issued"  data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("MetadataSchema","dct_issued");?>">
													<span class="fa fa-calendar form-control-feedback"></span>
												</div>
											</div>								
											<div class="form-group  has-feedback">												
												<label class="col-sm-4 control-label">dct:modified</label>
												<div class="col-sm-6">
													<input type="text" id="dct_modified" name="dct_modified[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_modified");?>" class="form-control" placeholder="Modified"  data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("MetadataSchema","dct_modified");?>">
													<span class="fa fa-calendar form-control-feedback"></span>									
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4 control-label">:originalId</label>
												<div class="col-sm-6">
													<input type="text" id="originalId" name="originalId[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"originalId");?>" class="form-control" placeholder="Original Id"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","originalId");?>">
												</div>
											</div>								
											<div class="form-group">												
												<label class="col-sm-4 control-label">dct:identifier</label>
												<div class="col-sm-6">
													<input type="text" id="dct_identifier" name="dct_identifier[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_identifier");?>" class="form-control" placeholder="Identifier"  >
												</div>
											</div>			
											<div class="form-group">
												<label class="col-sm-4 control-label">dcat:keyword</label>
												<div class="col-sm-6">
													<input type="text" id="dcat:keyword" name="dcat_keyword[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dcat_keyword");?>" class="form-control" placeholder="Keyword"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","dcat_keyword");?>">
												</div>
											</div>
											<div class="form-group ">
												<label class="col-sm-4 control-label">*dct:language</label>
												<div class="col-sm-6">
													<select name="dct_language[]" id="dct_language" multiple="multiple" class="populate placeholder">
														<?php 
														$sql_query = "SELECT * FROM languages";
														$results = mysql_query($sql_query,$db);
														while($result = mysql_fetch_array($results)) {
															$lan_name = $result['name'];
															$lan_id = $result['id'];
															if(getSelectedValue("MetadataSchema",$metadataSchemaId,"dct_language",$lan_id)>0) $sel="selected"; else $sel="";	
															echo "<option value='".$lan_id."' $sel>".$lan_name."</option>\n";
														}												
														?>
													</select>
												</div>
											</div>	
											<div class="form-group has-feedback">
												<label class="col-sm-4 control-label">dct:audience</label>
												<div class="col-sm-6">
													<input type="text" id="dct:audience" name="dct_audience[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_audience");?>" class="form-control" placeholder="Audience"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","dct_audience");?>">
													<span class="fa fa-group form-control-feedback"></span>										
												</div>
											</div>								
											<div class="form-group">												
												<label class="col-sm-4 control-label">dct:landingPage</label>
												<div class="col-sm-6">
													<input type="text" id="dct:landingPage" name="dct_landingPage[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_landingPage");?>" class="form-control" placeholder="Landing Page"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","dct_landingPage");?>">
												</div>
											</div>									
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:subject</label>
												<div class="col-sm-8">
													<input type="text" id="dct_subject" name="dct_subject[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_subject");?>" class="form-control" placeholder="Subject" data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","dct_subject");?>">
												</div>
											</div>	
										</div>
										<div class="col-md-5">											
											<div class="form-group">										
												<label class="col-sm-offset-1 col-xs-9 control-label">dct:description</label>
												<div class="col-sm-10">
													<textarea class="form-control" rows="8" id="dct_description" name="dct_description[]" placeholder="Description" data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("MetadataSchema","dct_description");?>"><?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_description");?></textarea>
												</div>
											</div>
										</div>	
									</div>		
								</div>
							</div>
							<div id="tabs-2">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">:standardUsed</label>
										<div class="col-sm-4">
											<select name="standardUsed[]" id="standardUsed" multiple="multiple" class="populate placeholder">
												<?php 
												$sql_query = "SELECT * FROM standards";
												$results = mysql_query($sql_query,$db);
												while($result = mysql_fetch_array($results)) {
													$s_name = $result['name'];
													$s_id = $result['id'];
													if(getSelectedValue("MetadataSchema",$metadataSchemaId,"standardUsed",$s_id)>0) $sel="selected"; else $sel="";	
													echo "<option value='".$s_id."' $sel>".$s_name."</option>\n";
												}												
												?>
											</select>
										</div>
									</div>	
									<div class="form-group">
										<label class="col-sm-2 control-label">:proprietary FormatDescription</label>
										<div class="col-sm-6">
											<textarea class="form-control" rows="5" id="proprietaryFormatDesc" name="proprietaryFormatDesc[]" placeholder="Description" id="wysiwig_simple" data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("MetadataSchema","proprietaryFormatDesc");?>"><?php echo getElementValue("MetadataSchema",$metadataSchemaId,"proprietaryFormatDesc");?></textarea>
										</div>									
									</div>
									<div class="form-group has-feedback">
										<label class="col-sm-2 control-label">foaf:homepage</label>
										<div class="col-sm-4">
											<input type="text" name="foaf_homepage[]" id="foaf:homepage" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"foaf_homepage");?>" class="form-control" placeholder="Homepage">
											<span class="fa fa-home form-control-feedback"></span>
										</div>									
									</div>									
								</div>
							</div>
							<div id="tabs-3">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">:accessPolicy</label>
										<div class="col-sm-4">
											<input id=":accessPolicy" name="accessPolicy[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"accessPolicy");?>" type="text" class="form-control" placeholder="Access Policy"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","accessPolicy");?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">dct:accessRights</label>
										<div class="col-sm-4">
											<input id="dct:accessRights" name="dct_accessRights[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_accessRights");?>" type="text" class="form-control" placeholder="Access Rights"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","dct_accessRights");?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">dct:rights</label>
										<div class="col-sm-4">
											<input id="dct:rights" name="dct_rights[]" value="<?php echo getElementValue("MetadataSchema",$metadataSchemaId,"dct_rights");?>" type="text" class="form-control" placeholder="Rights"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("MetadataSchema","dct_rights");?>">
										</div>
									</div>									
								</div>
							</div>
							<div id="tabs-4">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-4 control-label">:usedby</label>
										<div class="col-sm-6">
											<select name="usedby[]" id="usedby" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("MetadataSchema",$metadataSchemaId,"usedby") ?>
											</select>
										</div>
									</div>								
									<div class="form-group">
										<label class="col-sm-4 control-label">dct:publisher</label>
										<div class="col-sm-6">
											<select name="dct_publisher[]" id="s2_with_tag_pub" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("MetadataSchema",$metadataSchemaId,"dct_publisher") ?>
											</select>
										</div>
									</div>	
									<div class="form-group">										
										<label class="col-sm-4 control-label">dct:creator</label>
										<div class="col-sm-6">
											<select name="dct_creator[]" id="s2_with_tag_cre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("MetadataSchema",$metadataSchemaId,"dct_creator") ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">:owner</label>
										<div class="col-sm-6">
											<select name="owner[]" id="s2_with_tag_ow" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("MetadataSchema",$metadataSchemaId,"owner") ?>
											</select>
										</div>
									</div>	
									<div class="form-group">										
										<label class="col-sm-4 control-label">:legalResponsible</label>
										<div class="col-sm-6">
											<select name="legalResponsible[]" id="s2_with_tag_lre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("MetadataSchema",$metadataSchemaId,"legalResponsible") ?>
											</select>
										</div>										
									</div>	
									<div class="form-group">
										<label class="col-sm-4 control-label">:scientificResponsible</label>
										<div class="col-sm-6">
											<select name="scientificResponsible[]" id="s2_with_tag_sre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("MetadataSchema",$metadataSchemaId,"scientificResponsible") ?>
											</select>
										</div>
									</div>	
									<div class="form-group">										
										<label class="col-sm-4 control-label">:technicalResponsible</label>
										<div class="col-sm-6">
											<select name="technicalResponsible[]" id="s2_with_tag_tre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("MetadataSchema",$metadataSchemaId,"technicalResponsible") ?>
											</select>
										</div>										
									</div>											
								</div>
							</div>	
							<div id="tabs-5">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">:isRealizedBy</label>
										<div class="col-sm-6">
											<select name="isRealizedBy[]" id="isRealizedBy" multiple="multiple" class="populate placeholder">
												<?php 
												$sql_query = "SELECT * FROM DataFormat";
												$results = mysql_query($sql_query,$db);
												while($result = mysql_fetch_array($results)) {
													$df_name = $result['name'];
													$df_id = $result['id'];
													if(getSelectedValue("MetadataSchema",$metadataSchemaId,"isRealizedBy",$df_id)>0) $sel="selected"; else $sel="";	
													echo "<option value='".$df_id."' $sel>".$df_name."</option>\n";
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
// Run Select2 plugin on elements
function DemoSelect2(){
	$('#dct_language').select2({placeholder: "Select language"});
	$('#s2_with_tag_pub').select2({placeholder: "Select publisher"});
	$('#s2_with_tag_cre').select2({placeholder: "Select creator"});
	$('#s2_with_tag_ow').select2({placeholder: "Select owner"});
	$('#s2_with_tag_lre').select2({placeholder: "Select legal responsible"});
	$('#s2_with_tag_sre').select2({placeholder: "Select scientific responsible"});
	$('#s2_with_tag_tre').select2({placeholder: "Select technical responsible"});
	$('#usedby').select2({placeholder: "Select the organization using the schema"});
	$('#standardUsed').select2({placeholder: "Select the standard"});
	$('#isRealizedBy').select2({placeholder: "Select Data format"});
}
function OpenLayersFS(){
	LoadOpenLayersScript(FullScreenMap);
}
$(document).ready(function() {
	// Create jQuery-UI tabs
	$("#tabs").tabs();
	// Add tooltip to form-controls
	$('.form-control').tooltip();
	LoadSelect2Script(DemoSelect2);
	// Load example of form validation
	LoadBootstrapValidatorScript(DemoFormValidator);
	// Add drag-n-drop feature to boxes
	WinMove();
	// Initialize datepicker
	$('#dct_issued').datepicker({setDate: new Date()});
	$('#dct_modified').datepicker({setDate: new Date()});
});
</script>

