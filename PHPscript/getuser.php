<!--  written by:   Yue Gu     -->
<!--  assisted by:	Rui Zhu    -->



<?php

include "mysql_connect_realdata.php";
$q = $_GET['q'];
$sql="SELECT * FROM `{$q}` WHERE `ID`= (SELECT MAX(`ID`)FROM `{$q}`)";
	$query = mysql_query($sql) or die("Stcok not found");
	$row=mysql_fetch_array($query);
	if($row == true)
	{


		echo "<div style = 'margin-top: 0px'>";
		echo 	"<a href = 'http://localhost/stockinfo.php?select=$q'>View the Stock detail<br><br></a>";
		echo "</div>";



		echo "<div style = 'float:left; margin-left :30px'>";

		echo "<table class='hovertable'>";
		echo 	"<tr onmouseover='this.style.backgroundColor='#ffff66';' onmouseout= '	   this.style.backgroundColor='#d4e3e5';'>";
		echo		"<td>Real time Price</td>";
		echo		"<td>" . $row['ask'] . "</td>";
		echo		"<td>Day's Low</td>";
		echo		"<td>" . $row['day_low'] . "</td>";
		echo	"</tr>";
		echo	"<tr onmouseover='this.style.backgroundColor='#ffff66';' onmouseout='this.style.backgroundColor='#d4e3e5';'>";
		echo		"<td>Open</td>";
		echo		"<td>" . $row['open1'] . "</td>";
		echo		"<td>Day's High</td>";
		echo        "<td>" . $row['day_high'] . "</td>";
		echo	"</tr>";
		echo	"<tr onmouseover='this.style.backgroundColor='#ffff66';' onmouseout='this.style.backgroundColor='#d4e3e5';'>";
		echo		"<td>Pervious Close</td>";
		echo 		"<td>" . $row['pervious_close'] . "</td>";
		echo		"<td>Volume</td>";
		echo		"<td>" . $row['volume'] . "</td>";
		echo	"</tr>";
		echo	"<tr onmouseover='this.style.backgroundColor='#ffff66';' onmouseout='this.style.backgroundColor='#d4e3e5';'>";
		echo		"<td>Change</td>";
		echo 		"<td>" . $row['change1'] . "</td>";
		echo		"<td>Ave Daily Volume</td>";
		echo		"<td>" . $row['ave_volume'] . "</td>";
		echo	"</tr>";
		echo	"<tr onmouseover='this.style.backgroundColor='#ffff66';' onmouseout='this.style.backgroundColor='#d4e3e5';'>";
		echo		"<td>Last Trade </td>";
		echo		"<td>" . $row['last_trade'] . "</td>";
		echo		"<td>Year's Low</td>";
		echo		"<td>" . $row['year_low'] . "</td>";
		echo 	"</tr>";
		echo	"<tr onmouseover='this.style.backgroundColor='#ffff66';' onmouseout='this.style.backgroundColor='#d4e3e5';'>";
		echo			"	<td>Market Cap</td>";
		echo			"<td>" . $row['market_cap'] . "</td>";
		echo			"<td>Year's High</td>";
		echo			"<td>" . $row['year_high'] . "</td>";
		echo 	"</tr>";
		echo "</table>";
		echo "</div>";
		echo "<div style = 'float:right;margin-right :30px'>";
		echo 	"<img border='0' src='http://chart.finance.yahoo.com/z?s=$q&t=1d&q=l&l=on&z=s'>";
		echo "</div>";
		
	}
mysql_close();
?>
