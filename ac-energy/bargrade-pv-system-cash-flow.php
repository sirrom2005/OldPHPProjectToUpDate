<?php
//require_once('jpgraph/jpgraph.php');
//require_once('jpgraph/jpgraph_bar.php');

function setDollarValues($v){
    return '$'.number_format($v,2,'.',',');
}

$cnt=0;
if(isset($val)){
    for($i=0;$i<=$step;$i++){
        if($i%5==0){
            $datax[$cnt] = "Year\r\n  ".$val[$i]['yr'];
            $datay[$cnt] = $val[$i]['ccf'];
            $cnt++;
        }
    }
}
else
{
    $datay=array(   
        array("Jan","Feb","Mar","Apr","May","Jun","Jan","Feb","Mar","Apr","May","Jun"),
        array(0.13,0.25,0.21,0.35,0.31,0.06,0.13,0.25,0.21,0.35,0.31,0.06)       
    );
}

// Setup the graph.
$graph = new Graph(950,600);
$graph->img->SetMargin(5,25,30,50);
$graph->SetScale("textlin");
$graph->SetMarginColor("lightblue:1.1");
$graph->SetShadow();

$graph->title->Set("CUMUALTIVE CASH FLOW {USD}");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,17);
$graph->title->SetMargin(8);
// Setup font for axis
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,10);
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,10);
$graph->yaxis->SetLabelFormatCallback('setDollarValues');
// Show 0 label on Y-axis (default is not to show)
$graph->yscale->ticks->SupressZeroLabel(false);

// Setup X-axis labels
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(0);

// Create the bar pot
$bplot = new BarPlot($datay);
$bplot->SetFillGradient(array(66,96,196),array(66,96,196),GRAD_LEFT_REFLECTION);
$bplot->SetWidth(0.6);
//$bplot->SetLegend("Estimated Dollar Value of Power Produced @ JMD ".number_format($this->kWhJmdValue,2,'.',',')."/kWh");

$accbplot = new AccBarPlot(array($bplot));
$accbplot->value->SetAngle(0);
$accbplot->value->SetColor("black");
$accbplot->value->SetMargin(10,0,0,0);
$accbplot->value->Show();
// Set color for the frame of each bar

$graph->Add($accbplot);
// Finally send the graph to the browser
$graph->Stroke('tmp/'.$this->postKey."/pv-cash-flow.jpg");
?>