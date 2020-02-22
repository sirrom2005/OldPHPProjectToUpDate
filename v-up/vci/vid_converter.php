<?php
	ob_implicit_flush(true);
	set_time_limit(0);
	session_start();
	// disable output buffering so we can send the encoding progress to the browser.
	//if(empty($_SESSION['ADMIN_USER'])){header("location: index.php");}
define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT']."v-up/", true);
define("VIDEO_TMP_FOLDER",  SERVER_ROOT."videos/the_tmp_store/", true);
define("VIDEO_DEST_FOLDER", SERVER_ROOT."videos/", true);
define("VIDEO_SCRIPT_PATH", SERVER_ROOT, true);
	
	//$obj = new site();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Converting video</title>
<link href="../css/layout.css" rel="stylesheet" type="text/css" />
<link href="../css/vci.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php
		ob_flush();
		flush(); 
    	echo "<span class='msg'>Processing please wait...<img src='../images/loader.gif'/></span>";
		echo "<div class='msg' id='progress'>...</div>";

		if(isset($_GET['f']))
		{ $srcvideo = base64_decode($_GET['f']); }
		else
		{ $srcvideo = $_GET['id']; }
		
		$videoFileName		= explode(".", $srcvideo);
		$videoFileEXT		= $videoFileName[count($videoFileName)-1];
		/*create destination video file from the source file name*/
		$destVideoFile		= $videoFileName[0].".flv";
		/*creat folder for each video uploaded*/
		$video_tmp_folder	= VIDEO_TMP_FOLDER;
		/*make new video folder*/
		$video_dest_folder	= VIDEO_DEST_FOLDER."{$videoFileName[0]}/";
		
		$descriptorspec = array(
		   0 => array('pipe', 'r'),  // stdin is a pipe that the child will read from (we do not use it).
		   1 => array('pipe', 'w'),  // stdout is a pipe that the child will write to and we will read from.
		   2 => array('pipe', 'w')   // stderr is a file to write to (we do not use it).
		   );	
		
		function runVideoProcessor($cmd, $image=false)
		{
		echo "<p>$cmd</p>";
			global $descriptorspec;
			$process = proc_open($cmd, $descriptorspec, $pipes);
			
			if($image)
			{
				if(is_resource($process))
				{ 
					echo "<script>document.getElementById('progress').innerHTML = '<b>Progressing image...</b>';</script>";
					ob_flush();
					flush(); 
					fclose($pipes[0]);
					fclose($pipes[1]);
					fclose($pipes[2]);
					proc_close($process);
				}
				return true;
			}
			
			/*process video*/
			if(is_resource($process))
			{ 
				while(!feof($pipes[2]))
				{ 	
					$str = fread($pipes[2], 1024);
					$strLine = str_replace("\r", "<br>", $str);
					echo "<script>document.getElementById('progress').innerHTML = \"$strLine\";</script>";
					ob_flush();
					flush();
					sleep(1);
				}
				
				fclose($pipes[0]);
				fclose($pipes[1]);
				fclose($pipes[2]);
				proc_close($process);
			}
		}
		
		function getInputVideoSize()
		{
			global $video_tmp_folder, $srcvideo, $descriptorspec;
			$cmd 		= VIDEO_SCRIPT_PATH."ffmpeg -i $video_tmp_folder{$srcvideo}";
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
					}
					
					if(strpos($strLine, "Video:"))
					{
						/*GET VIDEO INPUT INFO*/
						$strLine = explode(",", $strLine);
						foreach($strLine as $key => $value)
						{
							if(preg_match("/[0-9]x[0-9]/",$value))
							{
								/*I'M HOPING THIS IS THE VIDEO SIZE*/
								$vs	= explode("x", $value);
								$videSize['width'] 	= (int)$vs[0];
								$videSize['height'] = (int)$vs[1];
							}
						}
						return $videSize;
					}
				}
			}
			return false;
		}
		
		function moveThisVideo($srcvideo)
		{
			global $video_tmp_folder, $video_dest_folder, $destVideoFile;
			copy("$video_tmp_folder{$srcvideo}", "$video_dest_folder{$destVideoFile}");
		}
		
		@mkdir($video_dest_folder, 0775);
		chmod($video_dest_folder, 0775);
					
		$vs = getInputVideoSize();

		if($vs['width'] <= 640)
		{
			/*PROCESS SAME VIDEO SIZE*/
			$cmd = VIDEO_SCRIPT_PATH."ffmpeg -i $video_tmp_folder{$srcvideo} -sameq -acodec libmp3lame -ar 22050 -ab 96000 -deinterlace -nr 500 -aspect 4:3 -r 20 -g 500 -me_range 20 -b 270k -deinterlace -f flv -y $video_dest_folder{$destVideoFile}";
		}
		else
		{
			/*PROCESS VIDEO TO VGA VIDE SIZE*/
			$cmd = VIDEO_SCRIPT_PATH."ffmpeg -i $video_tmp_folder{$srcvideo} -acodec libmp3lame -ar 22050 -ab 96000 -deinterlace -nr 500 -aspect 4:3 -r 20 -g 500 -me_range 20 -b 270k -deinterlace -f flv -y -s 640x380 -qscale 8 $video_dest_folder{$destVideoFile}";
		}
		
		/*A QUICK TIME CALCULATION WILL DO IT OVER*/
		$t = $vs['duration'];
		$t1 = (int)substr($t,0,2);//hh
		$t2 = (int)substr($t,3,4);//mm
		$t2 = $t2*60;
		$t3 = (int)substr($t,6,7);//ss
		$t4 = (int)substr($t,9,10);//ms
		
		$snapshot = floor(($t2 + $t3)/2);
		/*A QUICK TIME CALCULATION WILL DO IT OVER*/
		$cmd1 = VIDEO_SCRIPT_PATH."ffmpeg -i $video_tmp_folder{$srcvideo} -f image2 -ss $snapshot -s 640x380 {$video_dest_folder}thumbnail1.jpg";
			
		if($videoFileEXT=="flv")
		{
			/*process image*/
			runVideoProcessor($cmd1,true);
			moveThisVideo($srcvideo);
		}
		else
		{
			/*process video*/
			runVideoProcessor($cmd); 
			/*process image*/
			runVideoProcessor($cmd1,true);
		}
		
		/*DELETE TMP FILE*/
		//unlink($video_tmp_folder.$srcvideo);
		
		/*$data = array("video" => $videoFileName[0], "duration" => $vs['duration'], "user_id" => $_SESSION['ADMIN_USER']['id']);
		if($obj->addvideo($data))
		{
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: videouploader.net <admin@videouploader.net>\r\n";
			$msg = "New video added <a href='http://videouploader.net/videos/{$videoFileName[0]}/'>http://videouploader.net/videos/{$videoFileName[0]}/</a> by {$_SESSION['ADMIN_USER']['username']} (ID:: {$_SESSION['ADMIN_USER']['id']}) ";	
			@mail("admin@videouploader.net", "New video added", $msg, $header);	
			echo "<script>window.top.location = 'index.php?action=edit_video&id=".base64_encode($videoFileName[0])."';</script>";
		}*/
	?>
</body>
</html>
