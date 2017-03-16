<?php
ini_set("display_errors",1);
function checkpermission($gotologin=false){
	require(__DIR__."/../config/config.php");
	if(PHP_SAPI=="cli"){
		return true;
	}else if(isset($_SERVER["PHP_AUTH_USER"])&&isset($_SERVER["PHP_AUTH_PW"])&&isset($password[$_SERVER["PHP_AUTH_USER"]])&&$password[$_SERVER["PHP_AUTH_USER"]]==$_SERVER["PHP_AUTH_PW"]){
		return true;
	}else if($gotologin){
		header('WWW-Authenticate: Basic realm="Login As Admin"');
		header('HTTP/1.0 401 Unauthorized');
		return false;
	}else {
		return false;
	}
}
function logouturl(){
	echo '<a href="//logout@'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'">log out</a>';
}
?>