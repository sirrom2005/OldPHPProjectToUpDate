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
    public function Header() {
        $header = '<p align="center"><img src="views/images/docheader.jpg"/><p>';
        //$this->Image("views/images/docheader.jpg");
        $this->writeHTML($header);
    }
    // Page footer
    public function Footer() {        
        $footer = "<style>
        div{font-size:7pt; text-align:center; padding:0; margin:0; line-height:1.1pt;}
        </style>
        <div>
        <u>DIRECTORS</u>: Aubyn Hill (Chairman), Ian K. Levy, Arnold Aiken, Ian Moore, Marguerite Cremin, Alexander Hill<br><br>
        ©Innovative Renewable Energy and Electronics Limited<br>
        29 Burlington Avenue<br>
        Kingston 10, Jamaica<br>
        876-968-IREE (4733)/876-371-IREE (4733)<br>
        www.ireesolar.com
        </div>";
        $this->writeHTML($footer);
    }
}


include_once('config/db_connection.php');
$con = mysql_connect($db_host, $db_username, $db_password) || die('Counld not connect...');
if(mysql_select_db($db_database))
{
    $query = "select text0,text1,text2,text3,text4,text5,text6,filename from off_grid_quote_list where id = '$key'";

    $rs = mysql_query($query);
    $row = mysql_fetch_assoc($rs);
    if(empty($row))
    {
        header("location: off_grid_quote_listing.php");
    }
}


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator("IREE SOLAR | ".date("Y-m-d")); 
$pdf->SetAuthor("IREE SOLAR");
$pdf->SetTitle("SOLAR Quote");
$pdf->SetSubject("Quote document");
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
$pdf->SetFont('times', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();
// Set some content to print
//
$frontPage      = $row['text0'];
$introTxt       = $row['text1'];
$pricingTxt     = $row['text2'];
$compPartsTxt   = $row['text3'];
$table          = $row['text4'];
$roiAnalysis    = $row['text5'];
$roiGraph       = $row['text6'];

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->writeHTML($frontPage);
$pdf->SetPrintHeader(true);
$pdf->SetPrintFooter(true);
$pdf->AddPage();
$pdf->writeHTML($introTxt);
$pdf->AddPage();
$pdf->writeHTML($table);
$pdf->writeHTML($pricingTxt);
$pdf->SetFont('times', '', 16, '', true);
$pdf->AddPage();
$pdf->writeHTML($roiAnalysis);
$pdf->SetFont('times', '', 12, '', true);
$pdf->AddPage('L');
$pdf->writeHTML($roiGraph);
$pdf->AddPage('P');
$pdf->writeHTML($compPartsTxt);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('tmp/'.$row['filename'].'/quote.pdf', 'F');
header("location: off_grid_quote_listing.php?pdf=".base64_encode($row['filename']));
//============================================================+
// END OF FILE
//============================================================+
?>