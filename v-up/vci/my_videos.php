<?php
require_once('raxan/pdi/autostart.php');
class index extends RaxanWebPage
{
    protected $db;
    protected $updateList = false;
    protected $pgNumber, $pageSize;

    protected function _config() {
        $this->pageSize = 10;
        $this->masterTemplate = "views/admin.html";
        $this->degradable = true;;
        // enable or disable debugging
        $this->Raxan->config('debug', true);
        $this->icon = '<span title="Close" class="right close ui-icon ui-icon-close click-cursor"></span>';
    }

    protected function _init(){
        $this->appendView("my_videos.html");
        $this->loadCSS('views/css/admin.css', true);
        $this->loadCSS('master');   // load css framework and default theme
        $this->loadTheme('default'); // load default/theme.css
        $this->connectToBD();
    }

    protected function _load() {		
        //// get current page. Defaults to 1 if 'emp-page-number' is not set
        $this->pgNumber = & $this->data('emp-page-number',1,true);
        // delegate events
        $this->pager->delegate('a','click','.changePage');
        $this->videoList->delegate('a.del','#click','.deleteVideo');
    }

    protected function _prerender() {
        if (!$this->isCallback||$this->updateList) {
            $this->loadVideos();
        }
    }

    protected function _authorize() {
        return true;
    }

    protected function loadVideos()
    {
        // count # of rows in database
	$rowCount = & $this->data('emp-row-count');

        if (!$rowCount) {
            $rows = $this->db->query('select count(*) as total from videos');
            $rowCount = $rows->fetchColumn(0);
        }
        
        if(!$rowCount)
        {
           $this->videoList->html('<center>You have no videos, click <a href="upload.php">here</a> to upload now.</center>');
           return;
        }

        $lower = (($this->pgNumber-1) * $this->pageSize);
        $offset = $this->pageSize;

        $rs = $this->db->query("select * from videos LIMIT ".$lower.",".$offset);
        $this->videoList->bind($rs);

        // setup pager
        $maxpage = ceil($rowCount/$this->pageSize);
        $pages = $this->Raxan->paginate($maxpage,$this->pgNumber,array(
        'tpl' => '<a href="#{VALUE}" title="Page {VALUE}" class="{ROWCLASS}">{VALUE}</a>',
        'itemClass' => 'rax-active-pal',
        'selectClass' => 'rax-selected-pal rax-metalic border1',
        'delimiter'=>'',
        ));
        $this->pager->html($pages);
    }

    protected function changePage($e){
        $this->pgNumber = $e->intVal();
        if (!$this->pgNumber) $this->pgNumber = 1;
    }

    protected function deleteVideo($e)
    {
        try
        {
            $id = $e->intVal() | 0;
            $this->db->tableDelete('videos','id=?',$id);
            $this->updateList = true;
            $this->videoList->updateClient();
            $this->flashmsg($this->icon.'Record successfully removed','fade','rax-box success');
        }
        catch(Exception $e)
        {
            $msg = 'Error while deleting record.';
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$e);
        }
    }

    protected function connectToBD()
    {
       $this->db = $this->Raxan->connect('sqlite:../_nova_core_/data/videouploader.sqlite');
    }
}
?>