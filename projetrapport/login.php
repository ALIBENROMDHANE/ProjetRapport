<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $pass = $_POST['password'];

   $select = mysqli_query($conn, "SELECT * FROM `compte` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['idcompte'];
      $_SESSION['class'] = $row['class'];
      $_SESSION['nom'] =$row['nom'];

if ($row['class']=='Client')               {header('location:cart.php');}
elseif ($row['class']=='Commercant')            {header('location:admin.php');}
elseif ($row['class']=='Admin Principale') {header('location:gestion.php');}
else                                       {$message[] = 'incorrect password or email!';}

}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style1.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login </h3>
      <input type="email" name="email" required placeholder="Entrer l'adresse email" class="box">
      <input type="password" name="password" required placeholder="Entrer password" class="box">
      <input type="submit" name="submit" class="btn" value="login">
      <p> créer un nouveau compte? <a href="registre.php">Enregistrer</a></p>
   </form>

</div>

</body>
</html>