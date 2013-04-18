<?php
	require("lib.php");
?>
	<html>
	<head>
	<title>View Logs - mBulance</title>
	</head>
	<body>
		<h1>Logs showing how many times each tree was used:</h1>
		<ul>
<?php
		CountLog::display();
?>
	</ul>
	</body>
	</html>
