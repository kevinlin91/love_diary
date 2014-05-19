﻿﻿﻿﻿﻿﻿<?php session_start(); ?>
<body  link=#0000ff alink=#0000ff vlink="0000ff" background=/picture/member.gif>
<p align=center><font size =6>歡迎來到日記管理系統<br>若要刪除日記請勾選<br></font><p>
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

<SCRIPT type="text/javascript">
function check()
{
 		 		if(update.number.value == "") 
                {
                        alert("未輸入ID");
                }
                else update.submit();
}
</SCRIPT>


<?php

if($_SESSION['username']!=NULL){
include("connectdb.php");
//設定ID
$id=$_SESSION['username'];

 
 $sql = "select * from diary where dmemberid='$id' ";
 $result=mysql_query($sql);
 $diaryid=null;
 $time=null;
 $memid=null;
 $content=null;
 

$i=1; 
 while(list($diaryid,$time,$memid,$content)=mysql_fetch_row($result)){
	echo "
		 <form name=updata method=post action=diarydel.php>
		<table width=580 align=center border=2>
		<tr><td>
		<input type=checkbox name=del[] value=$diaryid>
		第 $i 篇日記 ID:$diaryid<br>
		上次編輯時間：$time<br>
		作者：$memid<br>
		日記內容: $content <br>
		</td></tr>
		</table>
		<p><hr><p>
	     ";
	     $i++;
	}
	echo '<div name=delete align=center>';
	echo '<input type=submit name=delete value="刪除留言" onclick="if(confirm(\'您確定要刪除嗎??\')) return true;else return false">';
	echo '</div>';
	echo '</form>';
	echo '<p><hr><p>';
	echo '
		 <form method=post action=diaryupdate.php>
		 我想修改ID第
		 <input type=text name=number>
		 篇文章.';
	echo '<font	color=red> (請輸入文章ID) </font>';
	
	echo '<input type=submit  value="前往"/><br><br>';
	echo '</from>';
	echo '<div class=css_btn_class>';
	echo '<a href="member.php" style="text-decoration:none">回到會員頁面</a><br>';
	echo '</div>';
}






?>