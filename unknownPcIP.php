<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css" type="text/css">
        <link href="whale.png" rel="icon" type="image/png" />
        <link rel="stylesheet" href="http://code.cdn.mozilla.net/fonts/fira.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>
            if (typeof jQuery === 'undefined')
            {
                document.write(unescape("%3Cscript%20src%3D%22js/jquery-2.1.4.min.js%22%3E%3C/script%3E"));
            }
        </script>
        <script src="js/ipPageScript.js"></script>
        <title>SPŠE FTP Přihlašovač</title>
        <style>
            body{
                font-family: "Fira Sans";
                font-weight: 300;
                padding-bottom: 40px;
            }
            
            h1{
                font-weight: 300;
            }
            
            .karta{
                padding: 20px;
            }
            
            #ohNo{
                color: #4CB7C3;
                font-size: 200px;
                font-weight: 800;
                font-family: "Fira Sans";
            }
            .center{
                text-align: center;
            }
            
            /*HNUS*/
            table{
                width: 90%;
            }
            
            .button {
                border-radius: 3px;
                background-color: #61A7EA;
                border: 1px solid #4CA1F4;
                padding: 10px;
                text-decoration: none;
                color: #FFFAFA;
                font-size: 1em;
                
            }
            
            .proposedSolution .button{
                width: 70px;
                transition: width 1s, padding-left 1s, padding-right 1s, border 1s;
            }
            
            .proposedSolution .button.hidden{
                width: 0;
                padding: 0;
                border: 0;
            }
            
            .proposedSolution{
                padding: 20px;
                border-bottom: #A6A6A6 1px solid;
            }
            
            .proposedSolution:last-of-type{
                padding: 20px;
                border-bottom: none;
            }
        </style>
    </head>
    
    <body>
        
        <div class="karta center">
            <h1>Než budete pokračovat...</h1>
            <div id="ohNo">:/</div>
            <p>
                Pokoušeli jsme se zjistit, na kterém počítači sedíte, ale něco nám v tom brání.
                Mezi naším serverem a vaším PC je pravděpodobně
                router, který znemožňuje identifikaci pomocí adresy IP.
            </p>
            <p>
                Ale nezoufejte, stačí vyplnit některý z údajů níže a můžete
                pokračovat.
            </p>
        </div>
        <div class="karta center">
            <h1>Možná řešení</h1>
            <div class="proposedSolution" id="getbypcnumber">
                <form method="get" action="index.php">
                    <input id="pcnumber" name="pcnumber" type="text" placeholder="Číslo PC" class="inputvkarte unhidesubmitbutton" pattern="[0-9]{1,2}" title="Jen čísla s délkou 2 znaků." required>
                    <input type="hidden" name="ip">
                    <input type="submit" class="hidden button" value="Odešli">
                </form>
            </div>
            <div class="proposedSolution">
                <form method="get" action="index.php">
                    <input id="ipAddress" name="ip" type="text" placeholder="IP adresa" class="inputvkarte unhidesubmitbutton" pattern="[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}" title="Platná IPv4 IP adresa" required>
                    <input type="submit" class="hidden button" value="Odešli">
                </form>
            </div>
        </div>
    </body>
</html>