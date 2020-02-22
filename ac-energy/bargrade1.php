<?php 
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

function setDollarValue($val){
    return '$'.number_format($val,0,'.',',');
}

// We need some data
if(isset($b1Query)){
    for($idx=0; $idx <= 11; $idx++) {
        $datay[$idx] = $b1Query[$idx];
        $datax[$idx] = date("M",mktime(0, 0, 0, $idx+1, 1, 2012));
    }
}
else
{
    $datay=array(2122.13,2144.25,2990.21,2440.35,2550.31,2330.06,2213,1110.25,2340.21,935,2880.31,2900.06);
    $datax=array("Jan","Feb","Mar","Apr","May","Jun","Jan","Feb","Mar","Apr","May","Jun");
}
// Setup the graph.
$graph = new Graph(600,400);
$graph->img->SetMargin(90,25,30,50);
$graph->SetScale("textlin");
$graph->SetMarginColor("lightblue:1.1");
$graph->SetShadow();

$graph->title->Set("Estimated Dollar Value of Power Produced \nJMD ".number_format($this->kWhJmdValue,2,'.',',')."/kWh");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,12);
$graph->title->SetMargin(8);
// Setup font for axis
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,9);
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,9);
$graph->yaxis->SetLabelFormatCallback('setDollarValue');
// Show 0 label on Y-axis (default is not to show)
$graph->yscale->ticks->SupressZeroLabel(false);

// Setup X-axis labels
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(0);

// Create the bar pot
$bplot = new BarPlot($datay);
$bplot->SetWidth(0.6);
//$bplot->SetLegend("Estimated Dollar Value of Power Produced @ JMD ".number_format($this->kWhJmdValue,2,'.',',')."/kWh");

$accbplot = new AccBarPlot(array($bplot));
$accbplot->value->SetAngle(45);
$accbplot->value->SetColor("black");
$accbplot->value->SetMargin(-5,0,0,0);
$accbplot->value->Show();
// Set color for the frame of each bar
$bplot->SetColor("white");
$graph->Add($accbplot);
// Finally send the graph to the browser
$graph->Stroke('tmp/'.$this->postKey."/g1".$this->postKey.".jpg");
?>
