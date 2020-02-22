<?php
$file = base64_decode($_GET['f']);
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$file");
header("Content-Type: application/pdf");
header("Content-Transfer-Encoding: binary");
readfile($file)
?>