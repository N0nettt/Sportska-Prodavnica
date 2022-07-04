<?php 
if(!isset($_SESSION)) 
{ 
  session_start(); 
} 



if(isset($_SESSION['ulogovan']) && $_SESSION['ulogovan'] == true)
{
  echo '<nav class="navbar navbar-default">';
  echo '<div class="navbar-header">';
  echo '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">';
  echo '<span class="sr-only">Toggle navigation</span>';
  echo '<span class="icon-bar"></span>';
  echo '<span class="icon-bar"></span>';
  echo '<span class="icon-bar"></span>';
  echo '</button>';
  echo '';
  echo '</div>';
  echo '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">';
  echo '<ul class="nav navbar-nav">';
  echo '<li class="dropdown">';
  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Muškarci <span class="caret"></span></a>';
  echo '<ul class="dropdown-menu">';
  echo '<li><a href="muskarci-obuca.php">Obuća</a></li>';
  echo '<li><a href="muskarci-trenerke.php">Trenerke</a></li>';
  echo '<li><a href="muskarci-majice.php">Majice</a></li>';
  echo '</ul>';
  echo '</li>';
  echo '<li class="dropdown">';
  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Žene <span class="caret"></span></a>';
  echo '<ul class="dropdown-menu">';
  echo '<li><a href="zene-obuca.php">Obuća</a></li>';
  echo '<li><a href="zene-trenerke.php">Trenerke</a></li>';
  echo '<li><a href="zene-majice.php">Majice</a></li>';
  echo '</ul>';
  echo '</li>';
  echo '';
  echo '<li><a href="sportska-oprema.php">Sportska oprema</a></li>';
  echo '</ul>';
  echo '<ul class="nav navbar-nav navbar-right">';
  if($_SESSION['role'] == 'Admin')
  {
    echo '<li><a href="adminpanel.php">Admin Panel</a></li>';
  }
  echo '<li><a href="logout.php">Logout, ' . $_SESSION['username'] . '</a></li>';
  echo '</ul>';
  echo '</div><!-- /.navbar-collapse -->';
  echo '</nav><!-- kraj navigacije -->';
}
else
{
  echo '<nav class="navbar navbar-default">';
  echo '<div class="navbar-header">';
  echo '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">';
  echo '<span class="sr-only">Toggle navigation</span>';
  echo '<span class="icon-bar"></span>';
  echo '<span class="icon-bar"></span>';
  echo '<span class="icon-bar"></span>';
  echo '</button>';
  echo '';
  echo '</div>';
  echo '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">';
  echo '<ul class="nav navbar-nav">';
  echo '<li class="dropdown">';
  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Muškarci <span class="caret"></span></a>';
  echo '<ul class="dropdown-menu">';
  echo '<li><a href="muskarci-obuca.php">Obuća</a></li>';
  echo '<li><a href="muskarci-trenerke.php">Trenerke</a></li>';
  echo '<li><a href="muskarci-majice.php">Majice</a></li>';
  echo '</ul>';
  echo '</li>';
  echo '<li class="dropdown">';
  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Žene <span class="caret"></span></a>';
  echo '<ul class="dropdown-menu">';
  echo '<li><a href="zene-obuca.php">Obuća</a></li>';
  echo '<li><a href="zene-trenerke.php">Trenerke</a></li>';
  echo '<li><a href="zene-majice.php">Majice</a></li>';
  echo '</ul>';
  echo '</li>';
  echo '';
  echo '<li><a href="sportska-oprema.php">Sportska oprema</a></li>';
  echo '</ul>';
  echo '<ul class="nav navbar-nav navbar-right">';
  echo '<li><a href="login.php">Login</a></li>';
  echo '<li><a href="register.php">Registracija</a></li>';
  echo '</ul>';
  echo '</div><!-- /.navbar-collapse -->';
  echo '</nav><!-- kraj navigacije -->';
}



?>


