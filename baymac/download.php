<?php

    require_once("inc/core.php");

    $objCore = new Core();

    $objCore->initSessionInfo();

    if($objCore->getSessionInfo()->isLoggedIn()) {
    
        $file = 'files/'.str_replace('/', '',urldecode($_GET['file']));
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            header("Location: index.php");
        }
    } else {
        header('Location: login.php');
    }
