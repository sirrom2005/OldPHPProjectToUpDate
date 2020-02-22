<?php
session_start();
ob_implicit_flush(true);
set_time_limit(0);

define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT']."v-up/", true);
define("VIDEO_TMP_FOLDER",  SERVER_ROOT."videos/the_tmp_store/", true);
define("VIDEO_DEST_FOLDER", SERVER_ROOT."videos/", true);
define("VIDEO_SCRIPT_PATH", SERVER_ROOT, true);

$video_dest_folder = null;
$destVideoFile     = null;
$videoFileName     = null;

init();
load();

function init()
{
    echo "<style>body{ background-color:#000; color:#fff; }</style>";
    echo "<p><b>Video Converter Ver 1.1.0<br>Now converting video</b></p>";
}

function load()
{
    global $destVideoFile,$video_dest_folder,$videoFileName;
    $file = base64_decode($_GET['f']);
    $videoFileName	= explode(".", $file);
    //$videoFileEXT	= $videoFileName[count($videoFileName)-1];
    /*create destination video file from the source file name*/
    $destVideoFile = $videoFileName[0].'.'.$videoFileName[1];
    /*creat folder for each video uploaded*/
    $video_tmp_folder   = VIDEO_TMP_FOLDER;
    /*make new video folder*/
    $video_dest_folder  = VIDEO_DEST_FOLDER."{$videoFileName[0]}/";

    @mkdir($video_dest_folder, 0775);
    chmod($video_dest_folder, 0775);

    /*PROCESS VIDEO TO VGA VIDE SIZE*/
    /*$cmd = VIDEO_SCRIPT_PATH."ffmpeg -i $video_tmp_folder{$this->file}
    -acodec libmp3lame -ar 22050 -ab 96000
    -deinterlace -nr 500 -aspect 4:3 -r 20
    -g 500 -me_range 20 -b 270k -deinterlace
    -f flv -y -s 640x380 -qscale 8 $video_dest_folder{$destVideoFile}";*/
    $cmd = VIDEO_SCRIPT_PATH."ffmpeg -i $video_tmp_folder{$file} -y -s 640x380 -qscale 8 $video_dest_folder{$destVideoFile}";
    convertVideo($cmd);
}

function convertVideo($cmd, $image=false)
{
   global $destVideoFile,$video_dest_folder,$videoFileName;
   $descriptorspec = array(
    0 => array('pipe', 'r'),  // stdin is a pipe that the child will read from (we do not use it).
    1 => array('pipe', 'w'),  // stdout is a pipe that the child will write to and we will read from.
    2 => array('pipe', 'w')   // stderr is a file to write to (we do not use it).
    );

    $process = proc_open($cmd, $descriptorspec, $pipes);

    /*if($image)
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
    }*/

    /*PROCESSING VIDEO*/
    if(is_resource($process))
    {
        $i=0;
        while(!feof($pipes[2]))
        {
            $str = fread($pipes[2], 1024);
            echo $strLine = str_replace("\r", "<br>", $str);
            
            ob_flush();
            flush();
            sleep(0);
            $i++;
        }
      
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);

        $_SESSION['VIDEODATA'] = array( "video_location" => str_replace(VIDEO_DEST_FOLDER, '', $video_dest_folder.$destVideoFile),
                                        "title" => 'video added on'.date('Y-m-d h:i:s'),
                                        "date_added" => date('Y-m-d'),
                                        "enabled" => 0,
                                        "user_id" => 100
                                        );
        echo "<script>location='manage_video.php';</script>";
    }
}
?>