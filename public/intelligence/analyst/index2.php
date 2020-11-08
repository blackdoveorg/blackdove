<?php
require('../connect.php');
foreach (glob("DaveChild/TextStatistics/*.php") as $filename)
{
    include $filename;
}
use DaveChild\TextStatistics as TS;
$textStatistics = new TS\TextStatistics;
$psCombo = array();
function clean($string) {
   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
function map($value, $fromLow, $fromHigh, $toLow, $toHigh) {
    $fromRange = $fromHigh - $fromLow;
    $toRange = $toHigh - $toLow;
    $scaleFactor = $toRange / $fromRange;

    // Re-zero the value within the from range
    $tmpValue = $value - $fromLow;
    // Rescale the value to the to range
    $tmpValue *= $scaleFactor;
    // Re-zero back to the to range
    return $tmpValue + $toLow;
}
$socialIssueSelect = "SELECT * FROM `socialIssues`;";
$socialIssueResult = $conn->query($socialIssueSelect);
if ($socialIssueResult->num_rows > 0) {
	while($row = $socialIssueResult->fetch_assoc()) {
		$socialIssue = $row['issue'];
		$issueList[$socialIssue] = array_filter(explode(",", strtoupper($row['associatedTerms'])));
		$issueColors[$socialIssue] = $row['color'];
		$issueIcons[$socialIssue] = $row['iconURL'];
	}
}
$socialSolutionSelect = "SELECT * FROM `socialSolutions`;";
$socialSolutionResult = $conn->query($socialSolutionSelect);
if ($socialSolutionResult->num_rows > 0) {
	while($row = $socialSolutionResult->fetch_assoc()) {
		$socialSolution = $row['solution'];
		$solutionList[$socialSolution] = array_filter(explode(",", strtoupper($row['associatedTerms'])));
		$issueColors[$socialSolution] = $row['color'];
		$issueIcons[$socialSolution] = $row['iconURL'];
	}
}
$issueSelect = "SELECT *, X(coordinate) as longitude, Y(coordinate) as latitude FROM `issues` ORDER BY `datetime` DESC LIMIT 1000;";
$issueResult = $conn->query($issueSelect);
if ($issueResult->num_rows > 0) {
	$issueHTML = '';
	while($row = $issueResult->fetch_assoc()) {
		$issuesInText = array();
		$solutionsInText = array();
		$foundIssueHTML = '';
		$foundSolutionHTML = '';
		$id = $row['id'];
		$issue = preg_replace("/\r|\n/", "", nl2br(htmlspecialchars($row['issue'])));
		$solution = preg_replace("/\r|\n/", "", nl2br(htmlspecialchars($row['solution'])));
		$fkreI = $textStatistics->fleschKincaidReadingEase($issue);
		$fkreS = $textStatistics->fleschKincaidReadingEase($solution);
		// echo 'Flesch-Kincaid Reading Level: ' . $textStatistics->fleschKincaidGradeLevel($issue);
		$issueTextList = explode(" ", clean(strtolower($issue)));
		$solutionTextList = explode(" ", clean(strtolower($solution)));
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		$westLongitude = $row['westLongitude'];
		$eastLongitude = $row['eastLongitude'];
		$northLatitude = $row['northLatitude'];
		$southLatitude = $row['southLatitude'];
		$crossDistance = $row['crossDistance'];
		$email = $row['email'];
		foreach ($issueList as $socialIssue => $keywords)
		{
			
			foreach ($keywords as $keyword)
			{
				if (strpos(strtoupper($issue), $keyword) !== false)
				{
					$issuesInText[$socialIssue]['count'] += 1;
				}
			}
		}
		if (count($issuesInText) > 0)
		{
			$issueCount = count($issuesInText);
			foreach ($issuesInText as $key => $value)
			{
				if ($foundIssueHTML == '')
				{
					$foundIssueHTML .= "<b>Issues Identified</b><br/>";
				}
					$foundIssueHTML .= "$key<br/>";
			}
		}
		
		foreach ($solutionList as $socialSolution => $keywords)
		{
			
			foreach ($keywords as $keyword)
			{
				if (strpos(strtoupper($solution), $keyword) !== false)
				{
					$solutionsInText[$socialSolution]['count'] += 1;
				}
			}
		}
		if (count($solutionsInText) > 0)
		{
			$solutionCount = count($solutionsInText);
			foreach ($solutionsInText as $key => $value)
			{
				if ($foundSolutionHTML == '')
				{
					$foundSolutionHTML .= "<b>Solutions Identified</b><br/>";
				}
					$foundSolutionHTML .= "$key<br/>";
			}
		}
		if (count($issuesInText) > 0)
		{
			if (count($solutionsInText) > 0)
			{
				foreach ($issuesInText as $iKey => $iValue)
				{
					foreach ($solutionsInText as $sKey => $sValue)
					{
						$psCombo["$iKey"]["$sKey"]['count'] += 1;
					}
				}
			}
		}
		$rellaxSpeed = rand(-5,5);
		/*if ($crossDistance <= 5)
		{
			$distanceBonus = .25;
		} if ($crossDistance > 5 && $crossDistance <= 20)
		{
			$distanceBonus = .75;
		} if ($crossDistance > 20 && $crossDistance < 50)
		{
			$distanceBonus = 1;
		} if ($crossDistance > 100)
		{
			$distanceBonus = 2;
		}
		if ($issuesInText > 1 && $solutionsInText > 1)
		{
			$issueBonus = .5;
		}
		else if ($issuesInText > 1 && $solutionsInText == 0)
		{
			$issueBonus = .75;
		} 
		else if ($solutionsInText > 1 && $issuesInText == 0)
		{
			$issueBonus = .75;
		}
		if ($fkreI != '')
		{
			if ($fkreS != '')
			{
				$fkreUse = ($fkreI+$fkreS);
			} else
			{
				$fkreUse = $fkreI + $fkreI;
			}
		} 
		else
		{
			$fkreUse = 10000;
		}
		
		$fkreUse = $actionable * $distanceBonus * $issueBonus * $fkreUse;
		if ($crossDistance <= 2)
		{
			if ($fkreUse < 200)
			{
				$actionable = .1;
			}
		}
		else
		{
			$actionable = 1;
		}
		$fkreUse = $actionable * $fkreUse;
		if ($fkreUse <= 200)
		{
			$qualityClass = 'goodSeed';
		}
		else
		{
			$qualityClass = "badSeed";
		}
		if ($actionable < 1)
		{
			$actionableText = "<b>Actionable</b><br/>";
		} else
		{
			$actionableText = '';
		}
		if ($email != '')
		{
			$hasEmailText = "<br/>Has Email";
		}
		else
		{
			$hasEmailText = '';
		}
		$issueSum = ($issueCount + $solutionCount);
		$issueHTML .= "<div class=\"seed rellax $qualityClass\" id=\"seed$id\" data-rellax-speed=\"$fkreUse\"><center><b>Issue $id</b><br/>$issue ($fkreI)<br/><br/><b>Solution</b><br/>$solution ($fkreS)<br/>$foundIssueHTML$foundSolutionHTML<br/>$actionableText <b>Data</b><br/>Cross Distance: $crossDistance KM<br/>Issue Bonus: $issueBonus<br/>Distance Bonus: $distanceBonus</br>Use: $fkreUse $hasEmailText</center></div>"; */
		$fkreMin = 100;
		$fkreMax = 0;	
		$fkreWeight = 200 - (200 - ($fkreI + $fkreS));
		$rellaxValue = $fkreWeight;
		
		$issueHTML .= "<div class=\"seed rellax\" id=\"seed$id\" data-rellax-speed=\"$rellaxValue\" fkreWeight=\"$fkreWeight\"><center><b>Issue $id</b><br/>$issue ($fkreI)<br/><br/><b>Solution</b><br/>$solution ($fkreS)<br/>$foundIssueHTML$foundSolutionHTML<br/>$actionableText <b>Data</b><br/>Cross Distance: $crossDistance KM<br/>FKRE: $fkreWeight<br/></center></div>";
		$issueJS .= "var marker$id = L.marker([$latitude, $longitude], {icon: defaultIcon}).addTo(mymap);";
		$issueJS .= "marker$id.bindPopup(\"<center><b>Issue $id</b><br/>$issue<br/><br/><b>Solution</b><br/>$solution</center>\");\n";
		$issueJS .= "latlngs$id = [[$northLatitude,$westLongitude],[$northLatitude,$eastLongitude],[$southLatitude,$eastLongitude],[$southLatitude,$westLongitude]]\n";
		$issueJS .= "var polygon$id = L.polygon(latlngs$id, {color: 'red'}).addTo(mymap);\n";
	}
}
//echo "<pre>";
//var_dump($psCombo);
//echo "</pre>";
$chordJS = '';
foreach ($psCombo as $iKey => $iValue)
{
	foreach ($iValue as $sKey => $sValue)
	{
		$chordCount = $sValue['count'];
		$chordJS .= "{\"from\":\"$iKey\",\"to\":\"$sKey\",\"value\":$chordCount},\n";
	}
}
?>
<html>
	<header>
	<?php require("http://www.blackdove.org/css.php"); ?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="crossorigin=""/>
	<style>
	html
	{
		width: 100% !important;
		margin: 0px !important;
	}
	.content
	{
		width: 100% !important;
	}
	.leaflet-tooltip{
		width: 100px;
		white-space: normal;
	}
	#mapid
	{
		width: 100%;
		height: 480px;
	}
	.title
	{
		font-size: 96px;
	}
	.top
	{
		vertical-align: middle;
	}
	#container 
	{
		text-align: justify;
		-ms-text-justify: distribute-all-lines;
		text-justify: distribute-all-lines;
		margin-left: 10%;
		margin-right: 10%;
	}
	.seed
	{
		border: 1px solid black;
		float:left;
		width: 200px;
		margin: 5px;
		display: block;
	}
	#chartdiv {
		width: 100%;
		height: 800px;
	}
	.goodSeed
	{
		background-color: #00FF00;
	}
	.badSeed
	{
		background-color: #FF0000;
	}

	</style>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="crossorigin=""></script>
	<script src="http://www.blackdove.org/intelligence/leaflet/leaflet-geoip.js"></script>
	<script src="http://www.blackdove.org/intelligence/analyst/rellax/rellax.min.js"></script>
	<script src="https://www.amcharts.com/lib/4/core.js"></script>
	<script src="https://www.amcharts.com/lib/4/charts.js"></script>
	<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script>
		am4core.ready(function() {

		// Themes begin
		am4core.useTheme(am4themes_animated);
		// Themes end

		var chart = am4core.create("chartdiv", am4charts.ChordDiagram);

		// colors of main characters
		chart.colors.saturation = 0.45;
		chart.colors.step = 3;
		var colors = {
			Rachel:chart.colors.next(),
			Monica:chart.colors.next(),
			Phoebe:chart.colors.next(),
			Ross:chart.colors.next(),
			Joey:chart.colors.next(),
			Chandler:chart.colors.next()
		}

		// data was provided by: https://www.reddit.com/user/notrudedude

		chart.data = [
		// node property fields take data from data items where they are first mentioned, that's 
		// why we add empty data items at the beginning and set colors here

		// real data
		<?php echo $chordJS; ?>]



		chart.dataFields.fromName = "from";
		chart.dataFields.toName = "to";
		chart.dataFields.value = "value";


		chart.nodePadding = 0.5;
		chart.minNodeSize = 0.01;
		chart.startAngle = 80;
		chart.endAngle = chart.startAngle + 360;
		chart.sortBy = "value";
		chart.fontSize = 10;

		var nodeTemplate = chart.nodes.template;
		nodeTemplate.readerTitle = "Click to show/hide or drag to rearrange";
		nodeTemplate.showSystemTooltip = true;
		nodeTemplate.propertyFields.fill = "color";
		nodeTemplate.tooltipText = "{name} Hits: {total}";

		// when rolled over the node, make all the links rolled-over
		nodeTemplate.events.on("over", function(event) {    
			var node = event.target;
			node.outgoingDataItems.each(function(dataItem) {
				if(dataItem.toNode){
					dataItem.link.isHover = true;
					dataItem.toNode.label.isHover = true;
				}
			})
			node.incomingDataItems.each(function(dataItem) {
				if(dataItem.fromNode){
					dataItem.link.isHover = true;
					dataItem.fromNode.label.isHover = true;
				}
			}) 

			node.label.isHover = true;   
		})

		// when rolled out from the node, make all the links rolled-out
		nodeTemplate.events.on("out", function(event) {
			var node = event.target;
			node.outgoingDataItems.each(function(dataItem) {        
				if(dataItem.toNode){
					dataItem.link.isHover = false;                
					dataItem.toNode.label.isHover = false;
				}
			})
			node.incomingDataItems.each(function(dataItem) {
				if(dataItem.fromNode){
					dataItem.link.isHover = false;
				   dataItem.fromNode.label.isHover = false;
				}
			})

			node.label.isHover = false;
		})

		var label = nodeTemplate.label;
		label.relativeRotation = 90;

		label.fillOpacity = 0.4;
		let labelHS = label.states.create("hover");
		labelHS.properties.fillOpacity = 1;

		nodeTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer;
		// this adapter makes non-main character nodes to be filled with color of the main character which he/she kissed most
		nodeTemplate.adapter.add("fill", function(fill, target) {
			let node = target;
			let counters = {};
			let mainChar = false;
			node.incomingDataItems.each(function(dataItem) {
				if(colors[dataItem.toName]){
					mainChar = true;
				}

				if(isNaN(counters[dataItem.fromName])){
					counters[dataItem.fromName] = dataItem.value;
				}
				else{
					counters[dataItem.fromName] += dataItem.value;
				}
			})
			if(mainChar){
				return fill;
			}

			let count = 0;
			let color;
			let biggest = 0;
			let biggestName;

			for(var name in counters){
				if(counters[name] > biggest){
					biggestName = name;
					biggest = counters[name]; 
				}        
			}
			if(colors[biggestName]){
				fill = colors[biggestName];
			}
		  
			return fill;
		})

		// link template
		var linkTemplate = chart.links.template;
		linkTemplate.strokeOpacity = 0;
		linkTemplate.fillOpacity = 0.15;
		linkTemplate.tooltipText = "{fromName} & {toName}:{value.value}";

		var hoverState = linkTemplate.states.create("hover");
		hoverState.properties.fillOpacity = 0.7;
		hoverState.properties.strokeOpacity = 0.7;

		// data credit label
		var creditLabel = chart.chartContainer.createChild(am4core.TextLink);
		creditLabel.text = "Data source: Black Dove";
		creditLabel.url = "https://www.reddit.com/r/blackdove";
		creditLabel.y = am4core.percent(99);
		creditLabel.x = am4core.percent(99);
		creditLabel.horizontalCenter = "right";
		creditLabel.verticalCenter = "bottom";

		var titleImage = chart.chartContainer.createChild(am4core.Image);
		titleImage.x = 30
		titleImage.y = 30;
		titleImage.width = 200;
		titleImage.height = 200;

		}); // end am4core.ready()
	</script>
	</header>
	<body>
		<center>
		<div class="content">
			<div class="top"><img src="http://www.blackdove.org/blackdove.svg" style="width: 96px; margin-bottom: -16px;"/><span class="title">BLACK DOVE</span></div>
			<h2>Analyst</h2>
			<div id="mapid"></div>
			<div id="chartdiv"></div>
			<div id="container">
						<?php echo $issueHTML; ?>
			<center>
			</center>
			</div>
			
			<!--http://www.blackdove.org/intelligence/Issue Visualization.kmz-->
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>
		</div>
		<script>
		function mapValue(value, fromLow, fromHigh, toLow, toHigh) {
			var fromRange = fromHigh - fromLow;
			var toRange = toHigh - toLow;
			var scaleFactor = toRange / fromRange;

			// Re-zero the value within the from range
			var tmpValue = value - fromLow;
			// Rescale the value to the to range
			var tmpValue = tmpValue * scaleFactor;
			// Re-zero back to the to range
			return tmpValue + toLow;
		}
		var ids = $(".seed[fkreWeight]").map(function() {
			return $(this).attr("fkreWeight");
		}).get();

		var highest = Math.max.apply( Math, ids );
		var lowest = Math.min.apply( Math, ids );
		

		// Loop through each .seed 
		$( ".seed" ).each(function() {
			var rellaxSpeed = $(this).attr("fkreWeight");
			$(this).attr('rellax-speed', mapValue(rellaxSpeed, lowest, highest, 0, 4));
		});
		// alert(highest);
		// alert(lowest);
		
		// var result = $('#container div').sort(function (a, b) {
			// var contentA = parseInt( $(a).data('rellax-speed'));
			// var contentB = parseInt( $(b).data('rellax-speed'));
			// return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
		// });
	
		// $('#container').html(result);
		// $(document).ready(function() {
			// var rellax = new Rellax('.rellax');
		// });
		var mymap = L.map('mapid', {
			zoomSnap: 1
		}).setView([0, 0], 2);

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