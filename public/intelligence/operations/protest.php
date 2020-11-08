<?php
require('../connect.php');
foreach ($_GET as $key => $value)
{
	$$key = $value;
	//echo "$key => $value<br/>";
}
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
$stateSelect = "SELECT `name`, `stusps`, `statefp`  FROM `us_states` WHERE ST_CONTAINS(`us_states`.`SHAPE`, POINT($centerLongitude, $centerLatitude))";
//echo $stateSelect;
$stateResult = $conn->query($stateSelect);
if ($stateResult->num_rows > 0) {
	while($row = $stateResult->fetch_assoc()) {
		//var_dump($row);
		$state = $row['name'];
		$statefp = $row['statefp'];
		$countySelect = "SELECT `namelsad`, `countyfp`, `statefp` FROM `us_counties` WHERE `statefp` = $statefp AND ST_CONTAINS(`us_counties`.`SHAPE`, POINT($centerLongitude, $centerLatitude))";
		$countyResult = $conn->query($countySelect);
		if ($countyResult->num_rows > 0) {
			while($countyRow = $countyResult->fetch_assoc()) {
				//var_dump($countyRow);
				$countyfp = $countyRow['countyfp'];
				$county = $countyRow['namelsad'];
			}
		}
	}
}
$hiddenFields = array("centerLatitude", "centerLongitude", "eastLongitude", "westLongitude", "northLatitude", "southLatitude");
?>
<html style="padding: 10px; overflow-y: auto ! important; ">
	<header>
	<?php require($_SERVER['DOCUMENT_ROOT'] . "/css.php"); ?>
	<script src="https://www.google.com/recaptcha/api.js?render=6LdxEfMUAAAAAD11hWSwjsIyoiZ4_BQxHjC6ItNA"></script>
	</header>
	<body>
		<center>
		<div class="content">
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/header.php"); ?>
			<h2>Report an Issue</h2>
			<p>By providing a short description of the problem, and solution to that problem, we can start gathering metrics on how people want to solve problems in their communities. Please fill out the form below.<p>
			<form id="issue" name="issue" action="submit.php" method="post">
				<?php
				foreach ($_GET as $key => $value)
				{
					if (in_array($key, $hiddenFields))
					{
						$inputHtml = "<input name=\"$key\" value=\"$value\" type=\"hidden\"></input>";
					}
					else
					{
						$inputHtml = "<input name=\"$key\" value=\"$value\"></input><br/>";
					}
					echo $inputHtml;
				}
				?>					
				<div class="form-group">
					<input name="statefp" type="hidden" value="<?php echo $statefp; ?>"/>
				</div>
				<div class="form-group">
					<input name="countyfp" type="hidden" value="<?php echo $countyfp; ?>"/>
				</div>
				<input name="g-recaptcha-response" id="g-recaptcha-response" type="hidden">
				<input name="first" class="form-control" placeholder="(Public, Optional) What's your name?"/><br/>
				<input name="email" class="form-control" placeholder="(Private, Optional) Email address?"/><br/>
				<textarea name="issue" class="form-control" rows="2" maxlength="255" placeholder="(Public, Required) What is the issue in this area?" required></textarea><br/>
				<textarea name="solution" class="form-control" rows="2" maxlength="255" placeholder="(Public, Optional) How do you think we can solve this problem?"></textarea><br/>
				<button type="submit" class="form-control">Submit</button>
			</form>
		<script>
		grecaptcha.ready(function() {
			grecaptcha.execute('6LdxEfMUAAAAAD11hWSwjsIyoiZ4_BQxHjC6ItNA', {action: 'action_name'}).then(function(token) {
				console.log(token);
				document.getElementById('g-recaptcha-response').value = token;
			});
		});
		</script>
		</div>
	</body>
</html>