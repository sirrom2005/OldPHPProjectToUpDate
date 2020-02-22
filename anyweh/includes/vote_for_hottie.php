<?php
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php" );
	include_once("../classes/banner.class.php");

	$bannerObj 	= new banner();
	
	$voteId 	= $_GET['vote_id'];	
	$fileName 	= $_GET['file_name'];
	$girl 		= $_GET['girl'];

	if( $bannerObj->voteForHottie($voteId, $fileName, $girl) )
	{ 
		$rs = $bannerObj->getVoteResults($voteId);
		if( $rs )
		{
			$rs['1'] = (empty($rs['1']))? "(N.A.)"  : $rs['1'];
			$rs['2'] = (empty($rs['2']))? "(N.A.)"  : $rs['2'];
			echo "<div class='vote_result' style='float:right;'>Girl B ".$rs['2'].".<div>
				  <div class='vote_result'>Girl A ".$rs['1'].".</div>";
		}
	}
?>