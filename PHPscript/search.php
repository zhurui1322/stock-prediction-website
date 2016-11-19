<!--  written by:   Yue Gu     -->
<!--  assisted by:	Rui Zhu    -->



<?php
/************************************************
	The Search PHP File
************************************************/


/************************************************
	MySQL Connect
************************************************/

// Credentials
$dbhost = "localhost";
$dbname = "realdata";
$dbuser = "root";
$dbpass = "";

//	Connection
global $tutorial_db;

$tutorial_db = new mysqli();
$tutorial_db->connect($dbhost, $dbuser, $dbpass, $dbname);
$tutorial_db->set_charset("utf8");

//	Check Connection
if ($tutorial_db->connect_errno) {
    printf("Connect failed: %s\n", $tutorial_db->connect_error);
    exit();
}

/************************************************
	Search Functionality
************************************************/

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a target="_blank" href="urlString">';
$html .= '<h3>nameString</h3>';
$html .= '<h4>functionString</h4>';
$html .= '</a>';
$html .= '</li>';

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $tutorial_db->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT * FROM nasdaq_list WHERE symbol LIKE "%'.$search_string.'%" OR fullname LIKE "%'.$search_string.'%"';

	// Do Search
	$result = $tutorial_db->query($query);
	while($results = $result->fetch_array()) {
		$result_array[] = $results;
	}

	// Check If We Have Results
	if (isset($result_array)) {
		foreach ($result_array as $result) {

			// Format Output Strings And Hightlight Matches
			$display_function = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['symbol']);
			$display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['fullname']);
			$display_url = 'http://localhost/stockinfo.php?select='.urlencode($result['symbol']);

			// Insert Name
			$output = str_replace('nameString', $display_name, $html);

			// Insert Function
			$output = str_replace('functionString', $display_function, $output);

			// Insert URL
			$output = str_replace('urlString', $display_url, $output);

			// Output
			echo($output);
		}
	}else{

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('nameString', '<b>No Results Found.</b>', $output);
		$output = str_replace('functionString', 'Sorry :(', $output);

		// Output
		echo($output);
	}
}
?>