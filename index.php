<html>
<?php
require(__DIR__."/config/config.php");
require(__DIR__."/function/SQL-function/sql.php");
require(__DIR__."/function/checkpermission.php");
$permission=checkpermission();
?>
<head>
	<meta charset="UTF-8">
	<title>Execution Manager</title>
</head>
<body topmargin="5" leftmargin="0" bottommargin="0">
<center>
<h2>Execution Manager</h2>
<?php
if($permission){
	logouturl();
}else {
	?><a href="login.php">login</a><?php
}
?>
<h3>Task List</h3>
<form id="delform" action="del.php" method="post">
	<input id="deltoken" name="token" type="hidden">
</form>
<form id="executeform" action="executer_one.php" method="post">
	<input id="executetoken" name="token" type="hidden">
</form>
<form id="isrunform" action="isrun.php" method="post">
	<input id="isruntoken" name="token" type="hidden">
	<input id="isrun" name="isrun" type="hidden">
</form>
<table width="0" border="1" cellspacing="0" cellpadding="3">
	<tr>
		<td>name</td>
		<td>path</td>
		<td>code</td>
		<td>status</td>
		<?php
		if($permission){
		?>
		<td>edit</td>
		<?php
		}
		?>
	</tr>
	<?php
		$isrun=array("Off","On");
		$query=new query;
		$query->dbname="xiplus_em";
		$query->table="task";
		$query->order=array(
			array("isrun","DESC"),
			array("name")
		);
		$tasklist=SELECT($query);
		foreach($tasklist as $task){
	?>
	<tr>
		<td><?php echo $task["name"]; ?></td>
		<td><?php
			echo str_replace($pathreplace, "", $task["path"]);
			if (!file_exists($task["path"])) {
				?> <span style="color: red;">找不到檔案</span><?php
			}
		?></td>
		<td><?php echo $task["source"]; ?></td>
		<td><?php echo $isrun[$task["isrun"]]; ?></td>
		<?php
		if($permission){
		?>
		<td>
			<button onClick="if(!confirm('Run?'))return false;executetoken.value='<?php echo $task["token"]; ?>';executeform.submit();">Run</button>
			<button onClick="if(!confirm('<?php echo $isrun[1-$task["isrun"]]; ?>?'))return false;isruntoken.value='<?php echo $task["token"]; ?>';isrun.value='<?php echo (1-$task["isrun"]); ?>';isrunform.submit();"><?php echo $isrun[1-$task["isrun"]]; ?></button>
			<button onClick="tname.value='<?php echo $task["name"]; ?>';path.value='<?php echo $task["path"]; ?>';source.value='<?php echo $task["source"]; ?>';token.value='<?php echo $task["token"]; ?>';">Edit</button>
			<button onClick="if(!confirm('Del?'))return false;deltoken.value='<?php echo $task["token"]; ?>';delform.submit();">Del</button>
		</td>
		<?php
		}
		?>
	</tr>
	<?php
		}
	?>
</table>
<hr>
<table width="0" border="0" cellspacing="0" cellpadding="5">
<tr>
<td align="center" valign="top">

<h3>Code</h3>
<table width="0" border="1" cellspacing="0" cellpadding="1">
	<tr>
		<td>&nbsp;</td>
		<td>enable</td>
		<td>disable</td>
	</tr>
	<tr>
		<td>day</td>
		<td>d (01-30)<br>
			j (1-31)<br>
			N (1-7) <br>
			w (0-6) <br>
			z (0-365)</td>
		<td>D<br>
			l<br>
			S</td>
	</tr>
	<tr>
		<td>week</td>
		<td>W (ISO-8601)<br></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>month</td>
		<td>m (01-12)<br>
			n (1-12)<br>
			t (28-31)</td>
		<td>F<br>
			M</td>
	</tr>
	<tr>
		<td>year</td>
		<td>L (0-1)<br>
			o (ISO-8601)<br>
			Y (1999 or 2003)<br>
			y (99 or 03)<br></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>time</td>
		<td>&nbsp;</td>
		<td>a A B</td>
	</tr>
	<tr>
		<td>hour</td>
		<td>g (1-12)<br>
			G (0-23)<br>
			h (01-12)<br>
			H (00-23)</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>minute</td>
		<td>i (00-59)</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>second</td>
		<td>&nbsp;</td>
		<td>s u</td>
	</tr>
	<tr>
		<td>timezone</td>
		<td>&nbsp;</td>
		<td>e I O P T Z c r U</td>
	</tr>
</table>
<a href="http://php.net/manual/zh/function.date.php" target="_blank">PHP date()</a>
</td>
<?php
if($permission){
?>
<td align="center" valign="top">
	<h3>Add/Edit</h3>
	<form action="add.php" method="post">
		<table width="0" border="1" cellspacing="0" cellpadding="1">
		<tr>
			<td>name</td>
			<td><input name="name" id="tname" type="text" size="50" maxlength="20" value="<?php echo ($permission?@$_GET["name"]:"No permission"); ?>" <?php echo ($permission?"":"disabled='disabled'"); ?>></td>
		</tr>
		<tr>
			<td>path</td>
			<td><input name="path" id="path" type="text" size="50" maxlength="255" required value="<?php echo ($permission?@$_GET["text"]:"No permission"); ?>" <?php echo ($permission?"":"disabled='disabled'"); ?>></td>
		</tr>
		<tr>
			<td>code</td>
			<td><input name="source" id="source" type="text" size="50" required value="<?php echo ($permission?@$_GET["source"]:"No permission"); ?>" <?php echo ($permission?"":"disabled='disabled'"); ?>></td>
		</tr>
		</table>
		<script>
			var allow=['d','j','N','w','z','W','m','n','t','L','o','Y','y','g','G','h','H','i'];
			function check(text){
				text=text.replace(/0/g,"");
				text=text.replace(/1/g,"");
				text=text.replace(/2/g,"");
				text=text.replace(/3/g,"");
				text=text.replace(/4/g,"");
				text=text.replace(/5/g,"");
				text=text.replace(/6/g,"");
				text=text.replace(/7/g,"");
				text=text.replace(/8/g,"");
				text=text.replace(/9/g,"");
				text=text.replace(/\(/g,"");
				text=text.replace(/\)/g,"");
				text=text.replace(/>/g,"");
				text=text.replace(/</g,"");
				text=text.replace(/=/g,"");
				text=text.replace(/!/g,"");
				
				text=text.replace(/\+/g,"?");
				text=text.replace(/-/g,"?");
				text=text.replace(/\*/g,"?");
				text=text.replace(/\//g,"?");
				text=text.replace(/%/g,"?");
				text=text.replace(/&/g,"?");
				text=text.replace(/\|/g,"?");
				text=text.split("?");
				
				var error=[];
				for(var i=0;i<text.length;i++){
					if(allow.indexOf(text[i])==-1&&text[i]!="")error.push(text[i]);
				}
				if(error.length!=0){
					alert("Wrong code: "+error);
					return false;
				}
				return true;
			}
		</script>
		<input type="hidden" name="token" id="token">
		<button type="submit" name="action" value="add" onClick="if(check(source.value)==false)return false;" <?php echo ($permission?"":"disabled='disabled'"); ?>>Add</button>
		<button type="submit" name="action" value="edit" onClick="if(check(source.value)==false)return false;" <?php echo ($permission?"":"disabled='disabled'"); ?>>Edit</button>
	</form>
</td>
<?php
}
?>
</tr>
</table>
</center>
</body>
</html>
