<?php 
$mysqli = new mysqli("localhost","root","","sprotskaprodavnica");
if($mysqli->error)
{
	die("Doslo je do greske.");
}

$password_greska = $username_greska = $email_greska = $confirmpassword_greska = "";
$username = $password = $confirm_password = $email = "";

if(isset($_POST['register']))
{
	

	$usernameduzina = $_POST['username'];
	$passwordduzina = $_POST['password'];
	if(empty($_POST['username']))
	{
		$username_greska = "Morate popuniti polje username";

	}
	else if(!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']))
	{
		$username_greska = "Username moze da sadrzi mala, velika slova i brojeve";
	}
	else if(strlen($usernameduzina) > 50)
	{
		$username_greska = "Username ne moze biti duzi od 50 karaktera";
	}
	else
	{
		$upit = "select * from korisnik where username = '" . $_POST['username'] . "'";

		$rez = $mysqli->query($upit);
		if($rez->num_rows==1)
		{
			$username_greska = "Username je vec zauzet";
		} 
	}
	
	

	if(empty($_POST['password']))
	{
		$password_greska = "Morate popuniti polje password";

	}
	else if(strlen($passwordduzina) < 6)
	{
		$password_greska = "Password mora biti duzi od 6  i kraci od 50 karaktera";
	}
	else if(strlen($passwordduzina) > 50)
	{
		$password_greska = "Password mora biti duzi od 6  i kraci od 50 karaktera";
	}
	else
	{	
		$password = $_POST['password'];
	}


	if(empty($_POST['cpassword']))
	{
		$confirmpassword_greska = "Molim vas potvrdite password";
	}
	else {
		$confirm_password = $_POST['cpassword'];
		
		if(empty($password_greska) && $confirm_password != $password){
			$confirmpassword_greska = "Passwordi se ne slazu, molim Vas pokusajte ponovo";
		}
	}

	if(empty($_POST['email']))
	{
		$email_greska = "Morate popuniti polje mail";
	}
	else if(!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $_POST['email']))
	{
		$email_greska = "Email nije ispravno unet, pokusajte ponovo";
	}
	else if(strlen($_POST['email']) > 50)
	{
		$email_greska = "Email ne moze biti duzi od 50 karaktera";
	}
	else 
	{
		$email = $_POST['email'];
	}



	if(empty($password_greska) && empty($confirmpassword_greska) && empty($username_greska))
	{
		$username = $_POST['username'];
		$upit = "insert into korisnik values('" . $username . "', '" . $password . "', '" . $email . "', 'Korisnik')";
		if($mysqli->query($upit) == TRUE)
		{
			echo ("<script LANGUAGE='JavaScript'>
				window.alert('Uspesno ste se registrovali!');
				window.location.href='login.php';
				</script>");
		}
		else {
			echo "Doslo je do greske";
		}
	}

}

?>
<div class="row">
	<div class="col-md-6">
		<div class="wrapper">
			<h2>Register</h2>
			<form action="register.php" method="post" novalidate>
				<div class="form-group">
					<label for="user">Username</label>
					<input id="user" type="text" name="username" class="form-control" >
					<span class="greska-feedback"><?php echo $username_greska; ?></span>
				</div>    
				<div class="form-group">
					<label for="password">Password</label>
					<input id="pw" type="password" name="password" class="form-control" >
					<span class="greska-feedback"><?php echo $password_greska; ?></span>
				</div>
				<div class="form-group">
					<label for="confirmpassword">Potvrdite password</label>
					<input id="confirmpassword" type="password" name="cpassword" class="form-control" >
					<span class="greska-feedback"><?php echo $confirmpassword_greska; ?></span>
				</div>
				<div class="form-group">
					<label for="mail">Email</label>
					<input id="mail" type="email" name="email"  class="form-control" >
					<span class="greska-feedback"><?php echo $email_greska; ?></span>
				</div>
				<div class="form-group">
					<input type="submit" name="register" class="btn btn-default" value="Register">
					<a href="login.php"><button class="btn btn-default" type="button">Login</button></a>
				</div>
				
			</form>
		</div>
	</div>
	<div class="col-md-6">
	</div>
</div>
