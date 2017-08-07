<?php
	function get_products() {
		
	  global $link;
     
      $sql = 'SELECT * FROM products  p 
              INNER JOIN warehouses  w 
              ON p.w_id = w.id  
              WHERE p.qty > 0 ORDER BY w.id';
   		
	  $result = mysqli_query($link, $sql);
		
	  $products = mysqli_fetch_all($result,MYSQLI_ASSOC);
        
	  return $products;
		
	}
	