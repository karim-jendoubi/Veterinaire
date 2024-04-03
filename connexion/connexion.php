<?php
session_start();
require('config.php');


if (isset($_POST['email'])) {
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM `users` WHERE email='$email' and password='" . hash('sha256', $password) . "'";
    var_dump($query);

    $result = mysqli_query($conn, $query);
    var_dump($result);

    if (!$result) {
        $message = "Erreur dans la requête SQL : " . mysqli_error($conn);
    } else {
        $rows = mysqli_num_rows($result);
        var_dump($rows);

        if ($rows == 1) {
            $_SESSION['email'] = $email;
            header("Location: ../site/site.php");
            exit();
        } else {
            $message = "L'email ou le mot de passe est incorrect.";
            var_dump($message);
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<form class="box" method="post" name="login">
		<h1 class="box-title">Connexion</h1>
		<input type="text" class="box-input" name="email" placeholder="Email">
		<input type="password" class="box-input" name="password" placeholder="Mot de passe">
		<input type="submit" value="Connexion " name="submit" class="box-button" >
		<?php if (! empty($message)) { ?>
	    	<p class="errorMessage"><?php echo $message; ?></p>
		<?php } ?>
		<p class="box-register">Vous êtes nouveau ici? <a href="inscription.php">S'inscrire</a></p>
	</form>
</body>
</html>

