<?php
	include "mysql_connect_user.php";
	$username = $_GET["username"];
	$password = $_GET["password"];
	

			
	$sql=mysql_query("select * from `{$_GET["username"]}`");
	$rs=mysql_fetch_assoc($sql);
	if($rs == true)
	{
					
		do
		{		
			$output[]=$rs;
		}while($rs =mysql_fetch_assoc($sql));
	}
	else
		$output = array('Isempty' => "true");

	print(json_encode($output));
			 				
				
	mysql_close();
?>
