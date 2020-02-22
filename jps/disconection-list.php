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
        $this->appendView("disconection-list.html");
    }

    protected function _load() {
        parent::_load();
        // get current page. Defaults to 1 if 'emp-page-number' is not set
        $this->pgNumber = & $this->data('emp-page-number',1,true);
        // delegate events
        $this->pager->delegate('a','#click','.changePage');
        $this->delegate('.history', '#click', NULL, '.viewHistory');
        $this->delegate('#exportCSV','click','.CSVExport');
    }

    protected function _prerender() {
        parent::_prerender();
        $this->pagesize->val($this->pageSize);
        if (!$this->isCallback||$this->updateList) {
            $this->showList();
        }
    }

    protected function _authorize() {
        $rt = parent::_authorize();
        return $rt;
    }

    protected function showList()
    {
        $endOfMonth = date('Y-m-d', mktime(0,0,0,1,25,date('Y')));
        $rows = $this->db->query("SELECT count(*) FROM viewDisconectionListCount
                                  WHERE id in (SELECT id FROM bills
                                  WHERE due_date = '$endOfMonth' AND bill_amount > 1500)");
        $rowCount = $rows->fetchColumn(0);

        $lower = (($this->pgNumber-1) * $this->pageSize);
        $offset = $this->pageSize;

        $sql = "SELECT * FROM viewDisconectionList WHERE id in (SELECT id FROM bills
                WHERE due_date = '$endOfMonth' AND bill_amount > 1500) LIMIT ".$lower.",".$offset;

        $rs = $this->db->query($sql);
        $this->data_grid->bind($rs, array(  'altClass' => 'even',
                                            'callback' => array($this,'rowHandler')));

	// setup*pager //
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

    public function rowHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass) {
        $row['bill_amount'] = '$ '.number_format($row['bill_amount'], 2);
        $row['amount_owed'] = '$ '.number_format($row['amount_owed'], 2);
        if($row['special_customer'] || $row['under_investigation'])
        {
            $row['status'] = "DISCONECTION ON HOLD";
            $row['statusStyle'] = '';
        }
        else
        {
            $row['status'] = "DISCONECT NOW";
            $row['statusStyle'] = 'color:#c00; font-weight:bold;';
        }
    }

    protected function CSVExport()
    {
        $data = $this->db->query("select * from viewDisconectionList where id in (SELECT id FROM bills WHERE due_date = '2011-01-25' AND bill_amount > 1500)");
        $data = $data->fetchAll();
        if($data)
        {
            $file = "list.csv";
            $str = "Premise-Customer, Name, Address, Due-Date, Bill Amount, Amount Owed, Status\n";
            foreach($data as $key => $row)
            {
     // echo "<pre>";print_r($row);exit();
                if($data[$key]['special_customer'] || $data[$key]['under_investigation'])
                {
                    $status = "DISCONECTION ON HOLD";
                    unset($data[$key]);
                }
                else
                {
                    $status = "DISCONECT NOW";
                }
                if(isset($data[$key]))
                {
                    $str .="{$data[$key]['premise']}-{$data[$key]['customer']},{$data[$key]['first_name']} {$data[$key]['last_name']},{$data[$key]['street_name']} {$data[$key]['city_town']} {$data[$key]['parish']},{$data[$key]['due_date']}, $ {$data[$key]['bill_amount']},$ {$data[$key]['amount_owed']}, $status\n";
                }
            }
            header('Content-Type: application/csv');
            header("Content-length: " . strlen($str));
            header('Content-Disposition: attachment; filename="' . $file . '"');
            printf($str);
            exit();
        }

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

    protected function viewHistory($e)
    {
        $this->redirectTo('payment_history.php?id='.$e->intVal());
    }
}
?>