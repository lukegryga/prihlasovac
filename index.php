<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css" type="text/css">
        <meta charset="UTF-8">
        <title>SPŠE Přihlašovač</title>
        
        
    </head>
    <body>
        <?php
            date_default_timezone_set("Europe/Prague");
            $intCas = intval(date("Hi"))+10;
            $hodiny = array(0700,0842,0937,1032,1137,1227,1317,1407);
            $hodina=0;

            for($i=7;$i>=0;$i--){
                if($intCas>$hodiny[$i]){
                    $hodina = $i+1;
                    break;
                }
            }
        ?>
        
        
        
        <div class="karta" id="stred">
            <form action="ftp.php" method="post">
                <input type="text" autofocus placeholder="Jméno" class="inputvkarte" pattern="[a-zěščřžýáíéóďťúů]{1,12}" title="Jen malá písmena s maximální délkou 12 znaků." name="jmeno" required>
                <input type="text" placeholder="Počítač" class="inputvkarte" pattern="[1-9]{1,2}" title="Jen čísla s délkou 2 znaků." name="pocitac" required><br>
                <input type="text" placeholder="Učitel" class="inputvkarte" pattern="[a-z]{1,12}" title="Jen malá písmena s maximální délkou 12 znaků a bez diakritiky." name="ucitel" required>
                <input type="text" placeholder="Hodina" value=<?php echo ($hodina) ?> class="inputvkarte" pattern="[1-9]{1,2}" title="Jen čísla s délkou 2 znaků." name="hodina" required><br>
                <input type="submit" class="submitvkarte" value="Přihlásit">
            </form>
        </div>
        <?php
        
        ?>
    </body>
</html>