<?php
ini_set("display_errors",1);
if(PHP_SAPI!="cli"){
	echo "No permission.";
	exit;
}
date_default_timezone_set('Asia/Taipei');
require_once(__DIR__."/function/SQL-function/sql.php");

$posttime=time();

$query=new query;
$query->dbname="xiplus_em";
$query->table="task";
$query->where=array("isrun","1");
$tasklist=SELECT($query);
foreach($tasklist as $task){
	$task["source"]=preg_replace("/[a-zA-Z]/","date('$0',".$posttime.")",$task["source"]);
	echo $task["source"];
	eval("\$isrun=".$task["source"].";");
	if($isrun){
		echo " Yes\n";
		exec("php ".$task["path"], $output);
		mkdir(__DIR__."/log/".$task["token"]);
		file_put_contents(__DIR__."/log/".$task["token"]."/".date("Y-m-d-H-i-s").".log", implode("\n", $output));
		$query=new query;
		$query->dbname="xiplus_em";
		$query->table="log_task";
		$query->value=array(
			array("text",basename($task["path"])),
			array("time",date("Y-m-d H:i:s"))
		);
		INSERT($query);
	}else echo " No\n";
}

$query=new query;
$query->dbname="xiplus_em";
$query->table="log_run";
$query->value=array(
	array("text","executer"),
	array("time",date("Y-m-d H:i:s"))
);
INSERT($query);
?>