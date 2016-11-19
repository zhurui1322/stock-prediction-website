<?php
	include "mysql_connect_user.php";
	$username = $_GET["username"];
	$quantity = $_GET['quantity'];
	$symbol = $_GET['symbol'];
	

		$priceDB=mysqli_connect("localhost","root","","realdata");
		// Check connection
		if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}

		$result = mysqli_query($priceDB,"SELECT * FROM `{$symbol}` WHERE `ID`= (SELECT MAX(`ID`)FROM `{$symbol}`)");
		while($row = mysqli_fetch_array($result))
		{
		  $price = $row['ask'];

		}
		
		mysqli_close($priceDB);

		$Nowdate = date("Y-m-d H:i:s");


		$userDB=mysqli_connect("localhost","root","","user");
		// Check connection
		if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
		
		$result = mysqli_query($userDB, "SELECT * FROM  `{$username}`WHERE `ID`= (SELECT MAX(`ID`)FROM `{$username}`)");
		
		
		
		$row = mysqli_fetch_array($result);	
		if($row == false)
			$money = 100000;
		else
			$money = $row['money'];
		
		$money = $money - $price * $quantity;
		if($money >=0)
		{
			mysqli_query($userDB, "INSERT INTO `{$username}`(`date_time`,`symbol`,`price`,`shares`,`sell_buy`, `money`) VALUES 
			('{$Nowdate}','{$symbol}','{$price}','{$quantity}',  '1','{$money}')");
			$output = array('IsBuy' => "true");
			print(json_encode($output));
	
		}
		else 
		{
			$output = array('IsBuy' => "false");
			print(json_encode($output));
		
		
		}
		
	
		mysqli_close($userDB);
	

?>
