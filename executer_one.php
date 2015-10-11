<?php
ini_set("display_errors",1);
require_once(__DIR__."/function/checkpermission.php");
if(!checkpermission(true)){
	echo "No permission.";
	exit;
}
date_default_timezone_set('Asia/Taipei');
require_once(__DIR__."/../function/sql/sql.php");

$query=new query;
$query->dbname="xiplus_em";
$query->table="task";
$query->where=array("token",$_POST["token"]);
$task=fetchone(SELECT($query));

exec("php ".$task["path"]);
$query=new query;
$query->dbname="xiplus_em";
$query->table="log_task";
$query->value=array(
	array("time",date("Y-m-d H:i:s")),
	array("text",basename($task["path"]))
);
INSERT($query);
$query=new query;
$query->dbname="xiplus_em";
$query->table="log_run";
$query->value=array(
	array("time",date("Y-m-d H:i:s")),
	array("text","one(".basename($task["path"]).")"),
);
INSERT($query);
?>
<hr><a href="./">Back to homepage.</a>