<?php 
if($_SESSION['role'] != 'Admin')
{
	header("location: index.php");
	exit;
}

$mysqli = new mysqli("localhost","root","","sprotskaprodavnica");
if($mysqli->error)
{
	die("Doslo je do greske.");
}
?>


<div class="row">
	<div class="col-md-12">
		<fieldset>
			<legend>Dodaj proizvod:</legend>
			<form enctype="multipart/form-data" method="post" action="adminpanel.php">
				<table class="table">
					<tr><td><label for="proizvod">Proizvod:</label>

						<select name="proizvod" id="proizvod">
							<option value="zenskaObuca">Zenska obuca</option>
							<option value="muskaObuca">Muska obuca</option>
							<option value="majica">Majica</option>
							<option value="trenerka">Trenerka</option>
							<option value="sportskaOprema">Sportska oprema</option>
						</select></td>
						<td><label for="brend">Brend:</label>

							<select name="brend" id="brend">
								<option value="Nike">Nike</option>
								<option value="Addidas">Addidas</option>
								<option value="Under Armour">Under Armour</option>
								<option value="Puma">Puma</option>
								<option value="Sergio Tacchini">Sergio Tacchini</option>
								<option value="Reebok">Reebok</option>
							</select></td>
							<td><label for="proizvod">Tip:</label>

								<select name="tip" id="tip">
									<option value="Kosarka">Kosarka</option>
									<option value="Fudbal">Fudbal</option>
									<option value="Lifestyle">Lifestyle</option>
									<option value="Trening">Trening</option>
									<option value="Outdoor">Outdoor</option>
								</select></td></tr>
								<tr>
									<td>Sifra:<input type="text" name="sifra"></td>
									<td><label for="pol">Pol:</label><select name="pol" id="pol">
										<option value="M">Muski</option>
										<option value="Z">Zenski</option>
									</select></td>
									<td><input type="hidden" name="max_file_size" value="999999">
										<input type="file"  name="fupload" value="Dodaj sliku"></td>

									</tr>
									<tr>
										<td>Velicina:<input type="text" name="velicina"><Br><br></td>
										<td>Cena:<input type="text" name="cena"></td>
										<td><input type="submit" class="btn-info" name="dodaj" value="Dodaj proizvod"></td>
									</tr>
								</table>
							</form>
						</fieldset>
						<?php 
						if(isset($_POST['dodaj']))
						{
							if(empty($_POST['sifra']) || empty($_POST['cena']))
							{
								echo ("<script LANGUAGE='JavaScript'>
									window.alert('Morate popuniti polja sifra, cena!');
									</script>");
							}
							else 
							{
								if($_POST['proizvod'] == "zenskaObuca")
								{
									if(empty($_POST['velicina']))
									{
										echo ("<script LANGUAGE='JavaScript'>
											window.alert('Morate uneti velicinu');
											</script>");
									}
									else{
										$upit = "select * from zenskaobuca where sifra = '" . $_POST['sifra'] . "'";
										$rez = $mysqli->query($upit);
										if($rez->num_rows == 1)
										{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Proizvod sa ovom sifrom vec postoji!');
												</script>");
										}
										else {
											if(isset($_FILES['fupload']))
											{

												if($_FILES['fupload']['type'] == "image/jpeg" || $_FILES['fupload']['type'] == "image/png")
												{
													$source = $_FILES['fupload']['tmp_name'];
													$target = "img/Proizvodi" . $_FILES['fupload']['name'];

													move_uploaded_file($source, $target);
												}
											}
											$upit = "insert into zenskaobuca VALUES('" . $_POST['sifra'] . "', '" . 
											$_POST['tip'] . "', '" . $_POST['brend'] . "', '" . $_POST['velicina'] . "', '"
											. $target . "', '" . $_POST['cena'] . "')";

											if($mysqli->query($upit))
											{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Proizvod je uspesno dodat!');
													</script>");
											}
											else{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Doslo je do greske, pokusajte ponovo!');
													</script>");
											}

										}

									}

									
								}
								if($_POST['proizvod'] == "muskaObuca")
								{

									
									if(empty($_POST['velicina']))
									{
										echo ("<script LANGUAGE='JavaScript'>
											window.alert('Morate uneti velicinu');
											</script>");
									}
									else{
										$upit = "select * from obuca where sifra = '" . $_POST['sifra'] . "'";
										$rez = $mysqli->query($upit);
										if($rez->num_rows == 1)
										{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Proizvod sa ovom sifrom vec postoji!');
												</script>");
										}
										else {
											if(isset($_FILES['fupload']))
											{

												if($_FILES['fupload']['type'] == "image/jpeg" || $_FILES['fupload']['type'] == "image/png")
												{
													$source = $_FILES['fupload']['tmp_name'];
													$target = "img/Proizvodi" . $_FILES['fupload']['name'];

													move_uploaded_file($source, $target);
												}
											}
											$upit = "insert into obuca VALUES('" . $_POST['sifra'] . "', '" . 
											$_POST['tip'] . "', '" . $_POST['brend'] . "', '" . $_POST['velicina'] . "', '"
											. $target . "', '" . $_POST['cena'] . "')";

											if($mysqli->query($upit))
											{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Proizvod je uspesno dodat!');
													</script>");
											}
											else{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Doslo je do greske, pokusajte ponovo!');
													</script>");
											}

										}

									}

									
								}
								if($_POST['proizvod'] == "trenerka")
								{
									
									if(empty($_POST['velicina']))
									{
										echo ("<script LANGUAGE='JavaScript'>
											window.alert('Morate uneti velicinu');
											</script>");
									}
									else{
										$upit = "select * from trenerke where sifra = '" . $_POST['sifra'] . "'";
										$rez = $mysqli->query($upit);
										if($rez->num_rows == 1)
										{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Proizvod sa ovom sifrom vec postoji!');
												</script>");
										}
										else {
											if(isset($_FILES['fupload']))
											{

												if($_FILES['fupload']['type'] == "image/jpeg" || $_FILES['fupload']['type'] == "image/png")
												{
													$source = $_FILES['fupload']['tmp_name'];
													$target = "img/Proizvodi" . $_FILES['fupload']['name'];

													move_uploaded_file($source, $target);
												}
											}
											$upit = "insert into trenerke VALUES('" . $_POST['sifra'] . "', '" . 
											$_POST['pol'] . "', '" . $_POST['brend'] . "', '" . $_POST['tip'] . "', '"
											. $target . "', '" . $_POST['cena'] . "', '" . $_POST['velicina'] . "')";

											if($mysqli->query($upit))
											{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Proizvod je uspesno dodat!');
													</script>");
											}
											else{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Doslo je do greske, pokusajte ponovo!');
													</script>");
											}

										}

									}

									
								}
								if($_POST['proizvod'] == "majica")
								{

									if(empty($_POST['velicina']))
									{
										echo ("<script LANGUAGE='JavaScript'>
											window.alert('Morate uneti velicinu');
											</script>");
									}
									else{
										$upit = "select * from majice where sifra = '" . $_POST['sifra'] . "'";
										$rez = $mysqli->query($upit);
										if($rez->num_rows == 1)
										{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Proizvod sa ovom sifrom vec postoji!');
												</script>");
										}
										else {
											if(isset($_FILES['fupload']))
											{

												if($_FILES['fupload']['type'] == "image/jpeg" || $_FILES['fupload']['type'] == "image/png")
												{
													$source = $_FILES['fupload']['tmp_name'];
													$target = "img/Proizvodi" . $_FILES['fupload']['name'];

													move_uploaded_file($source, $target);
												}
											}
											$upit = "insert into majice VALUES('" . $_POST['sifra'] . "', '" . 
											$_POST['brend'] . "', '" . $_POST['tip'] . "', '" . $_POST['cena'] . "', '"
											. $_POST['velicina'] . "', '" . $_POST['pol'] . "', '" . $target . "')";

											if($mysqli->query($upit))
											{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Proizvod je uspesno dodat!');
													</script>");
											}
											else{
												echo ("<script LANGUAGE='JavaScript'>
													window.alert('Doslo je do greske, pokusajte ponovo!');
													</script>");
											}

										}

									}
								}
								if($_POST['proizvod'] == "sportskaOprema")
								{
									$upit = "select * from sportskaoprema where sifra = '" . $_POST['sifra'] . "'";
									$rez = $mysqli->query($upit);
									if($rez->num_rows == 1)
									{
										echo ("<script LANGUAGE='JavaScript'>
											window.alert('Proizvod sa ovom sifrom vec postoji!');
											</script>");
									}
									else {
										if(isset($_FILES['fupload']))
										{

											if($_FILES['fupload']['type'] == "image/jpeg" || $_FILES['fupload']['type'] == "image/png")
											{
												$source = $_FILES['fupload']['tmp_name'];
												$target = "img/Proizvodi" . $_FILES['fupload']['name'];

												move_uploaded_file($source, $target);
											}
										}
										$upit = "insert into sportskaoprema VALUES('" . $_POST['sifra'] . "', '" . 
										$_POST['velicina'] . "', '" . $_POST['cena'] . "', '" . $target . "')";

										if($mysqli->query($upit))
										{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Proizvod je uspesno dodat!');
												</script>");
										}
										else{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Doslo je do greske, pokusajte ponovo!');
												</script>");
										}

									}
								}

							}
						}



						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<fieldset>
							<legend>Korisnici:</legend>	
							<table class="table">
								<tr><th>Username</th><th>Email</th><th>Role</th><th>Brisanje</th><th>Izmena</th></tr>
								<?php 
								$username = "";
								$email = "";
								$role = "";
								$upitKor = "select * from korisnik";

								$rez = $mysqli->query($upitKor);
								if($rez)
								{
									while($red = $rez->fetch_assoc())
									{
										$username = $red['username'];
										$email = $red['email'];
										$role = $red['role'];

										echo "<tr><td>" . $username . "</td><td>" . $email . "</td><td>" . $role . "</td><td>" . "<a href='adminpanel.php?action=delete&username=" . $username . "'><span class='text-danger'>Obrisi korisnika</span></a></td><td><a href='adminpanel.php?action=promeni&username=" . $username . "&role=" . $role . "'><span class='text-danger'>Promeni role</span></a></td>"; 
									}
								}
								else{
									print "Doslo je do greske";
								}
								if(isset($_GET['action']))
								{
									if($_GET['action'] == 'delete')
									{
										$deleteUpit = "delete from korisnik where username = '" . $_GET['username'] . "'";
										if($mysqli->query($deleteUpit))
										{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Korisnik je obrisan!');
												window.location.href='adminpanel.php';
												</script>");
										}
										else {
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Doslo je do greske!');
												</script>");
										}
									}

									if($_GET['action'] == 'promeni')
									{
										$upitPromeni = "";
										if($_GET['role'] == 'Korisnik')
										{
											$upitPromeni = "update korisnik set role = 'Admin' where username = '" . $_GET['username'] . "'";
										}
										if($_GET['role'] == 'Admin')
										{
											$upitPromeni = "update korisnik set role = 'Korisnik' where username = '" . $_GET['username'] . "'";
										}if($mysqli->query($upitPromeni))
										{
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Uspesno promenjen role');
												window.location.href='adminpanel.php';
												</script>");
										}
										else {
											echo ("<script LANGUAGE='JavaScript'>
												window.alert('Doslo je do greske!');
												</script>");
										}

									}
								}
								?>
							</table>
						</fieldset>
					</div>
				</div>


				<div class="row">
					<div class="col-md-6">
						<fieldset>
							<legend>Porudzbine:</legend>
							<table class="table">
								<tr><th>PourdzbinaID</th><th>Korisnik</th><th>Cena</th><th>Vreme</th></tr>
								<?php 	
								$upit = "select * from porudzbina";
								$rez = $mysqli->query($upit);
								$kosinik = "";
								$porudzbina = "";
								$cena = "";
								$vreme = "";
								while($red = $rez->fetch_assoc())
								{		
									$korisnik = $red['Korisnik'];
									$porudzbina = $red['PorudzbinaID'];
									$cena = $red['Cena'];
									$vreme = $red['Datum'];
									echo "<tr><td>" . $porudzbina . "</td><td>" . $korisnik . "</td><td>" . $cena . "</td><td>" . $vreme . "</td></tr>";
								}
								?>
							</table>
						</fieldset>
					</div>
					<div class="col-md-6">
						<fieldset>
							<legend>Najverniji korisnici:</legend>
							<table class="table">
								<tr><th>Korisnik</th><th>Potroseno</th></tr>
								<?php 	
								$upit = "select Korisnik, SUM(Cena) from porudzbina group by Korisnik order by SUM(Cena) desc;";
								$rez = $mysqli->query($upit);
								$kosinik = "";
								$cena = "";
								while($red = $rez->fetch_assoc())
								{		
									$korisnik = $red['Korisnik'];
									$cena = $red['SUM(Cena)'];
									echo "<tr><td>" . $korisnik . "</td><td>" . $cena . "</td><tr>";
								}

								?>
							</table>
						</fieldset>
					</div>
				</div>


