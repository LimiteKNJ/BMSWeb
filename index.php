<?php
include_once "include/layout.inc";
require_once('dbconn.php');
require_once('makePage.php');

$base = new Layout;
$base->title = "Limite BMS / Main";
$base->link = "css/bms_index.css";

$pageTitle = "<div><p class='pageTitle'>Main</p></div>"; 
$comment = "<div>
                <p id='comment'>
                    はじめまして、譜面作成のLimiteです。<br>
                    今日もこのアーカイブを利用してくださってありがとうございます。<br>
                    本サイトは、これまでやってきた差分BMSらをまとめて管理するところです。<br>
                </p>
            </div>
            <div><br></div>";

$difftable = "<div>
                <p class='tableComment'>
                    - 現在、BeMusicSeeker難易度表に試験的に対応しています。<br>
                </p>
                <ul class='difftable'>
                    <li><div id='tableSPN'>SP 通常難易度表 : https://www.limiteknj.net/diff/spnormal/</div></li>
                    <li><div id='tableSPI'>SP 発狂難易度表 : https://www.limiteknj.net/diff/spinsane/</div></li>
                    <li><div id='tableSPLN'>SP LN発狂難易度表 : https://www.limiteknj.net/diff/spln/</div></li>
                    <li><div id='tableDPN'>DP 通常難易度表 : https://www.limiteknj.net/diff/dpnormal/</div></li>
                    <li><div id='tableDPI'>DP 発狂難易度表 : https://www.limiteknj.net/diff/dpinsane/</div></li>
                </ul>        
            </div>";

$eventTable = new table;
$jsonStr = $eventTable->exporteventJSON();
$event = "<div>
            <p class='tableComment'>
                - 下の表は、これまで参加したBMS大会の譜面のリストです。
            </p>
        </div>".makeEventTable($jsonStr)."<div><br><br></div>";

$base->content= $pageTitle.$comment.$event.$difftable;
$base->LayoutMain();

?>

