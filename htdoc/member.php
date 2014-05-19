﻿﻿﻿﻿﻿﻿﻿﻿<?php session_start(); ?>
<html><head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body  link=#0000ff alink=#0000ff vlink="0000ff" background=/picture/member.gif style="font-family:標楷體;font-size: 25px;";>

<style type="text/css">
body, td { font-size:20pt ; font-family:標楷體 }
.css_btn_class {
	font-size:24px;
	margin: 2px auto;
	font-family:Arial;
	font-weight:normal;
	-moz-border-radius:16px;
	-webkit-border-radius:16px;
	border-radius:16px;
	border:1px solid #469df5;
	padding:11px 18px;
	text-decoration:none;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(5%, #79bbff), color-stop(100%, #4197ee) );
	background:-moz-linear-gradient( center top, #79bbff 5%, #4197ee 100% );
	background:-ms-linear-gradient( top, #79bbff 5%, #4197ee 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#4197ee');
	background-color:#79bbff;
	color:#ffffff;
	display:inline-block;
	text-shadow:1px 1px 50px #287ace;
 	-webkit-box-shadow:inset 1px 1px 29px 0px #cae3fc;
 	-moz-box-shadow:inset 1px 1px 29px 0px #cae3fc;
 	box-shadow:inset 1px 1px 29px 0px #cae3fc;
}.css_btn_class:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(5%, #4197ee), color-stop(100%, #79bbff) );
	background:-moz-linear-gradient( center top, #4197ee 5%, #79bbff 100% );
	background:-ms-linear-gradient( top, #4197ee 5%, #79bbff 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#4197ee', endColorstr='#79bbff');
	background-color:#4197ee;
}.css_btn_class:active {
	position:relative;
	top:1px;
}
</style>

<?php
	 include("connectdb.php");
	if (@$_SESSION['username']!=null){
	$userid=$_SESSION['username'];
	echo "歡迎".$userid."回來<br>";
	$sql = "select * from member where memid='$userid'";
	 mysql_query("SET NAMES 'utf8'"); 
         mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
         mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
	$result=mysql_query($sql);
	$usersex=NULL;
	$userstar=NULL;
	while(list($number,$day,$id,$pwd,$name,$eamil,$sex,$star,$bd)=mysql_fetch_row($result)){
	
	switch ($sex){
	case "1":
	$usersex="男";
	break;
	case "2":
	$usersex="女";
	break;
	default:
	$usersex=NULL;
	}
	
	switch ($star){
	case "1":
	$userstar="牡羊";
	break;
	case "2":
	$userstar="金牛";
	break;
	case "3":
	$userstar="雙子";
	break;
	case "4":
	$userstar="巨蟹";
	break;
	case "5":
	$userstar="獅子";
	break;
	case "6":
	$userstar="處女";
	break;
	case "7":
	$userstar="天秤";
	break;
	case "8":
	$userstar="天蠍";
	break;
	case "9":
	$userstar="射手";
	break;
	case "10":
	$userstar="魔羯";
	break;
	case "11":
	$userstar="水瓶";
	break;
	case "12":
	$userstar="雙魚";
	break;
	default:
	$userstar=NULL;
	}
	
	echo "<table width=580 align=center border=2 >
	      <tr><td>
		會員ID:$number<br>
		註冊時間:$day<br>
		會員姓名:$name<br>
		會員信箱:$eamil<br>
		會員性別:$usersex<br>
		會員星座:$userstar<br>
		會員生日:$bd<br>
		</td></tr>
		</table>
		<p><hr><p>
	     ";
	}
	echo '<div class=css_btn_class >';
	echo '<a href="logout.php" style="text-decoration:none">登出</a><br>';
	echo '</div>';
	echo '<br>';
	echo '<div class=css_btn_class >';
	echo '<a href="update.html" style="text-decoration:none">修改資料</a><br>';
	echo '</div>';
	echo '<br>';
	echo '<div class=css_btn_class >';
	echo '<a href="diary11.html" style="text-decoration:none">新增日記</a><br>';
	echo '</div>';
	echo '<br>';
	echo '<div class=css_btn_class >';
	echo '<a href="diaryshow.php" style="text-decoration:none">日記管理</a><br>';
	echo '</div>';
	echo '<br>';
	}
	else {
	echo "您尚未登入 一秒後轉至登入頁面";
	echo '<a href=member.php>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index_diary.html>';
	}
	
?>
</body>
</html>