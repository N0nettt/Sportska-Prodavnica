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
if($_GET['action'] == 'delete')
{
  $upit = "delete from majice where sifra ='" . $_GET['id'] . "'";
  if($mysqli->query($upit))
  {
    echo ("<script LANGUAGE='JavaScript'>
      window.alert('Proizvod je uspesno obrisan!');
      </script>");
  }
  else
  {
    echo ("<script LANGUAGE='JavaScript'>
      window.alert('Doslo je do greske, pokusajte ponovo!');
      </script>");
  }
}
}


if($mysqli->error)
{
  print("Doslo je do greske");
  die();
}

$sifra = "";
$tip = "";
$brend = "";
$velicina = "";
$slika = "";
$cena = "";
$brojac = 0;


?>
<div class="row">
  <div class="col-md-3">
    <form class="formBrend" id="myForm" name="formBrend"  method="post" action="zene-majice.php">
      <table name="tableBrend" class="tableObuca">
        <tr><th>Brend</th></tr>
        <tr><td><input type="checkBox" id="brendNike" name="brend[]" value="Nike"><label class="brendLbl" for="brendNike" >Nike</label></td></tr>
        <tr><td><input type="checkBox" id="brendAddidas" name="brend[]" value="Addidas"><label class="brendLbl" for="brendAddidas">Addidas</label></td></tr>
        <tr><td><input type="checkBox" id="brendUnder" name="brend[]" value="Under Armour"><label class="brendLbl" for="brendUnder">Under Armour</label></td></tr>
        <tr><td><input type="checkBox" id="brendPuma" name="brend[]" value="Puma"><label class="brendLbl" for="brendPuma">Puma</label></td></tr>
      </table>
      <table name="tableSport" class="tableObuca">
        <tr><th>Tip</th></tr>
        <tr><td><input type="checkBox" id="sportTrening"  name="sport[]" value="Trening"><label class="brendLbl" for="sportTrening">Trening</label></td></tr>
        <tr><td><input type="checkBox" id="sportLifestyle"  name="sport[]" value="Lifestyle"><label class="brendLbl" for="sportLifestyle">Lifestyle</label></td></tr>
      </table>
      <table name="tableVelicina" class="tableObuca">
        <tr><th>Velicina</th></tr>
        <tr><td><input type="checkbox" id="S" name="broj[]" value="S"><label class="brendLbl" for="S">S</label>
          <input type="checkbox" id="M" name="broj[]" value="M"><label class="brendLbl" for="M">M</label></td></tr>
          <tr><td><input type="checkbox" id="M-L" name="broj[]" value="M-L"><label class="brendLbl" for="M-L">M-L</label>
            <input type="checkbox" id="L" name="broj[]" value="L"><label class="brendLbl" for="L">L</label></td></tr>
            <tr><td><input type="checkbox" id="XL" name="broj[]" value="XL"><label class="brendLbl" for="XL">XL</label>
            </td></tr>
          </table>
          <input type="submit" form="myForm" class="btn-info"  name="pretraga"  value="Pretraga">
        </form>
      </div>
      <?php 

      if(isset($_POST['pretraga']))
      {
        $testDeoUpita = "";
        $testDeoUpita1 = "";
        $testDeoUpita2 = "";

        $deoUpita = "'Nike', 'Addidas', 'Under Armour', 'Puma'";
        $deoUpita1 = "'Trening', 'Lifestyle', 'Kosarka', 'Fudbal', 'Outdoor'";
        $deoUpita2 = "'S', 'M', 'M-L', 'L', 'XL'";

        if(isset($_POST['brend']))
        {
          foreach ($_POST['brend'] as $check) 
          {
            $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
          }
          $deoUpita = rtrim($testDeoUpita, ", ");
        }

        if(isset($_POST['sport']))
        {
          foreach ($_POST['sport'] as $check) 
          {
            $testDeoUpita1 = $testDeoUpita1 . "'$check'" . ", ";                
          }
          $deoUpita1 = rtrim($testDeoUpita1, ", ");
        }

        if(isset($_POST['broj']))
        {
          foreach ($_POST['broj'] as $check) 
          {
            $testDeoUpita2 = $testDeoUpita2 . "'$check'" . ", ";                
          }
          $deoUpita2 = rtrim($testDeoUpita2, ", ");
        }

        $upit = "select * from Majice where Brend in(" . $deoUpita . ") AND Tip in(" . $deoUpita1 . ") AND Velicina in (" . $deoUpita2 . ") AND Pol in('Z')";
        $rez = $mysqli->query($upit);
        if($rez->num_rows>1)
        {
          while($row = $rez->fetch_assoc())
          {
            $sifra=$row['Sifra'];
            $tip=$row['Tip'];
            $brend=$row['Brend'];
            $velicina=$row['Velicina'];
            $slika=$row['Slika'];
            $cena=$row['Cena'];


            if($brojac >= 3 && $brojac % 3 == 0)
            {
              echo "<div class='col-md-3'>";
              echo "</div>";
              echo "<div class='col-md-3'>";
              echo "<form method='post' action='zene-majice.php?action=add&id=" . $sifra . "'>";
              echo "<div class='thumbnail'>";
              echo "<img src='" . $slika . "' alt='img'>";
              echo "<div class='caption'>";
              echo "<p>" . $brend . " " . $tip . "<br>" . "Velicina: " . $velicina . "<br>" . $cena . ",00rsd</p>";
              echo "<input type='hidden' name='hidden_name' value='" . $brend . ' ' . $tip . " '/>";
              echo "<input type='hidden' name='hidden_price' value='" . $cena . "'/>";
              echo "<input type='submit' name='add_to_cart' class='btn btn-info' value='Add to cart'/><br>";
              if(isset($_SESSION['role']))
              {
                if($_SESSION['role'] == 'Admin')
                {
                  echo "<a href='zene-majice.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                }
              }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
              echo "</div>";
              echo "</div>";
              echo "</form>";
              echo "</div>";
              $brojac = $brojac + 1;

            }
            else {

              echo "<div class='col-md-3'>";
              echo "<form method='post' action='zene-majice.php?action=add&id=" . $sifra . "'>";
              echo "<div class='thumbnail'>";
              echo "<img src='" . $slika . "' alt='img'>";
              echo "<div class='caption'>";
              echo "<p>" . $brend . " " . $tip . "<br>" . "Velicina: " . $velicina . "<br>" . $cena . ",00rsd</p>";
              echo "<input type='hidden' name='hidden_name' value='" . $brend . ' ' . $tip . " '/>";
              echo "<input type='hidden' name='hidden_price' value='" . $cena . "'/>";
              echo "<input type='submit' name='add_to_cart' class='btn btn-info' value='Add to cart'/><br>";
              if(isset($_SESSION['role']))
              {
                if($_SESSION['role'] == 'Admin')
                {
                  echo "<a href='zene-majice.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                }
              }
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
          $tip=$row['Tip'];
          $brend=$row['Brend'];
          $velicina=$row['Velicina'];
          $slika=$row['Slika'];
          $cena=$row['Cena'];

          echo "<div class='col-md-3'>";
          echo "<form method='post' action='zene-majice.php?action=add&id=" . $sifra . "'>";
          echo "<div class='thumbnail'>";
          echo "<img src='" . $slika . "' alt='img'>";
          echo "<div class='caption'>";
          echo "<p>" . $brend . " " . $tip . "<br>" . "Velicina: " . $velicina . "<br>" . $cena . ",00rsd</p>";
          echo "<input type='hidden' name='hidden_name' value='" . $brend . ' ' . $tip . " '/>";
          echo "<input type='hidden' name='hidden_price' value='" . $cena . "'/>";
          echo "<input type='submit' name='add_to_cart' class='btn btn-info' value='Add to cart'/><br>";
          if(isset($_SESSION['role']))
          {
            if($_SESSION['role'] == 'Admin')
            {
              echo "<a href='zene-majice.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
            }
          }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
          echo "</div>";
          echo "</div>";
          echo "</form>";
          echo "</div>";
        }    
      }


    ?>