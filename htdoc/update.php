﻿<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=big-5" />
<?php
	include("connectdb.php");
	@$oldpwd=$_POST['c1'];
	@$pwd=$_POST['a1'];
	@$pwd2=$_POST['b1'];
	@$name=$_POST['a2'];
	@$email=$_POST['a3'];
	@$sex=$_POST['a4'];
	@$star=$_POST['a5'];
	if($_POST['a6']!=NULL && $_POST['a7']!=NULL && $_POST['a8']!=NULL){
	$bd=date("$_POST[a6]-$_POST[a7]-$_POST[a8]");
	}
	else{
	$bd=NULL;
	}
	
	if($_SESSION['username']!=NULL){
	$id=$_SESSION['username'];

	$sql = "select * from member where memid='$id'";
	$result=mysql_query($sql);
	$row=@mysql_fetch_row($result);
	if( $pwd!=NULL && $pwd2!=NULL && $pwd===$pwd2 && $row[3]==$oldpwd){
	$sqlpwd="update member set mempwd='$pwd' where memid='$id'";
	mysql_query($sqlpwd);
	echo "修改成功<br>";
	}
	else if($pwd!=$pwd2 && $pwd!=null && $pwd2!=null){
	echo "兩次密碼輸入不同 請重新填寫";
	echo '<a href=update.php>兩秒後跳轉至修改頁面</a>';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=update.php>';
	}
	else if($row[3]!=$oldpwd && $oldpwd!=null){
	echo "舊密碼輸入錯誤 請重新填寫";
	echo '<a href=update.php>兩秒後跳轉至些改頁面</a>';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=update.php>';
	}

	if($name!=NULL){
	$sqlname="update member set memname='$name' where memid='$id'";
	if(mysql_query($sqlname)){
	echo "修改姓名成功<br>";}
	else{
	echo "修改姓名失敗<br>";}
	}

	if($email!=NULL){
	$sqlemail="update member set mememail='$email' where memid='$id'";
	if(mysql_query($sqlemail)){
	echo "修改信箱成功<br>";}
	else{
	echo "修改信箱失敗<br>";}
	}

	if($sex!=3 && $sex!=NULL){
	$sqlsex="update member set memsex='$sex' where memid='$id'";
	if(mysql_query($sqlsex)){
	echo "修改性別成功<br>";}
	else{
	echo "修改性別失敗<br>";}
	}

	if($star!=13 && $star!=NULL){
	$sqlstar="update member set memstar='$star' where memid='$id'";
	if(mysql_query($sqlstar)){
	echo "修改星座成功<br>";}
	else{
	echo "修改星座失敗<br>";}
	}

	if($bd!=NULL){
	$sqlbd="update member set membd='$bd' where memid='$id'";
	if(mysql_query($sqlbd)){
	echo "修改生日成功<br>";}
	else{
	echo "修改生日失敗<br>";}
	}
	echo "修改完成!";
	echo '<a href=member.php>兩秒後跳轉至會員頁面</a>';
	echo '<meta http-equiv=REFRESH CONTENT=3;url=member.php>';
	}
	else {
	echo "您尚未登入!";
	echo '<a href=index_board.php?Act=3>兩秒後跳轉至登入頁面</a>';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=index_board.php?Act=3>';
	}

?>