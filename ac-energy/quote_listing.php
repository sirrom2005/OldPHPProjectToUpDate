<?php
require_once 'raxan/pdi/autostart.php';
class Listing extends common {
    protected $updateList = false;
    protected $pgNumber;
    protected $pageSize;
    protected $id;
    
    protected function _config(){
        parent::_config();
        $this->autoAppendView = 'quotelisting.view.php';  // set page view file name
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
        $this->delegate('a.email', '#click', NULL, '.sendEmail');
        $this->delegate('a.pdf', 'click', NULL, '.downloadPdf');
        $this->delegate('a.pdfpreview', 'click', NULL, '.downloadPdfPreview');
        $this->pager->delegate('a','#click', array('callback' => '.changePage', 'autoToggle' => '#imgloader'));
    }
    
    protected function _prerender(){
        if(!$this->isCallback||$this->updateList) {
            $this->loadQuoteList();
            
            $pdf = $this->get->value('pdf');
            if($pdf){
                $pdf = base64_decode($pdf);
                $pdf = base64_encode("tmp/$pdf/quote.pdf");
                $this->flashmsg($this->icon.'PDF file generated click <a target="_blank" style="color:#c00;" href="getpdffile.php?f='.$pdf.'">here</a> to view','fade','rax-box success');
            }
        }
        if($this->X_acclevel!=1){
            $this['.preview']->remove();
            $this['.email']->remove();
            $this['.pdf']->remove();
            $this['.edit']->remove();
        }
    }
    
    protected function loadQuoteList(){
        try
        { 
            $query      = ($this->id)? "WHERE a.id=".$this->id : "" ;
            $rows       = $this->db->query("SELECT count(a.id) FROM quote_list a INNER JOIN clients c on c.id = a.clientid $query");
            $rowCount   = $rows->fetchColumn(0);
            $lower      = (($this->pgNumber-1) * $this->pageSize);
            $offset     = $this->pageSize;

            $rs = $this->db->query("SELECT a.id, CONCAT(c.title,' ',c.firstname,' ',c.lastname) as fullname, c.email, a.placetype, a.filename, a.date_added 
                                    FROM quote_list a
                                    INNER JOIN clients c on c.id = a.clientid 
                                    $query 
                                    ORDER BY a.date_added DESC LIMIT ".$lower.",".$offset );
            
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
            $this->flashmsg($this->icon.$msg.$ex,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    public function rowHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass) {
        $row['filename'] = base64_encode("tmp/".$row['filename']."/quote.pdf");
        $row['date_added'] = date('D, M d, Y - g:m:i a',  strtotime($row['date_added']));
    }
    
    protected function deleteEvent($e)
    {
        $id = $e->intVal();
        $rs = $this->db->table('quote_list filename','id=?',$id);
        
        $rt = $this->db->exec("DELETE q,r FROM quote_list q
                               INNER JOIN roof_section_quote r ON r.quote_id = q.id
                               WHERE q.id = '$id'");
        if($handle = opendir("tmp/{$rs[0]['filename']}/")) {
            while(false !== ($entry = readdir($handle))) {
                @unlink("tmp/{$rs[0]['filename']}/".$entry);
            }
            closedir($handle);
            @rmdir("tmp/{$rs[0]['filename']}/");
            $this->pgNumber   = 1;
            $this->updateList = true;
        }
    }
    
    protected function sendEmail($e)
    {
        $file = $e->value;
        $file = base64_decode($file);
        $id = explode('/',$file);
                
        $rs = $this->db->execQuery("SELECT q.id, CONCAT(c.title,' ',c.firstname,' ',c.lastname) AS fullname, c.email FROM quote_list q
                                    INNER JOIN clients c on c.id = q.clientid
                                    WHERE q.filename = '{$id[1]}'");
        
        if(!file_exists($file)){
            $this->flashmsg($this->icon.'PDF file not generated<br>Click <a href="getpdf.php?id='.$rs[0]['id'].'">here</a> to create pdf file','fade','rax-box error');
            return false;
        }
        
        try{
            $email = $rs[0]['email'];
            $fullname = $rs[0]['fullname'];
            if(!empty($email)){
                $file = base64_encode($file);
                $rt = $this->db->table('template_text detail','id=6');
                $message = str_replace("_DOWNLOADLINK_", "<a href='".SITEADDRESS."getpdffile.php?f=$file'>getpdffile.php?f=$file</a>", $rt[0]['detail']);
                $message = str_replace("_CLIENTNAME_", $fullname, $message);

                $headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
                $headers .= "Reply-To: ".SITE_EMAIL."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                if(mail($email, "IREE SOLAR QUOTE", $message, $headers)){
                    $this->flashmsg($this->icon.'Email sent to '.$fullname,'fade','rax-box success');
                }             
            }else{
                $msg = "Email address not found.";
                $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            }
        }
        catch(Exception $ex)
        {
            $msg = $ex;
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    protected function changePage($e){
        $this->pgNumber = $e->intVal();
        if (!$this->pgNumber) $this->pgNumber = 1;
        $this->updateList = true;
    }
    
    
    protected function downloadPdf($e){
        $id = explode('_',$e->value);
        
        $file = base64_decode($id[0]);
        if(file_exists($file)){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$file");
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: binary");
            readfile($file);
            exit();
        }else{          
            $this->redirectTo("getpdf.php?id=".$id[1]);
        }
    }
    
    protected function downloadPdfPreview($e){
        $id = base64_decode($e->value);
        $ext = explode('/',$id);
        $file = "tmp/{$ext[1]}/inputs.pdf";
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