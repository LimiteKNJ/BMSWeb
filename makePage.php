<?php

    function storeJSON($fname, $str){

    }

    function makeEventTable($str){

        $data = array();
        $data = json_decode($str, true);

        $resultTableStart = "<table class='table'>";
        $resultHead = "<thead>
                    <tr class='table table-column-title'>
                        <th style='width:10%'>Event</th>
                        <th style='width:20%'>Title</th>
                        <th colspan='5' style='width:20%'>SP Pattern</th>
                        <th colspan='4' style='width:20%'>DP Pattern</th>
                    </tr>
                </thead>";
        $resultBodyStart = "<tbody>";

        $resultContext = "";
        if(!empty($data)){
            foreach($data as $row){

            $resultContext = $resultContext.
                "<tr class='table table-column-context'>
                    <td id='eventName'>".$row['Event']."</td>
                    <td><a id='eventTitle' href='".$row['URL']."'>".$row['Title']."</a></td>
                    ".makeYoutube($row['SPBeginner'],10)."
                    ".makeYoutube($row['SPNormal'],11)."
                    ".makeYoutube($row['SPHyper'],12)."
                    ".makeYoutube($row['SPAnother'],13)."
                    ".makeYoutube($row['SPInsane'],14)."
                    ".makeYoutube($row['DPNormal'],21)."
                    ".makeYoutube($row['DPHyper'],22)."
                    ".makeYoutube($row['DPAnother'],23)."
                    ".makeYoutube($row['DPInsane'],24)."
                </tr>";
            }
        }

        $resultBodyEnd = "</tbody>";
        $resultTableEnd = "</table>";
        
        $result = $resultTableStart.$resultHead.$resultBodyStart.
                  $resultContext.$resultBodyEnd.$resultTableEnd;
        return $result ;
    }

    function makeTable($str, $page){

        $data = array();
        $data = json_decode($str, true);

        $resultCurrentTable = "
            <div class='currentTable'>
                <p class='pageTitle'>".thisPage($page)."</p>
            </div>
            ";
        $resultTableStart = "<table class='table'>";
        $resultHead = "<thead>
                    <tr class='table table-column-title'>
                        <th style='width:5%'>Mode</th>
                        <th style='width:6%'>難易度</th>
                        <th style='width:20%'>Title</th>
                        <th style='width:20%'>SubTitle</th>
                        <th colspan='2' style='width:10%'>Notes</th>
                        <th style='width:2.5%'>MV</th>
                        <th style='width:2.5%'>IR</th>
                        <th style='width:2.5%'>DL</th>
                        <th style='width:2.5%'>MR</th>
                    </tr>
                </thead>";
        $resultBodyStart = "<tbody>";

        $resultContext = "";
        if(!empty($data)){
            foreach($data as $row){

            $resultContext = $resultContext.
                "<tr class='table table-column-context'>
                    <td id='playmode'>".$row['PlayMode']."</td>
                    <td id='diff'>".$row['difficulty']."</td>
                    <td id='title'>".$row['Title']."</td>
                    <td id='subtitle'>".$row['Subtitle']."</td>
                    <td id='notes'>".$row['Total Notes']."</td>
                    <td id='total'>".$row['Total']."</td>
                    ".makeYoutube($row['youtube'], 0)."
                    <td><a href='".makeIR($row['md5'])."'>IR</a></td>
                    <td><a href='".$row['bmsDL']."'>DL</a></td>
                    <td><a href=".$row['bmsMRDL'].">OD</a></td>
                </tr>";
            }
        }

        $resultBodyEnd = "</tbody>";
        $resultTableEnd = "</table>";
        
        $result = $resultCurrentTable.$resultTableStart.
                  $resultHead.$resultBodyStart.
                  $resultContext.$resultBodyEnd.$resultTableEnd;
        return $result ;
    }

    function thisPage($pageNum){
        
        switch ($pageNum){
            case 0:
                return "差分 SP List";
                break;
            case 1:
                return "差分 SP制限 List";
                break;
            case 2:
                return "差分 DP List";
                break;
            default:
                return "Unknown Page";
        }
    }

    function makeIR($key){
        $LR2IR_URL = "http://www.dream-pro.info/~lavalse/LR2IR/search.cgi?mode=ranking&bmsmd5=";
        return $LR2IR_URL.$key;
    }

    function makeYoutube($key, $diff){
        $Youtube_URL = "https://www.youtube.com/watch?v=";
        if($key == ""){
            return "<td></td>";
        } else {
            switch ($diff){
                case 10 : return "<td><a id='beginner' href=".$Youtube_URL.$key.">Beginner</a></td>"; break;
                case 11 : return "<td><a id='normal' href=".$Youtube_URL.$key.">Normal</a></td>"; break;
                case 12 : return "<td><a id='hyper' href=".$Youtube_URL.$key.">Hyper</a></td>"; break;
                case 13 : return "<td><a id='another' href=".$Youtube_URL.$key.">Another</a></td>"; break;
                case 14 : return "<td><a id='insane' href=".$Youtube_URL.$key.">Insane</a></td>"; break;
                case 21 : return "<td><a id='normal' href=".$Youtube_URL.$key.">Normal</a></td>"; break;
                case 22 : return "<td><a id='hyper' href=".$Youtube_URL.$key.">Hyper</a></td>"; break;
                case 23 : return "<td><a id='another' href=".$Youtube_URL.$key.">Another</a></td>"; break;
                case 24 : return "<td><a id='insane' href=".$Youtube_URL.$key.">Insane</a></td>"; break;
                default : return "<td><a id='youtube' href=".$Youtube_URL.$key.">▶</a></td>";
            }
        }
    }

    function makefileloadPage(){

        $ext = ".bms,.bme,.bml,.bmson,.pms";
        $id = "readFile";
        $skipPage = "location.href='update.php'";
        $pageTitle = "
            <div>
                <p class='pageTitle'>BMS Database Update</p>
           </div>
        ";

        $fileLoadStart = "<form enctype='multipart/form-data' method='post' action='./parse.php'>";
        $fileLoadForm = "
                    <div class='loadform'>
                        <div class='upload'>Please Upload file</p>
                        <div><input type='file' name=".$id." accept=".$ext."></p>
                    </div>
                    <div class='loadform'>
                        <div class='left'><button type='submit' id='read'>read</button></div>
                        <div class='right'><button type='button' id='readSkip'
                                            onclick=".$skipPage.">skip</button></div>
                    </div>";
        $fileLoadEnd = "</form>";
        $fileLoadPage = $fileLoadStart.$fileLoadForm.$fileLoadEnd;
        return $fileLoadPage;        
    }

    function makeUpdatePage(){

        if(isset($_POST["type"])) $playtype = $_POST["type"];
        else $playtype = "";
        if(isset($_POST["title"])) $title = $_POST["title"];
        else $title = "";
        if(isset($_POST["subtitle"])) $subtitle = $_POST["subtitle"];
        else $subtitle = "";
        if(isset($_POST["plevel"])) $plevel = $_POST["plevel"];
        else $plevel = 0;
        if(isset($_POST["total"])) $total = $_POST["total"];
        else $total = 300;
        if(isset($_POST["notes"])) $notes = $_POST["notes"];
        else $notes = 0;
        if(isset($_POST["md5"])) $md5 = $_POST["md5"];
        else $md5 = "";
        if(isset($_POST["type"])){
            $playtype = $_POST["type"];
            switch($playtype){
                case 7:
                    $isSP = "checked";
                    $isDP = "";
                    $isPMS = "";
                    $isSPtable = "selected";
                    $isDPtable = "";
                    break;
                case 14:
                    $isSP = "";
                    $isDP = "checked";
                    $isPMS = "";
                    $isSPtable = "";
                    $isDPtable = "selected";
                    break;
                case 9:
                    $isSP = "";
                    $isDP = "";
                    $isPMS = "checked";
                    $isSPtable = "";
                    $isDPtable = "";
                    break;
                default:
            }
        } else {
            $isSP = "";
            $isDP = "";
            $isPMS = "";
            $isSPtable = "";
            $isDPtable = "";
        }

        $prevPage = "location.href='readFile.php'";
        $pageTitle = "
            <div>
                <p class='pageTitle'>BMS Database Update</p>
           </div>
        ";

        $getDataStart = "<form enctype='multipart/form-data' method='post' action='./updateRequest.php'>";
        $getDataForm = "
                    <div class='dataform'>
                        <div class='form-left'>BMS Title</div>
                        <div class='form-middle'><input type='text' class='edit-title' name='bmstitle' value=".$title."></div>
                    </div>
                    <div class='dataform'>
                        <div class='form-left'>BMS SubTitle</div>
                        <div class='form-middle'><input type='text' class='edit-subtitle' name='bmssubtitle value=".$subtitle."></div>
                    </div>
                    <div class='dataform'>
                        <div class='form-left'>BMS Upload Table</div>
                        <div class='form-middle'><select id='bmsseltable'>
                            <option value='null'>select Table</option>
                            <option value='SP' ".$isSPtable.">SP</option>
                            <option value='seigen'>制限</option>
                            <option value='DP' ".$isDPtable.">DP</option>
                        </div></select>
                    </div>
                    <div class='dataform'>
                        <div class='form-left'>BMS Type</div>
                        <div class='form-middle'>
                            <input type='radio' name='bmsType' value='sp' ".$isSP." onclick='return(false);'>SP
                            <input type='radio' name='bmsType' value='dp' ".$isDP." onclick='return(false);'>DP
                            <input type='radio' name='bmsType' value='pms' ".$isPMS." onclick='return(false);'>PMS
                        </div>
                    </div>
                    <div class='dataform'>
                        <div class='form-left'>BMS Difficulty</div>
                        <div class='form-middle'>
                            <input type='radio' name='diffType' value='normal'>☆
                            <input type='radio' name='diffType' value='insane'>★
                            <input type='radio' name='diffType' value='longnote'>◆
                        </div>
                        <div class='form-right'>
                            <input type='text' class='edit-diff' name='plevel' value=".$plevel.">
                        </div>
                    </div>
                    <div class='dataform'>
                        <input type='hidden' name='bmstotal' value=".$total.">
                        <input type='hidden' name='bmsnotes' value=".$notes.">
                        <input type='hidden' name='bmsMD5' value=".$md5.">
                    </div>
                    <div class='dataform'>
                        <div class='form-left'>BMS MirrorURL</div>
                        <div class='form-middle'><input type='text' class='edit-mirURL' name='mirURL'></div>
                    </div>
                    <div class='dataform'>
                        <div class='form-left'>youtube URL</div>
                        <div class='form-middle'>https://www.youtube.com/watch?v=<input type='text' class='edit-ytURL' name='ytURL'></div>
                    </div>
                    <div class='dataform'>
                        <div class='form-left'><button type='submit' id='upload-button' class='button'>UpdateDB</button></div> 
                        <div class='form-middie'><button type='reset' id='reset-button' class='button'>reset</button></div>
                        <div class='form-right'><button type='button' id='prev-button' class='button' onclick=".$prevPage.">priv</button></div>
                    </div>
                ";    
            $getDataEnd = "</form>";
        $getDataContent = $getDataStart.$getDataForm.$getDataEnd;
        
        return $pageTitle.$getDataContent;
    }
?>
    