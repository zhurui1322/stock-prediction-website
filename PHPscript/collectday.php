<!--  written by:   Yue Gu     -->
<!--  assisted by:	Rui Zhu    -->





<!DOCTYPE html>
<html>
<body>
<?php
ignore_user_abort(1);
include_once "mysql_connect_realdata.php";
$endtime = "04:00:00";
$interval = 55;
$today = date("Y-m-d");

$i = 0;

//----------------get the stock list----------------------
$sql="SELECT * FROM `nasdaq_list` WHERE 1";
$queryget = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
$rs=mysql_fetch_array($queryget);
if($rs == true)
{
	do
	{
		$re_symbol[$i] = $rs['symbol'];
		$i++;
	}while($rs=mysql_fetch_array($queryget));
}
	
	$num_stock = $i;
	$num_each_loop = 101;
	//echo $num_stock."<br>";
	$last_num_loop = fmod($num_stock,$num_each_loop);
	//echo $last_num_loop."<br>";
	$loop_num = (ceil($num_stock/$num_each_loop));
	//echo $loop_num."<br>";
	
do
{
	
	$j = 0;
	for($k=1;$k<=$loop_num ;$k++)
	{
		//----------------combine the stock symbol ----------------------
		$symbol_list[$k] = "";
		
		
		if($k==$loop_num )
		{
			for($i=(($k-1)*$num_each_loop); $i<$num_stock; $i++)
			{
				$symbol_list[$k] = $symbol_list[$k].$re_symbol[$i]."+";
			}
		}
		else
		{
			for($i=(($k-1)*$num_each_loop); $i<$num_each_loop*$k; $i++)
			{
				$symbol_list[$k] = $symbol_list[$k].$re_symbol[$i]."+";
			}
			
			
		}
		$symbol_list[$k]= $symbol_list[$k] {strlen($symbol_list[$k] )-1} == '+' ? substr($symbol_list[$k] , 0, -1) : $symbol_list[$k] ;
		echo $symbol_list[$k]."<br>";
		
		//---------------- Call the API---------------------
		
		if (($handle = fopen("http://finance.yahoo.com/d/quotes.csv?s={$symbol_list[$k]}&f=d1t1apoc1ghl1w1kjj1va2", "r")) !== FALSE) 
		{		
			
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) 
			{
				$c = count($data);
				for ($i=0;$i<$c;$i++)
				{
					if($i == 0)
						$data[$i] = (date('Y-m-d',strtotime($data[$i])));
					if($i==1)
						$data[$i] = (date('h:i:s',strtotime($data[$i])));
					$csvarray[$j][$i] = $data[$i];
					//echo $csvarray[$j][$i];
				}
				//echo "<br />\n";
				
				//echo $csvarray[$j][1];
				//echo $endtime;
				
				
				
				$sqlcheck="SELECT `ID`, `trade_date`, `last_trade_time` FROM `{$re_symbol[$j]}` WHERE `ID`= (SELECT MAX(`ID`)FROM `{$re_symbol[$j]}`)";
				$querycheck = mysql_query($sqlcheck) or die($sqlcheck."<br/><br/>".mysql_error());
				$rscheck=mysql_fetch_array($querycheck);
				$IsInsert = 1;
				if($rscheck == true)
				{		
					$re_Trade_Date=($rscheck['trade_date']);
					$re_Last_Trade_Time=($rscheck['last_trade_time']);
				
					if($re_Trade_Date == $csvarray[$j][0] && $re_Last_Trade_Time == $csvarray[$j][1])
						$IsInsert = 0;
					else
						$IsInsert = 1;
				}	
				echo $IsInsert;
				
		 

			
				if($IsInsert == 1)
				{ 
	
					mysql_query("INSERT INTO `{$re_symbol[$j]}`
					(`trade_date`,`last_trade_time`,`ask`,`pervious_close`,`open1`, `change1`,      `day_low`,   `day_high`,`last_trade`,`year_high`,`year_low`,`market_cap`,`volume`,`ave_volume`) VALUES 						
					('{$csvarray[$j][0]}','{$csvarray[$j][1]}','{$csvarray[$j][2]}','{$csvarray[$j][3]}',  '{$csvarray[$j][4]}','{$csvarray[$j][5]}','{$csvarray[$j][6]}','{$csvarray[$j][7]}', '{$csvarray[$j][8]}','{$csvarray[$j][10]}','{$csvarray[$j][11]}','{$csvarray[$j][12]}','{$csvarray[$j][13]}','{$csvarray[$j][14]}')");
				}	
				$j++;
			}				
			fclose($handle);
			
		}
	}
		//if(strcmp($csvarray[1][1],$endtime)==0)
		//			echo exit("Time is same and exit");
	sleep(60);
}while(1);
mysql_close();

?>
