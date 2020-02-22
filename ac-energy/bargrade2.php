<?php
//require_once('jpgraph/jpgraph.php');
//require_once('jpgraph/jpgraph_bar.php');
require_once('jpgraph/jpgraph_table.php');

// We need some data
if(isset($b2Query)){
    for($idx=0; $idx <= 11; $idx++) {
        $d1[$idx] = date("M",mktime(0, 0, 0, $idx+1, 1, 2012));
        $d2[$idx] = $b2Query[$idx];
    }
    $datay = array($d1,$d2);
}
else
{
    $datay=array(   
        array("Jan","Feb","Mar","Apr","May","Jun","Jan","Feb","Mar","Apr","May","Jun"),
        array(0.13,0.25,0.21,0.35,0.31,0.06,0.13,0.25,0.21,0.35,0.31,0.06)       
    );
}

$nbrbar = 12;
$cellwidth = 40;
$tableypos = 330;
$tablexpos = 60;
$tablewidth = $nbrbar*$cellwidth;
$rightmargin = 60;
// Overall graph size
$height = 400;
$width = $tablexpos+$tablewidth+$rightmargin;

// Setup the graph.
$graph = new Graph($width,$height);
$graph->img->SetMargin($tablexpos,$rightmargin,50,$height-$tableypos);
$graph->SetScale("textlin");
//$graph->SetMarginColor("lightblue:1.1");
//$graph->SetShadow();

// Set up the title for the graph
$graph->title->Set("AVG Annual kWh Production");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,12);
$graph->title->SetMargin(15);
$graph->xaxis->hide();
$graph->yaxis->title->Set('kwh');
$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,10);
$graph->yaxis->title->SetMargin(20);

// Create the bar pot
$bplot = new BarPlot($datay[1]);
$bplot->SetWidth(0.6);
$bplot->SetFillGradient(array(166,199,97),array(166,199,97),GRAD_LEFT_REFLECTION);
$graph->Add($bplot);

//Setup the table
$table = new GTextTable();
$table->Set($datay);
$table->SetPos($tablexpos,$tableypos+1);

// Basic table formatting
$table->SetFont(FF_ARIAL,FS_NORMAL,10);
$table->SetAlign('center');
$table->SetMinColWidth($cellwidth);
//$table->SetNumberFormat('%0.1f');

// Format table header row
$table->SetRowFont(0,FF_ARIAL,FS_BOLD,8);
$table->SetRowAlign(0,'center');

// .. and add it to the graph
$graph->Add($table);

// Finally send the graph to the browser
$graph->Stroke('tmp/'.$this->postKey."/g2".$this->postKey.".jpg");
?>
