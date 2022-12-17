<?php
  session_start();
  $userid=$_SESSION['user_id'];
  $nomcompte=$_SESSION['nom'];
  $class=$_SESSION['class'];
  if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};
?>


<header class="header">
   <div class="flex">
      <a href="#" class="logo">InfoTech</a>
<?php    
if ($class=='Admin'){ 
echo'<nav class="navbar"><a href="admin.php">Ajouter Produit</a></nav>  ';}
elseif($class=='Admin Principale'){
   echo'<nav class="navbar">
   <a href="admin.php">Ajouter Produit</a>
   <a href="gestion.php">Gestion des Comptes</a>
   </nav>  ';}
else{ echo'<nav class="navbar">
   <a href="products.php">Afficher Produit</a>
</nav>';
$select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
$row_count = mysqli_num_rows($select_rows);
echo'<a href="cart.php" class="cart">Liste De Paiment <span> '.$row_count.'</span> </a>
<div id="menu-btn" class="fas fa-bars"></div>';}
   ?>
   <h1><?php echo $nomcompte ;?></h1>
   <a href="login.php" 
   onclick="return confirm('deconnecter ?');" 
   class="info-btn">Déconnexion</a>

   </div>
</header>

