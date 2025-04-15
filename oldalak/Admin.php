<?php
$views = 0;
session_start();
require_once "../connection/connection.php";

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit("Nincs jogosultság.");
}

if (isset($_SESSION['views'])) {
    $views = $_SESSION['views'];
}
setcookie('views', $views, time() + (86400 * 30), "/"); // Set the cookie to expire in 30 days
$id=0;
$nev="";
$jelszo="";
if(isset($_SESSION['id'])&&isset($_SESSION['nev'])&&isset($_SESSION['jelszo']))
{
   $id=$_SESSION['id'];
   $nev=$_SESSION['nev'];
   $jelszo=$_SESSION['jelszo'];
}
?>
<?php
include "../connection/connection.php";
 $comments=0;
  if (isset($_SESSION['messages']))
   {
    $comments = $_SESSION['messages'];
   }
    
 
?>

<?php
 include '../connection/connection.php';
 $adminnumber= 0;
 $query = "SELECT COUNT(aktív) as felhasznalo FROM felhasznalo WHERE aktív = true and Szerep=1";
$result = mysqli_query($conn, $query);
 if ($result) {
     $row = mysqli_fetch_assoc($result);
     $adminnumber = $row['felhasznalo'];
 }
 $felhasznalo=0;
 $query = "SELECT COUNT(aktív) as felhasznalo FROM felhasznalo WHERE aktív = true and Szerep=0";
 $result = mysqli_query($conn, $query);
 if ($result) {
     $row = mysqli_fetch_assoc($result);
     $felhasznalo = $row['felhasznalo'];
 }
     $query = "SELECT COUNT(szoveg) as szoveg FROM uzenetek";
     $result = mysqli_query($conn, $query);
     if ($result) {
         $row = mysqli_fetch_assoc($result);
         $comments = $row['szoveg'];
     
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="css/administrator.css">
<link rel="stylesheet" href="../css/segitseg.css">
  <script src="javascriptek/segitseg.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
   <div class="container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#">
            <span class="icon">
              <i class='bx bx-home'></i>
            </span>
            <span class="title">Gladiator Arena</span>
          </a>
        </li>
        <li>
          <a href="#" id="uzemfal">
            <span class="icon">
              <i class='bx bx-cog'></i>
            </span>
            <span class="title">Üzemfal</span>
          </a>
        </li>
        <li>
          <a href="#" id="segitseg">
            <span class="icon">
            
              <i class='bx bx-user-pin'></i>
            </span>
            <span class="title">Segítség</span>
          </a>
        </li>
        <li>
          <a href="#" id="beállítások">
            <span class="icon">
              <i class='bx bx-user'></i>
           
            </span>
            <span class="title">Beállítások</span>
          </a>
        </li>
        
        <li>
          <a href="/kilepesadmin">
            <span class="icon">
              <i class='bx bx-power-off'></i>
            </span>
            <span class="title">
              Kilépés
          </a>
        </li>
      </ul>
    </div>

    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
        <!--kereső-->
        <div class="search">
          <label >
            <input type="text" placeholder="Itt tudsz keresni!">
            <i class='bx bx-search'></i>
          </label>
        </div>
        <!--felhaználó kép-->
        <div class="user">
          <img src="kepek/g.png" alt="">
        </div>
      </div>
      <!--kártyák-->
       <div class="cardBox">
        <div class="card">
          <div>
            <div class="numbers"><?php echo $views; ?></div>
            <div class="cardName">Napi megtekintés</div>
          </div>
           <div class="iconBx">
            <i class='bx bxs-user'></i>
           </div>
        </div>
        <div class="card">
          <div>
            <div class="numbers"><?php echo  $comments;?></div>
            <div class="cardName">Kommentek</div>
          </div>
           <div class="iconBx">
            <i class='bx bxs-message-rounded'></i>
           </div>
        </div>
        <div class="card">
          <div>
            <div class="numbers"><?php echo $felhasznalo;?></div>
            <div class="cardName">Aktív Felhasznalók</div>
          </div>
           <div class="iconBx">
            <i class='bx bxs-user'></i>
           </div>
        </div>
        <div class="card">
          <div>
            <div class="numbers"><?php echo $adminnumber;?></div>
            <div class="cardName">Aktív Adminok</div>
          </div>
           <div class="iconBx">
            <i class='bx bxs-user'></i>
           </div>
        </div>
       </div>
  <div class="ablak">
  <?php if (isset($_SESSION['id'])): ?>
    <div class="egybeazegesz" id="jelkeret">
        
         <div id="cseveges-kapcsolo">Jovahagyas</div> 
    </div>
       <div id="cseveges-doboz" style="display: none;">
        <div id="cseveges-fejlec">Kérj segítséget <span id="cseveges-bezar">×</span></div>
        <div id="cseveges-uzenetek"></div> <!-- Üzenetek megjelenítése -->
        <div id="cseveges-beviteli-terulet">
            <input type="text" id="cseveges-bevitel" placeholder="Írj egy üzenetet..." autocomplete="off" /> <!-- Üzenet beírása -->
            <button id="cseveges-kuldes">Küldés</button> <!-- Üzenet elküldése -->
        </div>
    </div>
<?php endif; ?>
  </div>
  




    </div>
   </div>
   <script src="Javascripts/adminja.js"></script>
   <script src="Javascripts/user-adats.js"></script>
   <script>
      let toggle=document.querySelector('.toggle');
      let navigation=document.querySelector('.navigation');
      let main=document.querySelector('.main');
      toggle.onclick=function(){
        navigation.classList.toggle('active');
        main.classList.toggle('active');
      }

    let list=document.querySelectorAll('.navigation li');
    function activeLink(){
      list.forEach((items)=>
        items.classList.remove('hovered'));
        this.classList.add('hovered');
    }
      list.forEach((item)=>
      item.addEventListener('mouseover',activeLink));
   </script>
</body>
</html>