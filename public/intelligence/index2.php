<?php
require('connect.php');
$issueSelect = "SELECT *, X(coordinate) as longitude, Y(coordinate) as latitude FROM `issues` ORDER BY `datetime` ASC LIMIT 1000;";
$issueResult = $conn->query($issueSelect);
if ($issueResult->num_rows > 0) {
	$issueHTML = '';
	while($row = $issueResult->fetch_assoc()) {
		$id = $row['id'];
		$issue = preg_replace("/\r|\n/", "", nl2br(htmlspecialchars($row['issue'])));
		$solution = preg_replace("/\r|\n/", "", nl2br(htmlspecialchars($row['solution'])));
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		$issueJS .= "var marker$id = L.marker([$latitude, $longitude], {icon: defaultIcon}).addTo(mymap);";
		$issueJS .= "marker$id.bindPopup(\"<center><b>Issue $id</b><br/>$issue<br/><br/><b>Solution</b><br/>$solution</center>\");\n";
	}
}
?>
<html>
	<header>
	<?php require($_SERVER['DOCUMENT_ROOT'] . "/css.php"); ?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="crossorigin=""/>
	<style>
	.leaflet-tooltip{
		width: 100px;
		white-space: normal;
	}
	#mapid
	{
		width: 480px;
		height: 270px;
	}
	</style>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="crossorigin=""></script>
	<script src="leaflet/leaflet-geoip.js"></script>
	</header>
	<body>
		<center>
		<div class="content">
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/header.php"); ?>
			<h2>Intelligence</h2>
			<p>What issues does your community face?<br/>Help us crowdsource potential solutions by providing data on social issues near you.</p>
			<h3>How to Report an Issue</h3>
			<p>1. Click and drag the map around, then zoom in until you can see your community.<br/>2. Click on a specific area where there are issues.<br/>3. Once the link that says <br/><b>Do you want to report an issue here?</b> <br/>appears over the area of interest, click on it and fill out the form.</p>
			<p>If you are interested with what we do with the data, check out our method <a href="/method" target="_blank">here</a>.</p>
			<div id="mapid"></div>
			<!--
			<h3>Method 2</h3>
			<h3><a href="https://www.google.com/earth/versions/" target="_blank">Download Google Earth</a>.</h3><p>Choose either the <b>Google Earth on Mobile</b> or <b>Google Earth Pro on desktop</b> options.<p>
			<h3>Once the file has downloaded, open it and follow the installation steps.</p>
			<h3>After you have successfully installed Google Earth, <a href="Issue Visualization.kmz" target="_blank">download the Issue Visualization File</a>.</h3>
			<h3>Open the Issue Visualization File</h3><p>File -> Open -> Navigate to your downloads folder and pick the <b>Issue Visualization.kmz</b> File -> Open</p>
			<h3>Type in the name of your city and state in the search bar, and center your screen on an area that has social issues.</h3><p>Is there a place where the homeless gather? Areas of town that have high crime rates? Go there.</p>
			<h3>After the Earth stops moving, there should be a yellow icon at the center of your screen that is labeled <b>Focus</b>. Click on it.</h3>
			<h3>Fill out the form and click submit.</h3><p>Do not provide any personally identifiable information, it will be public.</p>
			<h3>Your issue is now added to the database.</h3>
			<P>Our network of volunteers will go through the data, and we will apply our resources generated from your <a href="http://www.blackdove.org/support/">support</a> to find potential remedies to these problems.</p>
			-->
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>
		</div>
		<script>
		var mymap = L.map('mapid', {
			zoomSnap: 1
		}).setView([39.8097343, -98.5556199], 3);

		L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox/streets-v11',
			tileSize: 512,
			zoomOffset: -1
		}).addTo(mymap);
		var popup = L.popup();
		var pos = L.GeoIP.getPosition("<?php echo $ipAddress; ?>");
		L.GeoIP.centerMapOnPosition(mymap, 10);

		function onMapClick(e) {
			var zoomLevel = mymap.getZoom();
			if (zoomLevel >= 10)
			{
				popup
					.setLatLng(e.latlng)
					.setContent("<a href=\"http://www.blackdove.org/intelligence/report.php?westLongitude=" + mymap.getBounds().getWest() + "&eastLongitude=" + mymap.getBounds().getEast() + "&southLatitude=" + mymap.getBounds().getSouth() + "&northLatitude=" + mymap.getBounds().getNorth() + "&centerLatitude=" + e.latlng.lat + "&centerLongitude=" + e.latlng.lng + "\" target=\"_blank\">Do you want to report an issue here?</a>")
					.openOn(mymap);
			} else
			{
				popup
					.setLatLng(e.latlng)
					.setContent("Try zooming in further, it's good to be specific.")
					.openOn(mymap);
			}
		}

		mymap.on('click', onMapClick);
		var defaultIcon = L.icon({
			iconUrl: 'http://maps.google.com/mapfiles/kml/shapes/shaded_dot.png',
			iconSize: [20, 20],
		});
		<?php echo $issueJS; ?>
	</script>
	</body>
</html>