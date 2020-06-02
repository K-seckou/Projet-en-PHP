<?php

if(isset($_GET['q'])){
	
	$shortcut = htmlspecialchars($_GET['q']);
	
	$bdd = new PDO('mysql:host=goplombirs554.mysql.db;dbname=goplombirs554;charset=utf8', 'goplombirs554', 'FhmUunp2f');
	
	$req = $bdd->prepare('SELECT COUNT(*) FORM links AS x WHERE shortcut = ?');
	
	$req->execute(array($shortcut));
	
	while($result = $req->fetch()){
		
		if($result != 1){
			
			header('location: ?error=true&message=Adresse url non reconnu');
			
			exit();
		}
	}
}


if (isset($_POST['url'])) {
	
	$url = $_POST['url'];

	if (!filter_var($url, FILTER_VALIDATE_URL)) {
		
		header('location: ?error=true&message=Adresse url invalide');
		
		exit();
	}

	
	$shortcut = crypt($url, rand());


	$bdd = new PDO('mysql:host=goplombirs554.mysql.db;dbname=goplombirs554;charset=utf8', 'goplombirs554', 'FhmUunp2f');

	$req = $bdd->prepare('select cout(*) as x from links where url = ?');

	$req->execute(array($url));

	while ( $result = $req->fetch()){

		if($result['x'] != 0){

			header('location : ?error=true&message=Adresse deja saisie, essayer avec une autre URL');

			exit();
		}

	}
		$req = $bdd->prepare('INSERT INTO links(url, shortcut) value(?, ?)');

		$req->execute(array($url, $shortcut));

		header('location: ?short='.$shortcut);
		exit();
	
		
		$req = $bdd->prepare('SELECT * FROM links WHERE shortcut = ?');
		
		$req->execute(array($shortcut));
		
		
		while($result = $req->fetch()){
			
			header('location: ?'.result['x']);
			
			exit();
		}
	
	
	
	}
	
	
?>
	


<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link rel="icon" type="image/png" href="pictures/favico.png">
		<link rel="stylesheet" type="text/css" href="design/default2.css">
	</head>
	<body>
		<section id="hello">
			<div class="container">
				<header>
					<img src="pictures/logo.png" alt="logo" id="logo">
				</header>
				<h1>Raccourcissez votre url</h1>
				<h2>Largement meilleur et plus court que les autres </h2>
				<form method="post" action="index.php">
					<input type="url" name="url" placeholder="Collez un lien à Raccourcir">
					<input type="submit" value="Raccourcir">
				</form>

					<?php if(isset($_GET['error']) && isset($_GET['message'])) { ?>
						
						<div class="center">

							<div id="result">
								<b><?php echo htmlspecialchars($_GET['message']);?></b>
							</div>
							
						</div>

					<?php } elseif (isset($_GET['short'])) { ?>
						
							<div class="center">

							<div id="result">
								<b>URL RACCOURCIE : </b>
								<a href="http://localhost/?q=<?php echo htmlspecialchars($_GET['short']);?>">http://localhost/?q=<?php echo htmlspecialchars($_GET['short']);?></a>
							</div>
							
						</div>
					<?php } ?>
					
			</div>
		</section>
		<section id="brands">
		
			<div class="container">
				<h3>Ces marques nous font confiance</h3>
					<img src="pictures/1.png" class="pictures" alt="1">
					<img src="pictures/2.png" class="pictures" alt="2">
					<img src="pictures/3.png" class="pictures" alt="3">
					<img src="pictures/4.png" class="pictures" alt="4">
			</div>
			
		</section>
			<footer>
					<img src="pictures/logo2.png" id="logo" alt="logo"><br>
					2019 © Bitly<br>
					<a href="">Contact</a> - <a href="">A Propos</a>
			</footer>
	</body>
</html>
    
    
