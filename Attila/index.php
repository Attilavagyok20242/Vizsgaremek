<?php

$ch= require "init_curl.php";
curl_setopt($ch, CURLOPT_URL, "https://api.github.com/user/repos");
$response=curl_exec($ch);
curl_close($ch);
$data=json_decode($response, true);
?>
<?php require "header.html" ?>
        <h1>Repositories</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $repository): ?> 
                <tr>
                    <td>    
                        <a href ="show.php?full_name=<?= $repository["full_name"] ?>">
                            <?php echo $repository["name"] ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($repository["description"]) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="new.php">New</a>
    <?php require "footer.html" ?>

    <!-- html rész
     foreach ($data as $repository):

Ez a ciklus végigiterál a $data tömbön, amely valószínűleg a GitHub API válaszát tartalmazza. Minden egyes iterációban az aktuális repozitórium adatokat a $repository változóban tároljuk.

<tr> és <td>:

Az adatok egy táblázat sorában jelennek meg. A <tr> HTML tag a táblázat sorát jelenti, és minden egyes repozitóriumot egy új sorban jelenít meg.

Minden repozitórium neve és leírása egy-egy <td> cellában jelenik meg.

Az href értéke egy dinamikus linket generál, amely a show.php oldalra vezet, és átadja a repozitórium full_name mezőjét. Ezt használják a részletes repozitórium oldal betöltéséhez.

Az  $repository["full_name"]  rövidített szintaxis a PHP echo parancsra, amely a repozitórium teljes nevét beilleszti a link URL-jébe.

$repository["name"] 

Itt a repozitórium nevét jelenítjük meg a link szövegeként.

 htmlspecialchars($repository["description"]) 

A htmlspecialchars() függvény a repozitórium leírását biztonságosan jeleníti meg. A htmlspecialchars() automatikusan lekezeli azokat a karaktereket, amelyek HTML speciális karakterek (például <, >, &), és megelőzi az XSS (Cross-Site Scripting) támadásokat.

A endforeach a PHP foreach ciklus végét jelzi.

Összegzés:
Ez a kódrészlet tehát egy dinamikus táblázatot generál, amelyben minden egyes repozitórium neve és leírása megjelenik, és a nevére kattintva a felhasználó a repozitórium részletes oldalára navigálhat.

Ha bármi további kérdésed van, ne habozz megkérdezni! 😊







