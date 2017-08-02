<?php
  $link=mysqli_connect('localhost','root','','warehouse');
  mysqli_query($link, 'set names utf8 collate utf8_general_ci');
  if(mysqli_connect_errno()){
	echo 'Ошыбка в подключении к бази данных('.mysqli_connect_errno().'): '.mysqli_connect_error();
	exit();
  }
