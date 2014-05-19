<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=big-5" />
<div class=register align=center style="font-size: 22px;" >
<?php
	unset($_SESSION['username']);
	echo "登出中... 一秒後跳轉至首頁<br>";
	echo '<a href=index_board.php>若沒跳轉請點此</a>';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index_diary.html>';
?>
</div>