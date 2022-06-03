<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
    // connexion à la base de données
    $db_username = 'root';
    $db_password = '';
    $db_name     = 'db_login';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
           or die('could not connect to database');
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    
    if($username !== "" && $password !== "")
    {
        $requete = "SELECT count(*) FROM loginform where 
              user = '".$username."' and pass = '".$password."' ";
        $exec_requete = mysqli_query($db,$requete);
        $reponse      = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
           $_SESSION['username'] = $username;
           header('Location: index---.php');
        }
        else
        {
           echo "Mot de passe incorrect !";
           header('Location: Login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
        echo "Veuillez remplir tous les champs !";
       header('Location: Login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: Login.php');
}
mysqli_close($db); // fermer la connexion
?>