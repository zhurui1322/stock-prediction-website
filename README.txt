

1.Go to http://www.apachefriends.org/index.html to download the XAMPP 
2.Install XAMPP in default setting
3.After the installation, open the XAMPP control Panel, Start the "Apache" and "MySQL"
	the default port for "MySQL" is 3306, if your 3306 port is used, for example, your machine already has a MYSQL database
	you need to free the 3306 port, or you can change the port of MySQL of XAMPP to other free port
4.When the two Service is connect correctly, click the "Admin" button or open "http://localhost/phpMyAdmin" in your browser
	you do need to set the username and password. otherwise you need to change the code in "mysql_connect.php" to set the username and password
5.in the PhpMyAdmin, create a new database name as "ece568" and click import button on the top
		select "cec568.sql" file to import tables and data in to the database.
6.go to C:/xmapp/hotdocs, put all the file in "hotdocs" folder 	
				"collectday.php"     "collectreal.php"
				"mysql_connect.php"  "index.php"
				"histdata.php"       "realtimedata.php"
				"CRON_day.bat"        "CRON_hist.bat"

7.Open C:/xmapp/php/php.ini as a text file, find the line "date.timezone = Europe/Berlin" change to your location's time zone. 
	For example: "date.timezone = America/New_York"

8.If your system is windows, you need to create two scheduled tasks. Go to windows control panel, find the "Scheduled Task". In the right column, 
	select "Create Basic Task" give a name. Next, Trigger select "Daily". Next, Select Start time. For historical collection, choice 5:00 PM, 
	for real-time collection,choice 9:00AM. And recur every "1" day. Next, Action select "Start a program". Next, choice the Program/script, 
	for historical collection, find the CRON_hist.bat, for the real-time collection, choice the CRON_real.bat. 
	Finally, check if all the setting is correct, and FINISH. 
9.Now the system installed in your computer. Go to http://localhost/index.php to browse our website. 