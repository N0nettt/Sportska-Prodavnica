<?php 
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$mysqli = new mysqli("localhost","root","","sprotskaprodavnica");
if($mysqli->error)
{
	die("Doslo je do greske.");
}

$login_greska = "";
$password_greska = "";
$username_greska = "";


$username = $password = "";

if(isset($_SESSION['ulogovan']) && $_SESSION['ulogovan'] === true)
{
	header("location: index.php");
	exit;
}

if(isset($_POST['Login']))
{
	if(empty($_POST['username']))
	{
		$username_greska = "Morate uneti username";
	}
	else	
	{
		$username = $_POST['username'];
	}

	if(empty($_POST['password']))
	{
		$password_greska = "Morate uneti password";
	}
	else
	{
		$password = $_POST['password'];
	}



	if(empty($username_greska) && empty($password_greska))
	{
		$upit = "select * from korisnik where username = '" . $username . "' and password = '" . $password . "'";
		$rez = $mysqli->query($upit);
		if($rez->num_rows == 1)
		{
			$red = $rez->fetch_assoc();
			$_SESSION['ulogovan'] = true;
			$_SESSION['username'] = $username;
			$_SESSION['role'] = $red['role'];
			echo ("<script LANGUAGE='JavaScript'>
				window.alert('Dobrodosli " . $username . "!');
				window.location.href='login.php';
				</script>");
		}
		else 
		{
			$login_greska = "Uneli ste pogresan username ili password";
		}
	}
}



?>
<div class="row">
	<div class="col-md-6">
		<div class="wrapper">
			<h2>Login</h2>
			
			<?php 
			if(!empty($login_greska)){
				echo '<div class="alert alert-danger">' . $login_greska . '</div>';
			}        
			?>
			<form action="login.php" method="post">
				<div class="form-group">
					<label for="user">Username</label>
					<input id="user" type="username" name="username" class="form-control" >
					<span class="greska-feedback"><?php echo $username_greska; ?></span>
				</div>    
				<div class="form-group">
					<label for="password">Password</label>
					<input id="pw" type="password" name="password" class="form-control" >
					<span class="greska-feedback"><?php echo $password_greska; ?></span>
				</div>
				<div class="form-group">
					<input type="submit" name="Login" class="btn btn-default" value="Login">
					<a href="register.php"><button class="btn btn-default" type="button">Register</button></a>
				</div>
				
			</form>
		</div>
	</div>
	<div class="col-md-6">
	</div>
</div>
