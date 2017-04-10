<?php
require_once(__DIR__."/function/checkpermission.php");
if(!checkpermission(true)){
	echo "No permission.";
	exit;
}
require(__DIR__."//config/config.php");
require_once(__DIR__."/function/SQL-function/sql.php");

$query=new query;
$query->dbname="xiplus_em";
$query->table="log_task";
$query->where=array(
	array("time", date("Y-m-d H:i:s", time()-$logkeep), "<")
);
DELETE($query);

$query=new query;
$query->dbname="xiplus_em";
$query->table="log_run";
$query->where=array(
	array("time", date("Y-m-d H:i:s", time()-$logkeep), "<")
);
DELETE($query);
header('Location: ./');
