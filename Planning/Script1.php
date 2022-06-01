<?php
require("Connexion.php");

$sql="SELECT * from user";
if(!$connexion->query($sql)) echo "Problème de connexion";
else{
     foreach ($connexion->query($sql) as $row)
     echo $row['Nom'];
}
?>