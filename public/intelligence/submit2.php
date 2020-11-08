<?php
require('connect.php');
$id = "999";
$problem = "Homelessness and drug use.";
$solution = "Provide low income housing, safe injection sites, mental health services, subsidized labor for hiring the homeless.";

$issuesCategories = "SELECT * FROM `socialIssues`";
$issueResult = $conn->query($issuesCategories);
if ($issueResult->num_rows > 0) {
	$issueHTML = '';
	while($row = $issueResult->fetch_assoc()) {
		$id = $row['id'];
		$issue = $row['issue'];
		$issueHTML .= "<option value=\"$id\">$issue</option>";
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
$ipAddress = getUserIpAddr();
?>
<html style="overflow-y: auto !important; ">
	<header>
	<?php require($_SERVER['DOCUMENT_ROOT'] . "/css.php"); ?>
	</header>
	<body>
		<center>
		<div class="content">
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/header.php"); ?>
			<h2>Report <?php echo $id; ?> Submitted</h2>
			<p>The more data we have, the better. We appreciate your contribution.</p>
			<h2>Do More</h2>
			<p>Interested in helping us out some more? Highlight key phrases in your response, pick a category that phase corresponds to, and click on the <b>Classify</b> button. This helps train our system to better identify problems and solutions.</p>
			<h3>Problem</h3>
			<p id="problem"><?php echo $problem; ?></p>
			<h3>Solution</h3>
			<p id="solution"><?php echo $solution; ?></p>
			<select id="issue" class="form-control">
				<?php echo $issueHTML; ?>
			</select>
			<button onclick="getSelectionText()" class="form-control">Cassify</button>
		</div>
		<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
		function getSelectionText() {
			var text = "";
			if (window.getSelection) {
				text = window.getSelection().toString();
			} else if (document.selection && document.selection.type != "Control") {
				text = document.selection.createRange().text;
			}
			return text;
		}
		</script>
	</body>
</html>