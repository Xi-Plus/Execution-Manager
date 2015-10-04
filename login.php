<?php
require_once(__DIR__."/function/checkpermission.php");
if(checkpermission(true)){
	echo "logged in.<br>";
	logouturl();
}
else echo "No permission.<br>";
?>
<br><a href="./">Back to homepage.</a>