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
    /**
     * 
     * @param string $ip - ip na které chceme zjístit číslo počítače.
     * @return string - vrací číslo počítače. Pokud není nalezeno, vrátí prázdný řetězec
     */
    function getCisloPc($ip){
        $link = linkToMyDb();
        if(!$link){
            return;
        }
        $result = mysqli_query($link,"SELECT pc FROM ippc WHERE ip = $ip;");
        if($row = mysqli_fetch_array($result)){
            return $row[0];
        }else{
            return "";
        }
    }
    
    /**
     * Aktualizuje záznam čísla počítače dané ip;
     * @param int $pc - číslo počítače
     */
    function ulozIPPC($pc){
        $link = linkToMyDb();
        if(!$link){
            return;
        }
        $ip = get_client_ip();
        mysqli_query($link,"DELETE FROM ippc WHERE ip = $ip;");
        mysqli_query($link,"INSERT INTO ippc VALUES ('$ip', $pc);");
    }
    
    /**
     * 
     * @return mysqli_link mysqli_link - připojení k dané databázi.
     */
    function linkToMyDb(){
        $link = mysqli_connect("localhost", "3c30", "3c30", "db_3c30");
        return $link;
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
            if(strpos($s,"q".date("md")) !== false && strpos($s,"h".$hodina) !== false){
                $slozka=$s; 
                break;
            }
        }
        if($slozka === ""){
            return "Složka pro kopírování nenalezena, zkokntrolujte hodinu a jménu učitele";
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
    }


