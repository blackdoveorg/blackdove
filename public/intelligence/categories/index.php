<pre>
<?php
require('../connect.php');
$issueSelect = "SELECT * FROM `socialIssues`;";
$issueResult = $conn->query($issueSelect);
if ($issueResult->num_rows > 0) {
	while($row = $issueResult->fetch_assoc()) {
		$socialIssue = $row['issue'];
		$issueList[$socialIssue] = array_filter(explode(",", $row['associatedTerms']));
		$issueColors[$socialIssue] = $row['color'];
		$issueIcons[$socialIssue] = $row['iconURL'];
		echo "Social Issue: $socialIssue</br>";
		echo "\tAssociated Terms:<br/>";
		foreach($issueList[$socialIssue] as $key => $value)
		{
			echo "\t\t$key => $value<br/>";
		}
	}
}
?>
</pre>