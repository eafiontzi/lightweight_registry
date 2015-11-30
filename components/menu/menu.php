		<div id="sidebar-left" class="col-xs-2 col-sm-2">
			<ul class="nav main-menu">
				<li>
					<a href="index.php?op=dashboard" class="<?php if($_GET['op']=="dashboard") echo "active"; ?> ">
						<i class="fa fa-dashboard"></i>
						<span class="hidden-xs">Dashboard</span>
					</a>
				</li>
				<li class="dropdown" >
					<a href="#" class="dropdown-toggle <?php if($_GET['op']=="list-datasets" || $_GET['op']=="edit-dataset") echo " active-parent active "; ?>">
						<i class="fa fa-table"></i>
						<span class="hidden-xs">Datasets</span>
					</a>
					<ul class="dropdown-menu"  <?php if($_GET['op']=="list-datasets" || $_GET['op']=="edit-dataset") echo " style=\"display:block;\""; ?> >
						<li><a class="<?php if($_GET['op']=="list-datasets") echo " active-parent active "; ?>" href="index.php?op=list-datasets">Datasets</a></li>
						<li><a class="<?php if($_GET['op']=="edit-dataset") echo " active-parent active "; ?>" href="index.php?op=edit-dataset&id=0">Create a new Dataset</a></li>
					</ul>
				</li>
				<li class="dropdown" >
					<a href="#" class="dropdown-toggle <?php if($_GET['op']=="list-dataFormat" || $_GET['op']=="edit-dataFormat") echo " active-parent active "; ?>">
						<i class="fa fa-pencil-square-o"></i>
						<span class="hidden-xs">Data Format</span>
					</a>
					<ul class="dropdown-menu"  <?php if($_GET['op']=="list-dataFormat" || $_GET['op']=="edit-dataFormat") echo " style=\"display:block;\""; ?> >
						<li><a class="<?php if($_GET['op']=="list-dataFormat") echo " active-parent active "; ?>" href="index.php?op=list-dataFormat">Data Format</a></li>
						<li><a class="<?php if($_GET['op']=="edit-dataFormat") echo " active-parent active "; ?>" href="index.php?op=edit-dataFormat&id=0">Create new Data Format</a></li>
					</ul>
				</li>
				<li class="dropdown" >
					<a href="#" class="dropdown-toggle <?php if($_GET['op']=="list-metadataSchema" || $_GET['op']=="edit-metadataSchema") echo " active-parent active "; ?>">
						<i class="fa fa-qrcode"></i>
						<span class="hidden-xs">Metadata Schema</span>
					</a>
					<ul class="dropdown-menu"  <?php if($_GET['op']=="list-metadataSchema" || $_GET['op']=="edit-metadataSchema") echo " style=\"display:block;\""; ?> >
						<li><a class="<?php if($_GET['op']=="list-metadataSchema") echo " active-parent active "; ?>" href="index.php?op=list-metadataSchema">Metadata Schema</a></li>
						<li><a class="<?php if($_GET['op']=="edit-metadataSchema") echo " active-parent active "; ?>" href="index.php?op=edit-metadataSchema&id=0">Create new Schema</a></li>
					</ul>
				</li>				
				<li class="dropdown" >
					<a href="index.php?op=maps" class="<?php if($_GET['op']=="maps") echo "active"; ?>" >
						<i class="fa fa-map-marker"></i>
						<span class="hidden-xs">Map</span>
					</a>
				</li>
			</ul>
		</div>

