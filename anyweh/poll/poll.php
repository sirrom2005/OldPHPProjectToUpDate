<?php
/****************************************************************************/
//                   MySQL/PHP Simple Poll by Joe Dolson                    //
//                Free for non-commercial use with attribution.             //	
//                            v.0.5 (11 April 2008)						//
//--------------------------------------------------------------------------//
//   This software incorporates very basic security features.  This should  //
//   not be considered any significant protection for your website.		    //
/****************************************************************************/ 

// check if mysql connection exists
if (@mysql_ping()) {

echo "<div id=\"poll_$pollname\">";

if(isset($_GET['results'])) {
$pollname = make_safe($_GET['results']);
get_results($pollname);
} else if (isset($_GET['poll'])) {
$pollname = make_safe($_GET['poll']);
show_poll($pollname, $formpath);
} else if (isset($_POST['pollname'])) {
$pollname = make_safe($_POST['pollname']);
record_vote($pollname);
} else if (isset($_GET['list'])) {
$listtype = make_safe($_GET['list']);
list_polls($listtype,$formpath);
} else {
show_poll($pollname, $formpath);
}
//echo "<p><a href=\"$formpath\">Current Poll</a></p>";
echo "</div>";
} else {
echo "<p>No active MySQL connection was detected.</p>";
}
?>