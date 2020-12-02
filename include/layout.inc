<?php

session_start();

class Layout {

    public $link;
    public $content;
    private $menu = array('Main'=>'index.php', 'SP'=>'sp', '制限'=>'seigen', 'DP'=>'dp');
    
    public $title;
    public $subtitle;
    public $sub;

    public function LayoutMain(){

        echo "<!DOCTYPE html>\n<html lang='ko'>";
        echo "<head>\n<meta charset='utf-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>".$this->title."</title>";
        echo $this->LayoutStyle();
        echo "</head>\n<body>\n<div id='container'>";
        echo    $this->LayoutHeader();
        echo    $this->LayoutContent();
        echo    $this->LayoutSide();
        echo    $this->LayoutFooter();
        echo "</div></body>\n</html>";
    }

    public function LayoutHeader(){

        echo "<header>
                <div id='header'><h1><a class='title' href='./'>$this->title</a></h1></div>
                <nav></nav>
              </header>";
    }

    public function LayoutStyle(){

        echo "<link rel='stylesheet' type='text/css' href='".$this->link."'/>";
    }

    public function LayoutContent(){

        echo "<section><article>".$this->content."</article>";
    }

    public function LayoutManu($menu, $side){
        
        foreach($menu as $key => $value){
            $this->ThisMenu($key, $value, $side);
        }
    }

    public function LayoutSide(){

        echo "<aside>";
        echo "<p class='youtube'><a href='https://youtube.limiteknj.net/' target='_blank'>Youtube</a></p>";
        echo "<ul class='menu'> <h1 class='title'> MENU </h1>";
        $this->SideMenu();
        echo "</ul>";
        echo "</aside></section>";
    }

    public function LayoutFooter(){

        echo "<footer>Copyright 2013 - 2020. LimiteKNJ All rights reserved.</footer>";
    }



    public function ThisMenu($key, $value, $main){
        
        $thisMenu = "";
        $str = strtolower($_SERVER['PHP_SELF']);
        if($main == 1){
            if(strpos($str, $value) == false){
                $thisMenu = $thisMenu."<li class='menuItem'><a href='./".$value."'>".$key."</a></li>";
            } else {
                $thisMenu = $thisMenu."<li class='menuItem select'><b>".$key."</b></li>";
            }
        } else {
            if(strpos($str, $value) == false){
                $thisMenu = $thisMenu."<li class='menuItem'><a href='../".$value."'>".$key."</a></li>";
            } else {
                if(!(strpos($str, $value) == 8) && 
                !(strpos($str, $value) == 12)){
                    $thisMenu = $thisMenu."<li class='menuItem select'><b>".$key."</b></li>";
                } else {
                    $thisMenu = $thisMenu."<li class='menuItem'><a href='../'>".$key."</a></li>";
                }
            }
        }
        
        echo $thisMenu;
    }

         public function SideMenu(){

        $this->subtitle=explode('/', $_SERVER['PHP_SELF']);
        $key = strtolower($this->subtitle[2]);

        switch($key){
            case 'index.php':
                $this->LayoutManu($this->menu, 1);
                break;
            case 'sp':
                $this->LayoutManu($this->menu, 0);
                break;
            case 'seigen':
                $this->LayoutManu($this->menu, 0);
                break;  
            case 'dp':
                $this->LayoutManu($this->menu, 0);
                break;
            default :
                echo "Error!";
        }
    }
}

?>