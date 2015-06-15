
<?php
    include("phpKnihovna.php");
    
    date_default_timezone_set("Europe/Prague");
    
    $jmeno = filter_input(INPUT_POST,"jmeno");
    $pocitac = filter_input(INPUT_POST,"pocitac");
    $ucitel = substr(filter_input(INPUT_POST,"ucitel"),0,3);
    $hodina = filter_input(INPUT_POST,"hodina");
    $ucebna = filter_input(INPUT_POST,"ucebna");
    $trida = filter_input(INPUT_POST,"trida");
    
    $datum = date("md");
    $slozka = "q".$datum.$ucebna."h".$hodina."_".$trida;
    $fileName = $pocitac.$jmeno.".txt";
    $file = fopen($fileName, "w");
    
    $resource = ftp_connect("172.16.1.3") or die("Nepodařilo se připojit k servru");
    
    if(ftp_login($resource, "v01", "01")){
       if(ftp_chdir($resource, "../".$ucitel."/".$slozka)){
           ftp_put($resource, $fileName, $fileName, FTP_ASCII) or die("Nepodařilo se přenest přihlašovaci soubor");
           echo ("Přihlášení proběhlo úspěšně");
       }else{
           echo("Nepodařilo se změnit složku na:<br>");
           echo("../".$ucitel."/".$slozka."<br>");
       }
    }else{
        echo("Nepodařilo se přihlásit uživatele");
    }
    
    $link = mysqli_connect("localhost", "3c30", "3c30", "db_3c30") or die("Nepodařilo se připojit k databázi.");
    $ip = get_client_ip();
    $result = mysqli_query($link,"SELECT * FROM ippc WHERE ip like '$ip'");
    if(!$zaznam = mysqli_fetch_array($result)){
        mysqli_query($link,"INSERT INTO ippc VALUES(0,'$ip','$ucebna',$pocitac)") or die("Nepodařilo se zaevidovat číslo počítače a učebnu.");
    }


