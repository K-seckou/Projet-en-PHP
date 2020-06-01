<?php

session_start();

if (isset($_SESSION['connect'])) {
	header('location: index.php');
}

require 'Src/Bdd.php';

if (!empty($_POST['Email']) && !empty($_POST['pass'])) {

	$Email = $_POST['Email'];
	$Password = $_POST['pass'];
	$Password = "aq1".sha1($Password."4509")."987";

	$req = $Bdd->prepare('SELECT * FROM users WHERE Email = ?');

	$req->execute(array($Email));

	while ($users = $req->fetch()){
		
		if ($Password != $users['Password']) {
			
			header('location: ?error=true&pass=1');
			exit();
		}
		elseif ($Password == $users['Password']) {

			$_SESSION['connect'] 	= 1;
			$_SESSION['pseudo'] 	= $users['Pseudo'];

			if (isset($_POST['auto'])) {

				setcookie('login', $users['Secret'], time() + 365*24*3600, '/', null, false, true);
				setcookie('Pseudo', $users['Pseudo'], time() + 365*24*3600, '/', null, false, true);
			}

			header('location: ?succes=1');
			exit();
		}
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Connection</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="design/Default2.css">
	</head>
	<body>
	<div class="container">
		<?php if (!isset($_COOKIE['auto'])) {  ?>
			<header>
				<h1 id="Connection1">Connectez-vous</h1>
			</header>
					<h3>Connectez pour avoir plus d'information sur mon site 
						<br> Sinon inscrivez-vous en<a href="index.php"> cliquent ici</a></h3>
						<?php

						if (isset($_GET['error'])){

							if (isset($_GET['pass'])) {

									echo "<p id='error'>Votre Mot de passe est incorret</p>";
								}
						}elseif(isset($_GET['succes'])){
							echo "<p id='succes'>Connection réussie</p>";
						}elseif (isset($_GET['deco'])) {

							echo"<p id='succes'>Vous êtes maintenant deconnectez !</p>";
						}
						

						?>
					<form method="post" action="Connection.php" id="Connection">
						<table>
							<tr>
								<td>Email</td>
								<td><input type="email" name="Email" required="">
								</td>
							</tr>
							<tr>
								<td>Mot de passe</td>
								<td><input type="password" name="pass" required="">
								</td>
						</table>
						<p><label><input type="checkbox" name="auto" checked>Connection automatique ?</label></p>
						<button id="button1">Connection</button>
					</form>
					<?php } else { ?>
						 
						<p id='succes'>Bienvnue <?= $_COOKIE['Pseudo'] ?><br>
							<a id="button1" href="Deconnection.php" >Deconnection</a></p>	
				
				<?php } ?>
			</div>
	</body>
</html>