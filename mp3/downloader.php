<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script language="javascript">
 function tryToDownload(url)
 {
     oIFrm = document.getElementById('myIFrm');
     oIFrm.src = url;
 }
 window.onload = setTimeout('tryToDownload("fileloader.php?f=<?php echo $_GET['f'];?>&i=<?php echo $_GET['i'];?>")', 3000);
</script>
</head>

<body style="margin:0;">
<p align="center">
Please wait retrieving your song.
<br />
<iframe id="myIFrm" src="" style="border:0;height:0;"></iframe>
</p>
</body>
</html>