<?php
require_once(__DIR__."/function/checkpermission.php");
if(!checkpermission(true)){
	echo "No permission.";
	exit;
}
require_once(__DIR__."/../function/sql/sql.php");

$rep=['0','1','2','3','4','5','6','7','8','9','(',')','<','>','=','!'];
$rep2=['+','-','/','*','%','&','|'];
$allow=['d','j','N','w','z','W','m','n','t','L','o','Y','y','g','G','h','H','i'];
$source=$_POST["source"];
$temp=$source;
$temp=str_replace($rep,"",$temp);
$temp=str_replace($rep2,"?",$temp);
$temp=explode("?",$temp);
$error=[];
foreach($temp as $t){
	if(!in_array($t,$allow)&&$t!="")array_push($error,$t);
}
if(count($error)!=0){
	echo "Wrong code: ".implode(",",$error)."<br>";
	?><a href="./">Back to homepage.</a><?php
	exit;
}
$source=str_replace("&&","&",$source);
$source=str_replace("&","&&",$source);
$source=str_replace("||","|",$source);
$source=str_replace("|","||",$source);
$source=str_replace("==","=",$source);
$source=str_replace("=","==",$source);
$source=str_replace("!==","!=",$source);
$source=str_replace("<==","<=",$source);
$source=str_replace(">==",">=",$source);
$source=preg_replace("/(\D)0+([1-9])/","$1$2",$source);
$source=preg_replace("/^0+([1-9])/","$1",$source);

$token=md5(uniqid(rand(),true));
$query=new query;
$query->dbname="xiplus_em";
$query->table="task";
$query->value=array(
	array("name",$_POST["name"]),
	array("source",$source),
	array("token",$token)
);
INSERT($query);
header('Location: ./');
?>