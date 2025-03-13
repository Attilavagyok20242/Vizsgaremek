<?php
require("../connection.php");
$sql="SELECT hir_szoveg, hir_kep FROM hirek ORDER BY datum ASC LIMIT 3";
$result=$con->query($sql);

while($row=$result->fetch_assoc())
{
    $tomb[]=array
    (
        "hir_szoveg" => $row["hir_szoveg"],
        "hir_kep" => $row["hir_kep"]
    );
}
$elso_hir=$tomb[0]["hir_szoveg"];
$masodik_hir=$tomb[1]["hir_szoveg"];
$harmadik_hir=$tomb[2]["hir_szoveg"];
$elso_hir_kep=$tomb[0]["hir_kep"];
$masodik_hir_kep=$tomb[1]["hir_kep"];
$harmadik_hir_kep=$tomb[2]["hir_kep"];
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="News.css">
    
    <title>Hírek</title>
</head>
<body>


    
    
    

    <script src="News.js"></script>
    
</body>
</html>