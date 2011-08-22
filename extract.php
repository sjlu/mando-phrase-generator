<?php
	function DatabaseConnect() {
		$dbhost = 'p50mysql3.secureserver.net';
		$dbuser = 'mandodb';
		$dbpass = 'TkkLc2Uv4';
		$dbname = 'mandodb';

		$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die("Cannot connect to MySQL database. Check your configuration and that the server is running.");
		mysql_select_db($dbname) or die("Can't use the MySQL database. Check your configuration and that the user you have specified has sufficient priveleges to use this database.");
		return $conn;
	}
	
	function DatabaseQueryReturn($query) {
		stripslashes($query);
		$conn = DatabaseConnect();
		$result = mysql_query($query) or die("Couldn't run mysql query " . mysql_error());
		$data = array();
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$data[] = $row;
		}
		mysql_close($conn);
        return $data;
	}
?>

	<?php $columns = DatabaseQueryReturn("SHOW COLUMNS FROM `table`"); ?>
	<?php $data = DatabaseQueryReturn("SELECT * FROM `jos_facileforms_subrecords`"); ?>
