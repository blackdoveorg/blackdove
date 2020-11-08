<?php
require('connect.php');
foreach ($_GET as $key => $value)
{
	$$key = $value;
	//echo "$key => $value<br/>";
}
$issueSelect = "SELECT * FROM `issues` WHERE `id` = $id;";
//echo $stateSelect;
$issueResult = $conn->query($issueSelect);
if ($issueResult->num_rows > 0) {
	while($row = $issueResult->fetch_assoc()) {
		$id = $row['id'];
		$name = $row['first'];
		$issue = $row['issue'];
		$solution = $row['solution'];
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
			<h2>Issue <?php echo $id; ?></h2>
			<h3>Problem</h3>
			<p><?php echo $issue; ?></p>
			<h3>Solution</h3>
			<p><?php echo $solution; ?></p>
		</div>
	</body>
</html>
<?php
}
else
{
?>
It doesn't work that wasdasdy.
<?php
echo $id;
}
?>