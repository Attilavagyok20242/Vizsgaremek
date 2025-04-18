<?php
include "../connection/connection.php";
if(isset($_POST['cim'])&&isset($_POST['tartalom']))
{
    $cim=$_POST['cim'];
    $tartalom=$_POST['tartalom'];
    $sql = "INSERT INTO hirek (hir_cim,hir_szoveg,datum) VALUES (?,?,NOW())";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ss", $cim,$tartalom);
    $stmt->execute();
}


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
     $query = "SELECT COUNT(id) as kommentek FROM uzenetek";
     $result = mysqli_query($conn, $query);
     if ($result) {
         $row = mysqli_fetch_assoc($result);
         $comments = $row['kommentek'];
     
        }
      $query = "SELECT COUNT(id) as felhasznalok FROM felhasznalo";
     $result = mysqli_query($conn, $query);
     if ($result) {
         $row = mysqli_fetch_assoc($result);
         $felhasznalok = $row['felhasznalok'];
     
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin felület</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="css/administrator.css">
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
            <span class="title">Arena Klub</span>
          </a>
        </li>
        <li id="uzemfal">
          <a href="#" >
            <span class="icon">
              <i class='bx bx-cog'></i>
            </span>
            <span class="title">Üzemfal</span>
          </a>
        </li>
        <li id="felhasznalok">
          <a href="#">
          <span class="icon">
          <i class='bx bx-user-pin'></i>
          </span>
          <span class="title">Kezelés</span>
          </a>
        </li>
        <li id="segitseg">
          <a href="#" >
            <span class="icon">
            
              <i class='bx bx-user-pin'></i>
            </span>
            <span class="title">Segítség</span>
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
        
        <!--felhaználó kép-->
        <div class="user">
          <img src="kepek/g.png" alt="">
        </div>
      </div>
      <!--kártyák-->
      <div id="uzemtartalomkeret">
       <div class="cardBox">
        <div class="card">
          <div>
            <div class="numbers"><?php echo $felhasznalok; ?></div>
            <div class="cardName">Regisztrált felhasználók</div>
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
            <div class="cardName">Aktív Felhasználók</div>
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
        <div class="keret">
          <div class="bemenetek">
            <form action="" method="post">
                    <input type="text" name="cim" placeholder="Add meg a hír címét!" class="cim" maxlength="50">
                    <textarea name="tartalom" placeholder="Add meg a hír tartalmát!" class="tartalom" maxlength="600"></textarea>
                    <input type="submit"  value="Küldés!" class="kuld" >
            </form>
        </div>
    </div>
   </div>
   <div id="segitsegtartalomkeret">
    <h2>Beérkezett jelentések</h2>
    <div id="jelentesek" class="jelentesek-container">
    </div>
  </div>
 

  <div class="chatresz">
  <?php if (isset($_SESSION['id'])): ?>
    <div id="cseveges-kapcsolo">Beszélgetés</div>
    <div id="cseveges-doboz" style="display: none;">
        <div id="cseveges-fejlec">Kérj segítséget <span id="cseveges-bezar">×</span></div>
        <div id="cseveges-uzenetek"></div>
        <div id="cseveges-beviteli-terulet">
            <input type="text" id="cseveges-bevitel" placeholder="Írj egy üzenetet..." autocomplete="off" />
            <button id="cseveges-kuldes">Küldés</button>
        </div>
    </div>
    <div id="jelentesek"></div>
  <?php endif; ?>
</div>

   
<div id="felhasznalo_torles"></div>



  
  <script src="Javascripts/felhasznalotorles.js"></script>
   <script src="Javascripts/adminja.js"></script>
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