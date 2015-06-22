<?php
    /**
     * 
     * @return string IP adresa klienta. Když neúspěch tak vrací prázdný řetězec
     */
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    /**
     * Funkce pro zobrazení karty s chybovou hláškou,
     * @param type $info string je text hlášky
     * @param type $die bool je informace o chtění smrti
     */
    function show_card($info, $die=false) {
        
        $karta = $info;
        
        if($die){
            die($karta);
        }else{
            echo ($karta);
        }
        
    }
    
    function vsechno_funkce() {
        date_default_timezone_set("Europe/Prague");
        
        $jmeno = filter_input(INPUT_POST,"jmeno");
        $pocitac = filter_input(INPUT_POST,"pocitac");
        $ucitel = substr(filter_input(INPUT_POST,"ucitel"),0,3);
        $hodina = filter_input(INPUT_POST,"hodina");
        
        $soubory = scandir("/home/".$ucitel);
        foreach($soubory as $s){
            echo($s);
        }
        
        $fileName = $pocitac.$jmeno.".txt";
        $file = fopen($fileName, "w");

        $resource = ftp_connect("172.16.1.3");
        if(!$resource){
            return "Nelze se připojet k serveru";
        }
        
        if(ftp_login($resource, "v01", "01")){
           if(ftp_chdir($resource, "../".$ucitel."/".$slozka)){
               $istrue = ftp_put($resource, $fileName, $fileName, FTP_ASCII);
               if(!$istrue){
                    return "Nepodařilo se přenest přihlašovaci soubor";
               }
               show_card("Přihlášení proběhlo úspěšně"); 
           }else{
               show_card("Nepodařilo se změnit složku na:<br>");
               show_card("../".$ucitel."/".$slozka."<br>");
           }
        }else{
            show_card("Nepodařilo se přihlásit uživatele");
        }

        $link = mysqli_connect("localhost", "3c30", "3c30", "db_3c30");
        if(!$link){
            return "Nepodařilo se připojit k databázi.";
        }
        $ip = get_client_ip();
        $result = mysqli_query($link,"SELECT * FROM ippc WHERE ip like '$ip'");
        if(!$zaznam = mysqli_fetch_array($result)){
            $istrue = mysqli_query($link,"INSERT INTO ippc VALUES(0,'$ip','$ucebna',$pocitac)");
            if(!$istrue){
                return "Nepodařilo se zaevidovat číslo počítače a učebnu.";
            }
            
        }
    }

?>

