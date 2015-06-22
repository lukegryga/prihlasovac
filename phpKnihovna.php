<?php
    /**
     * 
     * @return string IP adresa klienta. Když neúspěch tak vrací prázdný řetězec
     */
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')){
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }else if(getenv('HTTP_X_FORWARDED_FOR')){
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        }else if(getenv('HTTP_X_FORWARDED')){
            $ipaddress = getenv('HTTP_X_FORWARDED');
        }else if(getenv('HTTP_FORWARDED_FOR')){
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        }else if(getenv('HTTP_FORWARDED')){
           $ipaddress = getenv('HTTP_FORWARDED');
        }else if(getenv('REMOTE_ADDR')){
            $ipaddress = getenv('REMOTE_ADDR');
        }else{
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }
    
    /**
     * 
     * @return int - číslo aktuální hodiny
     */
    function getHodina(){
        date_default_timezone_set("Europe/Prague");
        $intCas = intval(date("Hi"));
        $hodiny = array(752,842,937,1032,1137,1227,1317,1407);
        $hodina=0;
        for($i=7;$i>=0;$i--){
            if($intCas>($hodiny[$i]-10)){
                $hodina = $i+1;
                break;
            }
        }
        return $hodina;
    }
    
    function vsechno_funkce() {
        date_default_timezone_set("Europe/Prague");
        //inicializace proměnných
        $jmeno = filter_input(INPUT_POST,"jmeno");
        $pocitac = filter_input(INPUT_POST,"pocitac");
        $ucitel = substr(filter_input(INPUT_POST,"ucitel"),0,3);
        $hodina = filter_input(INPUT_POST,"hodina");
        $report = filter_input(INPUT_POST,"report");
        
        //nalezení složky pro nahrání souborů
        $soubory = scandir("/home/".$ucitel);
        $slozka = "";
        foreach($soubory as $s){
            //if(!substr_compare($s,"q".date("md"),0) && !substr_compare($s,"h".$hodina,0)){
            if(strpos($s,"q0617") !== false && strpos($s,"h3") !== false){
                $slozka=$s; 
                break;
            }
        }
        
        //vytvoření přihlašovacího soubou
        if (!is_dir("prihlasovaky")) {
            mkdir("prihlasovaky");         
        }
        $dir = "prihlasovaky/";
        $fileName = $pocitac.$jmeno.".txt";
        $file = fopen($dir.$fileName, "w");
        fwrite($file,$report);
        fclose($file);

        //nahrání souboru
        if(!copy($dir.$fileName, "/home/".$ucitel."/".$slozka."/".$fileName)){
            return "Nepodařilo se zkopírovat soubor";
        }

        $link = mysqli_connect("localhost", "3c30", "3c30", "db_3c30");
        if(!$link){
            return "Nepodařilo se připojit k databázi.";
        }
        $ip = get_client_ip();
    }


