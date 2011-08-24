<?php
require "common.inc.php";
settype($_GET["file"], "string");
?>
<!DOCTYPE HTML> 
<html> 
<head> 
<meta charset="UTF-8" /> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title>File Share - <?php echo htmlspecialchars($_GET["file"]); ?></title> 
<link rel="stylesheet" href="res/style.css" type="text/css" />
<script src="res/script.js"></script>
</head> 
 
<body class="image">
<img src="http://192.168.189.39/share/<?php
	echo htmlspecialchars($_GET["file"]);
?>" />
</body>
</html>

