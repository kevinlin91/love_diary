<?php  
        //This file is to link to the database
	$link = @mysql_connect("localhost","root","");
	if(!$link){
	echo "�L�k�s����SQL";}
	  mysql_query("SET NAMES 'utf8'"); 
         mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
         mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
	$db_select = mysql_select_db("test",$link);
	if(!$db_select){
	echo "�L�k�s����Table";}
?>
