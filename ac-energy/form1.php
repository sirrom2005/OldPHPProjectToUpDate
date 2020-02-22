<?php
require_once 'raxan/pdi/autostart.php';
class LedForms extends common{
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'form1.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        $this->loadClients();
        $this->delegate("#btn", "click", array('callback' => '.post', 'autoToggle' => '#imgloader'));
        $this->findname->bind('#keyup',array(
            'callback' => '.ajaxNameSearch',
            'delay' => false,
            'autoToggle' => '',
            'serialize' => '#findname',
            'inputCache' => true
        ));
        $this->delegate("a.clientidlink", "#click", null,'.addSelectedClient');
    }
            
    protected function post(){
        $post = $this->post;
        $findname         = $post->textVal("findname");
        $data['clientid'] = $post->textVal("clientid");
        for($i=1;$i<=20;$i++){
            $data["value{$i}"] = $post->textVal("value{$i}");
        }
        $data['date_added'] = date("Y-m-d H:i:s");
        
        $valid = true;
        if(empty($findname)        ){$valid = false;$this->findname->css('border','solid 1px #c00');}
        if(empty($data['clientid'])){$valid = false;$this->clientid->css('border','solid 1px #c00');}
        if(!$valid)
        {
           $this->clientid->updateClient();
           $this->findname->updateClient();
           return false;
        }
        
        try{
            $rt = $this->db->table("clients",'id=?',$data['clientid']);
            $this->db->tableInsert("waterheater_info",$data);
            $id = $this->db->lastInsertId();

            $table = "<style>
                            table,td,th{ border:solid 1px #000; text-align:left;}
                            th{font-weight:bold; font-size:0.8pt;}
                       </style>
                      <h3>Water Heater Form Inputs</h3>
                      <p>".trim($rt[0]['title']." ".$rt[0]['firstname']." ".$rt[0]['lastname']).
                      "<br>".$rt[0]['email'].
                      "<br>".$rt[0]['telephone'].
                      "<br>".str_replace("\r\n", "<br>", trim($rt[0]['address']))."</p>
                      <table width='100%'>
                        <tr>
                            <td>How many persons will use the system daily?</td>
                            <td>{$data['value1']}</td>
                        </tr>
                        <tr>
                            <td>Will we need to drill through the wall, where?</td>
                            <td>{$data['value2']}</td>
                        </tr>
                        <tr>
                            <td>System size</td>
                            <td>{$data['value3']}</td>
                        </tr>
                        <tr>
                            <td>Will the client require an eletrical back up?</td>
                            <td>{$data['value4']}</td>
                        </tr>
                        <tr>
                            <td>Type of System</td>
                            <td>{$data['value5']}</td>
                        </tr>
                        <tr>
                            <td>Will the client require a thermostat system?</td>
                            <td>{$data['value6']}</td>
                        </tr>
                        <tr>
                            <td>Type of Roof</td>
                            <td>{$data['value7']}</td>
                        </tr>
                        <tr>
                            <td>Where will the thermostat be place, Wire run.</td>
                            <td>{$data['value8']}</td>
                        </tr>
                        <tr>
                            <td>Orientation of intended roof for installation</td>
                            <td>{$data['value9']}</td>
                        </tr>
                        <tr>
                            <td>Is there a existing heater? how many?</td>
                            <td>{$data['value10']}</td>
                        </tr>
                        <tr>
                            <td>Where will the pipes be connected to the building</td>
                            <td>{$data['value11']}</td>
                        </tr>
                        <tr>
                            <td>Does the client wish to keep the existing heater?</td>
                            <td>{$data['value12']}</td>
                        </tr>
                        <tr>
                            <td>Addition cold water pipe 10ft length</td>
                            <td>{$data['value13']}</td>
                        </tr>
                        <tr>
                            <td>Does the client want muliple quotation.</td>
                            <td>{$data['value14']}</td>
                        </tr>
                        <tr>
                            <td>Addition hot water pipe 10ft length</td>
                            <td>{$data['value15']}</td>
                        </tr>
                        <tr>
                            <td>How many 10ft length of trucking, How many bends</td>
                            <td>{$data['value16']}</td>
                        </tr>
                        <tr>
                            <td>Available roof space for panel sq/ft</td>
                            <td>{$data['value17']}</td>
                        </tr>
                        <tr>
                            <td>What is the currently monthly KHW usage?</td>
                            <td>{$data['value18']}</td>
                        </tr>
                        <tr>
                            <td>What is their currently dollar value of the JPS bill:</td>
                            <td>{$data['value17']}</td>
                        </tr>
                        <tr>
                            <td>Estimated  lenght of wire run from PV panel to box?</td>
                            <td>{$data['value18']}</td>
                        </tr>
                      </table>";
                            
            $_SESSION['ledtable'] = $table;
            $_SESSION['s']['siteaddress'] = SITEADDRESS;
            $_SESSION['s']['sitename'] = SITE_NAME;
            $_SESSION['s']['siteemail'] = SITE_EMAIL;
            Raxan::removeData('clientId');
            $this->redirectTo("createWHpdf.php?id=$id");
        }
        catch(Exception $ex)
        {
            $msg = $ex;
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}
?>