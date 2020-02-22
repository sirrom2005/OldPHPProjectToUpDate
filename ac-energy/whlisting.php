<?php
require_once 'raxan/pdi/autostart.php';
class Listing extends common {
    protected $updateList = false;
    protected $pgNumber;
    protected $pageSize;
    protected $id;
    
    protected function _config(){
        parent::_config();
        $this->autoAppendView = 'whlisting.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();   
    }

    protected function _load(){
        parent::_load();
        $this->id = $this->get->intVal('id');
        $this->pageSize = & $this->data('emp-page-size',10,true);
        $this->pgNumber = & $this->data('emp-page-number',1,true);
        $this->delegate('a.remove', '#click', NULL, '.deleteEvent');
        $this->delegate('a.preview', 'click', NULL, '.downloadPdf');       
        $this->pager->delegate('a','#click', array('callback' => '.changePage', 'autoToggle' => '#imgloader'));
    }
    
    protected function _prerender(){
        if(!$this->isCallback||$this->updateList) {
            $this->loadList();
        }
        if($this->X_acclevel!=1){
            $this['.preview']->remove();
        }
    }
    
    protected function loadList(){
        try
        { 
            $query      = ($this->id)? "WHERE a.id=".$this->id : "" ;
            $rows       = $this->db->query("SELECT count(a.id) FROM waterheater_info a INNER JOIN clients c on c.id = a.clientid $query");
            $rowCount   = $rows->fetchColumn(0);
            $lower      = (($this->pgNumber-1) * $this->pageSize);
            $offset     = $this->pageSize;

            $rs = $this->db->query("SELECT  a.id, CONCAT(c.title,' ',c.firstname,' ',c.lastname) as fullname, c.email, a.value1,a.value3,a.value4,a.date_added FROM waterheater_info a
                                    INNER JOIN clients c on c.id = a.clientid
                                    $query
                                    ORDER BY a.date_added DESC
                                    LIMIT ".$lower.",".$offset );
            
            $this['#datatable tbody']->bind($rs, array( 'altClass' => 'even',
                                                        'callback' => array($this,'rowHandler')));
            // setup pager
            $maxpage = ceil($rowCount/$this->pageSize);
            $pages = $this->Raxan->paginate($maxpage,$this->pgNumber,array(
            'tpl' => '<a href="#{VALUE}" title="'.$this->Raxan->locale('page').' {VALUE}" class="{ROWCLASS} paginate">{VALUE}</a>',
            'itemClass' => 'rax-active-pal',
            'selectClass' => 'rax-selected-pal rax-metalic border1',
            'delimiter'=>'',
            ));
            $this->pager->html($pages);
            $this['#datatable tbody']->updateClient();
            $this->pager->updateClient();
        }
        catch(Exception $ex)
        {
            $msg = 'Error while loading list';
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    public function rowHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass) {
        $row['date_added'] = date('D, M d, Y - g:m:i a',  strtotime($row['date_added']));
    }
    
    protected function deleteEvent($e)
    {
        $id = $e->intVal();
        if($this->db->tableDelete('waterheater_info','id=?',$id)){    
            @unlink("tmp/WHINFO/whinfo{$id}.pdf");
            $this->pgNumber   = 1;
            $this->updateList = true;
        }
    }
    
    protected function changePage($e){
        $this->pgNumber = $e->intVal();
        if (!$this->pgNumber) $this->pgNumber = 1;
        $this->updateList = true;
    }
       
    protected function downloadPdf($e){
        $id = $e->value;
        
        $file = "tmp/WHINFO/whinfo{$id}.pdf";
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/pdf");
        header("Content-Transfer-Encoding: binary");
        readfile($file);
        exit();
    }
}
?>