<?php
include_once('../common_functions.php');

function required_field($variable) {
	if ($variable == "") {
	$variable = FALSE;
	return FALSE;
	} else {
	$variable = escape_data($variable);
	return $variable;
	}
}

function list_polls() {
echo "<div id=\"admin\"><h2>Edit pre-existing Polls</h2>";
echo "<ul>";
	$query = mysql_query("SELECT * FROM pollv2");
		while ($results = mysql_fetch_array($query,MYSQL_ASSOC)) {
			$num_questions = $results['num_questions'];
			$expires = datetime($results['expires'],'F j, Y');
			$caption = strip_slashes($results['caption']);
			$description = strip_slashes($results['description']);
			$pollname = strip_slashes($results['pollname']);
			echo "<li><a href=\"?edit=$pollname\">$caption</a> - $num_questions "; $term = ($num_questions == 1) ? 'question' : 'questions'; echo "$term: <strong>$expires</strong></li>";
		}
echo "<li><strong><a href=\"index.php\">Add new poll</a></strong> &raquo;</li>";
echo "</ul></div>";
mysql_free_result($query);
}

$php_self_submit = htmlentities($_SERVER['PHP_SELF']);

?>