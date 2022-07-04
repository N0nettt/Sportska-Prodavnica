<?php 
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$mysqli = new mysqli("localhost","root","","sprotskaprodavnica");

if(isset($_GET['action']))
{
  if($_GET['action'] == 'add')
  {
    if(isset($_SESSION['shopping_cart']))
    {
      $item_array_id = array_column($_SESSION['shopping_cart'], 'item_id');
      if(!in_array($_GET['id'], $item_array_id))
      { 
        $count = count($_SESSION['shopping_cart']);
        $item_array = array (
          'item_id' => $_GET['id'],
          'item_name' => $_POST['hidden_name'],
          'item_price' => $_POST['hidden_price'],
          'item_quantity' => '1'
        );
        $_SESSION['shopping_cart'][$count] = $item_array;
      }
    else // Ovde hocemo da napravimo ako je item vec dodat da mu samo poveca kolicinu
    { 
      foreach($_SESSION['shopping_cart'] as $keys => $values)
      {
        if($values['item_id'] == $_GET['id'])
        {
          $_SESSION['shopping_cart'][$keys]['item_quantity']++;

        }
      }
    }
  }

  else
  {
    $item_array = array (
      'item_id' => $_GET['id'],
      'item_name' => $_POST['hidden_name'],
      'item_price' => $_POST['hidden_price'],
      'item_quantity' => '1'
    );
    $_SESSION['shopping_cart'][0] = $item_array;
  }
}
}


if($mysqli->error)
{
  print("Doslo je do greske");
  die();
}

$sifra = "";
$naziv = "";
$slika = "";
$cena = "";
$brojac = 0;


?>
<div class="row">
  <div class="col-md-3">
      <form method="post" action="sportska-oprema.php">
      <label for="sort">Sortiraj po ceni:</label>
      <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="random"></option>
        <option value="Opadajuce">Opadajuce</option>
        <option selected="selected" value="Rastuce">Rastuce</option>
      </select>
    </form>
    
  </div>
  <?php  
  {


    if(isset($_POST['sort']))
    {
      if($_POST['sort'] == "Opadajuce")
      {
        header( 'Location: http://127.0.0.1/SportskaProdavnica/sportska-oprema-opadajuce.php' );
      }
    }

    if(isset($_POST['sort']))
    {
      if($_POST['sort'] == "Rastuce")
      {
        header( 'Location: http://127.0.0.1/SportskaProdavnica/sportska-oprema-rastuce.php' );
      }
    }

    if(isset($_POST['sort']))
    {
      if($_POST['sort'] == "")
      {
        header( 'Location: http://127.0.0.1/SportskaProdavnica/sportska-oprema.php' );
      }
    }


    $upit = "select * from sportskaoprema order by Cena asc";
    $rez = $mysqli->query($upit);
    if($rez->num_rows>1)
    {
      while($row = $rez->fetch_assoc())
      {
        $sifra=$row['Sifra'];
        $naziv=$row['Naziv'];
        $slika=$row['Slika'];
        $cena=$row['Cena'];


        if($brojac >= 3 && $brojac % 3 == 0)
        {
          echo "<div class='col-md-3'>";
          echo "</div>";
          echo "<div class='col-md-3'>";
          echo "<form method='post' action='sportska-oprema-rastuce.php?action=add&id=" . $sifra . "'>";
          echo "<div class='thumbnail'>";
          echo "<img src='" . $slika . "' alt='img'>";
          echo "<div class='caption'>";
          echo "<p>" . $naziv . "<br>" . $cena . ",00rsd</p>";
          echo "<input type='hidden' name='hidden_name' value='" . $naziv . "'/>";
          echo "<input type='hidden' name='hidden_price' value='" . $cena . "'/>";
          echo "<input type='submit' name='add_to_cart' class='btn btn-info' value='Add to cart'/>";
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
          echo "</div>";
          echo "</div>";
          echo "</form>";
          echo "</div>";
          $brojac = $brojac + 1;

        }
        else {

          echo "<div class='col-md-3'>";
          echo "<form method='post' action='sportska-oprema-rastuce.php?action=add&id=" . $sifra . "'>";
          echo "<div class='thumbnail'>";
          echo "<img src='" . $slika . "' alt='img'>";
          echo "<div class='caption'>";
          echo "<p>" . $naziv . "<br>" . $cena . ",00rsd</p>";
          echo "<input type='hidden' name='hidden_name' value='" . $naziv . "'/>";
          echo "<input type='hidden' name='hidden_price' value='" . $cena . "'/>";
          echo "<input type='submit' name='add_to_cart' class='btn btn-info' value='Add to cart'/>";
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
          echo "</div>";
          echo "</div>";
          echo "</form>";
          echo "</div>";
          $brojac = $brojac + 1;
        }
      }
    }
    else if($rez->num_rows == 1) {
      $row = $rez->fetch_assoc();
      $sifra=$row['Sifra'];
      $naziv=$row['Naziv'];
      $slika=$row['Slika'];
      $cena=$row['Cena'];

      echo "<div class='col-md-3'>";
      echo "<form method='post' action='sportska-oprema-rastuce.php?action=add&id=" . $sifra . "'>";
      echo "<div class='thumbnail'>";
      echo "<img src='" . $slika . "' alt='img'>";
      echo "<div class='caption'>";
      echo "<p>" . $naziv . "<br>" . $cena . ",00rsd</p>";
      echo "<input type='hidden' name='hidden_name' value='" . $naziv . "'/>";
      echo "<input type='hidden' name='hidden_price' value='" . $cena . "'/>";
      echo "<input type='submit' name='add_to_cart' class='btn btn-info' value='Add to cart'/>";
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
      echo "</div>";
      echo "</div>";
      echo "</form>";
      echo "</div>";
    }    
  }


?>