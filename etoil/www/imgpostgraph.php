<?php
session_start();

include('postgraph.class.php');

$graph = new PostGraph(550,330);

$graph->setGraphTitles('Dénivellé du parcours', 'x (m)', 'z (m)');

$graph->setYNumberFormat('integer');

$graph->setYTicks(10);
$graph->xTicks=15;

$graph->setData($_SESSION['datas']);

$graph->setBarsColor(array(255,0,0));

$graph->setBackgroundColor(array(223,241,211));

//$graph->setTextColor(array(144,144,144));

$graph->setXTextOrientation('horizontal');
    
$graph->drawImage();

$graph->printImage();
?>