<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('config.php');
if (isset($_REQUEST['prenom'], $_REQUEST['nom'], $_REQUEST['email'], $_REQUEST['numero'], $_REQUEST['password'])){
    // récupérer le prenom et supprimer les antislashes ajoutés par le formulaire
    $prenom = stripslashes($_REQUEST['prenom']);
    $prenom = mysqli_real_escape_string($conn, $prenom);
    // récupérer le nom et supprimer les antislashes ajoutés par le formulaire
    $nom = stripslashes($_REQUEST['nom']);
    $nom = mysqli_real_escape_string($conn, $nom);
    // récupérer l'email et supprimer les antislashes ajoutés par le formulaire
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    // récupérer le numero et supprimer les antislashes ajoutés par le formulaire
    $numero = stripslashes($_REQUEST['numero']);
    $numero = mysqli_real_escape_string($conn, $numero);
    // récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    //requéte SQL + mot de passe email et numero crypté
    $query = "INSERT into `users` (prenom, nom, email, numero, password)
              VALUES ('$prenom','$nom','$email', '$numero', '".hash('sha256',$password)."');";
    // Exécute la requête sur la base de données
    $res = mysqli_query($conn, $query);
    if($res){
        header("location:../site/site.php");
    } else {
        echo "Erreur lors de l'exécution de la requête SQL: " . mysqli_error($conn);
    }
} else {
?>
<form class="box" action="" method="post">
    <h1 class="box-title">S'inscrire</h1> 
    <input type="text" class="box-input" name="prenom" placeholder="Prénom" required /> 
    <input type="text" class="box-input" name="nom" placeholder="Nom" required /> 
    <input type="text" class="box-input" name="email" placeholder="Email" required /> 
    <input type="tel" class="box-input" name="numero" placeholder="numero" required /> 

    <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />     
    <input type="submit" name="submit" value="S'inscrire" class="box-button" />
    <p class="box-register">Déjà inscrit? <a href="connexion.php">Connectez-vous ici</a></p> 
</form> 
<?php } ?> 
</body> 
</html>

