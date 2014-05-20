<?php
	include("connectdb.php");

	$a = "
		create table member(
		mempk integer auto_increment primary key,
		memdate datetime,
		memid varchar(100) Unique,
		mempwd varchar(100),
		memname char(100),
		mememail varchar(100),
		memsex integer,
		memstar integer,
		membd date)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	      ";
	$result = mysql_query($a);
	if($result) {
	echo "<p>Create successful.";
	}
	else{
	echo "<p>Create failed.";
	}
?>
	