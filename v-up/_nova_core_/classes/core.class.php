<?php
include_once( str_replace('classes', '', __DIR__).'config.php');
class Core
{
    public $setThemeFolder;
    public $setTemplate;
    public $db = NULL;
    public $buffer;

    protected function _init(){}

    protected function _config(){}

    protected function _load()
    {
        $template = $this->setThemeFolder.'/'.$this->setTemplate;
        ob_start();
            include_once(THEMEFOLDER.$template);
            $this->buffer = ob_get_contents();
        ob_end_clean();
    }

    protected function _render(){ echo $this->buffer; }

    protected function sqliteConnect($filename)
    {
        try
        {
            $this->db = new PDO('sqlite:'.SERVER_PATH.'_nova_core_/data/'.$filename);
            return $this->db;
        }
        catch(PDOException $ex)
        {
            $this->lodDebugMsg($ex);
            $this->printMsg('Connection error');
            exit();
        }
    }

    protected function cleanString($str)
    {
        $str = trim($str);
        $str = stripslashes($str);
        $str = strip_tags($str, "<a>");
        if(!empty($len))
        {
            $a = explode(' ', $str);
            $str = implode(' ', array_slice($a,0,$len));
        }
        return $str;
    }

    protected function stringToURL($str)
    {
        $str = strtolower(str_replace(" ", "_",$str));
        return $str;
    }
    
    protected function URLToString($str)
    {
        $str = strtolower(str_replace("_", " ",$str));
        return $str;
    }

    protected function sqliteQuery($query){ return $this->db->query($query); }

    protected function lodDebugMsg($msg){}

    protected function printMsg($msg){echo $msg;}

    protected function DBconnect(){$this->db = $this->sqliteConnect('videouploader.sqlite');}

    protected function loadCategory()
    {
       $str = '';
       $subStr = '';
       $rs = $this->sqliteQuery('select title,cat_url from categories');
       $cnt=0;
       foreach($rs as $row)
       {
           if($cnt<=9)
           {
                $str .= "<li><a href='".DOMAIN.$row['cat_url']."/' title='". $this->cleanString($row['title']) ."' >"
                     . $this->cleanString($row['title']) ."</a></li>";
           }
           else
           {
               $subStr .= "<li><a href='".DOMAIN.$row['cat_url']."/' title='". $this->cleanString($row['title']) ."' >"
                       . $this->cleanString($row['title']) ."</a></li>";
           }
           $cnt++;
       }
       $this->buffer = str_replace("{MAINMENU}", $str, $this->buffer);
       $this->buffer = str_replace("{SUBMAINMENU}", $subStr, $this->buffer);
    }

    protected function mediumVideoList($data)
    {
        $isEmpty = true;
        $str = "<ul class='latest_video'>";
        $i=0;
        foreach($data as $row)
        {
            $i++;
            $noStyle = ($i%2==0)? "noStyle" : "";
            $tags = $this->getTagsForVideo($row['video_id']);
            $duration = "0:00.00";
            if(!empty($row['duration']))
            {
                $duration = substr($row['duration'],3,5);
                $duration = "<b title='video duration'>$duration</b> | ";
            }
            $url = (empty($row['explicit']))? DOMAIN.$row['cat_url']."/{$row['url_title']}.html" : DOMAIN."restricted/".base64_encode($row['video'])."/index.html";

            $str .= "<li class='$noStyle'>
                        <h2><a href='$url' title=\"".$this->cleanString($row['title'])."\">".substr($row['title'], 0, 42)."...</a></h2>
                        <a href='$url' title='".$this->cleanString(strtolower($row['title']))."'><img src='".DOMAIN."videos/{$row['foldername']}/thumbnail1sml.jpg' alt='image of ".$this->cleanString(strtolower($row['title']))."' /></a>
                        <font><b></b></font>
                        <font class='tags'>$tags</font>
                        <font>Duration: $duration</font>
                        <font>Views: {$row['viewed']}</font>
                        <font>Added: ".date("M-d-y", strtotime($row['date_added']))." by <a href='".DOMAIN."search.php?user={$row['username']}'>{$row['username']}</a></font>
                        <font><a href='$url#disqus_thread'>&nbsp;</a></font>
                     </li>";
           $isEmpty = false;
        }
        $str .= "</ul><br class='clearleft'>";
        if($isEmpty)
            return false;
        return $str;
    }

    protected function largeVideoList($data)
    {
        $str = "<ul class='featured_video'>";
        $i=0;

        if(!empty($data))
        {
            foreach($data as $row)
            {
                $i++;
                $noStyle = ($i%3==0)? "noStyle" : "";
                $url = (empty($row['explicit']))? DOMAIN.$row['cat_url']."/{$row['url_title']}.html" : DOMAIN."restricted/".base64_encode($row['video'])."/index.html";
                $str .= "<li class='$noStyle'>
                          <a href='$url' title='".$this->cleanString(strtolower($row['title']))."'><img src='videos/{$row['foldername']}/thumbnail1med.jpg' width='213' alt='image of ".$this->cleanString(strtolower($row['title']))."' /></a>
                          <font><h2><a href='$url' title='".$this->cleanString(strtolower($row['title']))."'>".substr($row['title'], 0, 44)."</a></h2></font>
                         </li>";
            }
        }
        $str .= "</ul><br class='clearleft'>";
        return $str;
    }

    protected function formateTags($str, $limit=3)
    {
        $str = strtolower($this->cleanString($str));
        $str = explode(",", $str);
        $keywords = "";
        if(!empty($str))
        {
            $i=0;
            foreach($str as $key => $value)
            {
                if($i == $limit){break;}
                $value = trim($value);
                if(strlen($value) >= 3)
                {
                        $keywords .= "<a href='".DOMAIN."video_tags/".$this->stringToURL($value).".html' title=\"$value\" class=\"tags\" target='_top' >$value</a> ";
                }
                $i++;
            }
        }
        return $keywords;
    }

    protected function getVideoTags()
    {
        /* Get video tage order by popularity*/
        $sql = "SELECT t.tag, count(t.tag) as cnt FROM tags t
                INNER JOIN video_tag vt ON t.id = vt.tag_id GROUP BY t.tag ORDER BY Random()";

        $rs  = $this->sqliteQuery($sql);
        $str = "";
        foreach($rs as $row)
        {
            if($row['cnt']<=2){$tagStyle = "tag1";}
            if($row['cnt']>=2){$tagStyle = "tag2";}

            $str .= "<a class='tag $tagStyle' href='".DOMAIN."video-tags/".$this->stringToURL($row['tag']).".html'>{$row['tag']}</a>";
        }
        $this->buffer = str_replace("{VIDEOTAGS}", $str, $this->buffer);
    }

    protected function getTagsForVideo($vId)
    {
        /* Get video tage order by popularity*/
        $sql = "SELECT t.tag, count(t.tag) as cnt FROM tags t
                INNER JOIN video_tag vt ON t.id = vt.tag_id WHERE video_id = '$vId' GROUP BY t.tag";

        $rs  = $this->sqliteQuery($sql);
        $str = "";
        foreach($rs as $row)
        {
            $str .= "<a class='tag' href='".DOMAIN."video-tags/".$this->stringToURL($row['tag']).".html'>{$row['tag']}</a>";
        }
        return $str;
    }

    protected function getCountryList()
    {
       $rs = $this->sqliteQuery('select id,name from country');
       return $rs->fetchAll();
    }

    function assign_rand_value($num)
    {
        // accepts 1 - 36
        switch($num)
        {
            case "1":
             $rand_value = "a";
            break;
            case "2":
             $rand_value = "b";
            break;
            case "3":
             $rand_value = "c";
            break;
            case "4":
             $rand_value = "d";
            break;
            case "5":
             $rand_value = "e";
            break;
            case "6":
             $rand_value = "f";
            break;
            case "7":
             $rand_value = "g";
            break;
            case "8":
             $rand_value = "h";
            break;
            case "9":
             $rand_value = "i";
            break;
            case "10":
             $rand_value = "j";
            break;
            case "11":
             $rand_value = "k";
            break;
            case "12":
             $rand_value = "l";
            break;
            case "13":
             $rand_value = "m";
            break;
            case "14":
             $rand_value = "n";
            break;
            case "15":
             $rand_value = "o";
            break;
            case "16":
             $rand_value = "p";
            break;
            case "17":
             $rand_value = "q";
            break;
            case "18":
             $rand_value = "r";
            break;
            case "19":
             $rand_value = "s";
            break;
            case "20":
             $rand_value = "t";
            break;
            case "21":
             $rand_value = "u";
            break;
            case "22":
             $rand_value = "v";
            break;
            case "23":
             $rand_value = "w";
            break;
            case "24":
             $rand_value = "x";
            break;
            case "25":
             $rand_value = "y";
            break;
            case "26":
             $rand_value = "z";
            break;
            case "27":
             $rand_value = "0";
            break;
            case "28":
             $rand_value = "1";
            break;
            case "29":
             $rand_value = "2";
            break;
            case "30":
             $rand_value = "3";
            break;
            case "31":
             $rand_value = "4";
            break;
            case "32":
             $rand_value = "5";
            break;
            case "33":
             $rand_value = "6";
            break;
            case "34":
             $rand_value = "7";
            break;
            case "35":
             $rand_value = "8";
            break;
            case "36":
             $rand_value = "9";
            break;
        }
        return $rand_value;
    }

    function get_rand_string($length)
    {
        if($length>0)
        {
                $rand_id="";
                for($i=1; $i<=$length; $i++)
                {
                        mt_srand((double)microtime() * 1000000);
                        $num = mt_rand(1,36);
                        $rand_id .= $this->assign_rand_value($num);
                }
        }
        return $rand_id;
    }
}
?>