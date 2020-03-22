<?php require('inc_connexion.php'); ?>
<?php 
$qte = null;
if (!empty($_COOKIE['qte'])) {
	$qte = $_COOKIE['qte'];
}
if (!empty($_GET['submit_form'])) {
	setcookie('qte', $_GET['submit_form']);
	$qte = $_GET['submit_form'];
}

?>

<?php require('header.php'); ?>

<div>
	<h1>Bienvenue sur ce site test de e-commerce.</h1>
	<h2>Voici le catalogue de nos produits :</h2>
	<?php
	$result = $mysqli->query('SELECT id, name, price FROM products ORDER BY id');

	while($row = $result->fetch_array()) {
		$id = $row['id'];
		$name = $row['name'];
		$price = $row['price'];
		$produit[$name] = $price;
	}
	?>
	
	<ul>
		<?php foreach ($produit as $name => $price) : ?>
			<form method="get" action="index.php?name=<?php echo $name ?>&amp;price=<?php echo $price ?>&amp;$qte=$qte+1">
				<li><?php echo $name ?> - <?php echo $price ?>€</li>
				<li><button name="submit_form" value=<?php echo $qte=$qte+1 ?>>Ajouter au panier</button></li><br>
			</form>
			<!--<li><a href="panier.php?name=<?php echo $name ?>&amp;price=<?php echo $price ?>&amp;qte=1">Ajouter au panier</a></li><br>-->
		<?php endforeach ?>
	</ul>
	<?php var_dump($qte); ?>
	<a href="panier.php">Accéder à mon panier.</a>
</div>

<?php require('footer.php'); ?>