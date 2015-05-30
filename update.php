<?php
	$c = new PDO('mysql:host=localhost;dbname=fridge', 'fridgedbuser', 'fridgedbpassword', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$stmtUpdate = $c->prepare("
		UPDATE fridge SET
			NomProduit = :NomProduit,
			TypeProduit = :TypeProduit,
			DateAchat = :DateAchat,
			DatePeremption = :DatePeremption,
			Quantite = :Quantite
		WHERE ID = :ID"
	);
		
	$stmtUpdate->execute(array(
		"NomProduit" => $_POST['NomProduit'],
		"TypeProduit" => $_POST['TypeProduit'],
		"DateAchat" => $_POST['DateAchat'],
		"DatePeremption" => $_POST['DatePeremption'],
		"Quantite" => $_POST['Quantite'],
		"ID" => $_POST['ID']
	));
	
	header('Location: index.php');
?>