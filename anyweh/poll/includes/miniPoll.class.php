<?php
class miniPoll {

	var $show_vote_count;
	var $active_poll_id;
	var $active_poll_title;
	var $timestamp;
	var $timeout;
	var $ip;
	var $repeated_vote;
	var $results_page;
	var $old_polls;

	function miniPoll() {
		$this->show_vote_count = false; // display total votes? true/false
		$this->pollLayout();
		$this->getActivePoll();
		$this->timestamp = time();
		$this->timeout = $this->timestamp - 1800;
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->repeated_vote = "You already voted today<br />";
		$this->results_page = "poll/poll_results.php"; // page where you display results
		$this->old_polls = true; // if true enables view of old polls. this only display old polls it doesn't allow users to vote. true/false
		
	}
	
	function pollLayout() {
		// it allows you to set visual settings using CSS definitions included in file where you're calling this class
		// replace these with your own CSS styles
		$this->form_table_width = "99%";
		$this->form_title = "menuhd";
		$this->form_table = "tabele";
		$this->form_table_cell = "poll";
		$this->form_button = "form_button";
		$this->poll_question = "poll_question"; // this is for <span> tag
		$this->results_title = "menuhd";
		$this->results_table = "resultsTable";
		$this->results_poll_question = "fat";
		$this->result_table_width = "450px";
		$this->result_table_cell = "pollbg";
		$this->bar_image = "images/bar.jpg"; // please select 1px width x 15px height image
	}
	
	function getActivePoll() {
		$sql = @mysql_query ("SELECT pollid, polltitle FROM poll_desc WHERE status = 'active'");
		$row = @mysql_fetch_object($sql);
		$this->active_poll_id = $row->pollid;
		$this->active_poll_title = $row->polltitle;
		return;
	}
	
	function voteCount() {
		$sql = @mysql_query ("SELECT SUM(votecount) AS votecount FROM poll_data WHERE pollid = '$this->active_poll_id'");
		$row = @mysql_fetch_object($sql);
		$this->votecount = $row->votecount;
		return $this->votecount;
	}
	
	function pollForm() { 
		$sql = @mysql_query ("SELECT polltext, voteid FROM poll_data WHERE pollid = '$this->active_poll_id' ORDER BY voteid");
		if (@mysql_num_rows($sql) > 0) {
			echo "<table width=\"$this->form_table_width\" cellpadding=\"0\" cellspacing=\"0\" class=\"$this->form_table\">
			<!--tr><td class=\"$this->form_title\">Super Mini Poll</td></tr-->
			<tr><td class=\"$this->form_table_cell\">\r\n";
			echo "<form action=\"$this->results_page\" name=\"pollf\" id=\"pollf\" method=\"get\">
			<div class=\"$this->poll_question\">" . $this->active_poll_title . "</div>\r\n";
			while ($row = @mysql_fetch_object($sql)) {
				if (!empty($row->polltext)) {
					echo "\t<a href=\"poll/poll_results.php?voteid=$row->voteid&pollid=$this->active_poll_id&poll=Vote\" class=\"poll_link thickbox\" title=\"poll choice: $row->polltext\" >$row->polltext</a>";
				}
			}
			echo "\r\n</td></tr></table>\r\n";
			echo "<input type=\"hidden\" name=\"pollid\" id=\"pollid\" value=\"$this->active_poll_id\" />\r\n";
			//echo "<input type=\"button\" name=\"poll\" id=\"poll\" value=\"Vote\" alt=\"\" title=\"Vote on this poll.\" class=\"$this->form_button thickbox\" onclick=\"validPoll();\" />";
			if ($this->show_vote_count) {
				echo "Total votes: " . $this->voteCount() . "\r\n";
			}
			echo "<input type=\"submit\" value=\"View results\" title=\"view www.anyweh.com poll results...\" class=\"$this->form_button\" />
			</form>";
		}
	}
	
	function deleteCheck() {
		$sql = @mysql_query ("DELETE FROM poll_check WHERE time < '$this->timeout'");
		return;
	}
	
	function insertCheck() {
		$sql = @mysql_query ("INSERT INTO poll_check (ip, time) VALUES ('$this->ip', '$this->timestamp')");
		return;
	}
	
	function voteCheck() {
		$this->deleteCheck();
		$sql = @mysql_query ("SELECT ip FROM poll_check WHERE ip = '$this->ip'");
		if (@mysql_num_rows($sql) == 0) {
			$this->insertCheck();
			return true;
		}
		else {
			return false;
		}
	}
	
	function processPoll($pollid, $voteid) {
		if ($this->voteCheck()) {
			$sql = @mysql_query ("UPDATE poll_data SET votecount = votecount + 1 WHERE voteid = '$voteid' AND pollid = '$pollid'");
		}
		else {
			echo "<p class='repeated_vote'>$this->repeated_vote</p>";
		}
	
	}
	
	function selectedPoll($pollid) {
		$sql = @mysql_query ("SELECT polltitle FROM poll_desc WHERE pollid = '$pollid'");
		$row = @mysql_fetch_object($sql);
		$this->polltitle = $row->polltitle;
		return $this->polltitle;
	}
	
	function selectedPollVotecount($pollid) {
		$sql = @mysql_query ("SELECT SUM(votecount) AS votecount FROM poll_data WHERE pollid = '$pollid'");
		$row = @mysql_fetch_object($sql);
		$this->votecount = $row->votecount;
		return $this->votecount;
	}
	
	function formatDate($val) { 
		$arr = explode("-", $val);
		return @date("d. F Y.", mktime (0,0,0, $arr[1], $arr[2], $arr[0]));
	}
	
	function oldPolls($pollid) {
		$sql = mysql_query ("SELECT pollid, polltitle, timestamp FROM poll_desc WHERE pollid <> '$pollid'");
		if (mysql_num_rows($sql) > 0) {
			echo "<tr><td class=\"$this->result_table_cell\" colspan=\"2\">\r\n";
			while ($row = mysql_fetch_object($sql)) {
				$datum = $this->formatDate($row->timestamp);
				echo "<a href=\"../$this->results_page?pollid=$row->pollid\">".substr($row->polltitle, 0, 50)."...</a> $datum<br />\r\n";
			}
			echo "</td></tr>\r\n";
		}
	}
	
	function pollResults($pollid) {
		$this->selectedPoll($pollid);
		$this->selectedPollVotecount($pollid);
		$sql = @mysql_query ("SELECT polltext, votecount, voteid FROM poll_data WHERE pollid = '$pollid' AND polltext <> '' ORDER BY voteid");
		echo "<table border=\"0\" class=\"$this->results_table\">
		<tr><td class=\"$this->results_title\" colspan=\"2\">Poll Results</td></tr>";
		if (@mysql_num_rows($sql) > 0) {
			echo "<tr><td class=\"$this->results_poll_question\" colspan=\"2\">$this->polltitle</td></tr>\r\n";
			while ($row = mysql_fetch_object($sql)) {
				if ($this->votecount == 0) {
					$tmp_votecount = 1;
				}
				else {
					$tmp_votecount = $this->votecount;
				}
				$vote_percents = number_format(($row->votecount / $tmp_votecount * 100), 2);
				$image_width = intval($vote_percents * 3);
				echo "<tr><th class=\"$this->result_table_cell\"><b>$row->polltext:</b>&nbsp;<!--$row->votecount votes.--> ($vote_percents %)</th><td class=\"$this->result_table_cell\"> <img src=\"$this->bar_image\" width=\"$image_width\" alt=\"$vote_percents %\" height=\"15\" /> </td></tr>\r\n";
			}
			if($this->votecount >= 60){ echo "<tr><td class=\"count\" colspan=\"2\">$this->votecount Person voted on this poll.</td></tr>\r\n"; }
			echo "<tr><td colspan=\"2\" id='powered'>Powered by: <a href=\"http://www.sim-php.info\" title=\"Simple Mini Poll\" target=\"_blank\">Simple Mini Poll</a></td></tr>\r\n";
		}
		/* HIDE POLL HISTORY */
		/*if ($this->old_polls) {
			$this->oldPolls($pollid);
		}*/
		echo "</table>\r\n";
	}

}
?> 