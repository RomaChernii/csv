<?php
try {
    $host = 'localhost';
    $db   = 'csv';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $db = new PDO($dsn, $user, $pass, $opt);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
$stmt = $db->query('SELECT * FROM quantity q
              INNER JOIN products p ON q.prod_id = p.prod_id
              INNER JOIN warehouses w ON q.wh_id = w.wh_id 
              WHERE q.qty > 0 ORDER BY q.q_id');


	/*function get_products() {
		
	  global $link;
     
      $sql = 'SELECT * FROM quantity q
              INNER JOIN products p ON q.prod_id = p.prod_id
              INNER JOIN warehouses w ON q.wh_id = w.wh_id 
              WHERE q.qty > 0 ORDER BY q.q_id';
   		
	  $result = mysqli_query($link, $sql);
		
	  $products = mysqli_fetch_all($result,MYSQLI_ASSOC);
        
	  return $products;
		
	}*/
	
  /*<?php
  
    $host = 'localhost';
    $db   = 'csv';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
  try{
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $opt);
  
   


	function get_products() {
		
	  
     
      $stmt = $pdo -> prepare ('SELECT * FROM quantity 
              INNER JOIN products p ON q.prod_id = p.prod_id
              INNER JOIN warehouses w ON q.wh_id = w.wh_id 
              WHERE q.qty > 0 ORDER BY q.q_id ');
          
   	
		
	}}
	 catch(PDOException $err){
      die($err->getMessage());
    }*/