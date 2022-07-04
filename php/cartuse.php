<?php 
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
$id = "";
if(isset($_GET['action']))
{
	if($_GET['action'] == "delete")
	{
		foreach($_SESSION['shopping_cart'] as $keys => $values)
		{
			if($values['item_id'] == $_GET['id'])
			{
				unset($_SESSION['shopping_cart'][$keys]);
				$_SESSION["shopping_cart"] = array_values($_SESSION["shopping_cart"]);
				echo "<script>window.location='cart.php'</script>";
			}
		}
	}
}


?>

<h3 align="center">Moja korpa</h3>
<div id="divKorpa" class="divCart">
	<table class="table">
		<tr>
			<th>Ime proizvoda</th>
			<th>Kolicina</th>
			<th>Cena</th>
			<th>Ukupna cena</th>
			<th></th>
		</tr>
		<?php
		$ukupnaCena = 0;
		if(!empty($_SESSION['shopping_cart']))
		{ 
			
			foreach($_SESSION['shopping_cart'] as $keys => $values)
			{
				?>
				<tr>
					<td><?php echo $values['item_name']; ?></td>
					<td><?php echo $values['item_quantity'] ?></td>
					<td><?php echo $values['item_price'] ?></td>
					<td><?php echo number_format($values['item_quantity'] * $values['item_price'], 2) ?></td>
					<td><a href="cart.php?action=delete&id=<?php echo $values['item_id']; ?>"><span class="text-danger">Ukloni</span></a></td>
				</tr>
				<?php
				$ukupnaCena = $ukupnaCena + ($values['item_quantity'] * $values['item_price']); 
			}
		}
		?>
		<tr>
			<td colspan="3" align="right">Ukupna cena:</td>
			<td align="right"> <?php echo number_format($ukupnaCena, 2); ?></td>
			<td></td>
		</tr>
	</table>
	<form method="post" action="cart.php">
		<input type="submit" id="btnPlati" name="plati" class="btn btn-default" value="Plati">
		<?php 	

		if(isset($_POST['plati']))
		{	
			if(isset($_SESSION['ulogovan']))
			{
				if($_SESSION['ulogovan'] == true)
				{	
					if(!empty($_SESSION['shopping_cart']))
					{
						$mysqli = new mysqli("localhost","root","","sprotskaprodavnica");
						$upit = "insert into Porudzbina Values('NULL', '" . $_SESSION['username'] . "', '" . $ukupnaCena . "', current_timestamp())"; 
						if($mysqli->query($upit))
						{
							echo ("<script LANGUAGE='JavaScript'>
								window.alert('Hvala na kupovini!');
								</script>");
						}
					}
					else
					{
						echo ("<script LANGUAGE='JavaScript'>
							window.alert('Korpa je prazna!');
							</script>");
					}

				}

			}
			else {
				echo ("<script LANGUAGE='JavaScript'>
					window.alert('Morate se ulogovati da bi platili proizvod!');
					</script>");
			}
		}
		?>
	</form>
</div>