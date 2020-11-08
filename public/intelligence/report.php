<?php
require('connect.php');
foreach ($_GET as $key => $value)
{
	$$key = $value;
	//echo "$key => $value<br/>";
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
$hiddenFields = array("centerLatitude", "centerLongitude", "eastLongitude", "westLongitude", "northLatitude", "southLatitude", "refer");
?>
<html style="padding: 10px; overflow-y: auto ! important; ">
	<header>
	<?php require($_SERVER['DOCUMENT_ROOT'] . "/css.php"); ?>
	<script src="https://www.google.com/recaptcha/api.js?render=6LdxEfMUAAAAAD11hWSwjsIyoiZ4_BQxHjC6ItNA"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script>
		function toggle(className, obj) {
			var $input = $(obj);
			var returnVal = confirm("Are you sure?");
			// aleqrt(returnVal);
			$(this).attr("checked", returnVal);
			if ($input.prop('checked')) $(className).show();
			else $(className).show();
		}
	</script>
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
				<input name="first" class="form-control" placeholder="(Public, Optional) How do you want your name displayed?"/><br/>
				<input name="email" class="form-control" placeholder="(Private, Optional) Email address? We might contact you to organize."/><br/>
				<textarea name="issue" class="form-control" rows="2" maxlength="255" minlength="10" placeholder="(Public, Required) In a few words, what is the issue in this area?" required></textarea><br/>
				<textarea name="solution" class="form-control" rows="2" maxlength="255" minlength="10" placeholder="(Public, Optional) In a few words, how do you think we can solve this problem?"></textarea><br/>
				<p><b>If you are concerned about privacy but you want to contribute, do not include your name or email address.</b></p>
				<p><input type="checkbox" id="confirm" onclick="toggle('#submit', this)"/>I want this data made public.</p>
				<button type="submit" class="form-control" id="submit" hidden=true>Submit</button>
			</form>
		<script>

		// $(document).ready(function() {
			// $('#confirm').change(function() {
				// if($(this).is(":checked")) {
					// var returnVal = confirm("Are you sure?");
					// $(this).attr("checked", returnVal);
				// }
				// $('#confirm').val($(this).is(':checked'));
				// $('#submit').removeAttr("hidden");				
			// });
		// });
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