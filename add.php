<?php
	$c = new PDO('mysql:host=localhost;dbname=fridge', 'fridgedbuser', 'fridgedbpassword', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$stmtInsert = $c->prepare("
		INSERT INTO fridge (NomProduit, TypeProduit, DateAchat, DatePeremption, Quantite) 
		VALUES (:NomProduit, :TypeProduit, :DateAchat, :DatePeremption, :Quantite)"
	);
		
	$stmtInsert->execute(array(
		"NomProduit" => $_POST['NomProduit'],
		"TypeProduit" => $_POST['TypeProduit'],
		"DateAchat" => $_POST['DateAchat'],
		"DatePeremption" => $_POST['DatePeremption'],
		"Quantite" => $_POST['Quantite']
	));
	
	header('Location: index.php');
?>