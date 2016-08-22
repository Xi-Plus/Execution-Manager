<?php
require_once(__DIR__."/function/checkpermission.php");
if(!checkpermission(true)){
	echo "No permission.";
	exit;
}
require_once(__DIR__."/function/SQL-function/sql.php");

$query=new query;
$query->dbname="xiplus_em";
$query->table="task";
$query->value=array(
	array("isrun",$_POST["isrun"])
);
$query->where=array(
	array("token",$_POST["token"])
);
UPDATE($query);
var_dump($_POST);
header('Location: ./');
?>