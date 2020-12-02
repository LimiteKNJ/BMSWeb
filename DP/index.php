<?php
include_once"../include/layout.inc";
require_once('../dbconn.php');
require_once('../makeTable.php');

$base = new Layout;
$base->title = "Limite BMS / 差分BMS DP";
$base->link = "../css/bms_index.css";

$dpTable = new table;
$dpTable->currentPage = 2;
$jsonStr = $dpTable->exportJSON();

$base->content = makeTable($jsonStr, $dpTable->currentPage);
$base->LayoutMain();

?>

