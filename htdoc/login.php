﻿﻿<?php session_start(); ?>

<div class=register align=center style="font-size: 22px;" >
<?php
	include("connectdb.php");
	$id=$_POST['a1'];
	$pwd=$_POST['a2'];

	$sql="select * from member where memid='$id'";
	$result=mysql_query($sql);
	$row=@mysql_fetch_row($result);
	if($id!=null && $pwd!=null && $row[2]==$id && $row[3]==$pwd){
	$_SESSION['username']=$id;
	echo $id;
	echo "登入成功! 一秒後轉至會員頁面<br>";
	echo '<a href=member.php>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
	}
	else{
	echo "登入失敗 兩秒後轉至登入頁面";
	echo '<a href=member.php>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index_diary.html>';
	}
?>


</div>