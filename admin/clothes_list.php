<?php
include '../db.php';

$data = mysqli_query($con,"DELETE FROM products where product_id=".$_GET['id']);
if($data)
	echo 1;
mysqli_close($con);