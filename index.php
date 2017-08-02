<meta charset="utf-8">
<?php
  ini_set('error_reporting',E_ALL);
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  include("database.php");
  include("function.php");
?>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouses</title>
    <link href="/public/css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <div class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <h3><p><b class="navbar-brand">Warehouses</b></p></h3>
        </div>
        <div class="collapse navbar-collapse">
          <h4><p><b class="navbar-btn">Form for uploading files </b></p></h4>
          <form method="post" enctype="multipart/form-data">
            <input type="file" name="filename">
            <input type="submit"class="btn btn-info navbar-btn" value="Download">
          </form>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead class="thead-inverse">
          <tr class="bg-primary">
            <th>#</th>
            <th>Product_Name</th>
            <th>Qty</th>
            <th>Warehouse</th>
          </tr>
        </thead>
        <?php
          $number=1;
          $products = get_products();
        ?>
        <?php foreach($products as $product):?>
        <tbody>
          <tr class="bg-success">
            <th scope="row"><?=$number++?></th>
            <td><?=$product['product_name']?></td>
            <td><?=$product['qty']?></td>
            <td><?=$product['warehouses']?></td>
          </tr>
        </tbody>
        <?php endforeach;?>
      </table>
    </div>
  </body>
</html>

<?php
  $valid_types =  array('text','csv');
  if (isset($_FILES["filename"])) {
    $uploads_dir = 'files/';
    $name = $_FILES['filename']['name'];
    $ext = substr($name, 1 + strrpos($name, "."));
    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
      if ($_FILES['filename']['size'] > ini_get('post_max_size')*1024*1024 ) {
      echo "<div class='alert alert-danger col-md-12 text-center'>Error: File size > 8MB.</div>";
      }
      elseif (!in_array($ext, $valid_types)) {
      echo "<div class='alert alert-danger col-md-12 text-center'>Error: Invalid file type.</div>";
      }
      else {		
        move_uploaded_file($_FILES['filename']['tmp_name'], $uploads_dir.$name);
        echo "<div class='alert alert-success col-md-12 text-center'>Moved file to destination directory</div>";
        $file = file_get_contents($uploads_dir.$name);
        $lines = explode(PHP_EOL, $file);
        $array = array();
        foreach ($lines as $key => $line) {
          if ($key == 0) {
            continue;
          }
          $line = str_getcsv($line);
          $array[] = reset($line);
        }
        $mysqli = $GLOBALS['link'];
        foreach ($array as $row) {
          $row = str_getcsv($row, ";");
          $result = mysqli_query($mysqli, 'SELECT * FROM product WHERE product_name="' . $row[0] . '" and warehouses="' . $row[2] . '"');
          $myrow = mysqli_fetch_array($result);
          if (!empty($myrow['id'])) {
            $qty = $row[1] + $myrow['qty'];
            if (!$mysqli->query('UPDATE product SET qty="' . $qty . '" WHERE id="' . $myrow['id'] . '"')) echo "Erorr (" . $mysqli->errno . ") " . $mysqli->error;
          }
          else{
            if (!$mysqli->query("INSERT  product(product_name, qty, warehouses) VALUES ('$row[0]', '$row[1]', '$row[2]')")) echo "Erorr (" . $mysqli->errno . ") " . $mysqli->error;
          }
        }
        $mysqli->close();
      }
    }
  }
?>
