<?php @include 'config.php'; ?>
<?php

if (isset($_POST['add_categorie'])) {
  $nomcategorie = $_POST['a_nomcategorie'];
  $select_categorie = mysqli_query($conn, "SELECT * FROM `categorie` WHERE nomcategorie ='$nomcategorie'");
  if (mysqli_num_rows($select_categorie) > 0) {

    $message[] = 'ce categorie est existe deja !!';
  } else {


    $req_categorie = mysqli_query($conn, "INSERT INTO `categorie`(nomcategorie) VALUES('$nomcategorie')");

    $message[] = 'le categorie est ajouter avec succes';
  }
}

if (isset($_GET['deletecategorie'])) {
  $delete_id = $_GET['deletecategorie'];
  $delete_query = mysqli_query($conn, "DELETE FROM `categorie` WHERE idcategorie = $delete_id ") or die('query failed');
  if ($delete_query) {
    header('location:test.php');
    $message[] = 'categorie has been deleted';
  } else {
    header('location:test.php');
    $message[] = 'categorie could not be deleted';
  };
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.7/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

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

  <form action="" method="POST">
    <input type="text" name="a_nomcategorie" value="Ajouter un nouneau categorie">
    <input type="submit" value="Ajouter" name="add_categorie" class="btn">


  </form>
  <form action="" method="GET">
    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
      <option selected>Choisir un categorie </option>
      <?php
      $select_categorie = mysqli_query($conn, "SELECT * FROM `categorie`");
      if (mysqli_num_rows($select_categorie) > 0) {
        while ($fetch_categorie = mysqli_fetch_assoc($select_categorie)) { ?>
          <option value="<?php $fetch_categorie['idcategorie'] ?>"><?php echo $fetch_categorie['nomcategorie']; ?></option>
      <?php  }
      } ?>
      <a href="test.php?deletecategorie=<?php echo $fetch_categorie['idcategorie'];  ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
    </select>

  </form>



  <!-- <script src="js/script.js"></script>-->
</body>

</html>