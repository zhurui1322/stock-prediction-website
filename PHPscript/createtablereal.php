
<!--  written by:   Yue Gu     -->
<!--  assisted by:	Rui Zhu    -->

<?php
set_time_limit(0);
include "mysql_connect_realdata.php";
$i = 0;
	$sql="SELECT * FROM `nasdaq_list` WHERE 1";
	$queryget = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
	$rs=mysql_fetch_array($queryget);
	if($rs == true)
	{
		do{		

			$sql="CREATE TABLE IF NOT EXISTS {$rs['symbol']} ( 
			ID int NOT NULL primary key AUTO_INCREMENT, 
			trade_date date, 
			last_trade_time time, 
			ask decimal(6,2), 
			pervious_close decimal(6,2), 
			open1 decimal(6,2),
			change1 decimal(6,4), 
			day_low decimal(6,2), 
			day_high decimal(6,2), 
			last_trade decimal(6,2), 
			year_high decimal(6,2), 
			year_low decimal(6,2), 
			market_cap varchar(7), 
			volume int(15), 
			ave_volume int(15))";

			$query = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());

		}while($rs=mysql_fetch_array($queryget));
	}	

		mysql_close();
?>