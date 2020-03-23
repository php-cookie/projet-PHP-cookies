<?php
$mysqli = new mysqli('localhost', 'root', '', 'devoir_panier');
session_start();
if (!empty($_GET['action'])) {
	switch ($_GET['action']) {
		case 'add':
			if (!empty($_POST['qte'])) {
				$result = $mysqli->query("SELECT id, name, price FROM products WHERE id = '".$_GET['id']."' ");
				$row = $result->fetch_array();
				$produitArray = array($row['id'] => array('name' => $row['name'], 'id' => $row['id'], 'qte' => $_POST['qte'], 'price' => $row['price']));

				if (!empty($_SESSION['panier'])) {
					if (in_array($row['id'], array_keys($_SESSION['panier']))) {
						foreach ($_SESSION['panier'] as $key => $value) {
							if ($row['id'] == $key) {
								if (empty($_SESSION['panier'][$key]['qte'])) {
									$_SESSION['panier'][$key]['qte'] = 0;
								}
								$_SESSION['panier'][$key]['qte'] += $_POST['qte'];
							}
						}
					} else {
						$_SESSION['panier'] = array_merge($_SESSION['panier'], $produitArray);
					}
				} else {
					$_SESSION['panier'] = $produitArray;
				}
			}
		break;
		case 'remove':
			if (!empty($_SESSION['panier'])) {
				foreach ($_SESSION['panier'] as $key => $value) {
					if ($_GET['id'] == $key) {
						unset($_SESSION['panier'][$key]);
					}
					if (empty($_SESSION['panier'])) {
						unset($_SESSION['panier']);
					}
				}
			}
		break;	
		case 'empty':
			unset($_SESSION['panier']);
			break;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="">
	<title>Panier en ligne pour site de e-commerce</title>
</head>
<body>
	<div>
		<h1>Bienvenue sur ce mini-site de e-commerce</h1>
		<?php
		if (isset($_SESSION['panier'])) {
			$qte_totale = 0;
			$prix_total = 0;
		?>
		<table border="solid">
			<tbody>
				<tr>
					<th>Nom</th>
					<th>Quantité</th>
					<th>Prix/article</th>
					<th>Prix total</th>
					<th>Supprimer article</th>
				</tr>
				<?php
				foreach ($_SESSION['panier'] as $produit) {
					$produit_prix = $produit['qte'] * $produit['price'];
				?>
				<tr>
					<td align="center"><?php echo $produit['name']; ?></td>
					<td align="center"><?php echo $produit['qte']; ?></td>
					<td align="center"><?php echo $produit['price'] . '€'; ?></td>
					<td align=" center"><?php echo number_format($produit_prix, 0) . '€'; ?></td>
					<td align="center"><a href="index.php?action=remove&id=<?php echo $produit['id']; ?>"><strong>X</strong></a></td>
				</tr>
				<?php
				$qte_totale += $produit['qte'];
				$prix_total += ($produit['price'] * $produit['qte']);
				}
				?>
				<tr>
					<td colspan="2" align="right">Nombre d'articles total: <?php echo $qte_totale; ?></td>
					<td align="right" colspan="2">Prix total: <strong><?php echo number_format($prix_total, 0) . '€'; ?></strong></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<p><a href="index.php?action=empty">Supprimer mon panier</a></p>
		<?php
		} else {
		?>
		<p><?php $message = 'Votre panier est vide' ?></p>
		<?php	
		}
		?>

		<h2>Voici la liste de nos produits</h2>
		<?php
		$result = $mysqli->query("SELECT id, name, price FROM products ORDER BY id ASC");
		while ($row = $result->fetch_array()) {
			if (!empty($row)) {
			?>
			<form method="post" action="index.php?action=add&id=<?php echo $row['id']; ?>">
				<div><?php echo $row['name'] ?> - <?php echo $row['price'] . '€'; ?></div>
				<input type="text" name="qte" value="1" size="2">
				<input type="submit" name="Ajouter au panier" value="Ajouter au panier">
			</form><br>
			<?php
			}
		}
		if (isset($message)) echo $message;
			?>		
	</div>
</body>
</html>