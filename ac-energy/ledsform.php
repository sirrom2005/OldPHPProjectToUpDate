<?php
require_once 'raxan/pdi/autostart.php';
class LedForms extends common{
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'ledsform.view.php';  // set page view file name
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
        $findname                       = $post->textVal("findname");
        $data['clientid']               = $post->textVal("clientid");
        $data['colour_tem']             = $post->textVal("colour_tem");
        $data['a19_light_bulb_cnt']     = $post->textVal("a19_light_bulb_cnt");
        $data['down_lights_cnt']        = $post->textVal("down_lights_cnt");
        $data['tube_4ft_fixtures_cnt']  = $post->intVal("tube_4ft_fixtures_cnt");
        $data['tube_2ft_fixtures_cnt']  = $post->textVal("tube_2ft_fixtures_cnt");
        $data['troffers_4ft_cnt']       = $post->textVal("troffers_4ft_cnt");
        $data['outdoor_floodlights_cnt']= $post->textVal("outdoor_floodlights_cnt");
        $data['street_lights_cnt']      = $post->textVal("street_lights_cnt");
        $data['date_added']             = date("Y-m-d H:i:s");
        
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
            $this->db->tableInsert("leds_info",$data);
            $id = $this->db->lastInsertId();
            $table = "<style>
                            table,td,th{ border:solid 1px #000; text-align:left;}
                            th{font-weight:bold; font-size:0.8pt;}
                      </style><h3>LED Form Inputs</h3>
                      <p>".trim($rt[0]['title']." ".$rt[0]['firstname']." ".$rt[0]['lastname']).
                      "<br>".$rt[0]['email'].
                      "<br>".$rt[0]['telephone'].
                      "<br>".str_replace("\r\n", "<br>", trim($rt[0]['address'])).                      
                      "</p>
                      <table width='100%'>
                        <tr>
                            <td>Colour Temperature?</td>
                            <td>{$data['colour_tem']}</td>
                        </tr>
                        <tr>
                            <td>How many A19 light bulb fixtures?</td>
                            <td>{$data['a19_light_bulb_cnt']}</td>
                        </tr>
                        <tr>
                            <td>How many down lights?</td>
                            <td>{$data['down_lights_cnt']}</td>
                        </tr>
                        <tr>
                            <td>How many 4ft tube fixtures?</td>
                            <td>{$data['tube_4ft_fixtures_cnt']}</td>
                        </tr>
                        <tr>
                            <td>How many 2ft tube fixtures?</td>
                            <td>{$data['tube_2ft_fixtures_cnt']}</td>
                        </tr>
                        <tr>
                            <td>How many 4ft troffers?</td>
                            <td>{$data['troffers_4ft_cnt']}</td>
                        </tr>
                        <tr>
                            <td>How many outdoor floodlights?</td>
                            <td>{$data['outdoor_floodlights_cnt']}</td>
                        </tr>
                        <tr>
                            <td>How many street lights?</td>
                            <td>{$data['street_lights_cnt']}</td>
                        </tr>
                      </table>";
            $_SESSION['ledtable'] = $table;
            $_SESSION['s']['siteaddress'] = SITEADDRESS;
            $_SESSION['s']['sitename'] = SITE_NAME;
            $_SESSION['s']['siteemail'] = SITE_EMAIL;
            
            Raxan::removeData('clientId');
            $this->redirectTo("createledpdf.php?id=$id");
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