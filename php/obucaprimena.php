<!-- Controls -->
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
  $upit = "delete from obuca where sifra ='" . $_GET['id'] . "'";
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
    <form class="formBrend" id="myForm" name="formBrend"  method="post" action="muskarci-obuca.php">
      <table name="tableBrend" class="tableObuca">
        <tr><th>Brend</th></tr>
        <tr><td><input type="checkBox" id="brendNike" name="brend[]" value="Nike"><label class="brendLbl" for="brendNike" >Nike</label></td></tr>
        <tr><td><input type="checkBox" id="brendAddidas" name="brend[]" value="Addidas"><label class="brendLbl" for="brendAddidas">Addidas</label></td></tr>
        <tr><td><input type="checkBox" id="brendReebok" name="brend[]" value="Reebok"><label class="brendLbl" for="brendReebok">Reebok</label></td></tr>
        <tr><td><input type="checkBox" id="brendPuma" name="brend[]" value="Puma"><label class="brendLbl" for="brendPuma">Puma</label></td></tr>
      </table>
      <table name="tableSport" class="tableObuca">
        <tr><th>Sport</th></tr>
        <tr><td><input type="checkBox"  name="sport[]" value="Kosarka"><label class="brendLbl" for="sportKosarka">Kosarka</label></td></tr>
        <tr><td><input type="checkBox"  name="sport[]" value="Fudbal"><label class="brendLbl" for="sportFudbal">Fudbal</label></td></tr>
        <tr><td><input type="checkBox"  name="sport[]" value="Outdoor"><label class="brendLbl" for="sportOutdoor">Outdoor</label></td></tr>
      </table>
      <table name="tableVelicina" class="tableObuca">
        <tr><th>Velicina</th></tr>
        <tr><td><input type="checkbox" id="broj35" name="broj[]" value="35"><label class="brendLbl" for="broj35">35</label>
          <input type="checkbox" id="broj36" name="broj[]" value="36"><label class="brendLbl" for="broj36">36</label>
          <input type="checkbox" id="broj37" name="broj[]" value="37"><label class="brendLbl" for="broj37">37</label></td></tr>
          <tr><td><input type="checkbox" id="broj38" name="broj[]" value="38"><label class="brendLbl" for="broj38">38</label>
            <input type="checkbox" id="broj39" name="broj[]" value="39"><label class="brendLbl" for="broj39">39</label>
            <input type="checkbox" id="broj40" name="broj[]" value="40"><label class="brendLbl" for="broj40">40</label></td></tr>
            <tr><td><input type="checkbox" id="broj41" name="broj[]" value="41"><label class="brendLbl" for="broj41">41</label>
              <input type="checkbox" id="broj42" name="broj[]" value="42"><label class="brendLbl" for="broj42">42</label>
              <input type="checkbox" id="broj43" name="broj[]" value="43"><label class="brendLbl" for="broj43">43</label></td></tr>
              <tr><td><input type="checkbox" id="broj44" name="broj[]" value="44"><label class="brendLbl" for="broj44">44</label>
                <input type="checkbox" id="broj45" name="broj[]" value="45"><label class="brendLbl" for="broj45">45</label>
                <input type="checkbox" id="broj46" name="broj[]" value="46"><label class="brendLbl" for="broj46">46</label></td></tr>

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
            if(isset($_POST['brend']) == false && isset($_POST['broj']) && isset($_POST['sport']) == false) // 1 kombinacija - broj set
            {
              foreach ($_POST['broj'] as $check) 
              {
                $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
              }
              $deoUpita = rtrim($testDeoUpita, ", ");
              $upit = "select * from obuca where Velicina in(" . $deoUpita . ")";
              $rez = $mysqli->query($upit);
              if(!$rez)
              {
                alert("Doslo je do greske prilikom ucitavanja proizvoda!");
              }
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
              }    
              
            }
            if(isset($_POST['brend']) && isset($_POST['broj']) == false && isset($_POST['sport']) == false) // 1 kombinacija - brend set
            {
              foreach ($_POST['brend'] as $check) 
              {
                $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
              }
              $deoUpita = rtrim($testDeoUpita, ", ");
              $upit = "select * from obuca where Brend in(" . $deoUpita . ")";
              $rez = $mysqli->query($upit);
              if(!$rez)
              {
                alert("Doslo je do greske prilikom ucitavanja proizvoda!");
              }
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
              }    
              
            }
            if(isset($_POST['brend']) == false && isset($_POST['broj']) == false && isset($_POST['sport'])) // 1 kombinacija - sport set
            {
              foreach ($_POST['sport'] as $check) 
              {
                $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
              }
              $deoUpita = rtrim($testDeoUpita, ", ");
              $upit = "select * from obuca where Tip in(" . $deoUpita . ")";
              $rez = $mysqli->query($upit);
              if(!$rez)
              {
                alert("Doslo je do greske prilikom ucitavanja proizvoda!");
              }
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
              }    
              
            }
            if(isset($_POST['brend'])  && isset($_POST['broj'])  && isset($_POST['sport']) == false) 
            {
              foreach ($_POST['brend'] as $check) 
              {
                $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
              }
              foreach ($_POST['broj'] as $check) 
              {
                $testDeoUpita1 = $testDeoUpita1 . "'$check'" . ", ";                
              }
              $deoUpita = rtrim($testDeoUpita, ", ");
              $deoUpita1 = rtrim($testDeoUpita1, ", ");
              $upit = "select * from obuca where Brend in(" . $deoUpita . ") AND Velicina in( " . $deoUpita1 . ")";
              $rez = $mysqli->query($upit);
              if(!$rez)
              {
                alert("Doslo je do greske prilikom ucitavanja proizvoda!");
              }
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
              }    
              
            }
            if(isset($_POST['brend'])  && isset($_POST['broj']) == false  && isset($_POST['sport'])) 
            {
              foreach ($_POST['brend'] as $check) 
              {
                $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
              }
              foreach ($_POST['sport'] as $check) 
              {
                $testDeoUpita1 = $testDeoUpita1 . "'$check'" . ", ";                
              }
              $deoUpita = rtrim($testDeoUpita, ", ");
              $deoUpita1 = rtrim($testDeoUpita1, ", ");
              $upit = "select * from obuca where Brend in(" . $deoUpita . ") AND Tip in( " . $deoUpita1 . ")";
              $rez = $mysqli->query($upit);
              if(!$rez)
              {
                alert("Doslo je do greske prilikom ucitavanja proizvoda!");
              }
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
              }    
              
            }
            if(isset($_POST['brend']) == false  && isset($_POST['broj'])  && isset($_POST['sport'])) 
            {
              foreach ($_POST['broj'] as $check) 
              {
                $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
              }
              foreach ($_POST['sport'] as $check) 
              {
                $testDeoUpita1 = $testDeoUpita1 . "'$check'" . ", ";                
              }
              $deoUpita = rtrim($testDeoUpita, ", ");
              $deoUpita1 = rtrim($testDeoUpita1, ", ");
              $upit = "select * from obuca where Velicina in(" . $deoUpita . ") AND Tip in( " . $deoUpita1 . ")";
              $rez = $mysqli->query($upit);
              if(!$rez)
              {
                alert("Doslo je do greske prilikom ucitavanja proizvoda!");
              }
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
              }    
            }
            if(isset($_POST['brend'])  && isset($_POST['broj'])  && isset($_POST['sport'])) 
            {
              foreach ($_POST['brend'] as $check) 
              {
                $testDeoUpita = $testDeoUpita . "'$check'" . ", ";                
              }
              foreach ($_POST['broj'] as $check) 
              {
                $testDeoUpita1 = $testDeoUpita1 . "'$check'" . ", ";                
              }
              foreach ($_POST['sport'] as $check) 
              {
                $testDeoUpita2 = $testDeoUpita2 . "'$check'" . ", ";                
              }
              $deoUpita = rtrim($testDeoUpita, ", ");
              $deoUpita1 = rtrim($testDeoUpita1, ", ");
              $deoUpita2 = rtrim($testDeoUpita2, ", ");
              $upit = "select * from obuca where Brend in(" . $deoUpita . ") AND Velicina in( " . $deoUpita1 . ") AND Tip in(" . $deoUpita2 . ")";
              $rez = $mysqli->query($upit);
              if(!$rez)
              {
                alert("Doslo je do greske prilikom ucitavanja proizvoda!");
              }
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                    echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
              }    
              
            }
            else if (isset($_POST['brend']) == false && isset($_POST['broj']) == false && isset($_POST['sport']) == false)
            {
             $upit = "select * from obuca";
             $rez = $mysqli->query($upit);
             if(!$rez)
             {
              alert("Doslo je do greske prilikom ucitavanja proizvoda!");
            }
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
                  echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
                  echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
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
              echo "<form method='post' action='muskarci-obuca.php?action=add&id=" . $sifra . "'>";
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
                        echo "<a href='muskarci-obuca.php?action=delete&id=" . $sifra . "'><span class='text-danger'>Obrisi iz baze</span></a>";
                      }
                    }
                    //echo "<p><a href='#'' class='btn btn-info' role='button'>Dodaj u korpu &rarr;</a></p>";
              echo "</div>";
              echo "</div>";
              echo "</form>";
              echo "</div>";
            }    
          }
        }
        ?>
      </div>  


