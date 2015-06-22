<?php
	require_once('db.php');

	$stmtInsert = $db->prepare("
		INSERT INTO fridge (fridge_id, nom_produit, type_produit, date_achat, date_peremption, quantite) 
		VALUES (:fridge_id, :nom_produit, :type_produit, :date_achat, :date_peremption, :quantite)"
	);
	
	try
	{
		$stmtInsert->execute(array(
			"fridge_id" => $_POST['FridgeId'],
			"nom_produit" => $_POST['NomProduit'],
			"type_produit" => $_POST['TypeProduit'],
			"date_achat" => $_POST['DateAchat'],
			"date_peremption" => $_POST['DatePeremption'],
			"quantite" => $_POST['Quantite']
		));

		header('Location: index.php');

	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
?>