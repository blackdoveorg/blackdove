<?php
require('connect.php');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
function clean($string) {
   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

$bbox = explode(",", $_GET['BBOX']);
$northLatitude = $bbox[3];
$southLatitude = $bbox[1];
$centerLatitude = ($northLatitude + $southLatitude)/2;
$westLongitude = $bbox[0];
$eastLongitude = $bbox[2];
$centerLongitude = ($westLongitude + $eastLongitude)/2;

$issueSelect = "SELECT * FROM `socialIssues`;";
$issueResult = $conn->query($issueSelect);
if ($issueResult->num_rows > 0) {
	while($row = $issueResult->fetch_assoc()) {
		if ($row['associatedTerms'] != NULL)
		{
			$socialIssue = $row['issue'];
			$issueList[$socialIssue] = array_filter(explode(",", $row['associatedTerms']));
			$issueColors[$socialIssue] = $row['color'];
		}
	}
}

$boundarySelect = "SELECT * FROM `zip` WHERE `latitude` BETWEEN $southLatitude AND $northLatitude AND `longitude` BETWEEN $westLongitude AND $eastLongitude LIMIT 100;";
$boundaryResult = $conn->query($boundarySelect);
if ($boundaryResult->num_rows > 0) {
	// output data of each row
	while($row = $boundaryResult->fetch_assoc()) {
		$data[$row['state']][$row['zip']]['city'] = $row['city'];
		$data[$row['state']][$row['zip']]['latitude'] = $row['latitude'];
		$data[$row['state']][$row['zip']]['longitude'] = $row['longitude'];
	}
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
	<Style id="zip_n">
		<IconStyle>
			<color>8000aaff</color>
			<scale>0.7</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/donut.png</href>
			</Icon>
		</IconStyle>
		<LabelStyle>
			<scale>0.7</scale>
		</LabelStyle>
		<BalloonStyle>
			<bgColor>ff4C1960</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<ListStyle>
		</ListStyle>
		<LineStyle>
			<color>b3f5f5f5</color>
		</LineStyle>
	</Style>
	<Style id="zip_hl">
		<IconStyle>
			<color>8000aaff</color>
			<scale>0.7</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/donut.png</href>
			</Icon>
		</IconStyle>
		<LabelStyle>
			<scale>0.7</scale>
		</LabelStyle>
		<BalloonStyle>
			<bgColor>ff4C1960</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<ListStyle>
		</ListStyle>
		<LineStyle>
			<color>b3f5f5f5</color>
		</LineStyle>
	</Style>
	<StyleMap id="zip">
		<Pair>
			<key>normal</key>
			<styleUrl>#zip_n</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#zip_hl</styleUrl>
		</Pair>
	</StyleMap>
	<Style id="bullseye_n">
		<IconStyle>
			<color>ff4C1960</color>
			<scale>0.8</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/target.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ff4C1960</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<Style id="bullseye_hl">
		<IconStyle>
			<color>ff4C1960</color>
			<scale>1</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/target.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ff4C1960</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<StyleMap id="bullseye">
		<Pair>
			<key>normal</key>
			<styleUrl>#bullseye_n</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#bullseye_hl</styleUrl>
		</Pair>
	</StyleMap>
	<Style id="boundary_n">
		<IconStyle>
			<scale>1.2</scale>
		</IconStyle>
		<LineStyle>
			<color>ff000000</color>
			<width>3</width>
		</LineStyle>
		<PolyStyle>
			<color>40ffffff</color>
		</PolyStyle>
	</Style>
	<Style id="boundary_hl">
		<LineStyle>
			<color>ff000000</color>
			<width>3</width>
		</LineStyle>
		<PolyStyle>
			<color>40ffffff</color>
		</PolyStyle>
	</Style>
	<StyleMap id="boundary">
		<Pair>
			<key>normal</key>
			<styleUrl>#boundary_n</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#boundary_hl</styleUrl>
		</Pair>
	</StyleMap>
	<Style id="issue_n">
		<IconStyle>
			<color>bfff5500</color>
			<scale>0.590909</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/triangle.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ff2a2a2a</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<Style id="issue_hl">
	<IconStyle>
			<color>bfff5500</color>
			<scale>0.5</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/triangle.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ff2a2a2a</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<StyleMap id="issue">
		<Pair>
			<key>normal</key>
			<styleUrl>#issue_n</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#issue_hl</styleUrl>
		</Pair>
	</StyleMap>
	<name>Issue Visualization</name>
<?php
?>
	<Placemark>
		<name>Bounding Box</name>
		<styleUrl>#boundary</styleUrl>
		<Polygon>
			<tessellate>1</tessellate>
			<outerBoundaryIs>
				<LinearRing>
					<coordinates>
						<?php echo "$westLongitude,$northLatitude $eastLongitude,$northLatitude $eastLongitude,$southLatitude $westLongitude,$southLatitude $westLongitude,$northLatitude"; ?>
					</coordinates>
					<description><![CDATA[<?php 
					echo "$actual_link<br/>$boundarySelect<br/>"; 
					//var_dump($data);
					?>]]></description>
				</LinearRing>
			</outerBoundaryIs>
		</Polygon>
	</Placemark>
	<Folder>
		<name>Utilities</name>
			<Placemark>
				<name>Bullseye</name>
				<description><![CDATA[<center><?php echo "<a href=\"http://markciubal.com/civics/report.php?westLongitude=$westLongitude&eastLongitude=$eastLongitude&southLatitude=$southLatitude&northLatitude
				=$northLatitude&centerLatitude=$centerLatitude&centerLongitude=$centerLongitude\" target=\"_blank\">Report an issue here.</a>"?><br/><a href="<?php echo $actual_link ; ?>">Share View</a></center>]]></description>
				<styleUrl>#bullseye</styleUrl>
				<Point>
					<extrude>1</extrude>
					<altitudeMode>relativeToGround</altitudeMode>
					<coordinates><?php echo "$centerLongitude,$centerLatitude,150";?></coordinates>
				</Point>
			</Placemark>
	</Folder>
<?php
foreach ($data as $key => $state)
{
?>
	<Folder>
		<name><?php echo $key; ?></name>
<?php
	foreach ($state as $zip => $value)
	{
		$city = $value['city'];
		$latitude = $value['latitude'];
		$longitude = $value['longitude'];
?>
		<Folder>
			<name><?php echo "$city, $key ($zip)"; ?></name>
<?php
?>
			<Placemark>
				<name><?php echo "$city, $key ($zip)"; ?></name>
				<description><![CDATA[<?php //echo $boundarySelect; ?>]]></description>
				<styleUrl>#zip</styleUrl>
				<Point>
					<extrude>1</extrude>
					<altitudeMode>relativeToGround</altitudeMode>
					<coordinates><?php echo "$longitude, $latitude,500";?></coordinates>
				</Point>
			</Placemark>
<?php 
$issueSelect = "SELECT * FROM `issues` WHERE `latitude` BETWEEN $southLatitude AND $northLatitude AND `longitude` BETWEEN $westLongitude AND $eastLongitude;";
echo $issueSelect;
$issueResult = $conn->query($issueSelect);
	if ($issueResult->num_rows > 0) {
		// output data of each row
		$issuesInText = array();
		while($row = $issueResult->fetch_assoc()) {
			$id = $row['id'];
			$datetime = date('c', strtotime($row['datetime']));
			$datetimeReadable = date('r', strtotime($row['datetime']));;
			$first = $row['first'];
			$thisIssue = $row['issue'];
			$thisSolution = $row['solution'];
			$issueLatitude = $row['latitude'];
			$issueLongitude = $row['longitude'];
			$textList = array_filter(explode(" ", clean(strtolower("$thisIssue $thisSolution"))));
			
			foreach ($issueList as $issue => $keywords)
			{
				foreach ($keywords as $keyword)
				{
					if (in_array($keyword, $textList))
					{
						$issuesInText[$issue] += 1;
					}
				}
			}
?>
				<Folder>
					<name>Issues in <?php echo "$city, $key ($zip)"; ?></name>
					<Placemark>
						<name><?php echo "[ID: $id] $first"; ?> says...</name>
						<TimeStamp>
							<when><?php echo $datetime; ?></when>
						</TimeStamp>
						<description><![CDATA[
						<html style="background-color:#2a2a2a">
							<div style="background-color:#BF0A30; padding:10px; border='1px solid black'">
								<font size=5 color="#ffffff">Problem</font>
								<br/>
								<font size=4 color="#f5f5f5"><?php echo $thisIssue; ?></font>
							</div>
							<div style="background-color:#002868; padding:10px;">
								<font size=5 color="#ffffff">Solution</font>
								<br/>
								<font size=4 color="#f5f5f5"><?php echo $thisSolution; ?></font>
							</div>
							<div style="background-color:#60194C; padding:10px;">
								<font size=5 color="#ffffff">Details</font>
								<br/>
								<font size=4.5 color="#f5f5f5"><b>Time</b><br/><font size=4 color="#f5f5f5"><?php echo $datetimeReadable; ?></font><br/>
								<font size=4.5 color="#f5f5f5"><b>Issues</b><br/><font size=4 color="#f5f5f5">
								<?php
								//echo $error;
								//var_dump($issueList);
								//var_dump($textList);
								//var_dump($issuesInText);
								foreach ($issuesInText as $i => $v)
								{
									if ($issueColors[$i])
									{
										$issueColor = $issueColors[$i];
									}
									else
									{
										$issueColor = '000000';
									}
									echo "<span style=\"background-color:#$issueColor;\">[$i - $v]</span><br/>";
								}
								//var_dump($issueList);
								?></font>
							</div>
						</html>]]></description>
						<styleUrl>#issue</styleUrl>
						<Point>
							<coordinates><?php echo "$issueLongitude, $issueLatitude,0";?></coordinates>
						</Point>
					</Placemark>
				</Folder>
<?php 
		}
	}
?>
		</Folder>
<?php
	}
?>
	</Folder>
<?php
}
?>
</Document>
</kml>