<?php
require_once 'raxan/pdi/autostart.php';
class Listing extends common {
    protected $updateList = false;
    protected $pgNumber;
    protected $pageSize;
    
    protected function _config(){
        parent::_config();
        $this->autoAppendView = 'clients.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();   
    }

    protected function _load(){
        parent::_load();
        $this->pageSize = & $this->data('emp-page-size',10,true);
        $this->pgNumber = & $this->data('emp-page-number',1,true);
        $this->delegate('a.remove', '#click', NULL, '.deleteEvent');  
        $this->pager->delegate('a','#click', array('callback' => '.changePage', 'autoToggle' => '#imgloader'));
        $this->delegate('#sbtn', 'click', NULL, '.findClientName');
    }
    
    protected function _prerender(){
        if(!$this->isCallback||$this->updateList) {
            $this->loadList();
        }
    }
    
    protected function loadList(){
        try
        { 
            $stext = $this->data('sText');
            $query = (!empty($stext))? "WHERE a.firstname LIKE '%$stext%' OR a.lastname LIKE '%$stext%'" : '' ;
            $rows       = $this->db->query("SELECT count(a.id) FROM clients a $query");
            $rowCount   = $rows->fetchColumn(0);
            $lower      = (($this->pgNumber-1) * $this->pageSize);
            $offset     = $this->pageSize;

            $rs = $this->db->query("SELECT * FROM clients a $query
                                    ORDER BY date_added DESC
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
    
    protected function findClientName()
    {
        $this->data('sText', $this['#stext']->val());
    }
    
    protected function deleteEvent($e)
    {
        $id = $e->intVal();
        if($this->db->tableDelete('clients','id=?',$id)){    
            $this->pgNumber   = 1;
            $this->updateList = true;
        }
    }
    
    protected function changePage($e){
        $this->pgNumber = $e->intVal();
        if (!$this->pgNumber) $this->pgNumber = 1;
        $this->updateList = true;
    }
}
?>