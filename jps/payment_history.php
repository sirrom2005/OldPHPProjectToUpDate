<?php
require_once('raxan/pdi/autostart.php');
class paymentHistory extends common
{
    protected $updateList = false;
    protected $pgNumber;
    public $pageSize;

    protected function _config() {
        parent::_config();
    }

    protected function _init(){
        parent::_init();
        $this->appendView("payment_history.html");
    }

    protected function _load() {
        parent::_load();
        $this->loadClientInfo();
        $this->loadBillHistory();

    }

    protected function _prerender() {
        parent::_prerender();
    }

    protected function _authorize() {
        $rt = parent::_authorize();
        return $rt;
    }

    protected function loadClientInfo()
    {
        $id = $this->get->intVal('id');
        $rs = $this->db->query("SELECT c.premise, c.customer, c.first_name, 
                                c.last_name, c.trn, c.street_name, c.city_town, 
                                c.special_customer, c.under_investigation, 
                                pa.parish, p.property_type FROM clients c 
                                INNER JOIN property_type p ON c.property_id = p.property_id
                                INNER JOIN parish pa ON pa.parish_id = c.parish_id
                                WHERE c.id = $id");
        $this->userform->bind($rs, array('callback' => array($this,'rowHandler')));
    }

    protected function loadBillHistory()
    {
        $id = $this->get->intVal('id');
        $rs = $this->db->query("SELECT b.due_date, b.bill_amount, bp.payment_date, bp.amount_paid  FROM bills b
                                INNER JOIN bill_payment bp ON bp.bill_id = b.id
                                WHERE b.client_id = $id");
        $this->data_grid->bind($rs, array( 'altClass' => 'even',
                                           'callback' => array($this,'rowCellHandler')));
    }

    public function rowHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass)
    {
        $row['under_investigation'] = ($row['under_investigation'])?"Yes" : "No";
        $row['special_customer']    = ($row['special_customer'])?"Yes" : "No";
    }

    public function rowCellHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass)
    {
        $row['bill_amount'] = '$ '.number_format($row['bill_amount'], 2);
        $row['amount_paid'] = '$ '.number_format($row['amount_paid'], 2);
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
}
?>