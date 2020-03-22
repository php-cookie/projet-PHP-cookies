<?php require('header.php'); ?>


<!--
<?php 
/*

if (isset($_GET['name'])) : 
	$name = $_GET['name'];
	$price = $_GET['price'];
	$qte = $_GET['qte'];
*/
?>
-->



<div>
	<h2>Votre panier :</h2>
	<table border="1px">
	    <tr>
	        <td colspan="4" style="text-align: center;">Votre panier</td>
	    </tr>
	    <tr>
	        <td>Quantité</td>
	        <td>Produit</td>
	        <td>Prix Unitaire</td>
	    </tr>
	    <tr style="text-align: center;">
	    	<td><?php echo $qte ?></td>
	    	<td><?php echo $name ?></td>
	    	<td><?php echo $price ?>€</td>
	    </tr>
	    <tr>
	    	<td colspan="4" style="text-align: right;">Prix total: <?php echo ($qte*$price) ?>€</td>
	    </tr>
	</table>
</div>
<!--
<?php  /* else : ?>
<?php $message = '<p class="error">Votre panier est vide!'; ?>
<?php endif */ ?>
-->
<p><?php if(isset($message)) echo $message; ?></p>

<br><a href="index.php">Continuer vos achats.</a>

<?php require('footer.php'); ?>

