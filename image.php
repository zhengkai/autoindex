<?php
require "common.inc.php";
settype($_GET["file"], "string");
?>
<!DOCTYPE HTML> 
<html> 
<head> 
<meta charset="UTF-8" /> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title>File Share - Image</title> 
<link rel="stylesheet" href="res/style.css" type="text/css" />
</head> 
 
<body>
<img src="http://192.168.189.39/share/<?php
	echo $_GET["file"];
?>" />
</body>
</html>

