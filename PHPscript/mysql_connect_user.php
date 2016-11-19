<!--  written by:   Yue Gu     -->
<!--  assisted by:	Rui Zhu    -->



<?php
$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "user";
@mysql_connect("$db_host","$db_username","$db_pass")or die("could not connect to MySQL");
@mysql_select_db("$db_name")or die("No database");
?>