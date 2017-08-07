<meta charset="utf-8">
<?php
  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  include('database.php');
  include('function.php');
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
            <input type="file" name="filename[]" multiple>
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
          $number = 1;
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
  if (isset($_FILES['filename'])) {
    for ($i = 0; $i < count($_FILES['filename']['name']); $i++) {
      foreach ($_FILES['filename'] as $_FILES['filename'][$i]) {
        $valid_types =  array('text','csv');
        $uploads_dir = 'files/';
        $name = $_FILES['filename']['name'][$i];
        $ext = substr($name, 1 + strrpos($name, "."));
        if (is_uploaded_file($_FILES['filename']['tmp_name'][$i])) {
          if ($_FILES['filename']['size'][$i] > ini_get('post_max_size')*1024*1024 ) {
            $messangers['size'] = '<div class="alert alert-danger col-md-12 text-center">Error: File size > 8MB.</div>';
          }
          elseif (!in_array($ext, $valid_types)) {
            $messangers['type'] =  '<div class="alert alert-danger col-md-12 text-center">Error: Invalid file type.</div>';
          }
          else {		
            move_uploaded_file($_FILES['filename']['tmp_name'][$i], $uploads_dir.$name);
            $messangers['success'] = '<div class="alert alert-success col-md-12 text-center">Moved file to destination directory</div>';
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
              if ( is_numeric ($row[1]) && is_string ($row[0]) && is_string($row[2])) {
                $result = mysqli_query($mysqli, "SELECT * FROM products  p 
                                                 INNER JOIN warehouses  w 
                                                 ON p.w_id = w.id 
                                                 WHERE product_name='" . $row[0] . "' and warehouses='" . $row[2] . "'");
                $myrow = mysqli_fetch_array($result);
                if (!empty($myrow['w_id'])) {
                  $qty = $row[1] + $myrow['qty'];
                  if (!$mysqli->query("UPDATE products SET qty='" . $qty . "' WHERE w_id='" . $myrow['w_id'] . "'")) echo "Erorr (" . $mysqli->errno . ") " . $mysqli->error;
                }
                else{
                  if (!$mysqli->query("INSERT INTO warehouses (warehouses) VALUES('$row[2]')")) echo "Error (" . $mysqli->errno . ") " . $mysqli->error;
                  $id = mysqli_query($mysqli, "SELECT id FROM warehouses WHERE warehouses = '" . $row[2]  . "'");
                  $myid = mysqli_fetch_array($id);
                  if (!$mysqli->query("INSERT INTO products  (product_name, qty, w_id ) VALUES ('$row[0]', '$row[1]', '" . $myid['id']  . "')")) echo "Error (" . $mysqli->errno . ") " . $mysqli->error;
                }
              }  
              else {
                $messangers['data'] = '<div class="alert alert-danger col-md-12 text-center">File data not valid</div>';
              }
            }
          } 
        @unlink($uploads_dir.$name);}
      }
    }
    if (isset ($messangers)) {
      foreach($messangers as $message) {
        echo $message ;
      }
    }
  }  
  
  

