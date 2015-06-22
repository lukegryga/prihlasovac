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
                echo $errorMessage;
            }
            $hodina = getHodina();
        ?>

        <div class="karta" id="stred">
            <form action="index.php" method="post">
                <input type="text" autofocus placeholder="Jméno" class="inputvkarte" pattern="[a-zěščřžýáíéóďťúů]{1,12}" title="Jen malá písmena s maximální délkou 12 znaků." name="jmeno" required>
                <input type="text" placeholder="Počítač" class="inputvkarte" pattern="[0-9]{1,2}" title="Jen čísla s délkou 2 znaků." name="pocitac" required><br>
                <input type="text" placeholder="Učitel" class="inputvkarte" pattern="[a-z]{1,12}" title="Jen malá písmena s maximální délkou 12 znaků a bez diakritiky." name="ucitel" required>
                <input type="text" placeholder="Hodina" value=<?php echo ($hodina) ?> class="inputvkarte" pattern="[0-9]{1,2}" title="Jen čísla s délkou 2 znaků." name="hodina" required><br>
                <input type="text" placeholder="Report" class="inputvkarte" name="report"><br>
                <input type="submit" class="submitvkarte" name="prihlasit" value="Přihlásit">
            </form>
        </div>
    </body>
</html>