<?php

require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\SecureWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;


class DownloadPage extends SecureWebPageController {

    protected $moduleId = 30; // DOWNLOAD
    protected $cacheTimeout;

    protected function _load() {
        parent::_load();
        $id = $this->get->intVal('id') | 0;
        $guids = Raxan::data(DataKeys::DOCLIB_DOCUMENT_GUIDS);

        $this->cacheTimeout = Raxan::config('cache.ttl');

        if (empty($guids[$id]))  {
            Raxan::sendError(404); // send 404 error to client
        }
        else {
            $content = '';
            
            // get file info
            $file = explode('|',$guids[$id]);
            $fileUrl = $file[0]; $fileName = $file[1];
            $ext = $file[2]; $guid = $file[3]; 
            $dateModified = $file[4] ? strtotime($file[4]) : null; // get date modified
            $fileTitle = $file[5];    // get file title
            $cache = Raxan::config('cache.path');
            $isWriteable = is_writable($cache);
            $file = $cache.'csf.doclib.'.$guid.'.'.crc32($ext);
            $ttl = $this->cacheTimeout * 60;
            
            // check for cache file
            $filemtime = file_exists($file) ? filemtime($file) : 0;
            if ( $filemtime && ($dateModified <= $filemtime) && (time()-$filemtime)<$ttl) {
                $content = $this->cacheGetContents($file);
            }
            else {
                // connect to web service
                try {
                    // download documents
                    $fileContent = User::downloadDocument($fileUrl);
                    if (empty($fileContent)) {
                        Raxan::sendError(404); // send 404 error to client
                    }
                    else {
                        $content = base64_decode($fileContent); // decode content
                        // create cache of file
                        if ($isWriteable) $this->cachePutContents($file,$content);
                    }

                } 
                catch(DataModelException $ex) {
                    // data model exception
                    $code = $ex->getLastErrorCode();
                    $params = $ex->getLastErrorCodeParams();
                    $msg = Shared::getErrorMessage($code, $params);
                    $msg = '<strong>'.Raxan::locale('request.failed').' for Document <span style="color:black">\''.$fileTitle.'\'</span></strong>:<br />'.$msg;
                    Raxan::data(DataKeys::MSGPASSTHRU,$msg);
                    $this->redirectTo('index.php'); // transfer to index page
                }
                catch(Exception $ex) {
                    $err = $ex->getTraceAsString();
                    Raxan::log($err,'ERROR','Document Library');  // log error
                    $msg = Raxan::locale('SYSERR');
                    $msg = '<strong>'.Raxan::locale('request.failed').' for Document <span style="color:black">\''.$fileTitle.'\'</span></strong>:<br />'.$msg;
                    Raxan::data(DataKeys::MSGPASSTHRU,$msg);
                    $this->redirectTo('index.php'); // transfer to index page
                }
    
            }

            switch ($ext) {
                case 'pdf': $type = 'application/pdf'; break;
                case 'zip': $type = 'application/zip'; break;
                case 'gif': $type = 'image/gif'; break;
                case 'wmv': $type = 'video/x-ms-wmv'; break;
                case 'txt': $type = 'text/plain'; break;
                case 'html': case 'htm': $type = 'text/html'; break;
                case 'jpg': case 'jpeg': $type = 'image/jpeg'; break;
                case 'ppt': case 'pptx': $type = 'application/vnd.ms-powerpoint'; break;
                case 'doc': case 'docx': $type = 'application/msword'; break;
                case 'xls': case 'xlsx': $type = 'application/vnd.ms-excel'; break;
                case 'flv': case 'swf': $type = 'application/x-shockwave-flash'; break;
                case 'mp3': $type='audio/mpeg'; break;
                case 'wav': $type='audio/x-wav'; break;
                case 'mpeg': case 'mpg': case 'mpe': $type='video/mpeg'; break;
                case 'mov': $type='video/quicktime'; break;
                case 'avi': $type='video/x-msvideo'; break;
                default: $type = 'application/octet-stream'; break;

            }


            if (c()->browser()->isMSIE) { // fix IE issues
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            }
            header('Content-Type:'.$type);
            header('Content-Disposition: attachment; filename='.$fileName.';');
            header('Content-Transfer-Encoding: binary');
            echo $content;
            flush();

            // purge unused documents
            if ($isWriteable && rand(1,10)>6) {
                $dh = dir($cache);
                while ($file = $dh->read()) {
                    if ($file!='.'&& $file!='..' && strpos($file,'csf.doclib.')!==false && (time()-filemtime($cache.$file))>$ttl) {
                        @unlink($cache.$file);
                    }
                }
            }

            exit();

        }
    }

    /**
     * Get cached content - used shared locking. timeout in 0.5 sec
     * @param string $filename
     * @return mixed
     */
    protected function cacheGetContents($filename){
        $retry = 0;
        $return = false;

        if($filename && is_string($filename)){
            if(($handle = @fopen($filename, 'r'))){
                while (!$return && $retry <= 1) {
                    $retry++;
                    if (!flock($handle, LOCK_SH)) usleep(round(rand(1, 100)*1000));
                    else {
                        if(($return = file_get_contents($filename))){
                            flock($handle, LOCK_UN);
                        }
                    }
                }
                fclose($handle);
            }
        }
        return $return;
    }

    /**
     * Get cached content - uses exclusive locking. timeout in 0.5 sec
     * @param string $filename
     * @param mixed $content
     * @return mixed
     */
    protected function cachePutContents($filename,$content){
        $retry = 0;
        $return = false;
        if($filename && is_string($filename)){
            if(($handle = @fopen($filename, 'w'))){
                while (!$return && $retry <= 5) {
                    $retry++;
                    if (!flock($handle, LOCK_EX)) usleep(round(rand(1, 100)*1000));
                    else {
                        if(($return = fwrite($handle,$content))){
                            flock($handle, LOCK_UN);
                        }
                    }
                }
                fclose($handle);
            }
        }
        return $return;
    }

}


?>