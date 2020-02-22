<?php
	include_once("../config/global.php");
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php" );
	include_once("../classes/banner.class.php");

	$bannerObj = new banner();
	
	$hotGirl   		= $bannerObj->getHotGirlOfTheWeek();
	$myVoteId 		= base64_encode($hotGirl[0]['filename']."_IMG_".$hotGirl[1]['filename']);	
	$voteResults 	= $bannerObj->getVoteResults($myVoteId, $_SERVER['REMOTE_ADDR']); 
?>

<?php if(!empty($voteResults)){ ?>
	<div class='vote_result' style="float:right;">Girl B <?php echo (empty($voteResults['2']))? "(N.A.)" : $voteResults['2'];?></div>
    <div class='vote_result'>Girl A <?php echo (empty($voteResults['1']))? "(N.A.)" : $voteResults['1'];?></div>
<?php }else{ ?>
    <p>Which of these honnies have the best style?</p>
	<span style="float:right;">
		<input type="radio" name="hottGirl" id="hottGirl_2" onclick="voteForHottie('<?php echo base64_encode($hotGirl[0]['filename']."_IMG_".$hotGirl[1]['filename']); ?>', '<?php echo base64_encode($hotGirl[1]['filename'])?>', 2);" />
		<label for="hottGirl_2">Vote for girl B</label>
	</span>
	<span>
		<input type="radio" name="hottGirl" id="hottGirl_1" onclick="voteForHottie('<?php echo base64_encode($hotGirl[0]['filename']."_IMG_".$hotGirl[1]['filename']); ?>', '<?php echo base64_encode($hotGirl[0]['filename'])?>', 1);" />
		<label for="hottGirl_1">Vote for girl A</label>
	</span>
<?php } ?>	
