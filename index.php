<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css" type="text/css">
        <meta charset="UTF-8">
        <link href="whale.png" rel="icon" type="image/png" />
        <title>SPŠE FTP Přihlašovač</title>
    </head>
    
    <body>
        <?php 
            include("phpKnihovna.php");
            if(isset($_POST['prihlasit'])){
                $errorMessage = vsechno_funkce();
                echo "<div class=\"karta\" id=\"stred\">";    
                echo "<a id=\"error\"> $errorMessage</a>"; 
                echo "</div>";
            }
            $hodina = getHodina();
        ?>

        <div class="karta" id="stred">
            <form action="index.php" method="post">
                <input type="text" class="inputvkarte" id="nadpis_input" value="Jméno" readonly="true">
                <input type="text" class="inputvkarte" id="nadpis_input" value="Počítač" readonly="true"><br>
                <input type="text" autofocus placeholder="Jméno" class="inputvkarte" pattern="[a-zěščřžýáíéóďťúů]{1,12}" title="Jen malá písmena s maximální délkou 12 znaků." value=<?php echo"\""; echo getJmeno(); echo"\""; ?> name="jmeno" required>
                <input type="text" placeholder="Počítač" class="inputvkarte" pattern="[0-9]{1,2}" title="Jen čísla s délkou 2 znaků." name="pocitac" required value="<?php echo getCisloPc(get_client_ip()) ?>" ><br>
                <input type="text" class="inputvkarte" id="nadpis_input" value="Jméno" readonly="true">
                <input type="text" class="inputvkarte" id="nadpis_input" value="Počítač" readonly="true"><br>
                <select>
                    <?php
                    $seznamUcitelu = getSeznamUcitelu();
                        while($row = mysqli_fetch_array($seznamUcitelu, MYSQL_NUM)){
                            echo "<option value=\"$row[0]\" "; 
                            if(getUcitel() == $row[0]){
                                echo " selected ";
                            }
                            echo">$row[1]</option>";
                        }
                    ?>
                </select>
                <!--<input type="text" placeholder="Učitel" class="inputvkarte" pattern="[a-z]{1,12}" title="Jen malá písmena s maximální délkou 12 znaků a bez diakritiky." name="ucitel" required>-->
                <input type="text" placeholder="Hodina" value=<?php echo ($hodina) ?> class="inputvkarte" pattern="[0-9]{1}" title="Jen čísla s délkou 2 znaků." name="hodina" required><br>
                <input type="text" class="inputvkarte" id="nadpis_input" value="Jméno" readonly="true"><br>
                <input type="text" placeholder="Report" class="inputvkarte" name="report"><br>
                <input type="submit" class="submitvkarte" name="prihlasit" value="Přihlásit">
            </form>
        </div>
    </body>
</html>