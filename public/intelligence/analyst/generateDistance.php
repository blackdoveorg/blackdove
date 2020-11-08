<?php
require('../connect.php');
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
function clean($string) {
   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
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
		$solution = preg_replace("/\r|\n/", "", nl2br(htmlspecialchars($row['solution'])));;
		// echo 'Flesch-Kincaid Reading Level: ' . $textStatistics->fleschKincaidGradeLevel($issue);
		$issueTextList = explode(" ", clean(strtolower($issue)));
		$solutionTextList = explode(" ", clean(strtolower($solution)));
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		$westLongitude = $row['westLongitude'];
		$eastLongitude = $row['eastLongitude'];
		$northLatitude = $row['northLatitude'];
		$southLatitude = $row['southLatitude'];
		$crossDistance = distance($northLatitude, $westLongitude, $southLatitude,$eastLongitude, "K");
		echo "UPDATE `issues` SET `crossDistance` = $crossDistance WHERE `issues`.`id` = $id;";
		// $rellaxSpeed = rand(-5,5);
		// $fkrlSum = ($fkrlI + $fkrlS);
		// $issueHTML .= "<div class=\"seed rellax\" id=\"seed$id\" data-rellax-speed=\"$fkrlSum\"><center><b>Issue $id</b><br/>$issue<br/>($fkrlI)<br/><br/><b>Solution</b><br/>$solution<br/>($fkrlS)<br/>$foundIssueHTML$foundSolutionHTML<br/></center></div>";
		// $issueJS .= "var marker$id = L.marker([$latitude, $longitude], {icon: defaultIcon}).addTo(mymap);";
		// $issueJS .= "marker$id.bindPopup(\"<center><b>Issue $id</b><br/>$issue<br/><br/><b>Solution</b><br/>$solution</center>\");\n";
		// $issueJS .= "latlngs$id = [[$northLatitude,$westLongitude],[$northLatitude,$eastLongitude],[$southLatitude,$eastLongitude],[$southLatitude,$westLongitude]]\n";
		// $issueJS .= "var polygon$id = L.polygon(latlngs$id, {color: 'red'}).addTo(mymap);\n";
		
	}
}
?>
