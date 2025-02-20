<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="News.css">
    
    <title>News</title>
</head>
<body>

<div id="eltun" onclick="Eltun()"></div>
    <h1>Hírek</h1>
    <table id="NewsTable">
    <tr>
        <div class="popup" id="felugro1">
            <form method="post" action="Kommentment.php" class="mozgat">
                <div id="egyutt1">
                <div id="kommentelj1">
                    
                </div>
                <textarea class="szovegd" placeholder="Írd le véleményed..." name="komment"></textarea>
                <input type="submit" class="kuld" value="Posztolom">
                </div>
            </form>
        </div>
        <td class="krt"><img src="NewsImg/Orbán.png" class="NImg"></td>
        <td class="SzN"><?php ?><?php require("../Kapcsolat.php"); $sql = "SELECT hir FROM `hirek` WHERE 0=(SELECT id FROM hirek ORDER BY id DESC LIMIT 1)-id;";
                        $result = $con->query($sql);
                        $szoveg=$result->fetch_assoc();
                        print($szoveg["hir"]);
                        ?></td>
    </tr>
    <tr>
    <td colspan="2" class="krt"><img src="NewsImg/Comment2.png" onclick="Komm()"alt="KOMMENT"><td>
    </tr>
    <tr>
        <div class="popup" id="felugro2">
            
            <form method="post" action="Kommentment.php">
                <div id="egyutt2">
                <div id="kommentelj2">
                    <div class="megjelent"><p>Szléj:</p><p>Sziasztok!</p><p>2024-10-23 11:12:13</p></div>
                    <div class="megjelent"><p>Szléj:</p><p>Sziasztok!</p><p>2024-10-23 11:12:13</p></div>
                    <div class="megjelent"><p>Szléj:</p><p>Sziasztok!</p><p>2024-10-23 11:12:13</p></div>
                </div>
                <textarea class="szovegd" placeholder="Írd le véleményed..." name="komment"></textarea>
                <input type="submit" class="kuld" value="Posztolom">
                </div>
            </form>
        </div>
        <td class="krt"><img src="NewsImg/Orbán.png" class="NImg"></td>
        <td class="SzN"><?php require("../Kapcsolat.php"); $sql = "SELECT hir FROM `hirek` WHERE 1=(SELECT id FROM hirek ORDER BY id DESC LIMIT 1)-id;";
                        $result = $con->query($sql);
                        $szoveg=$result->fetch_assoc();
                        print($szoveg["hir"]);
                        ?>
        </td>
    </tr>
    <tr>
    <td colspan="2" class="krt"><img src="NewsImg/Comment2.png" onclick="Comm()" alt="KOMMENT"><td>
    </tr>
    <tr>
        <div class="popup" id="felugro3">
            
            <form method="post" action="Kommentment.php">
                <div id="egyutt3">
                <div id="kommentelj3">
                    <div class="megjelent"><p>Szléj:</p><p>Sziasztok!</p><p>2024-10-23 11:12:13</p></div>
                    <div class="megjelent"><p>Szléj:</p><p>Sziasztok!</p><p>2024-10-23 11:12:13</p></div>
                    <div class="megjelent"><p>Szléj:</p><p>Sziasztok!</p><p>2024-10-23 11:12:13</p></div>
                </div>
                <textarea class="szovegd" placeholder="Írd le véleményed..." name="komment"></textarea>
                <input type="submit" class="kuld" value="Posztolom">
                </div>
            </form>
        </div>
        <td class="krt"><img src="NewsImg/Orbán.png" class="NImg"></td>
        <td class="SzN"><?php require("../Kapcsolat.php"); $sql = "SELECT hir FROM `hirek` WHERE 2=(SELECT id FROM hirek ORDER BY id DESC LIMIT 1)-id;";
                        $result = $con->query($sql);
                        $szoveg=$result->fetch_assoc();
                        print($szoveg["hir"]);
                        ?></td>
    </tr>
    <tr>
    <td colspan="2" class="krt"><img src="NewsImg/Comment2.png" onclick="Comm()" alt="KOMMENT"><td>
    </tr>
    


    </table>
    
    
    

    <script src="News.js"></script>
    
</body>
</html>