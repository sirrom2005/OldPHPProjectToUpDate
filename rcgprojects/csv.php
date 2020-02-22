<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

$fp = fopen("file.txt","rb");
while (!feof($fp)) {
$rd = fgets($fp,filesize("file.txt"));
$data[] = $rd;
}

$str = "";
for($i=0;$i<count($data);$i+=6)
{
$str1 = clean($data[0+$i]);
$str2 = clean($data[1+$i]);
$str3 = clean($data[2+$i]);
$str4 = clean($data[3+$i]);
$str5 = clean($data[4+$i]);
$str6 = clean($data[5+$i]);

 $str .= "$str1, $str2, $str3, $str4, $str5, $str6\n";
}
echo $str;
//$fpw = fopen("file.csv","wb");
//fwrite($fpw, $str);


fclose($fp);
//fclose($fpw);

function clean($str)
{
	$str = str_replace(',', '', $str);
	$str = trim($str);
	return $str;
}
?>