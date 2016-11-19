<?php
	include "mysql_connect_user.php";
	$username = $_GET["username"];
	$password = $_GET["password"];
	
	$sql="SELECT * FROM `user_list` WHERE `email`= '{$username}' OR `username` = '{$username}'";
		$query = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
		$rs_email=mysql_fetch_array($query);
		if($rs_email == true)
		{
			if($password == $rs_email['password'])
			{
			
				$output = array('Islog' => "true");
				print(json_encode($output));
				
			}
			else
			{
				$output = array('Islog' => "wrong");
				print(json_encode($output));
			}
		}
		else
		{
			$output = array('Islog' => "wrong");
			print(json_encode($output));
		}
  mysql_close();
?>
