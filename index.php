<?php
	require_once('db.php');

	$stmtSelect = $db->query("SELECT * FROM fridge WHERE (date_peremption >= NOW() OR date_peremption IS NULL) AND quantite > 0 ORDER BY type_produit");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Fridge</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="timeline">
		<ul class="events">
			<?php
				// Afficher les lignes des produits.
				while ($row = $stmtSelect->fetch(PDO::FETCH_ASSOC))
				{
					$left = "";
					if ($row['date_peremption'] == null) $width = 100; // Produit n'expire jamais.
					else
					{
						// Calculer le nombre de jour d'ici la date d'expiration.
						$exp = datediff($row['date_peremption'], date('Y-m-d')) + 2;// +2 pcq on commence un jour avant et la différence enlève 1 jour.
						$width = $exp / 20 * 100; // Taille de la barre pour ce produit.
					}
					if ($row['date_achat'] == date('Y-m-d'))
					{
						// Si le produit a été acheté aujourd'hui, placer une journée plus tard que le début.
						$width -= 5; // Enlever une journée.
						if ($width > 95) $width = 95;
						$left = ";left:5%";
					}
					else if ($width > 100) $width = 100; // Produit expire après la dernière date affichée.
					
					echo '<li class="' . getClassFromType($row['type_produit']) . '" style="width:' . $width . '%' . $left . '">';
					echo '<span>' . $row['nom_produit'];
					echo '<em>' . $row['quantite'] . '</em>';
					echo '</span>';
					echo '<span class="hidden dateachat">' . $row['date_achat'] . '</span>';
					echo '<span class="hidden dateperemption">' . $row['date_peremption'] . '</span>';
					echo '<span class="hidden ID">' . $row['id'] . '</span>';
					echo '</li>';
				}
			?>
		</ul>
		<ul class="intervals">
			<?php
				// Afficher la timeline.
				$date = strtotime("-1 day"); // Commencer 1 jour avant ajd.
				for ($i = 0; $i < 20; $i++)
				{
					$day = date('j', $date); // Jour du mois.

					// Formatage
					if ($i == 0) echo '<li class="first">';
					else if ($i == 1) echo '<li class="today">';
					else if ($i == 19) echo '<li class="last">';
					else echo '<li>';
					
					if ($day == 1) echo "<strong>$day</strong>";
					else echo $day;
					
					echo '</li>';
					$date = strtotime(date('Y-m-d', $date) . " + 1 day");
				}
			?>
		</ul>
	</div>
	<div style="clear: both;"></div>
	<div class="ajout">
		<h2>Ajout</h2>
		<form method="POST" action="add.php">
			<label>Produit:</label>
			<input type="text" name="NomProduit" /><br/>
			<label>Type:</label>
			<select name="TypeProduit">
				<option value="1">L&eacute;gume</option>
				<option value="2">Fruit</option>
				<option value="3">Laitier</option>
				<option value="4">Viande</option>
				<option value="5">C&eacute;r&eacute;alier</option>
				<option value="6">&Eacute;pice</option>
				<option value="7">Pr&eacute;par&eacute;</option>
				<option value="8">Huile</option>
			</select><br/>
			<label>Fridge Id:</label>
			<select name="FridgeId">
				<option value="1">1</option>
				<option value="2">2</option>
			</select>
			<label>Date d'achat:</label>
			<input type="text" name="DateAchat" value="<?php echo date('Y-m-d'); ?>" /><br/>
			<label>Date de p&eacute;remption:</label>
			<input type="text" name="DatePeremption" value="<?php echo date('Y-m-d'); ?>" /><br/>
			<label>Quantit&eacute;:</label>
			<input type="text" name="Quantite" /><br/>
			<input type="submit" value="Ajouter" /><br/>
		</form>
	</div>
	<div class="modif">
		<h2>Modifier</h2>
		<form method="POST" action="update.php">
			<label>Produit:</label>
			<input type="text" name="NomProduit" /><br/>
			<label>Type:</label>
			<select name="TypeProduit">
				<option value="1">L&eacute;gume</option>
				<option value="2">Fruit</option>
				<option value="3">Laitier</option>
				<option value="4">Viande</option>
				<option value="5">C&eacute;r&eacute;alier</option>
				<option value="6">&Eacute;pice</option>
				<option value="7">Pr&eacute;par&eacute;</option>
				<option value="8">Huile</option>
			</select><br/>
			<label>Date d'achat:</label>
			<input type="text" name="DateAchat" value="<?php echo date('Y-m-d'); ?>" /><br/>
			<label>Date de p&eacute;remption:</label>
			<input type="text" name="DatePeremption" value="<?php echo date('Y-m-d'); ?>" /><br/>
			<label>Quantit&eacute;:</label>
			<input type="text" name="Quantite" /><br/>
			<input type="submit" value="Modifier" /><br/>
			<input type="button" value="Annuler" onclick="$('div.modif').hide();" /><br/>
			<input type="hidden" name="ID" value=""/>
			<input type="hidden" name="FridgeId" value=""/>
		</form>
	</div>
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script>
		$(function(){
			$('ul.events li').on('click', function(){
				$('div.modif input[name="NomProduit"]').val($(this).children('span:first').justtext());
				$('div.modif input[name="Quantite"]').val($(this).find('span:first em').text());
				$('div.modif input[name="DateAchat"]').val($(this).find('span.dateachat').text());
				$('div.modif input[name="DatePeremption"]').val($(this).find('span.dateperemption').text());
				$('div.modif input[name="ID"]').val($(this).find('span.ID').text());
				$('div.modif select[name="TypeProduit"]').val(getTypeFromClass($(this).attr('class')));
				$('div.modif').show();
			});
		});
		
		// Retourner seulement le texte du node sans ses enfants.
		jQuery.fn.justtext = function() {
			return $(this).clone().children().remove().end().text();
		};
		
		function getTypeFromClass(className)
		{
			switch (className)
			{
				case 'veg': return 1;
				case 'fruit': return 2;
				case 'dairy': return 3;
				case 'meat': return 4;
				case 'grain': return 5;
				case 'spice': return 6;
				case 'prep': return 7;
				case 'oil': return 8;
			}
		}
	</script>
</body>
</html>
<?php
	function getClassFromType($type)
	{
		switch ($type)
		{
			case 1: return 'veg';
			case 2: return 'fruit';
			case 3: return 'dairy';
			case 4: return 'meat';
			case 5: return 'grain';
			case 6: return 'spice';
			case 7: return 'prep';
			case 8: return 'oil';
		}
	}
	
	function datediff($date1, $date2)
	{
		// Retourne le nombre de jours entre deux dates.
		// N'est pas précis car nul besoin: Si > 1 mois, width = 100%.
		$date1 = new DateTime($date1);
		$date2 = new DateTime($date2);
		$diff = $date2->diff($date1);
		return ($diff->m * 30) + $diff->d;
	}
?>