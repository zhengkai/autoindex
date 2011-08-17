<?php
define("ROOT_DIR", "/share");

function dirfull($s) {
	if (substr($s, 0, -1) != "/") {
		$s .= "/";
	}
	return $s;
}

