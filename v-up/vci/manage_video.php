<?php
session_start();
require_once('raxan/pdi/autostart.php');
class index extends RaxanWebPage
{
    protected $db;
    protected $videoId;


    protected function _config() {
        $this->pageSize = 10;
        $this->masterTemplate = "views/admin.html";
        $this->degradable = true;;
        // enable or disable debugging
        $this->Raxan->config('debug', true);
        $this->icon = '<span title="Close" class="right close ui-icon ui-icon-close click-cursor"></span>';
    }

    protected function _init(){
        $this->appendView("manage_video.html");
        $this->loadCSS('views/css/admin.css', true);
        $this->loadCSS('master');   // load css framework and default theme
        $this->loadTheme('default'); // load default/theme.css
        $this->connectToBD();
    }

    protected function _load(){
        $this->btn->val('Update');
        $this->delegate('#btn', '#click', '.eventUpdateVideo');
        
        if(isset($_SESSION['VIDEODATA']) && !empty($_SESSION['VIDEODATA']))
        {
            //Add new video to DB
            $this->db->tableInsert('videos',$_SESSION['VIDEODATA']);
            $this->videoId = $this->db->lastInsertId();
            Raxan::data('videoId', $this->videoId);
            unset($_SESSION['VIDEODATA']);
        }
        else
        {
            $id = $this->get->intVal('id');
            $this->videoId = (!empty($id))? $id : Raxan::data('videoId');           
            if(empty($this->videoId)){ $this->redirectTo('my_videos.php'); }
        }
        
        $this->loadCategoryList();
    }

    protected function eventUpdateVideo()
    {
        $post                   = $this->post;
        $data['title']          = $post->textVal('title');
        //$data['tags']           = $post->textVal('tags');
        $data['category_id']    = $post->textVal('category_id');
        $data['description']    = $post->textVal('description');
        $data['enabled']        = $post->intVal('enabled');
        $data['explicit']       = $post->intVal('explicit');
        $data['url_title']      = $post->textVal('url_title');
        //$data['meta_desc']      = $post->textVal('meta_desc');

        $valid = true;
        $msg = 'Missing/Invalid Field(s) detected';
        if( empty($data['title']) ){ $this->title->css('border','solid 1px #f00'); $valid=false; }
        //if( empty($data['tags']) ){ $this->tags->css('border','solid 1px #f00'); $valid=false; }
        if( empty($data['category_id']) ){ $this->category_id->css('border','solid 1px #f00'); $valid=false; }
        if( empty($data['description']) ){ $this->description->css('border','solid 1px #f00'); $valid=false; }
        
        if(!$valid)
        {
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->frm->inputValues($data);
            $this->frm->updateClient();
            return false;
        }

        try
        {
            $this->db->tableUpdate('videos',$data,'id=?',$this->videoId);
            Raxan::removeData('videoId');
            $this->redirectTo('my_videos.php');
        }
        catch(Exception $ex)
        {
            $msg = 'Error while updating record.';
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }

    protected function _authorize() {
        return true;
    }

    protected function loadCategoryList()
    {
        $rs = $this->db->table('categories');
        $this->category_id->bind($rs);
    }

    protected function connectToBD()
    {
       $this->db = $this->Raxan->connect('sqlite:../_nova_core_/data/videouploader.sqlite');
    }
}
?>