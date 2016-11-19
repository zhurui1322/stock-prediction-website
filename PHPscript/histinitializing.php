<!--  written by:   Yue Gu     -->
<!--  assisted by:	Rui Zhu    -->



<?php
set_time_limit(0);
include "mysql_connect_histdata.php";
$i = 0;
	$sql="SELECT * FROM `nasdaq_list` WHERE 1";
	$queryget = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
	$rs=mysql_fetch_array($queryget);
	if($rs == true)
	{
		do{		
			$sql="CREATE TABLE IF NOT EXISTS {$rs['symbol']} (
			ID int NOT NULL primary key AUTO_INCREMENT,
			date date,
			open decimal(6,2),
			high decimal(6,2),
			low decimal(6,2),
			close decimal(6,2),
			volume decimal(12.0),
			adj_close decimal(6,2),
			pred_nd decimal(6,2),
			pred_nm_low decimal(6,2),
			pred_nm_low_conf decimal(6,2),
			pred_nm_high decimal(6,2),
			pred_nm_high_conf decimal(6,2)
			)";
			$query = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
	

	
			if (($handle = fopen("http://table.finance.yahoo.com/table.csv?s={$rs['symbol']}&d=4&e=21&f=2014&g=d&a=1&b=1&c=2010&ignore=.csv", "r")) !== FALSE) 
			{		
				$data = fgetcsv($handle, 0, ",");
				while (($data = fgetcsv($handle, 0, ",")) !== FALSE) 
				{

					mysql_query("INSERT INTO `{$rs['symbol']}`(`date`,  `open`,  `high`,   `low`,   `close`, `volume`, `adj_close`)VALUES ('{$data[0]}',  '{$data[1]}', '{$data[2]}', '{$data[3]}',  '{$data[4]}','{$data[5]}','{$data[6]}')");
					//echo "<br />\n";
				}
			}fclose($handle);
			//sleep(10);
		}while($rs=mysql_fetch_array($queryget));
	}	
mysql_close();
?>