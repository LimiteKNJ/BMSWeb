<?php
include_once"../include/layout.inc";
require_once('../dbconn.php');
require_once('../makeTable.php');

$base = new Layout;
$base->title = "Limite BMS / 差分BMS obj.制限";
$base->link = "../css/bms_index.css";

$seigenTable = new table;
$seigenTable->currentPage = 1;
$jsonStr = $seigenTable->exportJSON();

$base->content = makeTable($jsonStr, $seigenTable->currentPage);
$base->LayoutMain();

?>

