<!--  simulator page               -->
<!--  written by:   Rui Zhu     -->
<!--  assisted by:	Yue Gu      -->
<!--  debugged by:  Xingyi Fan -->


<?php
session_start();
if(!$_SESSION['username'])
{
	header("location: loginandregister.php");
}
?>

<?php

	if( isset($_POST['submit']))
	{
		$quantity = $_POST['quantity'];
		$symbol = $_POST['symbol'];
		
	
		
		


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
		
		$result = mysqli_query($userDB, "SELECT * FROM  `{$_SESSION['username']}`WHERE `ID`= (SELECT MAX(`ID`)FROM `{$_SESSION['username']}`)");
		
		
		
		$row = mysqli_fetch_array($result);	
		if($row == false)
			$money = 100000;
		else
			$money = $row['money'];
		
		$money = $money - $price * $quantity;
		if($money >=0)
			mysqli_query($userDB, "INSERT INTO `{$_SESSION['username']}`(`date_time`,`symbol`,`price`,`shares`,`sell_buy`, `money`) VALUES ('{$Nowdate}','{$symbol}','{$price}','{$quantity}',  '1','{$money}')");
		//	mysqli_query($userDB, "INSERT INTO `{$_SESSION['username']}`(`date_time`,`symbol`,`price`,`shares`,`sell_buy`, `money`) VALUES ('{$Nowdate}','{$symbol}','{$price}','{$quantity}',  '1','{$money}')");


		mysqli_close($userDB);
	}
	/*--------------------------sell stock php ---------------------------*/
	if( isset($_POST['sellit']))
	{
	
		$id = $_POST['id'];
		$sell_quantity= $_POST['sell_quantity'];
		
		echo $id;
		echo $sell_quantity;

		$userDB=mysqli_connect("localhost","root","","user");
		// Check connection
		if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
		$result = mysqli_query($userDB, "SELECT * FROM  `{$_SESSION['username']}`WHERE `ID`= (SELECT MAX(`ID`)FROM `{$_SESSION['username']}`)");
		$row = mysqli_fetch_array($result);	
		/*---------cash we have now --------------*/
		$money = $row['money'];

		
		$result = mysqli_query($userDB, "SELECT * FROM  `{$_SESSION['username']}`   WHERE `ID` =  {$id}");
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
			
			$money = $money + ($sell_price*$sell_quantity);
			
			$remind_share = $sell_shares-$sell_quantity;
			$userDB=mysqli_connect("localhost","root","","user");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
		
			mysqli_query($userDB, "INSERT INTO `{$_SESSION['username']}`(`date_time`,`symbol`,`price`,`shares`,`sell_buy`, `money`) VALUES 
			('{$Nowdate}','{$sell_symbol}','{$sell_price}','{$remind_share}', '0','{$money}')");
			
			if($sell_shares-$sell_quantity==0)
				mysqli_query($userDB, "UPDATE `{$_SESSION['username']}` SET `sell_buy`='2' WHERE `ID` =  {$id} ");
			else
				mysqli_query($userDB, "UPDATE `{$_SESSION['username']}` SET `shares`={$remind_share} WHERE `ID` =  {$id} ");
			
			
			mysqli_close($userDB);
		}
		else
			mysqli_close($userDB);
			
	
	}
	
?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" class="no-js">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="viewport" content="width=device-width">

<title>Rutgers Stock Predict and Simulator</title>
<!--General Page CSS-->
<link rel="stylesheet" href="css/simulator_style.css" media="screen" type="text/css" />
<!--Element CSS-->
<link rel="stylesheet" href="css/menu.css" media="screen" type="text/css" />


<!--gallery Javascript and CSS-->
<link rel="stylesheet" href="css/slider.css"  type="text/css" />
<script type='text/javascript' src='js/gallery/jquery-1.7.2.min.js'></script>



<!--Fonts Link-->
<link href='http://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:regular,bold" type="text/css" />
	
<!-- Search Box Javascript and CSS -->
<script type='text/javascript' src='js/custom.js'></script>
<link href="css/searchboxstyle.css" rel="stylesheet" type="text/css" />
	
<link rel="stylesheet" href="css/table.css" media="screen" type="text/css" />


<script type='text/javascript' src='js/simulator.js'></script>

</head>


<body>
	<!-- Title  -->
	<div id = "head">
		<div id = "title">
			<h1>Rutgers Stock Predict and Simulator</h1>
		</div>
	</div>
	<!-- Menu -->
	<div class='nav'>
		<ul>
			<li><a href='index.php'>Home</a></li>
			<li><a href='about.html'>About Us</a></li>
			<li><a href='#'>Prediction strategy</a>
			<ul>
				<li><a href='longterm.html'>Long-term</a></li>
				<li><a href='shortterm.html'>Short-term</a></li>
			</ul>
			</li>
			<li><a href='loginandregister.php'>Stock Simulation</a>
			<ul>
				<li><a href='loginandregister.php'>Login</a></li>
			</ul>
			</li>
			<li><a href='android.html'>Android App</a></li>
			<li class='lamp'><span></span></li>
		</ul>
	</div>
	<!-- Searchbox -->	
	
	<div id="main">
		<input type="text" id="search" autocomplete="off" placeholder='Search All NASDAQ Stock' type='text'>
		<!-- Show Results -->
		<h4 id="results-text">Showing results for: <b id="search-string">Array</b></h4>
		<ul id="results"></ul>
	</div>
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	<div id = "contentbox">
		
		<div id="d0">
			<h1 class="h1">Welcome to Rutgers Stock Simulator</h1>
		</div>
		
		
		
		<div id = "accountinfo">
			<p color = 'blue' size = '8'>	
				User Name :<?php echo $_SESSION['username'];?><br>
				User Email :<?php echo $_SESSION['email'];?><br>
			
			<a href = 'PHPscript/logout.php'> Logout here<br></a>
			</p>
		</div>
		
		
		
		
		
		
		
		
		
		
		<?php
			$userDB=mysqli_connect("localhost","root","","user");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			$num = 0;
			$result = mysqli_query($userDB, "SELECT * FROM  `{$_SESSION['username']}`WHERE `ID` = (SELECT MAX(`ID`)FROM `{$_SESSION['username']}`)");
			$rs=mysqli_fetch_array($result);
			if($rs == true)
			{
				$rs_cash = ($rs['money']);
				$Isfirsttime = 0;
			}
			else 
				$Isfirsttime = 1;
			
			$result = mysqli_query($userDB, "SELECT * FROM  `{$_SESSION['username']}` WHERE `sell_buy` = 1");
			
			$rs=mysqli_fetch_array($result);
			if($rs == true)
			{
				do
				{		
					$rs_id[$num] = ($rs["ID"]);
					$rs_date[$num]=($rs['date_time']);		
					$rs_stock[$num]=($rs['symbol']);	
					$rs_price_buy[$num]=($rs['price']);
					$rs_shares[$num]=($rs['shares']);
					
					
					
					$num++;
					
				}while($rs = mysqli_fetch_array($result));
			}
			

			mysqli_close($userDB);
			
			
			$priceDB=mysqli_connect("localhost","root","","realdata");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			$totalStockValue = 0;
			for($i = 0; $i < $num ; $i++)
			{
				$result = mysqli_query($priceDB,"SELECT * FROM `{$rs_stock[$i]}` WHERE `ID`= (SELECT MAX(`ID`)FROM `{$rs_stock[$i]}`)");
				$lastprice = mysqli_fetch_array($result);
				
				$realprice[$i] = $lastprice['ask'];
				$pricechange[$i] = $lastprice['change1'];

				
				$totalStockValue += ($realprice[$i])*$rs_shares[$i];
				
				
			}
			mysqli_close($priceDB);
			
			
			
			
			
			
			$histdataDB=mysqli_connect("localhost","root","","histdata");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			for($i = 0; $i < $num ; $i++)
			{
				$resultpred = mysqli_query($histdataDB,"SELECT * FROM `{$rs_stock[$i]}` WHERE `ID`= 1");
				$rsp = mysqli_fetch_array($resultpred);
				$pred_nd[$i] = ($rsp['pred_nd']);
				
				if($pred_nd[$i]<= $realprice[$i])
					$sellorbuy[$i] = "sell";
				else
					$sellorbuy[$i] = "keep or buy more";
			}		
			
			mysqli_close($histdataDB);

		?>
		
		
	
		<div id="d0">
			<h1 class="h1">Your Stcok Portfolio</h1>
		</div>
		
		
		<div id = "Portfolio">
			
			<?php 
			if($Isfirsttime == 1)
			{
			?>
			
			<p1>You have no record for any stock<br></p1>
			<p1>You get <span style="color:green;font-weight:bold">$100,000</span>virtual moeny Risk Free</p1>
			<p>Join the Rutgers Stock Simulator for FREE and receive $100,000 in virtual cash! <br>Put your trading skills to the test against other users and see where you rank among all traders. <br>Beat the rest of the pack and trade your way to the top!</p>
			
			<?php
			}
			else
			{
			?>
			<p1>Cash :<?php  echo number_format($rs_cash,2);?>$ <br> </p1>
			<p1>Equities :<?php echo number_format($totalStockValue,2);?>$ <br> </p1>
			<p1>Total  :<?php echo number_format($rs_cash+$totalStockValue,2);?>$ <br><br> </p1>
			<table class="hovertable">
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td style="width:150px">Trade Date</td>
					<td style="width:50px">Stock Symbol</td>
					<td style="width:70px">Price You buy</td>
					<td style="width:70px">Real time Price</td>
					<td style="width:70px">Price Change</td>
					<td style="width:70px">Shares you own</td>
					<td style="width:70px">Stock Value</td>
					<td style="width:70px">Value Change</td>
					<td style="width:70px">Sell Share</td>
					<td style="width:60px">SELL IT</td>
				</tr>
			</table>
				<?php
				for($i = 0; $i < $num ; $i++)
				{
					$valuechange = ($realprice[$i]-$rs_price_buy[$i])*$rs_shares[$i];
					if ($valuechange == 0)
					{
						$valuechange_str = "<p style = 'color :black'>&#8594;<p>";
						$porColor = "#d4e3e5";
					}
					if ($valuechange > 0)
					{
						$valuechange_str = "<p style = 'color :green'>&#8593;<p>";
						$porColor = "#9dff9d";
					}
					if ($valuechange < 0)
					{
						$valuechange_str = "<p style = 'color :red'>&#8595;<p>";	
						$porColor = "#ff7676";
					}
				
				
				?>
				<table class="hovertable">
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td style="width:150px;background:<?php echo $porColor;?>"><?php echo $rs_date[$i];?></td>
						<td style="width:50px;background:<?php echo $porColor;?>"><?php echo $rs_stock[$i];?></td>
						<td style="width:70px;background:<?php echo $porColor;?>"><?php echo number_format($rs_price_buy[$i],2);?></td>
						<td style="width:70px;background:<?php echo $porColor;?>"><?php echo number_format($realprice[$i],2);?></td>
						<td style="width:70px;background:<?php echo $porColor;?>"><?php echo $pricechange[$i];?></td>
						<td style="width:70px;background:<?php echo $porColor;?>"><?php echo $rs_shares[$i];?></td>
						<td style="width:70px;background:<?php echo $porColor;?>"><?php echo number_format($realprice[$i]*$rs_shares[$i],2);?></td>

						<td style="width:70px;background:<?php echo $porColor;?>"><?php echo number_format($valuechange,2).$valuechange_str;?></td>
						
						
						<td style="width:70px;background:<?php echo $porColor;?>">
							<form  name = "mysellform" action="simulator.php" method = "POST" > 
								<input  type="number" name="sell_quantity" min="1" max="<?php echo $rs_shares[$i];?>">
								
							
						</td>
						
						
						<td style="width:60px;background:<?php echo $porColor;?>">
							
								<input type="hidden" name="id" value = "<?php echo $rs_id[$i];?>"></input>
								<input type="submit" name="sellit" value="SELL IT" Onclick = "return mychecksell();"></input>
							</form>
					
						</td>
					</tr>
					
					
					
					
				</table>
			
			
			<table class="hovertable">
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td style="width:882px;background:#d4e3e5">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						For the <span style="color:blue;font-weight:bold"><?php echo $rs_stock[$i];?></span> The predict price of next day is <span style="color:blue;font-weight:bold"><?php echo $pred_nd[$i];?>$</span> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspWe recommend you to <span style="color:blue;font-weight:bold"><?php echo $sellorbuy[$i];?> it</span> </td>
					</tr>
					
			</table>
			
			
			<?php
				}
			}
			?>
			
			
			
			
			
			
		</div>
		
		
		<script language = "javascript">
					function mychecksell()
					{
						if(mysellform.sell_quantity.value=="")
						{
							alert(" Enter The Shares of Sell !");
							mysellform.sell_quantity.focus();
							return false;
						}
					}
					</script>
		
		
		
		
		
		
		
	 
		
		<div id="d0">
			<h1 class="h1">Search Stock and Place Order</h1>
		</div>

		
		
		<div id = "searchstock">
			<form name ="mybuyform"action="simulator.php" method = "POST" > 
			<p1>Stock Symbol:</p1><input class="textbox" type="text" name="symbol" onkeyup="showUser(this.value);showHint(this.value)">
				<p1>	Quantity for Order</p1> <input class="textbox" type="number" name="quantity" min="1" max="200">
				<input type="submit" name= "submit" Onclick = "return mycheckbuy();" value = "BUY IT">
			</form>
			
			
			
			<script language = "javascript">
				function mycheckbuy()
				{
					if(mybuyform.symbol.value=="")
					{
						alert(" Enter Stock Symbol you want to buy!");
						mybuyform.symbol.focus();
						return false;
					}
						
						
					if(mybuyform.quantity.value=="")
					{
						alert(" Enter Stock quantity you want to buy!");
						mybuyform.quantity.focus();
						return false;
					}
						
				}
			</script>
			
			
			
			
			
			
			
			
			
			<br><br><p>Suggestions: <span id="txtHint"></span></p>
			<div id="txtStock">
				
			</div>
				
		</div>
		
		<div id="d0">
			<h1 class="h1">Stock Trade History</h1>
		</div>
		
		
		
		
		
		<?php
			$userDB=mysqli_connect("localhost","root","","user");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			$num = 0;
			$result = mysqli_query($userDB, "SELECT * FROM  `{$_SESSION['username']}`");
			
			$rs=mysqli_fetch_array($result);
			if($rs == true)
			{
				do
				{		
					$rs_id[$num] = ($rs["ID"]);
					$rs_date[$num]=($rs['date_time']);		
					$rs_stock[$num]=($rs['symbol']);	
					$rs_price_buy[$num]=($rs['price']);
					$rs_shares[$num]=($rs['shares']);
					$rs_cash[$num] = ($rs['money']);
					
					if($rs['sell_buy']==0)
						$rs_sell_buy[$num] = "sell";
					else if($rs['sell_buy']==1)
						$rs_sell_buy[$num] = "holding";
					else if($rs['sell_buy']==2)
						$rs_sell_buy[$num] = "sold";
					
					$num++;
					
				}while($rs = mysqli_fetch_array($result));
			}
			if($num==0)
				 $Isfirsttime = 1;
			else $Isfirsttime = 0;
			mysqli_close($userDB);
		?>
		
		<div id = "Portfolio">
		
		 <?php 
			
			if($Isfirsttime == 1)
			{
			?>
			
			<p1>You have no record for any stock<br></p1>
			
			
			<?php
			}
			else
			{
			?>

			
				<table class="hovertable" style = "text-align:center; margin-left:120px">
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td style="width:150px">Trade Date</td>
						<td style="width:100px">Buy or Sell</td>
						<td style="width:100px">Stock Symbol</td>
						<td style="width:100px">Shares</td>
						<td style="width:100px">Price Buy or Sell</td>
						 
					</tr>
				</table>
			
				<?php
				for($i = 0; $i < $num ; $i++)
				{
				
					if($rs_sell_buy[$i] == "sell")
						$backgroundColor = "#4e7881";
					if($rs_sell_buy[$i] == "sold")
						$backgroundColor = "#97bbc0";	
					if($rs_sell_buy[$i] == "holding")
						$backgroundColor = "#d4e3e5";
				
				?>
				<table class="hovertable" style = "text-align:center; margin-left:120px">
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					
					<td style="width:150px; background:<?php echo $backgroundColor;?>"><?php echo $rs_date[$i];?></td>
					<td style="width:100px; background:<?php echo $backgroundColor;?>"><?php echo $rs_sell_buy[$i];?></td>
					<td style="width:100px; background:<?php echo $backgroundColor;?>"><?php echo $rs_stock[$i];?></td>
					<td style="width:100px; background:<?php echo $backgroundColor;?>"><?php echo $rs_shares[$i];?></td>
					<td style="width:100px; background:<?php echo $backgroundColor;?>"><?php echo number_format($rs_price_buy[$i],2);?></td>
				</tr>
				</table>
			
			
	
			
			<?php
				}
			}
			?>
		</div>
		
		
		
	
		
		
		
		
		
		
	</div>
	
	
	
	

	
	
	
	
	
	
	
	
	
	<div id ="footer">
		<h3>Rutgers ECE568 Final Project Team 14<br>
		Team Members: Xinyu Li  Jiaqi Guo  Rui Zhu  Yue Gu  Xingyu Fan<br>
		Web Designer: Rui Zhu&Yue Gu  Email: rz140@cs.rutgers.edu<br>
		All rights reserved<h3>
	</div>
	
	<script src="js/index.js"></script>



	
</body>
</html>


	