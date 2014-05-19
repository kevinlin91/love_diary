﻿﻿﻿﻿﻿﻿﻿﻿<?php

//calculate time
function cal_time(){ 
$time = explode( " ", microtime()); 
$usec = (double)$time[0]; 
$sec = (double)$time[1]; 
return $sec + $usec; 
}

$begin_time = cal_time();

set_time_limit(0);


$txtDir = './svmtf/';
$txtArr = scandir($txtDir);
//total idf data
$idfdata = array();
//idf frequncy
$idf = array();
//idf content
$idfcontent = array();



//load idf txt
$fileidf = fopen("./svmidf/idf.txt","r");
while(!feof($fileidf)){
$idfdata[] = fgets($fileidf);
}
fclose($fileidf);

$i=0;
// string token content($idfcontent) + frequncy($idf)
while($i<(count($idfdata))){
$str = $idfdata[$i];
$tok_str = strtok($str," ");
array_push($idfcontent,$tok_str);
$tok_str = strtok("");
array_push($idf,$tok_str);
$i++;
}

//check idf content number equal to idf number
if(count($idf) != count($idfcontent)){
echo "idf string token error.";
}

$countertf = 2;
//load every tf 
while ($countertf < count($txtArr)){

$dir = $txtArr[$countertf];

//total tf data
$tfdata = array();
//tf frequncy
$tf = array();
//tf content
$tfcontent = array();
//tfidf
$number = array();


$filetf = fopen("./svmtf/$dir","r");
$tfidffile = fopen("./svmtfidf/$dir","w");
while(!feof($filetf)){
$tfdata[] = fgets($filetf);
}
fclose($filetf);
$j=0;
while($j<(count($tfdata))){

$str = $tfdata[$j];
$tok_str = strtok($str," ");
array_push($tfcontent,$tok_str);
$tok_str = strtok("");
array_push($tf,$tok_str);
$j++;
}
//check tf content number equal to tf number
if(count($tf) != count($tfcontent)){
echo "tf string token error.";
}

for($i=0;$i<count($tfcontent);$i++){
  for($j=0;$j<count($idfcontent);$j++){
   if($tfcontent[$i] == $idfcontent[$j]){
   @$num = $tf[$i]/$idf[$j]; 
   array_push($number,$num);
   break;
   }
}
}

//check if tfcontent number equal to tfidf number
if(count($tfcontent) != count($number)){
echo "tfidf number error.";
}
for($i=0;$i<count($number);$i++){
 $a = $tfcontent[$i]." ".$number[$i]."\r\n";
fwrite($tfidffile,"$a");}
fclose($tfidffile);
$countertf++;
}


//calculete total time 
$end_time = cal_time();
$total_time = $end_time - $begin_time;
echo "共執行".$total_time."秒";


?>