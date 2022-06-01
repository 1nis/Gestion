<?php
// Connexion à la BDD planning avec comme id : root et un mdp vide. //
$user = "root";
$pass = "";
try {
    $connexion = new PDO('mysql:host=localhost;dbname=planning', $user, $pass);
    
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>