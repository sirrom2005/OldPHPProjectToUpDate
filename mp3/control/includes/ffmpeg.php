<?php
// disable output buffering so we can send the encoding progress to the browser.
ob_implicit_flush(true);
set_time_limit(0);
include_once("../../config/config.php");
include_once("../../classes/mySqlDB__.class.php");
include_once("../../classes/commonDB.class.php");

$comObj = new commonDB();	

$id = $_GET['id'];
$rs = $comObj->getDataById("odb_mp3",$id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Converting video</title>
<style>
#progress
{
	text-align:center; 
	font-weight:bold; 
	font-size:12px;
	border:solid 1px #F3CF83; 
	display:block; 
	text-align:center; 
	background-color:#C6CFFB; 
	padding:5px 10px; 
	margin:5px 20%;
}
</style>
</head>
<body>
<div id='progress' style=''>Creating sample MP3</div>
<?php
flush(); 		
$descriptorspec = array(
   0 => array('pipe', 'r'),  // stdin is a pipe that the child will read from (we do not use it).
   1 => array('pipe', 'w'),  // stdout is a pipe that the child will write to and we will read from.
   2 => array('pipe', 'w')   // stderr is a file to write to (we do not use it).
   );

function runMP3Processor($cmd)
{
	global $descriptorspec, $pipes;
	$process = proc_open($cmd, $descriptorspec, $pipes);
	
	if(is_resource($process))
	{ 
		while(!feof($pipes[2]))
		{ 
			$str = fread($pipes[2], 1024);
			$strLine = str_replace("\r", "<br>", $str);
			//echo $strLine;
            echo "<script>document.getElementById('progress').innerHTML += '...';</script>";
			flush();  
			sleep(1);
		}
		
		fclose($pipes[0]);
		fclose($pipes[1]);
		fclose($pipes[2]);
		proc_close($process);
	}
	
	echo "<script>document.getElementById('progress').innerHTML += 'Done!!!';</script>";
	flush();
}

function getMP3Time()
{
	global $descriptorspec, $pipes, $rs;
	$cmd 		= FFMPEG_SCRIPT_PATH."ffmpeg -i ".UPLOADDIR."{$rs['filename']}";
	$process 	= proc_open($cmd, $descriptorspec, $pipes);
	$videSize	= array();
	
	if(is_resource($process))
	{ 
		while(!feof($pipes[2]))
		{ 
			$str = fgets($pipes[2], 1024);
			$strLine = str_replace("\r", "<br>", $str);
			if(strpos($strLine, "Duration:"))
			{
				$d = explode(",", $strLine);
				foreach($d as $key => $value)
				{
					if(strpos($value,"Duration:"))
					{
						$videSize['duration'] = trim(str_replace("Duration:","",$value));
					}
				}
				return $videSize;
			}
			
		}
	}
	return false;
}

$musicTime = getMP3Time(); 
/*A QUICK TIME CALCULATION WILL DO IT OVER*/
$t = $musicTime['duration'];
$t2 = (int)substr($t,3,2);//mm
$t2 = $t2*60;//total seconds for mm time
$t3 = (int)substr($t,6,2);//ss
$t3 = floor(($t2+$t3)/2);//total seconds

$cmd = FFMPEG_SCRIPT_PATH."ffmpeg -i ".UPLOADDIR."{$rs['filename']} -ab 48k -t 20 -ss $t3 -y ".UPLOADDIR."sample_{$id}.mp3";
runMP3Processor($cmd); 
echo "<script>window.location='../index.php?action=list_music';</script>";
?>
</body>
</html>