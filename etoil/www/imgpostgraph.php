<?php
session_start();

include('postgraph.class.php');

$graph = new PostGraph(300,250); // (largeur,hauteur)

$graph->setGraphTitles('D�nivell� du parcours', 'x (m)', 'z (m)');

$graph->setYNumberFormat('integer');

$graph->setYTicks(10);
$graph->xTicks=10;

$graph->setData($_SESSION['datas']);

$graph->setBarsColor(array(255,0,0));

$graph->setBackgroundColor(array(223,241,211));

//$graph->setTextColor(array(144,144,144));

$graph->setXTextOrientation('horizontal');
    
$graph->drawImage();

$graph->printImage();
unset($_SESSION['datas']); // pour lib�rer de la m�moire
?>