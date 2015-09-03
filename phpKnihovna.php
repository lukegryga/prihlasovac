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
            if($intCas>($hodiny[$i]-18)){
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
            return "";
        }
        $result = mysqli_query($link,"SELECT * FROM ippc WHERE ip like '$ip'");
        if(($row = mysqli_fetch_array($result))){
            return $row[1];
        }else{
            return "";
        }
    }
    /**
     * Vybere učitele (zkratku) na základě dnu v dvou týdnech, ip adresy, a aktuální hodiny
     * @param type $ip 
     * @param type $den den ve formátu 14
     * @param type $hodina
     * @return string 
     */
    function getUcitel(){
        $ip = get_client_ip();
        $den = getDay();
        $hodina = getHodina();
        $link = linkToMyDb();
        if(!$link){
            return "";
        }
        $result = mysqli_query($link,"SELECT * FROM rozvrh WHERE ip like '$ip' and den=$den and hodina=$hodina" );
        $pzaznam = null;
        if(!($pzaznam = mysqli_fetch_array($result))){
                return "";
        }
        while($row = mysqli_fetch_array($result)){
            if($row[4] > $pzaznam[4]){
                $pzaznam = $row;
            }
        }
        
        return $pzaznam[3];
    }
    
    /**
     * Vybere jméno na základě dnu v dvou týdnech, ip adresy, a aktuální hodiny
     * @param type $ip
     * @param type $den
     * @param type $hodina
     * @return string
     */
    function getJmeno(){
        $ip = get_client_ip();
        $den = getDay();
        $hodina = getHodina();
        $link = linkToMyDb();
        
        if(!$link){
            return "";
        }
        $result = mysqli_query($link,"SELECT * FROM rozvrh WHERE ip like '$ip' and den=$den and hodina=$hodina");
        $pzaznam = null;
        if(!($pzaznam = mysqli_fetch_array($result))){
                return "";
        }
        while($row = mysqli_fetch_array($result)){
            //Pokud je priorita vyšší tak ulož do pzaznam
            if($row[4] > $pzaznam[4]){
                $pzaznam = $row;
            }
        }
        
        return $pzaznam[5];
    }
    /**
     * Vráti mysql_query s učilely (zkratka, přijmení)
     */
    function getSeznamUcitelu(){
        $link = linkToMyDb();
        
        return mysqli_query($link,"SELECT * FROM ucitele");  
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
        mysqli_query($link,"DELETE FROM ippc WHERE ip = $ip");
        mysqli_query($link,"INSERT INTO ippc VALUES ('$ip', $pc)");
    }
    
    /**
     * Pokud konkretni záznam není v databází přidá nový, pokud je, tak zvýší prioritu o 1;
     * @param string $ucitel 
     * @param string $jmeno
     * @param int $hodina
     */
    
    function aktualizujRozvrh($ucitel, $jmeno, $hodina){
        $link = linkToMyDb();
        if(!$link){
            return;
        } 
        $ip = get_client_ip();
        $den = getDay();
        $resutl = mysqli_query("SELECT * FROM rozvrh WHERE den = $den and hodina = $hodina and ip like'$ip' and ucitel like'$ucitel' and jmeno like'$jmeno'");
        if(!($row = mysqli_fetch_array($resutl))){
            mysqli_query($link,"INSERT INTO rozvrh VALUES(0, $den, '$ip', '$ucitel', 1, '$jmeno', $hodina)");
        }else{
            mysqli_query($link,"UPDATE rozvrh SET priorita = priorita+1 WHERE id = $row[0]");
        }
    }
    
    /**
     * 
     * @return mysqli_link mysqli_link - připojení k dané databázi.
     */
    function linkToMyDb(){
        $link = mysqli_connect("localhost", "3c30", "3c30", "db_3c30") or die("chyba");
        return $link;
    }
    
    /**
     * 
     * @return int vrátí číslo 1-14 (den od 1.9.2015)
     */
    function getDay(){
        date_default_timezone_set("Europe/Prague");
        return (time() / 86400) % 14;
        
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
            //if(strpos($s,"q".date("md")) !== false && strpos($s,"h".$hodina) !== false){
            if(strpos($s,"q".date("m").date("d")) !== false && strpos($s,"h".$hodina) !== false){
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
        ulozIPPC($pocitac);
        aktualizujRozvrh($ucitel, $jmeno, $hodina);
    }


