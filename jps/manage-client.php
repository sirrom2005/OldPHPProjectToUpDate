<?php
require_once('raxan/pdi/autostart.php');
class index extends common
{
    protected $userId;
    protected function _config() {
        parent::_config();
    }

    protected function _init(){
        parent::_init();
        $this->appendView("manage-client.html");
    }

    protected function _load() {
        parent::_load();
        $this->userId = $this->get->intVal('id') | 0;
        $this->loadParish();
        $this->loadPropertyType();

        $this->delegate('#btnadd', '#click', NULL, '.addClient');

        if($this->userId)
        {
            $this->btnadd->attr('class','button btnedit right');
            $this->btnadd->val('Edit client');
            $this->loadUserData();
        }
    }

    protected function _prerender() {
        parent::_prerender();
    }

    protected function _authorize() {
        $rt = parent::_authorize();
        return $rt;
    }

    protected function loadParish()
    {
	$rs = $this->db->table('viewParish');
        $this->parish_id->bind($rs);
    }

    protected function loadPropertyType()
    {
        $rs = $this->db->table('property_type');
        $this->property_type_row->bind($rs);
    }

    protected function addClient($e)
    { 
        $valid                  = true;
        $post                   = $this->post;
        $data['first_name']     = $post->value('first_name');
        $data['last_name']      = $post->value('last_name');
        $data['dob']            = $post->value('dob');
        $data['trn']            = $post->value('trn');
        $data['street_name']    = $post->value('street_name');
        $data['city_town']      = $post->value('city_town');
        $data['parish_id']      = $post->value('parish_id');
        $data['property_id']    = $post->value('property_id');
        $data['m_phone']        = $post->value('m_phone');
        $data['h_phone']        = $post->value('h_phone');
        $data['w_phone']        = $post->value('w_phone');
        $data['email']          = $post->value('email');
        $data['special_customer']       = $post->value('special_customer');
        $data['special_customer']       = (empty($data['special_customer']))? 0 : 1;
        $data['special_customer']       = $post->value('under_investigation');
        $data['under_investigation']    = (empty($data['special_customer']))? 0 : 1;
        $id                     = $post->value('id');

        $errorMsg = 'Missing Field(s) detected';
        if(empty($data['first_name'])){ $this->first_name->css('border','solid 1px #c00'); $valid=false; }
        if(empty($data['trn'])){ $this->trn->css('border','solid 1px #c00'); $valid=false; }
        if(empty($data['street_name'])){ $this->street_name->css('border','solid 1px #c00'); $valid=false; }
        if(empty($data['city_town'])){ $this->city_town->css('border','solid 1px #c00'); $valid=false; }
        if(empty($data['dob'])){ $this->dob->css('border','solid 1px #c00'); $valid=false; }
        if(!empty($data['email']))
        {
            if(!@eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $data['email']))
            {
                $errorMsg .= ' <br>Invalid email address';
                $this->email->css('border','solid 1px #c00'); $valid=false;
            }
        }

        if(!$valid)
        {
            $this->flashmsg($this->icon.$errorMsg,'fade','rax-box error');
            $this->frm->updateClient();
            return false;
        }
        
        if($this->userId)
        {
            try
            {
                $rs = $this->db->tableUpdate('clients', $data, 'id=?', $this->userId);
                $msg = 'Client updated.';
            }catch(Exception $ex){
                $msg = 'Error while updating record.';
                $this->flashmsg($this->icon.$msg,'fade','rax-box error');
                $this->Raxan->debug($msg.' '.$ex);
            }
        }
        else
        {
            try
            {
                $data['customer']   = $post->value('property_id').rand(10000,99999);
                $data['premise']    = $post->value('property_id').rand(10000,99999);
                $data['date_added'] = date('Y-m-d');
                $rs = $this->db->tableInsert('clients', $data);
                $msg = 'New client added.';
            }
            catch(Exception $ex){
                $msg = 'Error while inserting record.';
                $this->flashmsg($this->icon.$msg,'fade','rax-box error');
                $this->Raxan->debug($msg.' '.$ex);
            }
        }
        $this->flashmsg($this->icon.$msg,'fade','rax-box alert');
        $this->redirectTo('manage-clients.php');

    }

    protected function loadUserData()
    {
        $rs = $this->db->table('clients', 'id=?', $this->userId);
        $rs = $rs[0];
        $this->frm->inputValues($rs);
    }
}
?>