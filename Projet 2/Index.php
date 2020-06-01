<?php 

session_start();

require('Src/Bdd.php');

if(!empty($_POST['Pseudo']) && !empty($_POST['Email']) && !empty($_POST['PASS']) && !empty($_POST['confim_pass'])) {

	$Pseudo 		= 	$_POST['Pseudo'];
	$Email 			= 	$_POST['Email'];
	$PASS 			= 	$_POST['PASS'];
	$confim_pass 	= 	$_POST['confim_pass'];


	if ($PASS != $confim_pass){

		header('location: ?error=true&pass=1');

		exit();
	}


	$req = $Bdd->prepare('SELECT COUNT(*) AS Verification_email FROM users WHERE Email = ?');

	$req->execute(array($Email));

	while ($Verif_mail = $req->fetch()) {

		if($Verif_mail['Verification_email'] != 0){

			header('location: ?error=true&email=1');

			exit();
		}
	}
	

	$secret = sha1($Email).time();
	$secret = sha1($secret).time().time();

	$PASS = "aq1".sha1($PASS."4509")."987";

	$req = $Bdd->prepare('INSERT INTO users (Pseudo, Email, Password, Secret) VALUES(?, ?, ?, ?)');

	$req->execute(array($Pseudo, $Email, $PASS, $secret));

	header('location: ?succes=1');
	exit();
}


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Formulaire d'inscrpiton</title>
		<link rel="stylesheet" type="text/css" href="design/Default2.css">
	</head>
	<body>
		<div class="container">
			<?php if (!isset($_SESSION['connect'])) {  ?>
			
			<header>
				<h1>Formulaire d'inscription</h1>
			</header>
					<h3>Benvenue sur mon site, si vous voulez en savoir plus inscrivez-vous, 
						<br>sinon si vous voulz vous connectez <a href="Connection.php">cliquer ici</a></h3>

						<?php 

							if (isset($_GET['error'])) {

								if (isset($_GET['pass'])) {

									echo "<p id='error'>les mots de passe ne sont pas identiques</p>";
								}elseif (isset($_GET['email'])){
									
									echo "<p id='error'>L'adresse mail que vous avez rentrer est déjà utliser</p>";

								}
							}elseif (isset($_GET['succes'])) {

								echo "<p id='succes'>Félicitation votre inscription à bien été valider</p>";
							}
						 ?>
					<form method="post" action="index.php">
						<table>
							<tr>
								<td>Pseudo</td>
								<td><input type="text" name="Pseudo" placeholder="Ex: Françoise" required>
								</td>
							</tr>
							<tr>
								<td>Email</td>
								<td><input type="Email" name="Email" placeholder="Ex: Exemple@Gmail.fr" required>
								</td>
							</tr>
							<tr>
								<td>Mot de passe</td>
								<td><input type="password" name="PASS" placeholder="Ex: ******" required>
								</td>
							</tr>	
							<tr>
								<td>Retaper le mot de passe</td>
								<td><input type="password" name="confim_pass" placeholder="Ex: ******" required>
								</td>
							</tr>
						</table>
						<button>Inscription</button>
					</form>
				<?php } else { ?>
						 
						<p id='succes'>Bienvnue <?= $_SESSION['pseudo'] ?><br>
							<a id="button2" href="Deconnection.php" >Deconnection</a></p>	
				
				<?php } ?>
			</div>
	</body>
</html>