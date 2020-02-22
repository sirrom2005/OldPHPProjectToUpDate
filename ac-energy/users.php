<?php
require_once 'raxan/pdi/autostart.php';
class Users extends common{
    protected $updateList = false;
    protected $pgNumber;
    protected $pageSize;
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'users.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->pageSize = & $this->data('emp-page-size',10,true);
        $this->pgNumber = & $this->data('emp-page-number',1,true);
        // delegate events
        $this->pager->delegate('a','#click', array('callback' => '.changePage', 'autoToggle' => '#imgloader'));
        $this->delegate('a.remove', '#click', NULL, '.deleteEvent');
    }
    
    protected function _prerender() {
        if (!$this->isCallback||$this->updateList) {
            $this->loadUser();
        }
    }
        
    protected function loadUser(){
        try
        { 
            $rows       = $this->db->query("SELECT count(a.id) FROM accounts a");
            $rowCount   = $rows->fetchColumn(0);
            $lower      = (($this->pgNumber-1) * $this->pageSize);
            $offset     = $this->pageSize;

            $rs = $this->db->query("SELECT a.id, a.username, CONCAT(a.firstname,' ',a.lastname) AS fullname, a.email, b.name as acc_type FROM accounts a
                                    INNER JOIN acc_level b ON b.id = a.acc_level
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
            $msg = $ex;
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    public function rowHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass) {
    }
    
    protected function changePage($e){
        $this->pgNumber = $e->intVal();
        if (!$this->pgNumber) $this->pgNumber = 1;
        $this->updateList = true;
    }
    
    protected function deleteEvent($e)
    {
        $id = $e->intVal();
        if($id==1){
            $this->flashmsg($this->icon.'This user cannot be deleted.','fade','rax-box error');
            return false;
        }
        $this->db->tableDelete('accounts','id=?',$id);
        $this->pgNumber   = 1;
        $this->updateList = true;
    }
}
?>