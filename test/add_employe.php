<?php

require_once "Connexion.php";
include "index---.php";

    // Ici si l'utilisateur clique sur le bouton ajouter alors les valeurs sont directement ajouter dans la bdd dans la table user //
    if (isset($_POST['Ajouter'])) {
        $ajouterpersonne = $connexion->query("INSERT INTO user VALUES (null, '{$_POST['nomajouter']}', '{$_POST['mailajouter']}', '{$_POST['adresseajouter']}', '{$_POST['numeroajouter']}')");
    }
?>