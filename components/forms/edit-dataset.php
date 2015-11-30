<?php	
	require_once("libraries/lib.php");
	
	if(isset($_GET['id'])) 	$DatasetId = intval($_GET['id']);
	if(isset($_POST['id'])) $DatasetId = intval($_POST['id']);
	
	$name="";
	if($DatasetId>0) {
		$sql_query = "SELECT name FROM Dataset WHERE id='".$DatasetId."'";
		$results = mysql_query($sql_query,$db);
		while($result = mysql_fetch_array($results)) {
			$name = $result['name'];
		}
	}
?>	
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script type='text/javascript'>
	function split( val ) {
	  return val.split( /,\s*/ );
	}
	function extractLast( term ) {
	   return split( term ).pop();
	}
	$(document).ready(function() {
	
		var myOptions = {
			zoom: 14,
			center: new google.maps.LatLng(37.9667, 23.7167),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("full-map"), myOptions);
		google.maps.event.trigger(map, 'resize');
		
		var coord = $("#lat_lon").val();
		var coord = coord.split(";");
		var x = coord[0];
		var y = coord[1];
		if(x>=-180 && x<=180 && y>=-180 && y<=180 && x!=0 && y!=0) {
			map.setCenter(new google.maps.LatLng(x,y));
			google.maps.event.trigger(map, 'resize');
		}		
		
		$('#lat_lon').on( "blur", function() {
			var coord = $("#lat_lon").val();
			var coord = coord.split(";");
			var x = coord[0];
			var y = coord[1];
			//alert("exo timi: "+x+","+y);
			if(x>=-180 && x<=180 && y>=-180 && y<=180 && x!=0 && y!=0) {
				map.setCenter(new google.maps.LatLng(x,y));
				google.maps.event.trigger(map, 'resize');
			}
		});	
			
        $( "#place_name" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "http://api.geonames.org/searchJSON",
                    dataType: "jsonp",
                    data: {
                        //featureClass: "P",
                        style: "full",
                        maxRows: 12,
                        username: "gavrilis@gmail.com",
                        name_startsWith: request.term
                    },
                    success: function( data ) {
                        response( $.map( data.geonames, function( item ) {
                        	//console.log(item);
                            return {
                                label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
                                value: item.name,
                                geonameid: item.geonameId,
                                lat: item.lat,
                                lng: item.lng
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                //log( ui.item ? "Selected: " + ui.item.label : "Nothing selected, input was " + this.value);
                //console.log(ui);
                $("#place_name").val(ui.item.label);
                $("#geonameid").val(ui.item.geonameid);
                $("#lat_lon").val(ui.item.lat+";"+ui.item.lng);
                /*$("#lon").val(ui.item.lng);
				var x = $("#lat").val();
				var y = $("#lon").val();*/
				var coord = $("#lat_lon").val();
				var coord = coord.split(";");
				var x = coord[0];
				var y = coord[1];				
				map.setCenter(new google.maps.LatLng(x,y));
				google.maps.event.trigger(map, 'resize');
            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });

		$(document).on('click', '#tabs li', function (event) {
			google.maps.event.trigger(map, 'resize');
		});		
		
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
				<li><a href="#">Datasets</a></li>
				<li><a href="#">Create a new Dataset</a></li>
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
							<li><a href="#tabs-2"><i class="fa fa-calendar-o"></i> Temporal</a></li>
							<li><a href="#tabs-3"><i class="fa fa-globe"></i> Spatial</a></li>
							<li><a href="#tabs-4"><i class="fa fa-minus-circle"></i> Rights</a></li>
							<li><a href="#tabs-5"><i class="fa fa-user"></i> Ownership</a></li>
							<li><a href="#tabs-6"><i class="fa fa-chain"></i> Associations</a></li>
						</ul>
						<form id="defaultForm1" class="form-horizontal" role="form" name="editDataset"  action='components/forms/op_edit-dataset.php' method='post' enctype='multipart/form-data' >
							<input type="hidden" name="id" value='<?php echo $DatasetId; ?>' />
							<div id="tabs-1">
								<div class="box-content">
									<div class="row">
										<div class="col-md-7">
											
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:title</label>
												<div class="col-sm-6">
													<input type="text" name="name" id="name" value='<?php echo $name;?>' class="form-control" placeholder="Title" data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","name");?>">
												</div>
											</div>
											<div class="form-group has-feedback">
												<label class="col-sm-4 control-label">dct:issued</label>
												<div class="col-sm-6">
													<input type="text" id="dct_issued" name="dct_issued[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_issued");?>" class="form-control" placeholder="Issued"  data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("Dataset","dct_issued");?>">
													<span class="fa fa-calendar form-control-feedback"></span>
												</div>
											</div>
											<div class="form-group has-feedback">
												<label class="col-sm-4 control-label">dct:modified</label>
												<div class="col-sm-6">
													<input type="text" id="dct_modified" name="dct_modified[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_modified");?>" class="form-control" placeholder="Modified"  data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("Dataset","dct_modified");?>">
													<span class="fa fa-calendar form-control-feedback"></span>									
												</div>
											</div>
																				
											<div class="form-group">
												<label class="col-sm-4 control-label">:originalId</label>
												<div class="col-sm-6">
													<input type="text" id="originalId" name="originalId[]" value="<?php echo getElementValue("Dataset",$DatasetId,"originalId");?>" class="form-control" placeholder="Original Id"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","originalId");?>">
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:identifier</label>
												<div class="col-sm-6">
													<input type="text" id="dct_identifier" name="dct_identifier[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_identifier");?>" class="form-control" placeholder="Identifier"  >
												</div>
											</div>	
																								
											<div class="form-group">
												<label class="col-sm-4 control-label">dcat:keyword</label>
												<div class="col-sm-6">
													<input type="text" id="dcat:keyword" name="dcat_keyword[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dcat_keyword");?>" class="form-control" placeholder="Keyword"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dcat_keyword");?>">
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
															if(getSelectedValue("Dataset",$DatasetId,"dct_language",$lan_id)>0) $sel="selected"; else $sel="";	
															echo "<option value='".$lan_id."' $sel>".$lan_name."</option>\n";
														}												
														?>
													</select>
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:accrualPeriodicity</label>
												<div class="col-sm-6">
													<input type="text" id="dct:accrualPeriodicity" name="dct_accrualPeriodicity[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_accrualPeriodicity");?>" class="form-control" placeholder="Accrual Periodicity"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dct_accrualPeriodicity");?>">
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:landingPage</label>
												<div class="col-sm-6">
													<input type="text" id="dct:landingPage" name="dct_landingPage[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_landingPage");?>" class="form-control" placeholder="Landing Page"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dct_landingPage");?>">
												</div>
											</div>	
											
											<div class="form-group has-feedback">
												<label class="col-sm-4 control-label">dct:extent</label>
												<div class="col-sm-6">
													<input type="text" id="dct:extent" name="dct_extent[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_extent");?>" class="form-control" placeholder="Extent"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dct_extent");?>">
												</div>
											</div>
											<div class="form-group has-feedback">
												<label class="col-sm-4 control-label">dct:audience</label>
												<div class="col-sm-6">
													<input type="text" id="dct:audience" name="dct_audience[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_audience");?>" class="form-control" placeholder="Audience"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dct_audience");?>">
													<span class="fa fa-group form-control-feedback"></span>												
												</div>
											</div>
																			
											<div class="form-group">
												<label class="col-sm-4 control-label">dct:subject</label>
												<div class="col-sm-8">
													<input type="text" id="dct_subject" name="dct_subject[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_subject");?>" class="form-control" placeholder="Subject" data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dct_subject");?>">
												</div>
											</div>
										</div>
										<div class="col-md-5">	
											<div class="form-group">										
												<label class="col-sm-offset-1 col-xs-9 control-label">dct:description</label>
												<div class="col-sm-10">
													<textarea class="form-control" rows="8" id="dct_description" name="dct_description[]" placeholder="Description" data-toggle="tooltip" data-placement="top" title="<?php echo getDescription("Dataset","dct_description");?>"><?php echo getElementValue("Dataset",$DatasetId,"dct_description");?></textarea>										
												</div>
											</div>										
										</div>							
									</div>
								</div>
							</div>
							<div id="tabs-2">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">Period name:</label>
										<div class="col-sm-4">
											<select name="period_name[]" id="period_name" multiple="multiple" class="populate placeholder">
												<?php 
												$sql_query = "SELECT * FROM PeriodName";
												$results = mysql_query($sql_query,$db);
												while($result = mysql_fetch_array($results)) {
													$pn_name = $result['name'];
													$pn_id = $result['id'];
													if(getSelectedValue("Dataset",$DatasetId,"period_name",$pn_id)>0) $sel="selected"; else $sel="";	
													echo "<option value='".$pn_id."' $sel>".$pn_name."</option>\n";
												}												
												?>
											</select>
										</div>
									</div>	
									<div class="form-group">
										<label class="col-sm-2 control-label">From Period:</label>
										<div class="col-sm-2">
											<select id="from_bc" name="from_bc[]" class="populate placeholder">
												<?php 
												if(getSelectedValue("Dataset",$DatasetId,"from_bc","BC")>0) $sel="selected"; else $sel="";
												echo "<option value='BC' ".$sel.">BC</option>";
												if(getSelectedValue("Dataset",$DatasetId,"from_bc","AC")>0) $sel="selected"; else $sel="";
												echo "<option value='AC' ".$sel.">AC</option>";
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<input type="text" name="from_year[]" id="from_year" value="<?php echo getElementValue("Dataset",$DatasetId,"from_year");?>" class="form-control" placeholder="Year">
										</div>
										<div class="col-sm-2">
											<input type="text" name="from_month[]" id="from_month" value="<?php echo getElementValue("Dataset",$DatasetId,"from_month");?>" class="form-control" placeholder="Month">
										</div>
										<div class="col-sm-2">
											<input type="text" name="from_day[]" id="from_day" value="<?php echo getElementValue("Dataset",$DatasetId,"from_day");?>" class="form-control" placeholder="Day">
										</div>										
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Until Period:</label>
										<div class="col-sm-2">
											<select id="to_bc" name="to_bc[]" class="populate placeholder">
												<?php 
												if(getSelectedValue("Dataset",$DatasetId,"to_bc","BC")>0) $sel="selected"; else $sel="";
												echo "<option value='BC' ".$sel.">BC</option>";
												if(getSelectedValue("Dataset",$DatasetId,"to_bc","AC")>0) $sel="selected"; else $sel="";
												echo "<option value='AC' ".$sel.">AC</option>";
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<input type="text" name="to_year[]" id="to_year" value="<?php echo getElementValue("Dataset",$DatasetId,"to_year");?>"  class="form-control" placeholder="Year">
										</div>
										<div class="col-sm-2">
											<input type="text" name="to_month[]" id="to_month" value="<?php echo getElementValue("Dataset",$DatasetId,"to_month");?>" class="form-control" placeholder="Month">
										</div>
										<div class="col-sm-2">
											<input type="text" name="to_day[]" id="to_day" value="<?php echo getElementValue("Dataset",$DatasetId,"to_day");?>" class="form-control" placeholder="Day">
										</div>										
									</div>									
								</div>
							</div>
							<div id="tabs-3">
								<div class="box-content">								
									<div class="row"> 
										<div class="col-md-6">				
											<div class="form-group">
												<label class="col-sm-3 control-label">Place name:</label>
												<div class="col-sm-6">
													<input id="place_name" name="place_name[]" value="<?php echo getElementValue("Dataset",$DatasetId,"place_name");?>" type="text" class="form-control" placeholder="Place name">											
												</div>
											</div>								
											<div class="form-group">												
												<label class="col-sm-3 control-label">GeoNameId:</label>
												<div class="col-sm-6">
													<input id="geonameid" name="geonameid[]" value="<?php echo getElementValue("Dataset",$DatasetId,"geonameid");?>" type="text" class="form-control" placeholder="GeoNameId">
												</div>
											</div>								
											<div class="form-group  has-feedback">
												<label class="col-sm-3 control-label">Coordinates:</label>
												<div class="col-sm-6">
													<input id="lat_lon" name="lat_lon[]" value="<?php echo getElementValue("Dataset",$DatasetId,"lat_lon");?>" type="text" class="form-control" placeholder="Latitude;Longitude">
													<span class="fa fa-location-arrow form-control-feedback"></span>										
												</div>
											</div>									
											<div class="form-group">
												<label class="col-sm-3 control-label">Bounding box:</label>
												<div class="col-sm-4">
													<input id="boxminlat" name="boxminlat[]" value="<?php echo getElementValue("Dataset",$DatasetId,"boxminlat");?>" type="text" class="form-control" placeholder="MinLat">
												</div>
												<div class="col-sm-4">
													<input id="boxminlon" name="boxminlon[]" value="<?php echo getElementValue("Dataset",$DatasetId,"boxminlon");?>" type="text" class="form-control" placeholder="MinLon">
												</div>									
											</div>	
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-4">
													<input id="boxmaxlat" name="boxmaxlat[]" value="<?php echo getElementValue("Dataset",$DatasetId,"boxmaxlat");?>" type="text" class="form-control" placeholder="MaxLat">
												</div>
												<div class="col-sm-4">
													<input id="boxmaxlon" name="boxmaxlon[]" value="<?php echo getElementValue("Dataset",$DatasetId,"boxmaxlon");?>" type="text" class="form-control" placeholder="MaxLon">
												</div>									
											</div>	
											<div class="form-group">
												<label class="col-sm-3 control-label">Address</label>
												<div class="col-sm-4">
													<input id="address" name="address[]" type="text" value="<?php echo getElementValue("Dataset",$DatasetId,"address");?>" class="form-control" placeholder="Address">
												</div>												
												<div class="col-sm-4">
													<input id="numinroad" name="numinroad[]" type="text" value="<?php echo getElementValue("Dataset",$DatasetId,"numinroad");?>"  class="form-control" placeholder="Road Number">
												</div>	
											</div>	
											<div class="form-group">												
												<div class="col-sm-offset-3 col-sm-4">
													<input id="postcode" name="postcode[]" type="text" value="<?php echo getElementValue("Dataset",$DatasetId,"postcode");?>" class="form-control" placeholder="Postcode">
												</div>													
												<div class="col-sm-4">
													<input id="country" name="country[]" type="text" value="<?php echo getElementValue("Dataset",$DatasetId,"country");?>" class="form-control" placeholder="Country">
												</div>										
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">									
												<div class="col-sm-offset-1 col-xs-9">
													<div class="box">
														<div id="full-map" class="box-content" style="height: 300px;"></div>
													</div>
												</div>											
											</div>
										</div>
									</div>						
								</div>
							</div>
							<div id="tabs-4">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">:accessPolicy</label>
										<div class="col-sm-4">
											<input id=":accessPolicy" name="accessPolicy[]" value="<?php echo getElementValue("Dataset",$DatasetId,"accessPolicy");?>" type="text" class="form-control" placeholder="Access Policy"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","accessPolicy");?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">dct:accessRights</label>
										<div class="col-sm-4">
											<input id="dct:accessRights" name="dct_accessRights[]" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_accessRights");?>" type="text" class="form-control" placeholder="Access Rights"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dct_accessRights");?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">dct:rights</label>
										<div class="col-sm-4">
											<input id="dct:rights" name="dct_rights[]" type="text" value="<?php echo getElementValue("Dataset",$DatasetId,"dct_rights");?>" class="form-control" placeholder="Rights"  data-toggle="tooltip" data-placement="bottom" title="<?php echo getDescription("Dataset","dct_rights");?>">
										</div>
									</div>									
								</div>
							</div>
							<div id="tabs-5">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-4 control-label">dct:publisher</label>
										<div class="col-sm-4">
											<select name="dct_publisher[]" id="s2_with_tag_pub" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("Dataset",$DatasetId,"dct_publisher") ?>
											</select>
										</div>
									</div>	
									<div class="form-group">										
										<label class="col-sm-4 control-label">dct:creator</label>
										<div class="col-sm-4">
											<select name="dct_creator[]" id="s2_with_tag_cre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("Dataset",$DatasetId,"dct_creator") ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">:owner</label>
										<div class="col-sm-4">
											<select name="owner[]" id="s2_with_tag_ow" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("Dataset",$DatasetId,"owner") ?>
											</select>
										</div>
									</div>	
									<div class="form-group">										
										<label class="col-sm-4 control-label">:legalResponsible</label>
										<div class="col-sm-4">
											<select name="legalResponsible[]" id="s2_with_tag_lre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("Dataset",$DatasetId,"legalResponsible") ?>
											</select>
										</div>										
									</div>	
									<div class="form-group">
										<label class="col-sm-4 control-label">:scientificResponsible</label>
										<div class="col-sm-4">
											<select name="scientificResponsible[]" id="s2_with_tag_sre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("Dataset",$DatasetId,"scientificResponsible") ?>
											</select>
										</div>
									</div>	
									<div class="form-group">										
										<label class="col-sm-4 control-label">:technicalResponsible</label>
										<div class="col-sm-4">
											<select name="technicalResponsible[]" id="s2_with_tag_tre" multiple="multiple" class="populate placeholder" >
												<?php getFoafAgents("Dataset",$DatasetId,"technicalResponsible") ?>
											</select>
										</div>										
									</div>											
								</div>
							</div>	
							<div id="tabs-6">
								<div class="box-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">:Distribution</label>
										<div class="col-sm-6">
											<select name="Distribution[]" id="Distribution" multiple="multiple" class="populate placeholder">
												<?php 
												$sql_query = "SELECT * FROM Distribution";
												$results = mysql_query($sql_query,$db);
												while($result = mysql_fetch_array($results)) {
													$dis_name = $result['name'];
													$dis_id = $result['id'];
													if(getSelectedValue("Dataset",$DatasetId,"Distribution",$dis_id)>0) $sel="selected"; else $sel="";	
													echo "<option value='".$dis_id."' $sel>".$dis_name."</option>\n";
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
	$('#period_name').select2({placeholder: "Select temporal period"});
	$('#s2_with_tag_pub').select2({placeholder: "Select publisher"});
	$('#s2_with_tag_cre').select2({placeholder: "Select creator"});
	$('#s2_with_tag_ow').select2({placeholder: "Select owner"});
	$('#s2_with_tag_lre').select2({placeholder: "Select legal responsible"});
	$('#s2_with_tag_sre').select2({placeholder: "Select scientific responsible"});
	$('#s2_with_tag_tre').select2({placeholder: "Select technical responsible"});
	$('#Distribution').select2({placeholder: "Select distribution"});
	$('#from_bc').select2();
	$('#to_bc').select2();
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
	// Load Google Map API and after this load OpenLayers
	//$.getScript('http://maps.google.com/maps/api/js?sensor=false&callback=OpenLayersFS');	
	// Initialize datepicker
	$('#dct_issued').datepicker({setDate: new Date()});
	$('#dct_modified').datepicker({setDate: new Date()});
});
</script>

