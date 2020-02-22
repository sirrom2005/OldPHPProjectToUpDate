var d = document;

function voteForHottie(voteId, fileName, girl)
{
	getPage( "includes/vote_for_hottie.php?file_name=" + fileName + "&vote_id=" + voteId + "&girl=" + girl + "&SESSID=" + Math.random(), "hottGirlVote" );
}