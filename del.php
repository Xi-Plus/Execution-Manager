<?php
require_once(__DIR__."/function/checkpermission.php");
if(!checkpermission(true)){
	echo "No permission.";
	exit;
}
require_once(__DIR__."/../function/sql/sql.php");

$query=new query;
$query->dbname="xiplus_em";
$query->table="task";
$query->where=array(
	array("token",$_POST["token"])
);
DELETE($query);
header('Location: ./');
?>