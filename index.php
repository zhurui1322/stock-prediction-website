<!--  Index page               -->
<!--  written by:   Rui Zhu     -->
<!--  assisted by:	Yue Gu      -->
<!--  debugged by:  Xingyi Fan -->



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<title>Rutgers Stock Predict and Simulator</title>
<!--General Page CSS-->
<link rel="stylesheet" href="css/index_style.css" media="screen" type="text/css" />
<!--Element CSS-->
<link rel="stylesheet" href="css/menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="css/table.css" media="screen" type="text/css" />

<!--gallery Javascript and CSS-->
<link rel="stylesheet" href="css/slider.css"  type="text/css" />
<script type='text/javascript' src='js/gallery/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='js/gallery/common.js'></script>
<script type='text/javascript' src='js/gallery/slider.js'></script>


<!--Fonts Link-->
<link href='http://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:regular,bold" type="text/css" />
	
<!-- Search Box Javascript and CSS -->
<script type='text/javascript' src='js/custom.js'></script>
<link href="css/searchboxstyle.css" rel="stylesheet" type="text/css" />
	

	
	






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
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<header>
	<div class="header-content home">
		<div class="parallax-bg" id="slider-wrap">
			<div class="slider parallax-bg" id="slider"> 
				<div class="slider-sections sandbox"> 
					<section class="first"> 
						<img alt="Kendo UI" src="images/dataviz-home-image-q2.png"/> 
							<div class="text"> 
								<h2>Accurate Stock prediction</h2> 
								<h2>We show the real price and our prediction of your stock! With a less than 5% error of our prediction, you will get your gains all the way!</h2> 
								<p class="button">
								<a href="longterm.html" >Long term </a>
								<a href="shortterm.html" >Short term</a>
								
								</p> 
							</div> 
					</section>
		
					<section> 
						<img src="images/phoneimage.png" alt="Kendo UI" /> 
							<div class="text" style="padding-top: 10px;"> 
								<h2>Android App</h2> 
									<h2>Simulator is coming! Real time price display. Historical price and volume display! Professional prediction information with Confidence!</h2>
									<p class="button">
									<a href="android.html" >Learn More </a>
								
									</p> 
							</div> 
					</section>
					
					<section> 
						<img src="images/home_banner_web-q2.png" alt="Kendo UI" /> 
							<div class="text"> 
								<h2>Stock Simulator</h2> 
								<h2>The Rutgers Stock Simulator is the ideal platform to get your financial feet wet! Submit trades in a safe simulated environment, Let's start.</h2>
								<p class="button">
								<a href="loginandregister.php" >Start</a>
							
							</p> 
							</div> 
					</section>
				</div>
			</div> <a class="slider-prev" href="javascript: void(0)">?</a> <a class="slider-next" href="javascript: void(0)">?</a>
		</div>
	</div>
</header>

	<div id = "contentbox">

	<div id="d0">
			<h1 class="h0">Top Gainers and Losers</h1>
		</div>	
	
	<?php 
	
	$i = 0;
	$histdataDB=mysqli_connect("localhost","root","","histdata");
			// Check connection
	if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
	$result = mysqli_query($histdataDB,"SELECT * FROM `nasdaq_list` WHERE 1");
	$row = mysqli_fetch_array($result);
	if($row == true)
	{
		do
		{
			$re_symbol[$i] = $row['symbol'];
			$i++;
		}while($row=mysqli_fetch_array($result));
	}
	
	$totalstocknum = 101;
	

	for($i = 0; $i<$totalstocknum; $i++)
	{
		$result = mysqli_query($histdataDB,"SELECT * FROM `{$re_symbol[$i]}` WHERE `ID` = 1 ");
		
		$rs=mysqli_fetch_array($result);
		if($rs == true)
		{
		
			$maxrow = ($rs['ID']);	
			$lastprice = ($rs['close']);	
			$data[$i][0] = ($rs['close']);
			$data[$i][1] = ($rs['volume']);
			$data[$i][3] = ($rs['date']);
		}
		$nextrow = $maxrow + 1;
		
		
		$result2 = mysqli_query($histdataDB,"SELECT * FROM `{$re_symbol[$i]}` WHERE `ID` = 2");
		$rs2=mysqli_fetch_array($result2);
		if($rs == true)
			$secondprice = ($rs2['close']);	
		$change[$i] = round($lastprice-$secondprice,2);
		
		$changepercentage[$i] = round($change[$i]/$secondprice,4)*100;	
	}
	$k = 0;
	asort($change);
	foreach($change as $x=>$x_value)
    {
		$key[$k] = $x;
		$change[$k] = $x_value;
		$k++;
	}
	?>
	<div id ="indexstocktable">
		<div id="gainerstocktable">
			<p1>Top 10 Gainer Stocks</p1>
			<table class="hovertable">
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Stock</td>
					<td>Prev Close</td>
					<td>Change</td>
					<td>Change%</td>
					<td>Volume</td>
				</tr>
				
				
				<?php 
				$num_stockdisp = 10;
				
				for ($i = 1; $i <=$num_stockdisp; $i++)
				{
				?>
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td><?php echo $re_symbol[$key[$totalstocknum-$i]];?></td>
					<td><?php echo $data[$key[$totalstocknum-$i]][0];?></td>
					<td><?php echo $change[$totalstocknum-$i];?></td>
					<td><?php echo $changepercentage[$key[$totalstocknum-$i]]."%";?></td>
					<td><?php echo $data[$key[$totalstocknum-$i]][1];?></td>
				</tr>
				<?php 
				}
				?>
			</table>
			<p>Data from Yahoo API <?php echo $data[$i][3];?></p>
		</div>


		<div id="loserstocktable">
			<p1>Top 10 Loser Stocks</P1>
			<table class="hovertable">
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td>Stock</td>
					<td>Prev Close</td>
					<td>Change</td>
					<td>Change%</td>
					<td>Volume</td>
				</tr>
				
				
				<?php 
				for ($i = 0; $i <$num_stockdisp; $i++)
				{
				?>
				<tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
					<td><?php echo $re_symbol[$key[$i]]?></td>
					<td><?php echo $data[$key[$i]][0];?></td>
					<td><?php echo $change[$i];?></td>
					<td><?php echo $changepercentage[$key[$i]]."%";?></td>
					<td><?php echo $data[$key[$i]][1];?></td>
				</tr>
				<?php 
				}
				?>
			</table>
			<p>Data from Yahoo API <?php echo $data[$i][3];?></p>
		</div>
	</div>
	
	
	
	<?php 
             $url = "http://finance.yahoo.com/rss/headline?s=^ixic";
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
	   
	   

	
	
		<div id="d0">
			<h1 class="h0">Latest Market News Headlines</h1>
		</div>	
		<div id="d1">
		
		    
		 	<h1 class="h3"><a href="<?php echo $L0 ?>" target="_blank"><b><?php echo $T0 ?></b></a></h1>
		    <p class="h1"><?php echo $DES0[1] ?></p>
			<p class="h2"><?php echo $DES0[0]?>&nbsp&nbsp&nbsp<?php echo $P0?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
            <h1 class="h3"><a href="<?php echo $L1 ?>" target="_blank"><b><?php echo $T1 ?></b></a></h1>
		    <p class="h1"><?php echo $DES1[1] ?></p>
			<p class="h2"><?php echo $DES1[0]?>&nbsp&nbsp&nbsp<?php echo $P1?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
			<h1 class="h3"><a href="<?php echo $L2 ?>" target="_blank"><b><?php echo $T2 ?></b></a></h1>
		    <p class="h1"><?php echo $DES2[1]; ?></p>
			<p class="h2"><?php echo $DES2[0]?>&nbsp&nbsp&nbsp<?php echo $P2?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
			<h1 class="h3"><a href="<?php echo $L3 ?>" target="_blank"><b><?php echo $T3 ?></b></a></h1>
		    <p class="h1"><?php echo $DES3[1] ?></p>
			<p class="h2"><?php echo $DES3[0]?>&nbsp&nbsp&nbsp<?php echo $P3?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />
			
			<h1 class="h3"><a href="<?php echo $L4 ?>" target="_blank"><b><?php echo $T4 ?></b></a></h1>
		    <p class="h1"><?php echo $DES4[1] ?></p>
			<p class="h2"><?php echo $DES4[0]?>&nbsp&nbsp&nbsp<?php echo $P4?> </p> 
			<p>&nbsp </p>
			<hr color="#CCCCCC" align=center width="100%" />

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