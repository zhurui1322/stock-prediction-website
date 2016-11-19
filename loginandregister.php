<!--  written by:   Rui Zhu    -->
<!--  assisted by:	Yue Gu    -->
<!--  debugged by:  Xingyi Fan -->





<?php
session_start();
?>












<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Login and Registration Form with HTML5 and CSS3</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/login.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
    </head>
    <body>
		
		
		<div style="margin-top:100px";>
		
		</div>
	
	
	
        <div class="container">
            <!-- Codrops top bar -->
            
            
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="loginandregister.php#tologin" method = 'Post' autocomplete="on" v> 
                                <h1>Log in</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your email or username </label>
                                    <input id="username" name="username" required="required" type="text" "/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" required="required" type="password"  /> 
                                </p>
                                <p class="keeplogin"> 
									<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
									<label for="loginkeeping">Keep me logged in</label>
								</p>
                                <p class="login button"> 
                                    <input type="submit" name = "submit_login"value="Login" /> 
								</p>
                                <p class="change_link">
									Not a member yet ?
									<a href="#toregister" class="to_register">Join us</a>
								</p>
                            </form>
                        </div>

                        <div id="register" class="animate form">
                            <form  action="loginandregister.php#toregister" method = 'Post' autocomplete="on"> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text"  />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" /> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" />
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" />
                                </p>
                                <p class="signin button"> 
									<input type="submit" name = "submit_register" value="Sign up"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Go and log in </a>
								</p>
                            </form>
                        </div>
						
                    </div>
                </div>  
            </section>
			
			
			
			
			
			
			
        </div>
    </body>
</html>

<?php
include "PHPscript/mysql_connect_user.php";
	if(isset($_POST['submit_login']))
	{
					
		$username = $_POST["username"];
		$password = $_POST["password"];


		echo $username."<br>"; 
		echo $password;

		
		$sql="SELECT * FROM `user_list` WHERE `email`= '{$username}' OR `username` = '{$username}'";
		$query = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
		$rs_email=mysql_fetch_array($query);
		if($rs_email == true)
		{
		
			if($password == $rs_email['password'])
			{
				$_SESSION['email'] = $rs_email['email'];
				$_SESSION['username'] = $rs_email['username'];
				echo "<script>window.open('simulator.php','_self')</script>";
			}
			else
			{
				echo "<script>alert('Password is Wrong! Try again')</script>";
				exit();
			}
		}
		else
		{
			echo "<script>alert('user name or email is not exist Try again')</script>";
			exit();
		}
					


		
	}
	if(isset($_POST['submit_register']))
	{
		$usernamesignup = $_POST["usernamesignup"];
		$emailsignup = $_POST["emailsignup"];
		$passwordsignup = $_POST["passwordsignup"];
		$passwordsignup_confirm = $_POST["passwordsignup_confirm"];

		echo $usernamesignup."<br>"; 
		echo $emailsignup."<br>"; 
		echo $passwordsignup."<br>"; 
		
		if ($passwordsignup != $passwordsignup_confirm)
		{
			echo "<script>alert('Password Comfirm Wrong')</script>";
			exit();
		}
		
		$sql="SELECT * FROM `user_list` WHERE `email`= '{$emailsignup}'";
		$query = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
		$rs_email=mysql_fetch_array($query);
		if($rs_email == true)
		{
			echo "<script>alert('The Email has already been registered Try another one')</script>";
			exit();
		}
			
		$sql="SELECT * FROM `user_list` WHERE `username` = '{$usernamesignup}'";
		$query = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
		$rs_username=mysql_fetch_array($query);
		if($rs_username == true)
		{
			echo "<script>alert('This Username has been registered Try another one')</script>";
			exit();
		}
		
		
		
		$query = "INSERT INTO `user_list`(`email`,`username`,`password`)VALUES('{$emailsignup}', '{$usernamesignup}', '{$passwordsignup}')";
		if(mysql_query($query))
		{
			$_SESSION['email'] = $emailsignup;
			$_SESSION['username'] = $usernamesignup;
			
			
			$sql="CREATE TABLE IF NOT EXISTS {$usernamesignup} (
			ID int NOT NULL primary key AUTO_INCREMENT,
			date_time datetime,
			symbol varchar(5),
			price decimal(6,2),
			shares decimal(5.0),
			sell_buy INT(1),
			money decimal(15,2)
			
			)";

			$query = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
			

			
			echo "<script>window.open('simulator.php','_self')</script>";
		}
				
	}			
				
?>