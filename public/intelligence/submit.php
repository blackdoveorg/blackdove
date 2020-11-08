<?php
define('SITE_KEY', '6LdxEfMUAAAAAD11hWSwjsIyoiZ4_BQxHjC6ItNA');
define('SECRET_KEY', '6LdxEfMUAAAAAFRZmnYGnoiM_Nt83xw2ZaAnwbAq');
if ($_POST)
{
	function getCaptcha($secretKey)
	{
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRET_KEY . "&response={$secretKey}");
		$return  = json_decode($response);
		return $return;
	}
	$return = getCaptcha($_POST['g-recaptcha-response']);
	// var_dump($_POST);
	// var_dump($return);
	global $captchaScore;
	$captchaScore = $return->score;
}
// $process = true;
// if ($process == true)
// {
require('connect.php');
//var_dump($_POST);
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
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$mturkCode = generateRandomString();
$ipAddress = getUserIpAddr();
foreach ($_POST as $key => $value)
{
	$$key = mysqli_real_escape_string ($conn, $value);
}
$crossDistance = distance($northLatitude, $westLongitude, $southLatitude,$eastLongitude, "K");
$insertQuery = "SET @p = 'POINT($centerLongitude $centerLatitude)';";
$issueQuery = "INSERT INTO `issues` SET
`refer` = '$refer',
`mturk` = '$mturkCode',
`captchaScore` = $captchaScore,
`ip` = '$ipAddress',
`statefp` = '$statefp',
`countyfp` = '$countyfp',
`coordinate` = ST_GeomFromText(@p),
`westLongitude` = '$westLongitude',
`eastLongitude` = '$eastLongitude',
`southLatitude` = '$southLatitude',
`northLatitude` = '$northLatitude',
`crossdistance` = '$crossDistance',
`first` = '$first',
`email` = '$email',
`issue` = '$issue',
`solution` = '$solution';";
if ($conn->query($insertQuery) === TRUE) {
	if ($conn->query($issueQuery) === TRUE) {
		//echo "New record created successfully";
		$message = "Thanks for your feedback!";
    } else {
		$message = "Error: " . $sql . "<br>" . $conn->error;
	}
} else {
    $message = "Error: " . $sql . "<br>" . $conn->error;
}
?>
<html style="overflow-y: auto !important; ">
	<header>
	<?php require($_SERVER['DOCUMENT_ROOT'] . "/css.php"); ?>
	</header>
	<body>
		<center>
		<div class="content">
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/header.php"); ?>
			<h2>Thank You</h2>
			<p>We appreciate your contribution. The more data we have, the better.</p>
			<?php if ($refer != '') echo "<a href=\"http://www.blackdove.org/intelligence/operations?id=$refer\">Click here to view an updated map with your contribution.<a>"; ?>
			<p>Your code is<br/><b><?php echo $mturkCode; ?></b></p>
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>
		</div>
		<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
		</script>
	</body>
</html>
<?php /*
}
else
{
?>
<html style="overflow-y: auto !important; ">
	<header>
	<?php require($_SERVER['DOCUMENT_ROOT'] . "/css.php"); ?>
	</header>
	<body>
		<center>
		<div class="content">
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/header.php"); ?>
			<h2>Thank You</h2>
			<p>We appreciate your contribution. The more data we have, the better.</p>
			<p>Your code is<br/><b><?php echo $mturkCode; ?></b></p>
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>
		</div>
		<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
		</script>
	</body>
</html>
<?php
}
*/?>