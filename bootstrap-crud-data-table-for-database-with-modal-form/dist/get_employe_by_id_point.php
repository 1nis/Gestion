<?php
require_once "Connexion.php";

    $uid = $_POST['id_row'];
    $insertion2= array();
    $insertion2 = $connexion->query("SELECT `ID`, `Nom`, `Email`, `Date`, `usrid` FROM pointage WHERE ID = '$uid'")->fetch(PDO::FETCH_OBJ);
    echo (json_encode($insertion));


//if  (isset($_POST['Sauvegarder'])){
    // $nommodifier = $_POST['nommodifier'];
    // $mailmodifier = $_POST['mailmodifier'];
    // $adressemodifier = $_POST['adressemodifier'];
    // $numeromodifier = $_POST['numeromodifier'];
    // $insertion = $connexion->query("SELECT * FROM user WHERE ID = '$uid'");
//}
?>