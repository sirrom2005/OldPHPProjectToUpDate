<?php
require_once('raxan/pdi/autostart.php');
class index extends common
{
    protected $updateList = false;
    protected $pgNumber;
    public $pageSize;

    protected function _config() {
        parent::_config();
    }

    protected function _init(){
        parent::_init();
        $this->appendView("manage-clients.html");
    }

    protected function _load() {
        parent::_load();
        $this->delegate('.edit', '#click', NULL, '.editClient');
        $this->delegate('.delete', '#click', NULL, '.deletClient');
        $this->delegate('.history', '#click', NULL, '.viewHistory');
        $this->loadPropertyType();

        // get current page. Defaults to 1 if 'emp-page-number' is not set
        $this->pgNumber = & $this->data('emp-page-number',1,true);
        // delegate events
        $this->pager->delegate('a','#click','.changePage');

        // form search
       $this->fname->bind('#keydown',array(
            'callback' => '.loadClients',
            'delay' => 400,
            'autoToggle' => '',
            'serialize' => '#frm',
            'inputCache' => true
        ));
        $this->lname->bind('#keydown',array(
            'callback' => '.loadClients',
            'delay' => 400,
            'autoToggle' => '',
            'serialize' => '#frm',
            'inputCache' => true
        ));
        $this->premise->bind('#keydown',array(
            'callback' => '.loadClients',
            'delay' => 400,
            'autoToggle' => '',
            'serialize' => '#frm',
            'inputCache' => true
        ));
        $this->customer->bind('#keydown',array(
            'callback' => '.loadClients',
            'delay' => 400,
            'autoToggle' => '',
            'serialize' => '#frm',
            'inputCache' => true
        ));
        $this->trn->bind('#keydown',array(
            'callback' => '.loadClients',
            'delay' => 400,
            'autoToggle' => '',
            'serialize' => '#frm',
            'inputCache' => true
        ));
       $this->property_type->bind('#change',array(
            'callback' => '.loadClients',
            'delay' => 100,
            'autoToggle' => '',
            'serialize' => '#frm',
            'inputCache' => true
        ));

        /*$this['.edit']->remove();
        $this['.delete']->remove();
        $this['.history']->remove();*/
    }

    protected function _prerender() {
        parent::_prerender();
        $this->pagesize->val($this->pageSize);
        if (!$this->isCallback||$this->updateList) {
            $this->loadClients();
        }
    }

    protected function _authorize() {
        $rt = parent::_authorize();
        return $rt;
    }

    protected function loadPropertyType()
    {
        $rs = $this->db->table('property_type');
        //Add default row to the list
        $rs[] = array('id' => '0','property_id' => '', 'property_type' => 'ALL');
        sort($rs);
        $this->property_type->bind($rs);
    }

    protected function loadClients()
    {         
        $fname      = $this->fname->val();
        $lname      = $this->lname->val();
        $premise    = $this->premise->val();
        $customer   = $this->customer->val();
        $trn        = $this->trn->val();
        $proptype   = $this->property_type->val();

        $query      = "where c.first_name like '%$fname%' and
                        c.last_name like '%$lname%' and
                        c.premise like '%$premise%' and
                        c.customer like '%$customer%' and
                        c.trn like '%$trn%' and
                        c.property_id like '%$proptype%'";

        $rows = $this->db->query("select count(*) as total from clients c $query");
        $rowCount = $rows->fetchColumn(0);

        $lower = (($this->pgNumber-1) * $this->pageSize);
        $offset = $this->pageSize;

        $rs = $this->db->query("select c.*, p.property_type from clients c inner join property_type p on c.property_id = p.property_id $query LIMIT ".$lower.",".$offset );
        $this->data_grid->bind($rs, array('altClass' => 'even'));
        
        // setup pager
        $maxpage = ceil($rowCount/$this->pageSize);
        $pages = $this->Raxan->paginate($maxpage,$this->pgNumber,array(
        'tpl' => '<a href="#{VALUE}" title="Page {VALUE}" class="{ROWCLASS}">{VALUE}</a>',
        'itemClass' => 'rax-active-pal',
        'selectClass' => 'rax-selected-pal rax-metalic border1',
        'delimiter'=>'',
        ));
        $this->pager->html($pages);
        
        $this->data_grid->updateClient(); // update list on client when in ajax mode
        $this->pager->updateClient();
    }

    protected function changePage($e){
        $this->pgNumber = $e->intVal();
        if (!$this->pgNumber) $this->pgNumber = 1;
        $this->updateList = true;
    }

    protected function pageSize($e){
        $this->pageSize = $e->intVal();
        if(!$this->pageSize) $this->pageSize = 20;
        $this->pgNumber = 1;
        $_SESSION['PAGESIZE'] = $this->pageSize;
    }

    protected function editClient($e)
    {
        $this->redirectTo('manage-client.php?id='.$e->intVal());
    }

    protected function deletClient($e) {
        $id = $e->intVal();
        $this->db->tableDelete('clients','id=?',$id);
        $this->pgNumber = 1;
        $this->updateList = true;
    }

    protected function viewHistory($e)
    {
        $this->redirectTo('payment_history.php?id='.$e->intVal());
    }
}
?>