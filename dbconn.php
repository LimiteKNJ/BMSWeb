<?php

class table {

    private $host = 'limiteknj.iptime.org:****';
    private $user = 'LimiteKNJ';
    private $pw = '****';
    private $dbName = '****';
    private $conn; 
    private $json;

    public $currentPage;

    public function dbConnect(){

        $this->conn = new mysqli($this->host, $this->user, $this->pw, $this->dbName);
        if(!$this->conn){
            echo "MySQL 접속 실패\n";
            return false;
        } else {
            mysqli_set_charset($this->conn, "utf8");
            return true;
        }
    }

    public function dbDisconnect(){

        mysqli_close($this->conn);
    }

    public function exportJSON(){

        if($this->dbConnect()){
        
            $getDataQuery =
                "SELECT bmsTitle, bmsSubtitle, bmstableType,
                bmstableNorDiff, bmstableInDiff, bmstableLNInDiff,
                bmsTOTAL, bmsNotes, bmsMD5, bmsMirrorURL, bmsYoutubeURL
                FROM bmsfile, bmstable
                WHERE bmsfile.bmsNo = bmstable.bmstableNo
                and bmsPlayStyle = ? ORDER BY bmsTitle";

            $statement = mysqli_prepare($this->conn, $getDataQuery);
            mysqli_stmt_bind_param($statement, "i", $this->currentPage);
            mysqli_stmt_execute($statement);
            mysqli_stmt_bind_result($statement,
            $bmsTitle, $bmsSubtitle, $bmstableType,
            $bmstableNorDiff, $bmstableInDiff, $bmstableLNInDiff,
            $bmsTOTAL, $bmsNotes, $bmsMD5, $bmsMirrorURL, $bmsYoutubeURL);

            // Make Json
            $count = 0;
            $this->json = "[";
            $response = array();
            while(mysqli_stmt_fetch($statement)) { 
                $bmsMode = $this->checkMode($bmstableType);
                $bmsDiff = $this->checkDiff($bmstableNorDiff, $bmstableInDiff, $bmstableLNInDiff);
                $bmsDLURL = $this->makeDL($bmsTitle);

                $response["Title"] = $bmsTitle;
                $response["Subtitle"] = $bmsSubtitle;
                $response["PlayMode"] = $bmsMode;
                $response["difficulty"] = $bmsDiff;
                $response["Total Notes"] = $bmsNotes;
                $response["Total"] = $bmsTOTAL;
                $response["md5"] = $bmsMD5;
                $response["bmsDL"] = $bmsDLURL;
                $response["bmsMRDL"] = $bmsMirrorURL;
                $response["youtube"] = $bmsYoutubeURL;
                if($count == 0){
                    $this->json = $this->json.json_encode($response,
                        JSON_UNESCAPED_UNICODE);
                } else {
                    $this->json = $this->json.",".json_encode($response,
                        JSON_UNESCAPED_UNICODE);
                } $count++;
              } $this->json = $this->json."]";

              $this->dbDisconnect();
              return $this->json;
              
        } else {
            echo "DataBase Connection Error";
        }
    }

    public function exporteventJSON(){

        if($this->dbConnect()){
        
            $getDataQuery =
                "SELECT eventbmsEvent, eventbmsName, eventbmsURL,
                eventbmsSPBeginner, eventbmsSPNormal, eventbmsSPHyper, eventbmsSPAnother, eventbmsSPInsane,
                eventbmsDPNormal, eventbmsDPHyper, eventbmsDPAnother, eventbmsDPInsane
                FROM bmsevent";

            $statement = mysqli_prepare($this->conn, $getDataQuery);
            mysqli_stmt_execute($statement);
            mysqli_stmt_bind_result($statement,
            $eventEvent, $eventName, $eventURL,
            $eventSPB, $eventSPN, $eventSPH, $eventSPA, $eventSPI,
            $eventDPN, $eventDPH, $eventDPA, $eventDPI);

            // Make Json
            $count = 0;
            $this->json = "[";
            $response = array();
            while(mysqli_stmt_fetch($statement)) { 
                $response["Event"] = $eventEvent;
                $response["Title"] = $eventName;
                $response["URL"] = $eventURL;
                $response["SPBeginner"] = $eventSPB;
                $response["SPNormal"] = $eventSPN;
                $response["SPHyper"] = $eventSPH;
                $response["SPAnother"] = $eventSPA;
                $response["SPInsane"] = $eventSPI;
                $response["DPNormal"] = $eventDPN;
                $response["DPHyper"] = $eventDPH;
                $response["DPAnother"] = $eventDPA;
                $response["DPInsane"] = $eventDPI;
                if($count == 0){
                    $this->json = $this->json.json_encode($response,
                        JSON_UNESCAPED_UNICODE);
                } else {
                    $this->json = $this->json.",".json_encode($response,
                        JSON_UNESCAPED_UNICODE);
                } $count++;
              } $this->json = $this->json."]";

              $this->dbDisconnect();
              return $this->json;
              
        } else {
            echo "DataBase Connection Error";
        }
    }

    private function checkMode($state){
        if($state == 0){
            return "SP";
        } else {
            return "DP";
        }
    }

    private function checkDiff($diffNor, $diffIn, $diffLN){
        
        $diff = "";
        if($diffNor != 0 && $diffIn == 0 && $diffLN == 0){
            $diff = "☆".strval($diffNor);
            return $diff;
        } else if($diffNor == 0 && $diffIn != 0 && $diffLN == 0){
            $diff = "★".strval($diffIn);
            return $diff;
        } else if($diffNor == 0 && $diffIn == 0 && $diffLN != 0){
            $diff = "◆".strval($diffLN);
            return $diff;
        } else {
            echo "Read Difficulty Failed";
            return 0;
        }
    }

    private function makeDL($title){
        
        $str = $_SERVER['REQUEST_URI'].$title.".rar";
        return $str;
    }

    private function printJSON(){
        echo $this->json;
    }

    private function saveJSON(){

        $pageName = ""; 
        switch($this->currentPage){
            case 0: $pageName = "SP"; break;
            case 1: $pageName = "Seigen"; break;
            case 2: $pageName = "DP"; break;
            default : break;
        } $path = $_SERVER["DOCUMENT_ROOT"]."/BMS/json/".$pageName.".json";
        
        $fp = fopen($path, 'w');
        fwrite($fp, json_encode($this->json,JSON_PRETTY_PRINT));
        fclose($fp);
    }

    private function updateDB(){
        
    } 
}
?>