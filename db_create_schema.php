<?php
	require_once('db.php');

	try
	{
		$sql = "CREATE TABLE IF NOT EXISTS fridge (
			id SERIAL PRIMARY KEY,
			date_peremption DATE NOT NULL,
			date_achat DATE NOT NULL,
			nom_produit VARCHAR(80) NOT NULL,
			type_produit INT NOT NULL,
			quantite VARCHAR(20) NOT NULL)";
		$db->exec($sql);

		echo "Database structure successfully created.";

	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
