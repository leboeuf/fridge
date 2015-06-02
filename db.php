<?php
	$db = new PDO('pgsql:host=localhost;dbname=fridge', 'fridgedbuser', 'fridgedbpassword');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);