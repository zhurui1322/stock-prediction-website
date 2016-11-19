<!--  stockinfo page               -->
<!--  written by:   Rui Zhu     -->
<!--  assisted by:	Yue Gu      -->
<!--  debugged by:  Xingyi Fan -->
<?php
			$data="var jsonData = [";
			$pricedata = "var priceData = [";
			$volumedata="var volumeData = [";
			$summarydata="var summaryData = [";
			
			$histdataDB=mysqli_connect("localhost","root","","histdata");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			
			$result = mysqli_query($histdataDB,"SELECT * FROM `{$_GET["select"]}` WHERE `ID`= (SELECT MAX(`ID`)FROM `{$_GET["select"]}`)");
			$row = mysqli_fetch_array($result);
			
			$maxrow = ($row['ID']);
			
			
			
			$num = 0;
			
			
			$result = mysqli_query($histdataDB, "SELECT  * FROM `{$_GET["select"]}` ORDER BY `ID` desc");
			
			$rs = mysqli_fetch_array($result);
			if($rs == true)
			{
				do
				{
					$re_date[$num]=($rs['date']);		
					$re_openhist[$num]=($rs['open']);	
					$re_high[$num]=($rs['high']);
					$re_low[$num]=($rs['low']);
					$re_close[$num]=($rs['close']);
					$re_volume[$num]=($rs['volume']);
						
						
					$date = (date('F j, Y',strtotime($rs['date'])));
					$arr = "{date:'{$date}',open:{$rs['open']},high:{$rs['high']},low:{$rs['low']},close:{$rs['close']},volume:{$rs['volume']}}";
					$data =  $data.$arr.",";

					$arr = "[{$num},{$rs['close']}],";
					$pricedata = $pricedata .$arr;
						
					$arr = "[{$num},{$rs['volume']}],";
					$volumedata = $volumedata .$arr;
						
					if(fmod($num,10)==0)
					{
						$arr = "[{$num},{$rs['close']}],";
						$summarydata = $summarydata .$arr;
					}
					$num ++;
				}while($rs=mysqli_fetch_array($result));
			}
			$data   = $data{strlen($data)-1} == ',' ? substr($data, 0, -1) : $data;
			$data = $data."];";
			file_put_contents('histchart\js\datatest.js', $data);
			
			$pricedata   = $pricedata{strlen($pricedata)-1} == ',' ? substr($pricedata, 0, -1) : $pricedata;
			$pricedata = $pricedata."];";
			file_put_contents('histchart\js\pricedatatest.js', $pricedata);
				
			$volumedata   = $volumedata{strlen($volumedata)-1} == ',' ? substr($volumedata, 0, -1) : $volumedata;
			$volumedata = $volumedata."];";
			file_put_contents('histchart\js\volumedatatest.js', $volumedata);
				
			$summarydata   = $summarydata{strlen($summarydata)-1} == ',' ? substr($summarydata, 0, -1) : $summarydata;
			$summarydata = $summarydata."];";
			file_put_contents('histchart\js\summarydatatest.js', $summarydata);
			
			
			$numoften = 0;
			
			$result = mysqli_query($histdataDB, "SELECT `high` FROM `{$_GET["select"]}` ORDER BY `ID` asc LIMIT 10");
			$rs = mysqli_fetch_array($result);
			if($rs == true)
			{
				do
				{
					$tendayshigh[$numoften]=($rs['high']);
					
					$numoften ++;
				}while($rs=mysqli_fetch_array($result));
			}
			$highestprice = max($tendayshigh);
			
			
			
			$SumYear = 0;
			$numOfYear = 0;
			
			$result = mysqli_query($histdataDB, "SELECT `close`, `low` FROM `{$_GET["select"]}` ORDER BY `ID` asc LIMIT 250");
			$rs = mysqli_fetch_array($result);
			if($rs == true)
			{
				do
				{
					$SumYear =$SumYear +($rs['close']);
					$YearLow[$numoften]=($rs['low']);
					$numoften ++;
				}while($rs=mysqli_fetch_array($result));
			}
			$AveYear = $SumYear/250;
			$LowestYearPrice = min($YearLow);
			
			
			
			
			
			
			mysqli_close($histdataDB);
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="viewport" content="width=device-width">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<title>Rutgers Stock Predict and Simulator</title>



	<link rel="stylesheet" href="css/menu.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="css/searchbox.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="css/table.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="css/stockinfo_style.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="css/slider.css"  type="text/css" />
	
	<script type='text/javascript' src='js/gallery/jquery-1.7.2.min.js'></script>
	<link href='http://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:regular,bold" type="text/css" />
	<script type='text/javascript' src='js/custom.js'></script>
	<link href="css/searchboxstyle.css" rel="stylesheet" type="text/css" />
	<!-- Load Fonts -->

	<link rel="stylesheet" type="text/css" href="histchart/css/hsd.css?" />
	<link rel="stylesheet" type="text/css" href="histchart/css/finance.css?" />
	
	
	
	<script src="histchart/js/hsd.js?"></script>
<script src="histchart/js/prototype.min.js?"></script>

<script src="histchart/js/Finance.js?"></script>
<script src="histchart/js/excanvas.js?"></script>
<script src="histchart/js/base64.js?"></script>
<script src="histchart/js/canvas2image.js?"></script>
<script src="histchart/js/canvastext.js?"></script>
<script src="histchart/js/flotr.js?"></script>
<script src="histchart/js/HumbleFinance.js?"></script>

<script src="histchart/js/demo.js?"></script>
<script src="histchart/js/datatest.js"></script>
<script src="histchart/js/pricedatatest.js"></script>
<script src="histchart/js/summarydatatest.js"></script>
<script src="histchart/js/volumedatatest.js"></script>
	
	

	
	
	





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

		<?php
		
		$realdataDB=mysqli_connect("localhost","root","","realdata");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			$result = mysqli_query($realdataDB,"SELECT `fullname` FROM `nasdaq_list` WHERE `symbol` = '{$_GET["select"]}'");
			$rs = mysqli_fetch_array($result);
			$fullname = ($rs['fullname']);
		
		
		
		mysqli_close($realdataDB);
		
		?>
		
		
	
	
	
	
	
	
	<div id = "contentbox">

		
		
		
		<div id = "contentboxrealtime">
		
		
		<div id="d9">
			<h1 class="h1">STOCK OF <?php echo $fullname."(".$_GET["select"].")"; ?></h1>
		</div>
		
		
		
		
		
		
			<div id = "contentboxrealtime_data">
			
			<h2 style= "text-align:center;">Real Time</h2>
			<?php 
			
			$realdataDB=mysqli_connect("localhost","root","","realdata");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			$result = mysqli_query($realdataDB,"SELECT * FROM `{$_GET["select"]}` WHERE `ID`= (SELECT MAX(`ID`)FROM `{$_GET["select"]}`)");
			$rs = mysqli_fetch_array($result);
			
			$re_Trade_Date=($rs['trade_date']);
			$re_Last_Trade_Time=($rs['last_trade_time']);
			$re_Ask=($rs['ask']);
			$re_Pervious_Close=($rs['pervious_close']);
			$re_open=($rs['open1']);
			$re_Change=($rs['change1']);
			$re_Day_Low=($rs['day_low']);
			$re_Day_High=($rs['day_high']);
			$re_Last_Trade=($rs['last_trade']);
			$re_YearHigh=($rs['year_high']);
			$re_YearLow=($rs['year_low']);
			$re_Market_Cap=($rs['market_cap']);
			$re_Volume=($rs['volume']);
			$re_Average_Daily_Volume=($rs['ave_volume']);
			  
			
			
			mysqli_close($realdataDB);
				
			
			?>
			<p>stock data at <?php echo $re_Trade_Date;?>  <?php echo $re_Last_Trade_Time;?></p>
			<table class="hovertable">
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Real time Price</td>
					<td><?php echo $re_Ask;?></td>
					<td>Day's Low</td>
					<td><?php echo $re_Day_Low;?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Open</td>
					<td><?php echo $re_open;?></td>
					<td>Day's High</td>
					<td><?php echo $re_Day_High;?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Pervious Close</td>
					<td><?php echo $re_Pervious_Close;?></td>
					<td>Volume</td>
					<td><?php echo $re_Volume;?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Change</td>
					<td><?php echo $re_Change;?></td>
					<td>Ave Daily Volume</td>
					<td><?php echo $re_Average_Daily_Volume;?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Last Trade </td>
					<td><?php echo $re_Last_Trade;?></td>
					<td>Year's Low</td>
					<td><?php echo $re_YearLow;?></td>
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Market Cap</td>
					<td><?php echo $re_Market_Cap;?></td>
					<td>Year's High</td>
					<td><?php echo $re_YearHigh;?></td>
				</tr>
			</table>
			

			
			<?php
			$histdataDB=mysqli_connect("localhost","root","","histdata");
			// Check connection
			if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
			$resultpred = mysqli_query($histdataDB,"SELECT * FROM `{$_GET["select"]}` WHERE `ID`= 1");
			$rsp = mysqli_fetch_array($resultpred);
				
				$pred_nd = ($rsp['pred_nd']);
				$pred_nm_low = ($rsp['pred_nm_low']);
				$pred_nm_low_conf = ($rsp['pred_nm_low_conf']);
				$pred_nm_high = ($rsp['pred_nm_high']);
				$pred_nm_high_conf = ($rsp['pred_nm_high_conf']);
				
				mysqli_close($histdataDB);
			?>

			<p>Data from Yahoo, about 15 mins delay</P>
			
			
			
			
			
			
			
		
			</div>
			
			<div id = "contentboxrealtime_graph">
				<img border="0" src="http://chart.finance.yahoo.com/z?s=<?php echo $_GET["select"];?>&t=1d&q=l&l=on&z=s">
		
			</div>
		
		
			<div id="d9">
				<h1 class="h1">Prediction Data & Graph Of <?php echo $fullname; ?></h1>
			</div>
			
			
			
			<div id = "contentboxrealtime_predict">

				<div id = "predictdatatable">
				<table align="center" class="hovertable"  >
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td colspan="2">price of next day</td>
						<td colspan="2"><?php echo $pred_nd;?></td>
					</tr>
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td>Lowest of next month</td>
						<td><?php echo $pred_nm_low;?></td>
						<td>confidence</td>
						<td><?php echo $pred_nm_low_conf;?></td>
					</tr>
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td>Highest of next month</td>
						<td><?php echo $pred_nm_high;?></td>
						<td>confidence</td>
						<td><?php echo $pred_nm_high_conf;?></td>
					</tr>
				</table>
				<br>
				</div>
				
				<img border="0" src="Pictures/<?php echo $_GET["select"];?>_Short.png"width="800">
				<div id = "describ">
				<p><br>Short term prediction result. The left figure is the comparison of real stock price and the pridiction, the Right figure is the error map of the prediction</p>
				</div>
				
				<img border="0" src="Pictures/<?php echo $_GET["select"];?>_Long_IG.png"width="800">
				<div id = "describ">
				<p><br>Long term prediction result. The left figure is the original stock price, The Right figure is the Information Granulation generated from original stock price, we use 30 day's price information to generate one Information Granulation</p>
				</div>
				
				<img border="0" src="Pictures/<?php echo $_GET["select"];?>_Long_High.png"width="800">
				
				<div id = "describ">
				<p><br>Long term prediction result. The left figure is the comparison of real stock daily highest price Information Granulation and the pridiction, the Right figure is the error map of the prediction</p>
				</div>
				
				<img border="0" src="Pictures/<?php echo $_GET["select"];?>_Long_Low.png"width="800">
				
				<div id = "describ">
				<p>Long term prediction result. The left figure is the comparison of real stock daily lowest price Information Granulation and the pridiction, the Right figure is the error map of the prediction</p>
				</div>
				
				
				<p>Data from Prediction system</P>
			
			</div>

		</div>
		
		<?php 
             $url = "http://finance.yahoo.com/rss/headline?s={$_GET["select"]}";
             $xml=file_get_contents($url);
             $f=simplexml_load_string($xml);
             $T0=$f->channel->item[2]->title;
			 $L0=$f->channel->item[2]->link;
			 $P0=$f->channel->item[2]->pubDate;
			 $D0=$f->channel->item[2]->description;			 
			 $T1=$f->channel->item[3]->title;
			 $L1=$f->channel->item[3]->link;
			 $P1=$f->channel->item[3]->pubDate;
			 $D1=$f->channel->item[3]->description;
			 $T2=$f->channel->item[4]->title;
			 $L2=$f->channel->item[4]->link;
			 $P2=$f->channel->item[4]->pubDate;
			 $D2=$f->channel->item[4]->description;
			 $T3=$f->channel->item[5]->title;
			 $L3=$f->channel->item[5]->link;
			 $P3=$f->channel->item[5]->pubDate;
			 $D3=$f->channel->item[5]->description;
			 $T4=$f->channel->item[6]->title;
			 $L4=$f->channel->item[6]->link;
			 $P4=$f->channel->item[6]->pubDate;
			 $D4=$f->channel->item[6]->description;

			 		 
			 
			 if($D0!="")
			 $DES0 = preg_split("/[-]+/", $D0);
			 else
			 {
			    $DES0[0] = ""; 
			 	$DES0[1] = "";
				}
			 
			 if($D1!="")
			 $DES1 = preg_split("/[-]+/", $D1);	
			 else
			 {
			    $DES1[0] = ""; 
			 	$DES1[1] = "";
				}
			 
			 if($D2!="")	 	
			 $DES2 = preg_split("/[-]+/", $D2);
			 else
			 {
			    $DES2[0] = ""; 
			 	$DES2[1] = "";
				}
			 
			 if($D3!="")	
			 $DES3 = preg_split("/[-]+/", $D3);
			 else	
			 {
			    $DES3[0] = ""; 
			 	$DES3[1] = "";
				}
			 
			 if($D4!="")
			 $DES4 = preg_split("/[-]+/", $D4);	
			 else
			 {
			    $DES4[0] = ""; 
			 	$DES4[1] = "";
				}
			 
		
       ?>  
	   
	   

	
	
		<div id="d9">
			<h1 class="h1">Latest Market News Headlines</h1>
		</div>	
		<div id="d1">
		
		    
		 	<h1 class="h3"><a href="<?php echo $L0 ?>" target="_blank"><b><?php echo $T0 ?></b></a></h1>
		    <p class="h4"><?php echo $DES0[1] ?></p>
			<p class="h2"><?php echo $DES0[0]?>&nbsp&nbsp&nbsp<?php echo $P0?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
            <h1 class="h3"><a href="<?php echo $L1 ?>" target="_blank"><b><?php echo $T1 ?></b></a></h1>
		    <p class="h4"><?php echo $DES1[1] ?></p>
			<p class="h2"><?php echo $DES1[0]?>&nbsp&nbsp&nbsp<?php echo $P1?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
			<h1 class="h3"><a href="<?php echo $L2 ?>" target="_blank"><b><?php echo $T2 ?></b></a></h1>
		    <p class="h4"><?php echo $DES2[1]; ?></p>
			<p class="h2"><?php echo $DES2[0]?>&nbsp&nbsp&nbsp<?php echo $P2?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
			<h1 class="h3"><a href="<?php echo $L3 ?>" target="_blank"><b><?php echo $T3 ?></b></a></h1>
		    <p class="h4"><?php echo $DES3[1] ?></p>
			<p class="h2"><?php echo $DES3[0]?>&nbsp&nbsp&nbsp<?php echo $P3?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
			<h1 class="h3"><a href="<?php echo $L4 ?>" target="_blank"><b><?php echo $T4 ?></b></a></h1>
		    <p class="h4"><?php echo $DES4[1] ?></p>
			<p class="h2"><?php echo $DES4[0]?>&nbsp&nbsp&nbsp<?php echo $P4?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />

		</div>
		
		
	
	
		<div id = "contentboxhist">
			<div id="d9">
			<h1 class="h1">Historical Data of  <?php echo $fullname."(".$_GET["select"].")"; ?></h1>
		</div>
				
			<!-- Hist Chart -->
			<div id="content-container">
				<div id="content">
					<div id="finance">
						<div id="labels">
							<div id="financeTitle">
									Historical Data Chart</div>
							<div id="time">
								<a onclick="HumbleFinance.zoom(5);">1w</a>
								<a onclick="HumbleFinance.zoom(21);">1m</a>
								<a onclick="HumbleFinance.zoom(65);">3m</a>
								<a onclick="HumbleFinance.zoom(127);">6m</a>
								<a onclick="HumbleFinance.zoom(254);">1y</a>
								<a onclick="HumbleFinance.zoom(1265);">5y</a> </div>
							<div id="dateRange">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			
			
			 
			 
			 
			<div id = "contentboxhistlist">
				<table class="hovertable">
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td  align="center">Data</td>
						<td  align="center">Open</td>
						<td  align="center">High</td>
						<td  align="center">Low</td>
						<td  align="center">Close</td>
						<td  align="center">Volume</td>
					</tr>
					<?php
					for($i = $maxrow-1; $i>=0; $i--)
					{
					?>
					<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
						<td align="center"><?php echo $re_date[$i];?></td>
						<td align="center"><?php echo $re_openhist[$i];?> </td>
						<td align="center"><?php echo $re_high[$i];?> </td>
						<td align="center"><?php echo $re_low[$i];?> </td>
						<td align="center"><?php echo $re_close[$i];?> </td>
						<td align="center"><?php echo $re_volume[$i];?> </td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>	
			
			
				<p style= "text-align:center;">Highest Stock price of <?php echo $_GET["select"]; ?> in last ten Days is <?php echo $highestprice; ?></p>
	
				
				
				<p style= "text-align:center;">Average Stock price of <?php echo $_GET["select"]; ?> in latest one year is <?php echo round($AveYear,2); ?></P>
				
				<p style= "text-align:center;">Lowest Stock price of <?php echo $_GET["select"]; ?> in latest one year is <?php echo $LowestYearPrice; ?> </P>
				
				
				
			
		</div>
	</div>

	
	
	
	<div id ="footer">
		<h3>Rutgers ECE568 Final Project Team 14<br>
		Team Members: Xinyu Li  Jiaqi Guo  Rui Zhu  Yue Gu  Xingyu Fan<br>
		Web Designer: Rui Zhu&Yue Gu  Email: rz140@cs.rutgers,edu<br>
		All rights reserved<h3>
	</div>
	


	



	
	
	<script src="js/index.js"></script>



	
</body>
</html>