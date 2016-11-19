<?php
	include "mysql_connect_histdata.php";

	$symbol = $_GET['symbol'];
	

		$priceDB=mysqli_connect("localhost","root","","histdata");
		// Check connection
		if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}

		$result = mysqli_query($priceDB,"SELECT `pred_nd`,`pred_nm_low`,`pred_nm_low_conf`,`pred_nm_high`,`pred_nm_high_conf` FROM `{$symbol}` WHERE `ID`= (SELECT MIN(`ID`)FROM `{$symbol}`)");
		$row = mysqli_fetch_assoc($result);
		print(json_encode($row));
		
		mysqli_close($priceDB);

		
	

?>
