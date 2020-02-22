<?php

//////////////////////////////FUNCTIONS/////////////////////////////////////
// SET COOKIE ON SUBMIT:
include_once('common_functions.php');

if (isset($_POST['pollname'])) {
$pollname = escape_data($_POST['pollname']);
setcookie("jdp_voted_$pollname", "voted", time()+60*60*24*100, "/");
}

function get_results($pollname) {
	$query = mysql_query("SELECT * FROM pollv2 WHERE pollname = '$pollname'");
		while ($results = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$num_questions = $results['num_questions'];
		$created = datetime($results['created'],'F j, Y');
		$expires = datetime($results['expires'],'F j, Y');
		$description = $results['description'];
		$caption = $results['caption'];
			$poll_query = mysql_query("SELECT * FROM $pollname");
			if ($description != "") {
			echo "<h2>$description</h2>";
			}
			
			while ($presults = mysql_fetch_array($poll_query,MYSQL_ASSOC)) {
				$num_options = $presults['num_options'];			
				$question = $presults['question'];
				$question_slash = str_replace("'","",$question);
				$pollsize = $presults['pollsize'];
				$pollcolor = $presults['pollcolor'];				
				echo "<div class=\"jdp_result_table\">";
				$table = "";
				for ($i=1;$i<=$num_options;$i++) {
				$cset = 'c' . $i;
				$rset = 'r' . $i;
				$c = $presults[$cset];
				$c_slash = str_replace("'","",$c);
				$r = $presults[$rset];
				$total = 0;
					for ($ir=1;$ir<=$num_options;$ir++) {
					$newrset = 'r' . $ir;
					$newr = $presults[$newrset];
					$total = $total + $newr;
					}
				if ($total != 0) {
				$percent = round(($r/$total)*100,1);
				} else {
				$percent = '0';
				}
				$table .= "<tr><td>$c ($percent &#37;)</td><td title=\"$percent percent of responses said $c\">$r</td></tr>\n";
				$summary .= "$percent percent voted $c_slash. ";
				}
echo "
<div class='caption'>$question</div>
<table class='hidden poll-results tochart ctype$ctype size$pollsize color$pollcolor' summary='$question_slash $summary'>
<thead>
<tr><th scope=\"col\">Question</th><th scope=\"col\">Votes</th></tr>
</thead><tbody>";
echo "$table";

echo "</tbody></table></div>\n";
			}
		}
echo "<p class=\"jdp_dates\">Created $created\n";
echo " &mdash; expires $expires.</p>\n";
echo "<script type=\"text/javascript\" src=\"table2chart.js\"></script>";
mysql_free_result($poll_query);
mysql_free_result($query);
}

function show_poll($pollname, $formpath) {
	$query = mysql_query("SELECT * FROM pollv2 WHERE pollname = '$pollname' AND expires >= NOW()");
		if (!$query) {
		$n_query = mysql_query("SELECT * FROM pollv2 WHERE pollname = '$pollname'");
			if ($n_query) {
			echo "<p>The poll you're attempting to take is no longer open for voting. <a href=\"?results=$pollname\">View the results!</a></p>";
			} else {
			echo "<p>The poll you're looking for does not exist.</p>";
			}
		}
		while ($results = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$pollid = $results['id'];
		$num_questions = $results['num_questions'];
		$created = datetime($results['created'],'F j, Y');
		$expires = datetime($results['expires'],'F j, Y');
		$expires_raw = $results['expires'];
		$description = $results['description'];
		$caption = $results['caption'];
		$pollsize = $results['pollsize'];
		$pollcolor = $results['pollcolor'];
		$poll_query = mysql_query("SELECT * FROM $pollname");	
		if ($description != '') {
		//echo "<p>$description</p>";
		}
		echo "<form action=\"$formpath/\" method=\"post\" id=\"jd_poll\">\n
		<div><input type=\"hidden\" value=\"$pollname\" name=\"pollname\" /></div>";		
		while ($presults = mysql_fetch_array($poll_query,MYSQL_ASSOC)) {
			$question = $presults['question'];
			$qid = $presults['qid'];
			$num_options = $presults['num_options'];
			echo "<div class='question'>$question</div>\n";
			echo "<ul class=\"jdp_answers\">";
				for ($i=1;$i <= $num_options;$i++) {
				$set = 'c' . $i;
				$c = $presults[$set];
				echo "<li><input type=\"radio\" name=\"$qid\" value=\"c$i\" id=\"c$i$qid\" /> <label for=\"c$i$qid\">$c</label></li>\n";
				}
			echo "</ul>\n";
		}
	echo "<p class=\"submit_button\"><input type=\"submit\" value=\"Vote\" class=\"button\" /></p>\n</form>\n";
	}
//echo "<p class=\"jdp_dates\">Created $created\n";
//echo " &mdash; expires $expires.</p>\n";
echo "<span class=\"get_results\"><a href=\"$formpath/?results=$pollname\" class='rrr'>Results</a></span>";		
//echo "<p class=\"list_polls\"><a href=\"$formpath/?list=active\">List of active polls.</a></p>";
//END FUNCTION
mysql_free_result($poll_query);
mysql_free_result($query);
}
		
function check_voter($pollname) {
	if(isset($_COOKIE['jdp_voted_' . $pollname])) {
	return TRUE;
	} else {
	return FALSE;
	}
}
function record_vote($pollname) { 
	if (check_voter($pollname) == TRUE) {
	echo "<div class=\"response\"><p>You have already voted in this poll.</p></div>";
	} else {
	$query = mysql_query("SELECT num_questions FROM pollv2 WHERE pollname = '$pollname'");
		while ($results = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$num_questions = $results['num_questions'];
			for ($i=1;$i <= $num_questions;$i++) {
				$field = $_POST[$i];
				$field = str_replace('c','',$field);
				$field = 'r'.$field;
				$update = "UPDATE $pollname SET $field=$field+1 WHERE qid = $i";
				$result = mysql_query($update); 
					if ($result) {
					echo "<p class=\"success\">Successful vote on question $i.</p>";
					} else {
					$set_vote = FALSE;
					echo "<p class\"failure\">Failed vote on question $i.</p>";
					}
			}
		}
	}
get_results($pollname);
return $set_vote;
mysql_free_result($result);
mysql_free_result($query);
}
function list_polls($data="all",$formpath) {
echo "
<ul>
<li><a href=\"$formpath/?list=all\">List all polls</a></li>
<li><a href=\"$formpath/?list=active\">List active polls</a></li>
<li><a href=\"$formpath/?list=expired\">List expired polls</a></li>
</ul>";

echo "\n<ul>";
	if ($data == "active") {
	$query = mysql_query("SELECT * FROM pollv2 WHERE expires >= NOW()");
	while ($results = mysql_fetch_array($query,MYSQL_ASSOC)) {
			$num_questions = $results['num_questions'];
			$expires = datetime($results['expires'],'F j, Y');
			$caption = strip_slashes($results['caption']);
			$description = strip_slashes($results['description']);
			$pollname = strip_slashes($results['pollname']);
			$term = ($num_questions == 1) ? 'question' : 'questions'; 
			echo "   <li><a href=\"$formpath/?poll=$pollname\">$caption</a> - $num_questions $term, expires $expires</li>\n";
		}
	}
	if ($data == "expired") {
	$query = mysql_query("SELECT * FROM pollv2 WHERE expires <= NOW()");
		while ($results = mysql_fetch_array($query,MYSQL_ASSOC)) {
			$num_questions = strip_slashes($results['num_questions']);
			$expires = datetime($results['expires'],'F j, Y');
			$caption = strip_slashes($results['caption']);
			$description = strip_slashes($results['description']);
			$pollname = strip_slashes($results['pollname']);
			$term = ($num_questions == 1) ? 'question' : 'questions'; 			
			echo "   <li><a href=\"$formpath/?results=$pollname\">$caption</a> - $num_questions $term, expired $expires</li>\n";
		}
	}
	if ($data == "all") {
	$query = mysql_query("SELECT * FROM pollv2");
		while ($results = mysql_fetch_array($query,MYSQL_ASSOC)) {
			$num_questions = $results['num_questions'];
			$expires = datetime($results['expires'],'F j, Y');
			$caption = strip_slashes($results['caption']);
			$description = strip_slashes($results['description']);
			$pollname = strip_slashes($results['pollname']);
			if (is_expired($pollname)) {
			echo "   <li><a href=\"$formpath/?results=$pollname\">$caption</a> - $num_questions questions, expired $expires</li>\n";			
			} else {
			echo "   <li><a href=\"$formpath/?poll=$pollname\">$caption</a> - $num_questions questions, expires $expires</li>\n";
			}
		}
	}
echo "</ul>";
mysql_free_result($query);
}
///////////////////////////////END FUNCTIONS///////////////////////////
?>