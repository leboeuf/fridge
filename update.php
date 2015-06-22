<?php
	require_once('db.php');

	$stmtUpdate = $db->prepare("
		UPDATE fridge SET
			fridge_id = :fridge_id,
			nom_produit = :nom_produit,
			type_produit = :type_produit,
			date_achat = :date_achat,
			date_peremption = :date_peremption,
			quantite = :quantite
		WHERE ID = :ID"
	);
	
	try
	{
		$stmtUpdate->execute(array(
		"fridge_id" => $_POST['FridgeId'],
		"nom_produit" => $_POST['NomProduit'],
		"type_produit" => $_POST['TypeProduit'],
		"date_achat" => $_POST['DateAchat'],
		"date_peremption" => $_POST['DatePeremption'],
		"quantite" => $_POST['Quantite'],
		"ID" => $_POST['ID']
	));
	
	header('Location: index.php');

	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
?>