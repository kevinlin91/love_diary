<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=big-5">
<body  link=#0000ff alink=#0000ff vlink="0000ff" background=/picture/image.jpg>
<style type ="text/css">
<!--
body{
	background-repeat:no-repeat;
  
	background-attachment:fixed;
  

  	background-position:center;
	background-size:1400px 700px;
}
-->
</style>


<div class=register align=center style="font-size: 22px;" >
<?php
	include("connectdb.php");
	date_default_timezone_set('Asia/Taipei');
	$dt=date("Y-m-d H:i:s");
	$bd=date("$_POST[a7]-$_POST[a8]-$_POST[a9]");
	@$id=$_POST['a1'];
	@$pwd=$_POST['a2'];
	@$pwd2=$_POST['b2'];
	@$name=$_POST['a3'];
	$name=iconv('Big5','UTF-8',$name);
	@$email=$_POST['a4'];
	@$sex=$_POST['a5'];
	@$star=$_POST['a6'];
	$aa="
		insert into member values (
		null,'$dt','$id','$pwd','$name','$email','$sex','$star','$bd')";
	$sql="select memid from member where memid='$id'";
	$repeat=mysql_query($sql);
	$rows= @mysql_num_rows($repeat);
	if( $id==null || $pwd==null)
	{ 
	echo "帳號跟密碼不得為空白<br> 請重新註冊<br>二秒後跳轉回跳轉回註冊頁面<br>";
	echo '<a href=register.html>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=register.html>';
	}
	else if($pwd != $pwd2)
	{
	echo $rows;
	echo "兩次輸入的密碼不同<br> 請重新註冊<br>二秒後跳轉回跳轉回註冊頁面<br>";
	echo '<a href=register.html>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=register.html>';
	}
	else if($name==null){
	echo "姓名不得為空值<br> 請重新註冊<br>二秒後跳轉回跳轉回註冊頁面<br>";
	echo '<a href=register.html>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=register.html>';
	}
	else if($rows!=0){
	echo "此帳號已有人使用<br> 請重新註冊<br>二秒後跳轉回跳轉回註冊頁面<br>";
	echo '<a href=register.html>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=register.html>';
	}
	else{
	mysql_query($aa);
	header("location:index_diary.html");
	}
?>

</div>

