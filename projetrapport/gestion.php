<?php
@include 'config.php';
if (isset($_POST['envoyer'])) {
  $compte_password = $_POST['password'];
  $compte_email = $_POST['email'];
  $requte = "SELECT * FROM `compte` WHERE email='$compte_email' and password ='$compte_password' ";
  $select_compte = mysqli_query($conn, $requte);
  if (mysqli_num_rows($select_compte) > 0) {
    $fetch_compte = mysqli_fetch_assoc($select_compte);
    if ($fetch_compte['class'] = 'Admin Principale') {
      header('location:gestion_compte.php');
    } elseif ($fetch_compte['class'] = 'Admin') {
      header('location:../admin.php');
    } else {
      header('location:../products.php');
    }
  } else {
    echo ("votre compte n'existe pas");
    header('location:index.php');
  }
} 



if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_query = mysqli_query($conn, "DELETE FROM `compte` WHERE idcompte = $delete_id ") or die('ne peut pas supprimer ');
  if ($delete_query) {
     header('location:gestion.php');
     $message[] = 'Compte est Supprimer avec succe';
  } else {
     header('location:gestion.php');
     $message[] = 'existe un probleme !';
  }
}









?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php include 'header.php'; ?>
  <?php

if (isset($message)) {
   foreach ($message as $message) {
      echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>
  <section class="display-product-table">
    <h1 class="heading">Traitemenet des Comptes</h1>
    <table>

      <thead>
        <th>id</th>
        <th>Nom </th>
        <th>Adresse e-mail</th>
        <th>Password</th>
        <th>Class</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php $select_tout_les_comptes = mysqli_query($conn, "SELECT * FROM `compte`");
        if (mysqli_num_rows($select_tout_les_comptes) > 0) {
          while ($afficher_tout_les_comptes = mysqli_fetch_assoc($select_tout_les_comptes)) {

        ?>
            <tr>
              <td><?php echo $afficher_tout_les_comptes['idcompte']; ?></td>
              <td><?php echo $afficher_tout_les_comptes['nom']; ?></td>
              <td><?php echo $afficher_tout_les_comptes['email']; ?></td>
              <td><?php echo $afficher_tout_les_comptes['password']; ?></td>
              <td><?php echo $afficher_tout_les_comptes['class']; ?></td>
              <td colspan="2">
                <a href="gestion.php?delete=<?php echo $afficher_tout_les_comptes['idcompte']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Supprimer </a>
                <a href="gestion.php?edit=<?php echo $afficher_tout_les_comptes['idcompte']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Modifier </a>
              </td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
    <table class="table table-borderless">
    <thead>
    
        <th>Nom </th>
       
        <th>Adresse e-mail</th>
        <th>Password</th>
        <th>Class</th>
        <th>Action</th>
      </thead>
      <tbody>
        <tr>
          <td><input type="text" class="box"  name="Ajouter_nom" id="" value="donner le nom"></td>
          <td><input type="email" class="box" name="Ajouter_email" id="" value="donner le nom"> </td>
          <td><input type="password"class="box"  name="Ajouter_password" id="" value="donner le nom"> </td>
          <td>  <select name="Ajouter_Class" class="box" aria-label=".form-select-lg example">
                <option disabled selected>Selectionner le Classe </option>
                <option value="Admin Principale">Commercant</option>
                <option value="Admin">Admin</option>
                <option value="Client">Client</option>
              </select></td>
          <td colspan="">
            <a href="gestion.php?Ajouter=<?php echo $afficher_tout_les_comptes['idcompte']; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> Ajouter </a>
          </td>
        </tr>
  </section>
</body>

</html>