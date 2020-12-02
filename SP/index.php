<?php
include_once"../include/layout.inc";
require_once('../dbconn.php');
require_once('../makeTable.php');

$base = new Layout;
$base->title = "Limite BMS / 差分BMS SP";
$base->link = "../css/bms_index.css";

$spTable = new table;
$spTable->currentPage = 0;
$jsonStr = $spTable->exportJSON();

$base->content = makeTable($jsonStr, $spTable->currentPage);
$base->LayoutMain();

?>

