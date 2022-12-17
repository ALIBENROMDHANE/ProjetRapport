<?php


@include 'config.php';

if (isset($_POST['add_product'])) {
   $p_name = $_POST['p_name'];
   $p_description = $_POST['p_description'];
   $p_idcategorie = $_POST['p_idcategorie'];
   $p_price = $_POST['p_price'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/' . $p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `produit`(nomproduit, description,prix, image,idcategorie) VALUES('$p_name','$p_description', '$p_price', '$p_image','$p_idcategorie')") or die('query failed');

   if ($insert_query) {
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product add succesfully';
   } else {
      $message[] = 'could not add the product';
   }
};


if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `produit` WHERE idproduit = $delete_id ") or die('query failed');
   if ($delete_query) {
      header('location:admin.php');
      $message[] = 'product has been deleted';
   } else {
      header('location:admin.php');
      $message[] = 'product could not be deleted';
   }
}

if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_description = $_POST['update_p_description'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/' . $update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `produit` SET nomproduit = '$update_p_name', description ='$update_p_description', prix = '$update_p_price', image = '$update_p_image' WHERE idproduit = '$update_p_id'");

   if ($update_query) {
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated succesfully';
      header('location:admin.php');
   } else {
      $message[] = 'product could not be updated';
      header('location:admin.php');
   }
}


if (isset($_GET['add_categorie'])) {
   $nomcategorie = $_GET['add_categorie'];
   $select_categorie = mysqli_query($conn, "SELECT * FROM `categorie` WHERE nomcategorie ='$nomcategorie'");
   if (mysqli_num_rows($select_categorie) > 0) {

      $message[] = 'ce categorie est existe deja !!';
   } else {


      $req_categorie = mysqli_query($conn, "INSERT INTO `categorie`(nomcategorie) VALUES('$nomcategorie')");

      $message[] = 'le categorie est ajouter avec succes';

   }
}







?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Commercant panel</title>

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
<h1 class="heading">Traitemenet des Produits</h1>
  

   <div class="container">

      <section>

         <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
            <h3>Ajouter Nouveau Produit </h3>
            <input type="text" name="p_name" placeholder="nom du produit...." class="box" required>
            <textarea class="box" required name="p_description" placeholder="Description...."></textarea>
            <input type="number" name="p_price" min="0" placeholder="prix " class="box" required>
            <select name="p_idcategorie" class="box" aria-label=".form-select-lg example">
               <option disabled selected>Selectionner un categorie </option>
               <?php
               $select_categorie = mysqli_query($conn, "SELECT * FROM `categorie`");
               if (mysqli_num_rows($select_categorie) > 0) {
                  while ($fetch_categorie = mysqli_fetch_assoc($select_categorie)) { ?>
                     <option value="<?php echo $fetch_categorie['idcategorie'] ?>"><?php echo $fetch_categorie['nomcategorie']; ?></option>
               <?php  }
               } ?>

            </select>

            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
            <input type="submit" value="Ajouter" name="add_product" class="btn">
         </form>
      </section>
      <section>

 


</div>
         </form>

      </section>

      <section class="display-product-table">

         <table>

            <thead>
               <th>image</th>
               <th>nom de produit </th>
               <th>Categorie</th>
               <th>description </th>
               <th>prix </th>
               <th>action</th>
            </thead>

            <tbody>
               <?php

               $select_products = mysqli_query($conn, "SELECT p.*,c.nomcategorie FROM `produit`p,categorie c WHERE p.idcategorie=c.idcategorie ");
               if (mysqli_num_rows($select_products) > 0) {
                  while ($row = mysqli_fetch_assoc($select_products)) {
               ?>

                     <tr>
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['nomproduit']; ?></td>
                        <td><?php echo $row['nomcategorie']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['prix']; ?>DT</td>
                        <td colspan="2">
                           <a href="admin.php?delete=<?php echo $row['idproduit']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Supprimer </a>
                           <a href="admin.php?edit=<?php echo $row['idproduit']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Modifier </a>
                        </td>
                     </tr>

               <?php
                  };
               } else {
                  echo "<div class='empty'>no product added</div>";
               };
               ?>
            </tbody>
         </table>
         <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET" class="add-product-form" enctype="multipart/form-data">
            <h3>Categorie </h3>
            <div>
            <input type="text" class="box" name="a_nomcategorie" value="Ajouter un nouveau catégorie">
            <a href="admin.php?add_categorie=a_nomcategorie" class="option-btn"> <i class="fas fa-edit"></i> Ajouter </a>
            </div>
<div>

      </section>

      <section class="edit-form-container">

         <?php

         if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `produit` WHERE idproduit = $edit_id");
            if (mysqli_num_rows($edit_query) > 0) {
               while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
         ?>

                  <form action="" method="post" enctype="multipart/form-data">
                     <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
                     <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['idproduit']; ?>">
                     <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['nomproduit']; ?>">

                     <textarea class="box" required name="update_p_description" value="<?php echo $fetch_edit['description']; ?>"></textarea>

                     <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['prix']; ?>">
                     <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                     <input type="submit" value="update the prodcut" name="update_product" class="btn">
                     <input type="reset" value="cancel" id="close-edit" class="option-btn">







                  </form>

         <?php
               };
            };
            echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
         };
         ?>
      </section>
   </div>





   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>