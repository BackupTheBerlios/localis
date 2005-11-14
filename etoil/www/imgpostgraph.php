<?php

if (!$incimgp) session_start();

include_once('postgraph.class.php');

$graph = new PostGraph(400,250); // (largeur,hauteur)

$graph->setGraphTitles('Dénivellé du parcours', 'x (m)', 'z (m)');

$graph->setYNumberFormat('integer');

$graph->setYTicks(10);
$graph->xTicks=10;

$graph->setData($_SESSION['datas']);

$graph->setBarsColor(array(255,0,0));

$graph->setBackgroundColor(array(223,241,211));

//$graph->setTextColor(array(144,144,144));

$graph->setXTextOrientation('horizontal');
    
$graph->drawImage();

$graph->printImage($filetogen);
//$graph->printImage();

unset($_SESSION['datas']); // pour libérer de la mémoire
?>