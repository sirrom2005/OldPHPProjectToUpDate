<?php
require_once('raxan/pdi/autostart.php');
class manageUser extends common
{
    protected $userId;
    protected function _config() {
        parent::_config();
    }

    protected function _init(){
        parent::_init();
        $this->appendView("manage-user.html");
    }

    protected function _load() {
        parent::_load();
        $this->userId = $this->get->intVal('id') | 0;
        $this->delegate('#btnadd', '#click', NULL, '.addUser');

        $this->loadUserLevel();
        $this->loadParish();

        if($this->userId)
        {
            $this->btnadd->attr('class','button btnedit right');
            $this->btnadd->val('Edit user');
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

    protected function loadUserLevel() {
        $rs = $this->db->table('admin_user_level');
        $this->admin_user_level->bind($rs);
    }

    protected function loadParish() {
        $rs = $this->db->table('parish');
        $rs[0] = array('parish_id' => '0', 'parish' => '-----' );
        $this->parish_id->bind($rs);
    }
    
    protected function addUser($e)
    { 
        $valid                  = true;
        $post                   = $this->post;
        $data['first_name']     = $post->value('first_name');
        $data['last_name']      = $post->value('last_name');
        $data['username']      = $post->value('user_name');
        $data['parish_id']      = $post->value('parish_id');
        $data['email']          = $post->value('email');
        $data['admin_user_level']= $post->value('admin_user_level');
        $id                     = $post->value('id');

        if(empty($data['username'])){ $this->user_name->css('border','solid 1px #c00'); $valid=false; }
        if(!@eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $data['email']))
        {
            $this->email->css('border','solid 1px #c00'); 
            $valid=false;
        }

        $msg = 'Missing/Invalid Field(s) detected<br>';
        if($data['admin_user_level']==3 && $data['parish_id']==0)
        {
            $msg .= 'Please select parish for the parish officer';
            $this->parish_id->css('border','solid 1px #c00');
            $valid=false;
        }

        if(!$valid)
        {
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->frm->updateClient();
            return false;
        }
        
        if($this->userId)
        {
            if($id==1)
            {
                $this->flashmsg($this->icon.'This user cannot be edited','fade','rax-box error');
                return false;
            }

            try
            {
                $rs = $this->db->tableUpdate('admin_user', $data, 'id=?', $this->userId);
                $msg = 'User updated.';
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
                $data['date_added'] = date('Y-m-d');
                $data['password'] = "password";
                $rs = $this->db->tableInsert('admin_user', $data);
                $msg = 'New user added.';
            }
            catch(Exception $ex){
                $msg = 'Error while inserting record.';
                $this->flashmsg($this->icon.$msg,'fade','rax-box error');
                $this->Raxan->debug($msg.' '.$ex);
            }
        }
        $this->flashmsg($this->icon.$msg,'fade','rax-box alert');
        $this->redirectTo('manage-users.php');
    }

    protected function loadUserData()
    {
        $rs = $this->db->table('viewAdminList', 'id=?', $this->userId);
        $rs = $rs[0];
        $this->frm->inputValues($rs);
    }
}
?>