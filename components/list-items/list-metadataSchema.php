
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="index.php?op=dashboard">Dashboard</a></li>
				<li><a href="#">Metadata Schema</a></li>
				<li><a href="#">Metadata Schema</a></li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-table"></i>
						<span>Already created Metadata Schema</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="expand-link">
							<i class="fa fa-expand"></i>
						</a>
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-3">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Rights</th>
								<th>Subject</th>
								<th>Homepage</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$i=1;
							$sql_query = "SELECT * FROM MetadataSchema";
							$results = mysql_query($sql_query,$db);
							while($result = mysql_fetch_array($results)) {
								$ms_name = $result['name'];
								$ms_id = $result['id'];
								
								echo "<tr>"
										."<td>".$i."</td>"
										."<td><a href='index.php?op=edit-metadataSchema&id=".$ms_id."' target='_blank'>".$ms_name."</a></td>"
										."<td>".getElementValue("MetadataSchema",$ms_id,"dct_rights")."</td>"
										."<td>".getElementValue("MetadataSchema",$ms_id,"dct_subject")."</td>"
										."<td><a href='".getElementValue("MetadataSchema",$ms_id,"foaf_homepage")."' target='_blank'>".getElementValue("MetadataSchema",$ms_id,"foaf_homepage")."</a></td>"
									."</tr>"; 
								
								$i++;
							}					
						?>							
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Rights</th>
								<th>Subject</th>
								<th>Homepage</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->
		
<script type="text/javascript">
// Run Datables plugin and create 3 variants of settings
function AllTables(){
	TestTable1();
	TestTable2();
	TestTable3();
	LoadSelect2Script(MakeSelect2);
}
function MakeSelect2(){
	$('select').select2();
	$('.dataTables_filter').each(function(){
		$(this).find('label input[type=text]').attr('placeholder', 'Search');
	});
}
$(document).ready(function() {
	// Load Datatables and run plugin on tables 
	LoadDataTablesScripts(AllTables);
	// Add Drag-n-Drop feature
	WinMove();
});
</script>
