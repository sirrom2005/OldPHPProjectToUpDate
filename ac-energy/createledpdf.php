<?php
session_start();
set_time_limit(0);
ini_set("memory_limit","64M");
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
$key = $_GET['id'];
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {}
    // Page footer
    public function Footer() {}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator("IREE SOLAR | ".date("Y-m-d")); 
$pdf->SetAuthor("IREE SOLAR");
$pdf->SetTitle("LED INFO");
$pdf->SetSubject("LED FORM INFO");
$pdf->SetKeywords("pdf, quote, iree, solar");

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();
// Set some content to print
//
$table = $_SESSION['ledtable'];
$pdf->AddPage();
$pdf->writeHTML($table);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$file = 'tmp/LEDINFO/ledinfo'.$key.'.pdf';
$pdf->Output($file,'F');


if(file_exists($file)){
    $file = base64_encode($file);
    $headers = "From: ".$_SESSION['s']['sitename']." <".$_SESSION['s']['siteemail'].">\r\n";
    $headers .= "Reply-To: ".$_SESSION['s']['siteemail']."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = "New LED form submitted,<br>
                click link bellow to view inputs<br>
                <a href='".$_SESSION['s']['siteaddress']."getpdffile.php?f=$file'>".$_SESSION['s']['siteaddress']."getpdffile.php?f=$file</a>";

    mail($_SESSION['s']['siteemail'], "LED form submitted", $message, $headers);
}
unset($_SESSION['s']);
header("location: ledlisting.php");
//============================================================+
// END OF FILE
//============================================================+
?>