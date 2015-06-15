<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>SPŠE Přihlašovač</title>
        <style>
            body{ 
                width:100%;
            }
            .telo{
                max-width:400px;
                max-height:600px;
                margin:auto;
                box-shadow:#777777 0px 0px 5px;
                
            }
        </style>
        
    </head>
    
    <?php
        date_default_timezone_set("Europe/Prague");
        $intCas = intval(date("Hi"))+10;
        $hodiny = array(0700,0842,0937,1032,1137,1227,1317);
        $hodina=0;

        for($i=6;$i>=0;$i--){
            if($intCas>$hodiny[$i]){
                $hodina = $i+1;
                break;
            }
        }
    ?>

    <body>
        <div class="telo">
            <form action="ftp.php" method="post">
                <label for="jmeno">Jméno</label><br>
                <input type="text" name="jmeno" required><br>
                <label for="trida">Třída</label><br>
                <input type="text" name="trida" required><br>
                <label for="pocitac">Počítač</label><br>
                <input type="text" name="pocitac" required><br>
                <label for="ucitel">Učitel</label><br>
                <input type="text" name="ucitel" required><br>
                <label for="hodina">Hodina</label><br>
                <input type="text" name="hodina" value=<?php echo ($hodina) ?> required><br>
                <label for="ucebna">Učebna</label><br>
                <input type="text" name="ucebna" required><br><br>
                <input type="submit" value="Přihlaš">
            </form>
        </div>
    </body>
</html>
