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

Class dbObj{
    /* Database connection start */
    var $dbhost = "localhost";
    var $username = "root";
    var $password = "";
    var $dbname = "planning";
    var $conn;
        function getConnstring() {
            $con = mysqli_connect($this->dbhost, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
    
                /* check Database connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                } else {
                    $this->conn = $con;
                }
                return $this->conn;
        }
    }
?>

