<?php
require_once('raxan/pdi/autostart.php');
class manageUser extends common
{
    protected $updateList = false;

    protected function _config() {
        parent::_config();
    }

    protected function _init(){
        parent::_init();
        $this->appendView("manage-users.html");
    }

    protected function _load() {
        parent::_load();
        $this->delegate('.edit', '#click', NULL, '.editUser');
        $this->delegate('.delete', '#click', NULL, '.deleteUser');
        $this->delegate('.resetpasswd', '#click', NULL, '.resetUserPass');
    }

    protected function _prerender() {
        parent::_prerender();
        if (!$this->isCallback||$this->updateList) {
            $this->loadUsers();
        }
    }

    protected function _authorize() {
        $rt = parent::_authorize();
        return $rt;
    }

    protected function loadUsers()
    {         
        $rs = $this->db->table("viewAdminList");
        $this->data_grid->bind($rs, array(  'altClass' => 'even',
                                            'callback' => array($this,'rowHandler')));
        $this->data_grid->updateClient();
    }

    public function rowHandler(&$row, $index, $tpl, $tplType, &$fmt, $cssClass) {
        if(empty($row['last_login_date']))
        {
            $row['last_login_date'] = 'Never';
        }
        if(empty($row['parish']))
        {
            $row['parish'] = 'All parishes';
        }
    }

    protected function editUser($e)
    {
        $this->redirectTo('manage-user.php?id='.$e->intVal());
    }

    protected function deleteUser($e) {
        $id = $e->intVal();
        if($id==1)
        {
            $this->flashmsg($this->icon.'This user cannot be delete','fade','rax-box error');
            return false;
        }
        $this->db->tableDelete('admin_user','id=?',$id);
        $this->updateList = true;
    }

    protected function resetUserPass($e) {
        $id = $e->intVal();
        try
        {
            $data['password'] = $this->get_rand_string(6);
            $rs = $this->db->tableUpdate('admin_user', $data, 'id=?', $id); 
            /*email info to user*/
            $this->flashmsg($this->icon.'Email send to user with new login informatiion','fade','rax-box alert');
        }catch(Exception $ex){
            $msg = 'Error while updating record.';
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }

    protected function assign_rand_value($num)
    {
	// accepts 1 - 36
	  switch($num)
	  {
		case "1":
		 $rand_value = "a";
		break;
		case "2":
		 $rand_value = "b";
		break;
		case "3":
		 $rand_value = "c";
		break;
		case "4":
		 $rand_value = "d";
		break;
		case "5":
		 $rand_value = "e";
		break;
		case "6":
		 $rand_value = "f";
		break;
		case "7":
		 $rand_value = "g";
		break;
		case "8":
		 $rand_value = "h";
		break;
		case "9":
		 $rand_value = "i";
		break;
		case "10":
		 $rand_value = "j";
		break;
		case "11":
		 $rand_value = "k";
		break;
		case "12":
		 $rand_value = "l";
		break;
		case "13":
		 $rand_value = "m";
		break;
		case "14":
		 $rand_value = "n";
		break;
		case "15":
		 $rand_value = "o";
		break;
		case "16":
		 $rand_value = "p";
		break;
		case "17":
		 $rand_value = "q";
		break;
		case "18":
		 $rand_value = "r";
		break;
		case "19":
		 $rand_value = "s";
		break;
		case "20":
		 $rand_value = "t";
		break;
		case "21":
		 $rand_value = "u";
		break;
		case "22":
		 $rand_value = "v";
		break;
		case "23":
		 $rand_value = "w";
		break;
		case "24":
		 $rand_value = "x";
		break;
		case "25":
		 $rand_value = "y";
		break;
		case "26":
		 $rand_value = "z";
		break;
		case "27":
		 $rand_value = "0";
		break;
		case "28":
		 $rand_value = "1";
		break;
		case "29":
		 $rand_value = "2";
		break;
		case "30":
		 $rand_value = "3";
		break;
		case "31":
		 $rand_value = "4";
		break;
		case "32":
		 $rand_value = "5";
		break;
		case "33":
		 $rand_value = "6";
		break;
		case "34":
		 $rand_value = "7";
		break;
		case "35":
		 $rand_value = "8";
		break;
		case "36":
		 $rand_value = "9";
		break;
	  }
	return $rand_value;
	}

	protected function get_rand_string($length)
	{
            if($length>0)
            {
                $rand_id="";
                for($i=1; $i<=$length; $i++)
                {
                    mt_srand((double)microtime() * 1000000);
                    $num = mt_rand(1,36);
                    $rand_id .= $this->assign_rand_value($num);
                }
            }
            return $rand_id;
	}
}
?>