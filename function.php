<?php
	function get_products() {
		
	  global $link;

	  $sql = 'SELECT * FROM product WHERE qty>0 ORDER BY id ';
		
	  $result = mysqli_query($link, $sql);
		
	  $products = mysqli_fetch_all($result,MYSQLI_ASSOC);
		
	  return $products;
		
	}
	