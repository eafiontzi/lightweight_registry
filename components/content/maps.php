<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div class="box">
			<div id="full-map" class="box-content fullscreenmap">
			</div>
		</div>
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script type="text/javascript">
// Load OpenLayers library and create map
function OpenLayersFS(){
	LoadOpenLayersScript(FullScreenMap);
}
$(document).ready(function() {
	// Add class for fullscreen view
	$('#content').addClass('full-content');
	// Set height of block
	SetMinBlockHeight($('.fullscreenmap'));

	//$.getScript('http://maps.google.com/maps/api/js?sensor=false&callback=OpenLayersFS');
	
	var myLatlng = new google.maps.LatLng(34.307144,32.167969);
	var mapOptions = {
		zoom: 2.5,
		center: myLatlng
	}
	var map = new google.maps.Map(document.getElementById("full-map"),mapOptions);
	
	var locations = [["New York",40.712784,-74.005941],["Cardiff",51.481581, -3.17909],["Lesbos",39.2645095,26.277707299999975]];
	
	var infowindow = new google.maps.InfoWindow();
	var marker, i;
	for (i = 0; i < locations.length; i++) { 
		marker = new google.maps.Marker({
		map: map,
		draggable:true,
		position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		title: "Click to zoom"
	   });

	/*google.maps.event.addListener(marker, 'click', function() {
		map.setZoom(8);
		map.setCenter(marker.getPosition());

	  });*/

	  google.maps.event.addListener(marker, 'click', (function(marker, i) {
		return function() {
		  infowindow.setContent(locations[i][0]);
		  infowindow.open(map, marker);
		}
	  })(marker, i));
	  
	}

});
</script>
