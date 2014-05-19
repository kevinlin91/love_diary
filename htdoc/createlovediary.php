﻿﻿<?php
include("connectdb.php");

	$a = "
		create table diary(
		diarypk integer auto_increment primary key,
		diarydate datetime,
		dmemberid char(100),
		diarytext text
		)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	      ";
	$result = mysql_query($a);
	if($result) {
	echo "<p>Create successful.";
	}
	else{
	echo "<p>Create failed.";
	}
?>