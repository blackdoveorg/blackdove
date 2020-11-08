<?php

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at https://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: https://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2018                  :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}
/*
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
*/
/**
 * Calculate a new coordinate based on start, distance and bearing
 *
 * @param $start array - start coordinate as decimal lat/lon pair
 * @param $dist  float - distance in kilometers
 * @param $brng  float - bearing in degrees (compass direction)
 */
function geo_destination($start,$dist,$brng){
    $lat1 = toRad($start[0]);
    $lon1 = toRad($start[1]);
    $dist = $dist/6371.01; //Earth's radius in km
    $brng = toRad($brng);
 
    $lat2 = asin( sin($lat1)*cos($dist) +
                  cos($lat1)*sin($dist)*cos($brng) );
    $lon2 = $lon1 + atan2(sin($brng)*sin($dist)*cos($lat1),
                          cos($dist)-sin($lat1)*sin($lat2));
    $lon2 = fmod(($lon2+3*pi()),(2*pi())) - pi();  
 
    return array(toDeg($lat2),toDeg($lon2));
}

function toRad($deg){
    return $deg * pi() / 180;
}

function toDeg($rad){
    return $rad * 180 / pi();
}

if ($_GET['html'])
{
	var_dump($_GET);
}
require('connect.php');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
function clean($string) {
   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

$bbox = explode(",", $_GET['BBOX']);
$bboxNorthLatitude = $bbox[3];
$bboxSouthLatitude = $bbox[1];
$bboxCenterLatitude = ($bboxNorthLatitude + $bboxSouthLatitude)/2;
$bboxWestLongitude = $bbox[0];
$bboxEastLongitude = $bbox[2];
$bboxCenterLongitude = ($bboxWestLongitude + $bboxEastLongitude)/2;

$issueSelect = "SELECT * FROM `socialIssues`;";
$issueResult = $conn->query($issueSelect);
if ($issueResult->num_rows > 0) {
	while($row = $issueResult->fetch_assoc()) {
		if ($row['associatedTerms'] != NULL)
		{
			$socialIssue = $row['issue'];
			$issueList[$socialIssue] = array_filter(explode(",", $row['associatedTerms']));
			$issueColors[$socialIssue] = $row['color'];
			$issueIcons[$socialIssue] = $row['iconURL'];
		}
	}
}
$stateSelect = "SELECT `name`, `stusps`, `statefp` FROM `us_states`";
$stateResult = $conn->query($stateSelect);
if ($stateResult->num_rows > 0)
{
	// output data of each row
	while($row = $stateResult->fetch_assoc())
	{
		foreach ($row as $key => $value)
		{
			$$key = $value;
		}
		$stateData[$statefp]['short'] = $stusps;
		$stateData[$statefp]['long'] = $name;
	}
}
//var_dump($stateData);
$countyData = array();
$issues = array();		
$issueSelect = "SELECT *, X(coordinate) as longitude, Y(coordinate) as latitude FROM `issues` WHERE Y(coordinate) BETWEEN $bboxSouthLatitude AND $bboxNorthLatitude AND X(coordinate) BETWEEN $bboxWestLongitude AND $bboxEastLongitude;";
$issueResult = $conn->query($issueSelect);
if ($issueResult->num_rows > 0)
{
	// output data of each row
	while($issueRow = $issueResult->fetch_assoc())
	{
		foreach ($issueRow as $key => $value)
		{
			$$key = $value;
		}
		if (!array_key_exists($countyfp, $countyData))
		{
			$countySelect = "SELECT `countyfp`, `name` FROM `us_counties` WHERE `statefp` = '$statefp' AND `countyfp` = '$countyfp';";
			//echo $countySelect;
			$countyResult = $conn->query($countySelect);
			if ($countyResult->num_rows > 0)
			{
				// output data of each row
				while($countyRow = $countyResult->fetch_assoc())
				{
					$countyName = $countyRow['name'];
					$countyfp = $countyRow['countyfp'];
					$countyData[$countyfp] = $countyName;
					
				}
			}
		}
		$issues[$stateData[$statefp]['long']][$countyName][] = $issueRow;
	}
}
//var_dump($issues);
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
			<color>b3ffffff</color>
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
			<color>b3ffffff</color>
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
	<Style id="focus_n">
		<IconStyle>
			<color>ff1cceff</color>
			<scale>0.8</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/target.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ffffffff</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<Style id="focus_hl">
		<IconStyle>
			<color>ff1cceff</color>
			<scale>1</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/target.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ffffffff</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<StyleMap id="focus">
		<Pair>
			<key>normal</key>
			<styleUrl>#focus_n</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#focus_hl</styleUrl>
		</Pair>
	</StyleMap>
	<Style id="boundary_n">
		<IconStyle>
			<scale>1.2</scale>
		</IconStyle>
		<LineStyle>
			<color>ff000000</color>
			<width>1</width>
		</LineStyle>
		<PolyStyle>
			<color>40ffffff</color>
		</PolyStyle>
	</Style>
	<Style id="boundary_hl">
		<LineStyle>
			<color>ff000000</color>
			<width>1</width>
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
			<color>ff1133cc</color>
			<scale>0.590909</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/donut.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ffffffff</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
		<LineStyle>
			<color>ff000000</color>
			<width>1</width>
		</LineStyle>
		<PolyStyle>
			<color>40ffffff</color>
		</PolyStyle>
	</Style>
	<Style id="issue_hl">
	<IconStyle>
			<color>ff1133cc</color>
			<scale>0.7</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/donut.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<bgColor>ffffffff</bgColor>
			<text>$[description]</text>
		</BalloonStyle>
		<LabelStyle>
			<scale>0.6</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
		<LineStyle>
			<color>ff1133cc</color>
			<width>1</width>
		</LineStyle>
		<PolyStyle>
			<color>40ffffff</color>
		</PolyStyle>
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
<?php
if ($issueResult->num_rows > 0)
{
	foreach ($issueList as $key => $value)
	{
		$icon = "http://maps.google.com/mapfiles/kml/paddle/wht-stars.png";
		if ($issueIcons[$key] != '')
		{
			$icon = $issueIcons[$key];
		}
		if ($issueColors[$key])
		{
			$issueColor = $issueColors[$key];
		}
		else
		{
			$issueColor = '000000';
		}
		$issueColorTemporary = str_split($issueColor, 2);
		$issueColorLine = $issueColorTemporary[2] . $issueColorTemporary[1] . $issueColorTemporary[0];
		$htmlFriendlyIssueName = strtolower(preg_replace("/\s/", "_", $key));
?>
		<Style id="<?php echo $htmlFriendlyIssueName; ?>_n">
		<IconStyle>
			<color>ffffffff</color>
			<scale>1</scale>
			<Icon>
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
		<LineStyle>
			<color>ff<?php echo $issueColorLine; ?></color>
			<width>1</width>
		</LineStyle>
		<PolyStyle>
			<color>40ffffff</color>
		</PolyStyle>
	</Style>
	<Style id="<?php echo $htmlFriendlyIssueName; ?>_hl">
	<IconStyle>
			<color>ffffffff</color>
			<scale>1.5</scale>
			<Icon>
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
		<LineStyle>
			<color>ff<?php echo $issueColorLine; ?></color>
			<width>1</width>
		</LineStyle>
		<PolyStyle>
			<color>40ffffff</color>
		</PolyStyle>
	</Style>
	<StyleMap id="<?php echo $htmlFriendlyIssueName; ?>">
		<Pair>
			<key>normal</key>
			<styleUrl>#<?php echo $htmlFriendlyIssueName; ?>_n</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#<?php echo $htmlFriendlyIssueName; ?>_hl</styleUrl>
		</Pair>
	</StyleMap>
<?php
	}
}
?>
	<name>Issue Visualization</name>
<?php
?>
	<Folder>
		<name>Utilities</name>
			<Placemark>
				<name>Focus</name>
				<description><![CDATA[<center><?php echo "<iframe src=\"http://www.blackdove.org/intelligence/report.php?westLongitude=$bboxWestLongitude&eastLongitude=$bboxEastLongitude&southLatitude=$bboxSouthLatitude&northLatitude
				=$bboxNorthLatitude&centerLatitude=$bboxCenterLatitude&centerLongitude=$bboxCenterLongitude\" target=\"_blank\" width=\"540px;\" height=\"800px\" style=\"border: 0px; overflow-y: hide !important;\"></iframe>"?><br/><a href="<?php echo $actual_link ; ?>">Share View</a></center>]]></description>
				<styleUrl>#focus</styleUrl>
				<Point>
					<extrude>1</extrude>
					<altitudeMode>relativeToGround</altitudeMode>
					<coordinates><?php echo "$bboxCenterLongitude,$bboxCenterLatitude,150";?></coordinates>
				</Point>
			</Placemark>
			<Placemark>
				<name>Bounding Box</name>
				<styleUrl>#boundary</styleUrl>
				<Polygon>
					<tessellate>1</tessellate>
					<outerBoundaryIs>
						<LinearRing>
							<coordinates>
								<?php echo "$bboxWestLongitude,$bboxNorthLatitude $bboxEastLongitude,$bboxNorthLatitude $bboxEastLongitude,$bboxSouthLatitude $bboxWestLongitude,$bboxSouthLatitude $bboxWestLongitude,$bboxNorthLatitude"; ?>
							</coordinates>
							<description><![CDATA[<?php 
							echo "$actual_link<br/>$boundarySelect<br/>"; 
							//var_dump($data);
							?>]]></description>
						</LinearRing>
					</outerBoundaryIs>
				</Polygon>
			</Placemark>
	</Folder>
	<?php 
	if ($issueResult->num_rows > 0)
	{
	?>
	<Folder>
		<name>Issue Data</name>
	<?php
	
	foreach ($issues as $state => $county)
	{
	?>
		<Folder>
			<name><?php echo $state; ?></name>
	<?php
		foreach ($county as $key => $issue)
		{
	?>
			<Folder>
				<name><?php echo $key; ?> County</name>
	<?php
				foreach ($issue as $i)
				{
					$issuesInText = array();
					$id = $i['id'];
					$datetime = date('c', strtotime($i['datetime']));
					$datetimeReadable = date('r', strtotime($i['datetime']));
					$first = $i['first'];
					$thisIssue = $i['issue'];
					$thisSolution = $i['solution'];
					$issueLatitude = $i['latitude'];
					$issueLongitude = $i['longitude'];
					$westLongitude = $i['westLongitude'];
					$eastLongitude = $i['eastLongitude'];
					$northLatitude = $i['northLatitude'];
					$southLatitude = $i['southLatitude'];
					$textList = explode(" ", clean(strtolower("$thisIssue $thisSolution")));
					
					foreach ($issueList as $issue => $keywords)
					{
						foreach ($keywords as $keyword)
						{
							if (in_array($keyword, $textList))
							{
								$issuesInText[$issue]['count'] += 1;
								$issuesInText[$issue]['data'][] = $i;
							}
						}
					}
	?>
				<Folder>
					<name><?php echo "[ID: " . $i['id'] . "]"; ?></name>
					<Placemark>
						<name><?php echo "[ID: " . $i['id'] . "]"; ?></name>
						<TimeStamp>
							<when><?php echo $datetime; ?></when>
						</TimeStamp>
						<description><![CDATA[<center>
							<iframe src="http://www.blackdove.org/intelligence/issue.php?id=<?php echo $i['id']; ?>" target="_blank" width="540;" height="800px;" style="border: 0px; overflow-y: hide !important;"></iframe>
<?php /*
							<h1 style="padding: 0px; margin: 0px;"><font color="white"><?php echo "[ID: " . $i['id'] . "]"; ?> by <?php echo $first; ?></font></h1>
							<table style="margin: 0px" width='400px'>>
								<tr>
									<td width="50%" style="display: table-cell; height: 100%;">
										<div style="background-color:#BF0A30; padding:10px; display: table;">
											<font size=5 color="#ffffff">Problem</font>
											<br/>
											<font size=4 color="#ffffff"><?php echo $thisIssue; ?></font>
										</div>
									</td>
									<td width="50%" style="display: table-cell; height: 100%;">
										<div style="background-color:#002868; padding:10px; display: table;">
											<font size=5 color="#ffffff">Solution</font>
											<br/>
											<font size=4 color="#ffffff"><?php echo $thisSolution; ?></font>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<center>
											<div style="background-color:#60194C; padding:10px;">
												<font size=5 color="#ffffff">Details</font>
												<br/>
												<font size=4.5 color="#ffffff"><b>Time</b><br/><font size=4 color="#ffffff"><?php echo $datetimeReadable; ?></font><br/>
												<font size=4.5 color="#ffffff"><b>Issues</b><br/><font size=4 color="#ffffff">
												<?php
												//echo $error;
												//var_dump($issueList);
												//var_dump($textList);
												//var_dump($issuesInText);
												if (count($issuesInText) > 0)
												{
													foreach ($issuesInText as $i => $v)
													{
														$issueCount = $v['count'];
														if ($issueColors[$i])
														{
															$issueColor = $issueColors[$i];
														}
														else
														{
															$issueColor = '000000';
														}
														echo "<span style=\"background-color:#$issueColor;\">[$i - $issueCount]</span><br/>";
													}
												}
												//var_dump($issueList);
												?></font>
											</div>
										</center>
									</td>
								</tr>
							</table>
*/?>
						</center></html>]]> </description>
						<styleUrl>#issue</styleUrl>
						<MultiGeometry>	
							<Point>
								<coordinates><?php echo "$issueLongitude,$issueLatitude,0";?></coordinates>
							</Point>
							<Polygon>
								<tessellate>1</tessellate>
								<outerBoundaryIs>
									<LinearRing>
										<coordinates>
											<?php echo "$westLongitude,$northLatitude $eastLongitude,$northLatitude $eastLongitude,$southLatitude $westLongitude,$southLatitude $westLongitude,$northLatitude"; ?>
										</coordinates>
									</LinearRing>
								</outerBoundaryIs>
							</Polygon>
						</MultiGeometry>
					</Placemark>
	<?php
				$counter = 1;
				if (count($issuesInText) > 0)
				{
					foreach ($issuesInText as $key => $value)
					{				
						$altitude = $issuesInText[$key]['count'] * ($counter * 100);
						$iconURL = "http://maps.google.com/mapfiles/kml/paddle/wht-stars.png";
						$htmlFriendlyIssueName = strtolower(preg_replace("/\s/", "_", $key));
		?>
						<Placemark>
							<name><?php echo $key; ?></name>
							<TimeStamp>
								<when><?php echo $datetime; ?></when>
							</TimeStamp>
							<styleUrl>#<?php echo $htmlFriendlyIssueName; ?></styleUrl>
							<Point>
									<extrude>1</extrude>
									<altitudeMode>relativeToGround</altitudeMode>
									<coordinates><?php echo "$issueLongitude,$issueLatitude,$altitude"; ?></coordinates>
							</Point>
						</Placemark>
		<?php
					$counter++;
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
		</Folder>

<?php 	
}
?>
	</Folder>
<?php
/* ?>
	<Folder>
		<name>Heatmap Data</name>
<?php
		
		foreach ($issuesInText as $key => $value)
		{
			//var_dump($d);
?>
		<Folder>
			<name><?php echo $key; ?></name>
			<Folder>
				<name><?php echo $key; ?> Heatmap Grid</name>
				<?php
				if (isset($_GET['gridCount']))
				{
					$gridCount = $_GET['gridCount'];
				}
				else
				{
					$gridCount = 10;
				}
				$grid['size']['longitude'] = ($bboxEastLongitude - $bboxWestLongitude)/$gridCount;
				$grid['size']['latitude'] = ($bboxNorthLatitude - $bboxSouthLatitude)/$gridCount;
				if (isset($_GET['gridSize']))
				{
					$grid['size']['use'] = $_GET['gridSize'];
				}
				else
				{
					
					if ($grid['size']['longitude'] < $grid['size']['latitude'])
					{
						$grid['size']['use'] = $grid['size']['longitude'];
					}
					else
					{
						$grid['size']['use'] = $grid['size']['latitude'];
					}
				}
				for ($i = 0; $i < $gridCount; $i++)
				{
					
					for ($j = 0; $j < $gridCount; $j++)
					{
						if (isset($_GET['gridSize']))
						{
							$gridNorthLatitude = $bboxNorthLatitude - ($grid['size']['use'] * $i);
							$gridSouthLatitude = $gridNorthLatitude - $grid['size']['use'];
							$gridWestLongitude = $bboxWestLongitude + ($grid['size']['use'] * $j);
							$gridEastLongitude = $gridWestLongitude + $grid['size']['use'];
						}
						else
						{
							$gridNorthLatitude = $bboxNorthLatitude - ($grid['size']['latitude'] * $i);
							$gridSouthLatitude = $gridNorthLatitude - $grid['size']['latitude'];
							$gridWestLongitude = $bboxWestLongitude + ($grid['size']['longitude'] * $j);
							$gridEastLongitude = $gridWestLongitude + $grid['size']['longitude'];
						}
						//var_dump($d);
							//var_dump($k);
						$gridAltitude = 0;
						foreach ($value['data'] as $d)
						{
							if (($d['latitude'] >= $gridSouthLatitude) & ($d['latitude'] <= $gridNorthLatitude) & ($d['longitude'] >= $gridWestLongitude) & ($d['longitude'] <= $gridEastLongitude))
							{
								$gridAltitude++;
							}
							
						}
						$gridAltitude = $gridAltitude * 1000;
						
				?>
					<Placemark>
						<name><?php echo "$i, $j"; ?></name>
						<description><![CDATA[
						<html style="background-color:#2a2a2a;">
							<h1 style="padding: 0px; margin: 0px;"><font color="white"><?php echo $grid['size']['use']; ?> Heatmap</font></h1>
						</html>]]></description>
						<styleUrl>#issue</styleUrl>
						<MultiGeometry>	
							<extrude>1</extrude>
							<altitudeMode>relativeToGround</altitudeMode>
							<Polygon>
								<extrude>1</extrude>
								<tessellate>1</tessellate>
								<altitudeMode>relativeToGround</altitudeMode>
								<outerBoundaryIs>
									<LinearRing>
										<coordinates>
											<?php echo "$gridWestLongitude,$gridNorthLatitude,$gridAltitude $gridEastLongitude,$gridNorthLatitude,$gridAltitude $gridEastLongitude,$gridSouthLatitude,$gridAltitude $gridWestLongitude,$gridSouthLatitude,$gridAltitude $gridWestLongitude,$gridNorthLatitude,$gridAltitude"; ?>
										</coordinates>
									</LinearRing>
								</outerBoundaryIs>
							</Polygon>
						</MultiGeometry>
					</Placemark>	
					<?php
					}
				}
				?>
			</Folder>
		</Folder>
		
<?php
		}		
?>
	</Folder>
	<?php  
	*/	
}
	?>
	<Folder>
		<name>Attribution</name>
		<description><![CDATA[<div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>]]></description>
	</Folder>
<?php

?>

</Document>
</kml>