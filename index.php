<?php
require "common.inc.php";

settype($_GET["dir"], "string");

$sDir = realpath(ROOT_DIR."/".$_GET["dir"]);
$sDir = dirfull($sDir);
if (strpos($sDir, dirfull(ROOT_DIR)) !== 0) {
	echo "路径不对头<br />".dirfull(ROOT_DIR)."<br />".$sDir;
	exit;
}

?>
<!DOCTYPE HTML> 
<html> 
<head> 
<meta charset="UTF-8" /> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title>File Share</title> 
<link rel="stylesheet" href="res/style.css" type="text/css" />
<script src="res/script.js"></script>
</head> 
 
<body>
<?php
$sPath = substr($sDir, strlen(ROOT_DIR), -1);
$aPath = explode("/", $sPath);

$sHTMLPath = "<div class=\"path\">";
// 显示路径
$sPath = "";
$aPathShow = array();
foreach ($aPath as $sPathSub) {
	if ($sPathSub) {
		$aPathShow[] = $sPathSub;
	}
	$sHTMLPath .= "<a href=\""
		.sprintf("/index.php?dir=%s", urlencode(implode("/", $aPathShow)))
		."\">".htmlspecialchars($sPathSub ?: "ROOT")."</a> / ";
}

$sHTMLPath .= "</div>";

echo $sHTMLPath;

// 列表

if (!is_dir($sDir)) {
	?>
	<p class="error">查无此目录</p>
	<?php
	exit;
}

$lFile = scandir($sDir);

$lImageFile = array(
	"png",
	"bmp",
	"jpg",
	"jpeg",
	"gif",
	"svg",
);

$lScan = array();
foreach ($lFile as $sFile) {
	if (substr($sFile, 0, 1) === "."
		|| substr($sFile, 0, 1) === "_") {
		continue;
	}
	$sExt = pathinfo($sFile, PATHINFO_EXTENSION);
	$sFileFull = $sDir.$sFile;

	switch (TRUE) {
		case is_dir($sFileFull):
			$aRow = array(
				"type" => "dir",
			);	
			break;
		case in_array(strtolower($sExt), $lImageFile):
			$aRow = array(
				"type" => "image",
			);	
			break;
		default:
			$aRow = array(
				"type" => "file",
			);	
			break;
	}

	$aRow["name"] = $sFile;
	$aRow["fullname"] = substr($sFileFull, strlen(ROOT_DIR) + 1);
	$lScan[] = $aRow;
}

usort($lScan, function($a, $b) {
	$lVal = array(
		"dir" => 100,
		"image" => 90,
		"file" => 0,
	);
	$at = $lVal[$a["type"]];
	$bt = $lVal[$b["type"]];

	if ($at == $bt) {
		return strcmp($a["name"], $b["name"]);
	}
	return ($at > $bt) ? -1 : 1;
});

$lURLFormat = array(
	"dir" => "/index.php?dir=%s",
	"image" => "/image.php?file=%s",
	"file" => "http://192.168.189.39/share/%s",
);

echo "<ul>\n";
foreach ($lScan as $aRow) {
	$sURL = $aRow["type"] == "file" 
		? rawurlencode($aRow["fullname"]) 
		: urlencode($aRow["fullname"]);
	$sURL = str_replace("%2F", "/", $sURL);
	echo "<li class=\"".$aRow["type"]."\"><a href=\"".sprintf($lURLFormat[$aRow["type"]], $sURL)."\">"
		.htmlspecialchars($aRow["name"])
		."</a></li>\n";
}
echo "</ul>";

echo $sHTMLPath;
?>
</body>
</html>

