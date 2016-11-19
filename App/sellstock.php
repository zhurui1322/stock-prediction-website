<?php 
	$username = $_GET["username"];
	$id = $_GET['id'];

	$userDB=mysqli_connect("localhost","root","","user");
	// Check connection
		if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
		$result = mysqli_query($userDB, "SELECT * FROM  `{$username}`WHERE `ID`= (SELECT MAX(`ID`)FROM `{$username}`)");
		$row = mysqli_fetch_array($result);	
		/*---------cash we have now --------------*/
		$money = $row['money'];

		
		$result = mysqli_query($userDB, "SELECT * FROM  `{$username}`   WHERE `ID` =  {$id}");
		$row = mysqli_fetch_array($result);	
		if($row == true)
		{
			$sell_symbol = $row['symbol'];
			$sell_price_buy = $row['price'];
			$sell_shares = $row['shares'];
			mysqli_close($userDB);
			
			
			$priceDB=mysqli_connect("localhost","root","","realdata");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}

			$result = mysqli_query($priceDB,"SELECT * FROM `{$sell_symbol}` WHERE `ID`= (SELECT MAX(`ID`)FROM `{$sell_symbol}`)");
			$row = mysqli_fetch_array($result);
			
			  $sell_price = $row['ask'];
			  
			
			mysqli_close($priceDB);

			$Nowdate = date("Y-m-d H:i:s");
			echo $Nowdate;
			$money = $money + ($sell_price*$sell_shares);
			
			$userDB=mysqli_connect("localhost","root","","user");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
		
			mysqli_query($userDB, "INSERT INTO `{$username}`(`date_time`,`symbol`,`price`,`shares`,`sell_buy`, `money`) VALUES 
			('{$Nowdate}','{$sell_symbol}','{$sell_price}','{$sell_shares}', '0','{$money}')");
			
			
			mysqli_query($userDB, "UPDATE `{$username}` SET `sell_buy`='2' WHERE `ID` =  {$id} ");
			
		
			
			mysqli_close($userDB);
		}
		else
			mysqli_close($userDB);
			
	
	?>