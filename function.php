<?php
	function get_products() {
		
	  global $link;
	  $sql = 'SELECT * FROM products  p 
            INNER JOIN warehouses  w 
            ON p.wh_id = w.w_id ';
   		
	  $result = mysqli_query($link, $sql);
		
	  $products = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
    
		
	  return $products;
		
	}
	