<?php
/**
 * Coprorate Moneyline Dashbaord
 * @author: Raymond Irving
 * @date: 10-July-2009
 */


require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\SecureWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;


class DashboardPage extends SecureWebPageController {

    protected $moduleId = 28; // DASHBOARD
    
    // page information
    protected $page, $pageSize, $files;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'dashboard.view.php';
    }

    protected function _load() {
        parent::_load();       

        // bind events
        $this['#pagesize']->bind('change','.change_pagesize');
        $this->findById('pager')->delegate('a','click','.change_page');
        $this->delegate('.file-refresh','click','.refresh_page');

        // get last page number
        $this->page = & $this->data('page',1,true);
        $this->pageSize = & Raxan::data(DataKeys::DOCLIB_PAGE_SIZE,20,true);
        if ($this->pageSize<=0) $this->pageSize = 20;
        $this->files = & $this->data('files',array(),true);

        // use javascript to show the app
        c('.applets a')->live('click',_fn('
            $("#doc-libs").hide();
            $("#applet-viewer").show();
            $("#applet-title").html($(this).text());
        '));

        $this->loadUserApplets();

        // check global/session msgPassThru
        $msg = '';
        if (isset($GLOBALS[DataKeys::MSGPASSTHRU]) || ($msg = Raxan::data(DataKeys::MSGPASSTHRU))) {
            $msg = $msg ? $msg : $GLOBALS[DataKeys::MSGPASSTHRU];
            Raxan::removeData(DataKeys::MSGPASSTHRU);
            $this->flashmsg($msg,'bounce','rax-box notice','msgbox');
        }

    }

    protected function _prerender() {
        parent::_prerender();
        // set page size on control
        $this->findById('pagesize')->val($this->pageSize);
        $this->loadDocuments(); // load users
    }

    // change page size event
    protected function change_pagesize($e){
        $this->pageSize = $e->intVal() | 0;
        if ($this->pageSize <= 0) $this->pageSize = 20;
    }

    // change page event
    protected function change_page($e){
        $this->page = $e->intVal() | 0;
        if ($this->page <= 0) $this->page = 1;
    }

    // refresh page
    protected function refresh_page($e) {
        $this->files = null;
        $this->page = 1;
    }

    protected function loadUserApplets(){
        try {
            $applets = User::getUserApplets();
            if (empty($applets)) $this['.applets']->html('');
            else {
                if (!is_array($applets)) $wsapplets = array($applets);
                $this['.applets']->bind($applets);
            }
        }
        catch(DataModelException $ex) {
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code,$params);
            $this->flashmsg($msg,'fade','rax-box error','msgbox');  // flash msg to msgbox
            $this['.applets']->remove();
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }


    }

    /**
     * Load Document Library
     */
    protected function loadDocuments() {

        $id = 0; $files = array(); $guids = array();
        if ($this->files) $files = $this->files; // use cached list
        else  {
            try {
                // get documents
                $docs = User::getUserDocuments();
                // filter & sort documents
                if (isset($docs->FileData)) {
                    $wsfiles = $docs->FileData;
                    if ($wsfiles && !is_array($wsfiles)) $wsfiles = array($wsfiles);
                    foreach ($wsfiles as $file) {
                        $id++;
                        $file = Shared::cloneObject($file,'Name,Guid,Url,Title,Description,DateModified',true);
                        $file['Description'] = strip_tags($file['Description']);
                        $file['Title'] = $file['Title'] ? strip_tags($file['Title']) : strip_tags($file['Name']);
                        $tmp = explode('/',trim(dirname($file['Url'])));
                        $file['BaseUrl'] = $tmp[0];
                        //$file['SortKey'] = $file['BaseUrl'].' '.$file['Title'];
                        $ext = explode('.',$file['Name']);
                        $ext = trim(array_pop($ext));
                        if (strpos('jpg,gif,png,bmp,jpeg',$ext)!==false) $file['image']= 'page_white_picture.png';
                        elseif (strpos('zip,tar,gzip',$ext)!==false) $file['image']= 'page_white_compressed.png';
                        elseif (strpos('doc,ppt,mdb,xls',$ext)!==false) $file['image']= 'page_white_office.png';
                        elseif (strpos('pdf',$ext)!==false) $file['image']= 'page_white_acrobat.png';
                        else $file['image'] = 'page_white.png';
                        $file['id'] = $id;
                        $files[] = $file;
                        $guids[$id] = $file['Url'].'|'.$file['Name'].'|'.$ext.'|'.$file['Guid'].'|'.$file['DateModified'].'|'.$file['Title'];
                    }
                    Raxan::data(DataKeys::DOCLIB_DOCUMENT_GUIDS, $guids); // save guids
                    //$files = Shared::sortRecord($files, 'SortKey');
                    $this->data('files',$files);
                }
            }
            catch(DataModelException $ex) {
                $code = $ex->getLastErrorCode();
                $params = $ex->getLastErrorCodeParams();
                $msg = Shared::getErrorMessage($code,$params);
                $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg;
                $this->flashmsg($msg,'fade','rax-box error','msgbox');  // flash msg to msgbox
                $this->findById('doc-lib-records')->remove();
                return;
            }
            catch (Exception $ex){
                // general exception
                Raxan::log($ex,'ERROR','Document Library');  // log error
                $msg = Raxan::locale('SYSERR');
                $this->flashmsg($msg,'fade','rax-box error','msgbox');
                $this->findById('doc-lib-records')->remove();
                return;
            }
        }

        // Render documents
        $total = count($files);
        $pageSize = $this->pageSize;
        $maxpage = ceil($total/$pageSize);
        if ($this->page > $maxpage) $this->page = $maxpage;
        $offset = ($this->page-1) * $pageSize;
        $files = array_slice($files, $offset, $pageSize);

        $this['#doc-lib-records tbody']->bind($files,array(
            'callback' => array($this,'docLibRowRender')
        ));
        $this['#doc-lib-records tbody tr:even']->addClass('even');

        // setup pager
        $tpl = $this->findById('pager')->html();
        $pager = 'Page: '.Raxan::paginate($maxpage,$this->page,array(
            'tpl' => $tpl,
            'tplFirst' => '<a href="#{FIRST}" title="First">First</a> .'.$tpl,
            'tplLast' => $tpl.' . <a href="#{LAST}" title="Last">Last</a>',
            'tplSelected' =>'<span class="lightgray hlf-pad">{VALUE}</span>', 'delimiter'=>'.',
        ));
        $this['#pager']->html($maxpage ? $pager : '');

        // hide page size selector
        if ($total==0) {
            $this->findById('pagesize')->remove();
            $this->find('#doc-lib-records tbody td')->html(Raxan::locale('documents.not.found'));
        }

        // save page info
        $this->data('page', $this->page);
        Raxan::data(DataKeys::DOCLIB_PAGE_SIZE,$this->pageSize);

        // toggle sub-titles
        c('#doc-lib-records .subtitle')->click(_fn('
            var folder = $(this).toggleClass("collapse").attr("rel");
            $("#doc-lib-records ."+folder).toggle();
        '));

    }

    /**
     * Document Library row render function
     */
    public function docLibRowRender($row, $index, $tpl){
        static $oldurl,$folder; $html = '';
        if (!$folder) $folder = 1;
        $url = $row['BaseUrl'];
        if ($url!=$oldurl) { // setup subtitle
            $folder++;
            $oldurl = $url;
            $html = '<tr class="subtitle click-cursor" rel="fldr'.$folder.'"><td colspan="4" title="Click to Collapse/Expand">'.$url.'</td></tr>';
        }
        $row['folder'] = 'fldr'.$folder; // used to collapse/expand rows
        $v = array_values($row);
        $k = explode(',','{'.implode('},{',array_keys($row)).'},{ROWCOUNT}');
        return $html.str_replace($k,$v,$tpl);
    }
    
}




?>