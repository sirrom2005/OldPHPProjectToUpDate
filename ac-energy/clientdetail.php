<?php
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $id,$rtType;
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'clientdetail.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $id = $this->get->intVal('id');
        $rs = $this->db->table("clients CONCAT(title,' ',firstname,' ',lastname) AS clientname, address, telephone, email", 'id=?', $id);
        $this['#info']->bind($rs);
        $this['#address']->html("<b>Address</b><br />".str_replace("\n","<br>",$rs[0]['address']));
        
        if($this->X_acclevel==1){
            $rt = $this->db->execQuery("SELECT a.id,'LED Quote' AS title,CONCAT('tmp/LEDINFO/ledinfo',a.id,'.pdf')AS filename,a.date_added FROM leds_info a
                                        INNER JOIN clients c ON c.id = a.clientid
                                        WHERE c.id = '$id'
                                        UNION
                                        SELECT a.id,'Roof Quote' AS title,CONCAT('tmp/',filename,'/quote.pdf_',a.id) AS filename,a.date_added FROM quote_list a
                                        INNER JOIN clients c ON c.id = a.clientid
                                        WHERE c.id = '$id'
                                        UNION
                                        SELECT a.id,'WH Quote' AS title,CONCAT('tmp/WHINFO/whinfo',a.id,'.pdf')AS filename,a.date_added FROM waterheater_info a
                                        INNER JOIN clients c ON c.id = a.clientid
                                        WHERE c.id = '$id'
                                        ORDER BY date_added DESC");

            $this['#datatable tbody']->bind($rt,array('callback' => array($this,'rowHandler')));
            $this->delegate('a.preview', 'click', NULL, '.downloadPdf'); 
        }else{
            $this['#datatable']->remove();
        }
    }   
    
    public function rowHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass) { 
        $row['filename'] = base64_encode($row['filename']);
        $row['date_added'] = date('l, F d, Y g:m:i a',  strtotime($row['date_added']));
    }
    
    protected function downloadPdf($e){
        $id = $e->value;
        $arr = explode('_', base64_decode($id)); 
        $file = $arr[0];
        if(file_exists($file)){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$file");
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: binary");
            readfile($file);
            exit();
        }else{
            if(isset($arr[1])){
                $this->redirectTo("getpdf.php?id=".$arr[1]);
            }
        }
    }
}
?>