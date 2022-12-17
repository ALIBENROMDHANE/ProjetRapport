<?php 
  class Post {
    // DB stuff
    private $conn;
    private $table = 'produit';

    // Post Properties
    public $idproduit;
    public $nomproduit;
    public $description;
    public $prix;
    public $idcategorie;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query 
     
      $query = "SELECT p.*,c.nomcategorie FROM `produit`p,categorie c WHERE p.idcategorie=c.idcategorie ";
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
 
  }