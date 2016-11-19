<!--  written by:   Yue Gu     -->
<!--  assisted by:	Rui Zhu    -->



<?php

include_once "mysql_connect_realdata.php";
$i = 0;
//----------------get the stock list----------------------
$sql="SELECT * FROM `nasdaq_list` WHERE 1";
$queryget = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
$rs=mysql_fetch_array($queryget);
if($rs == true)
{
	do
	{
		$a[$i] = $rs['symbol'];
		$i++;
	}while($rs=mysql_fetch_array($queryget));
}
// Fill up array with names


// get the q parameter from URL
$q=$_REQUEST["q"]; $hint="";

// lookup all hints from array if $q is different from "" 
if ($q !== "")
  { $q=strtolower($q); $len=strlen($q);
    foreach($a as $name)
    { if (stristr($q, substr($name,0,$len)))
      { if ($hint==="")
        { $hint=$name; }
        else
        { $hint .= ", $name"; }
      }
    }
  }

// Output "no suggestion" if no hint were found
// or output the correct values 
echo $hint==="" ? "no suggestion" : $hint;
?>