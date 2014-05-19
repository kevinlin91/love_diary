﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<?php
//caculate time
function cal_time(){ 
$time = explode( " ", microtime()); 
$usec = (double)$time[0]; 
$sec = (double)$time[1]; 
return $sec + $usec; 
}
//reomve stopword
function remove_stopword($a,$b){
$counter = 0;
$have=0;

while($counter < count($b)){
if( $a==trim($b[$counter]) ){
$have = 1;
}
$counter++;
}

return $have;
}


//program start time
$begin_time = cal_time();

set_time_limit(0);

//global val
//dir 1(file name)
$txtDir = './svmdata/';
$txtArr = scandir($txtDir);
$counter = 2;
$idfhead = array();
$idf = array();
$idfsign = array();
$idfcounter = 0;
//dir 2(writeidf)
$idffile = fopen("./svmidf/term.txt","w");

//load stopword list
$filesw = fopen("stopwords.txt",'r');
$stopword = array();
while (!feof($filesw)){
$stopword[] = @iconv('Big5','UTF-8',fgets($filesw));
}
fclose($filesw);
//start analysis tf-idf
while($counter<count($txtArr)){
$dir = $txtArr[$counter];
$arr = array();
$data = array();
$str = array();
//dir 3(load)
$file = fopen("./svmdata/$dir","r");
//dir4 (wriettf)
$fp = fopen("./svmtf/$dir","w");


//load text
while(!feof($file)){
$data[] = fgets($file);
}
fclose($file);

//string token
for ($j=0;$j<count($data);$j++){
$arr = explode("　",$data[$j]);
for ($i=0;$i<count($arr);$i++){
$a=remove_stopword($arr[$i],$stopword);
if($a==0){
$s =trim("$arr[$i]");
array_push($str,$s);
//}
}
}
}
//count tf
$head = array();
$tf = array();
$tfcounter = 0;
$sign = 0;
for ($i=0;$i<count($str);$i++){
   for($j=0;$j<count($head);$j++){
   if($str[$i]==$head[$j]){
   $tf[$j]++;
   $sign = 1;
   break;}
   }
   if($sign == 0){
   
   $head[$tfcounter] = $str[$i];
   $tf[$tfcounter] = 1;
   $tfcounter++;
   }
   else if($sign ==1){
   $sign =0;
   continue;}
}
//count idf
$idfsn = 0;
for ($i=0;$i<count($str);$i++){
   for($j=0;$j<count($idfhead);$j++){
   if($str[$i] == $idfhead[$j] && @$idfsign[$j]==0){
   $idf[$j]++;
   $idfsign[$j] = 1;
   $idfsn = 1;
   break;
   }
   else if($str[$i]==$idfhead[$j] && $idfsign[$j]==1){
   $idfsn = 1;
   break;
   }
   }
   if($idfsn == 0){ 
   $idfhead[$idfcounter] = $str[$i];

   $idf[$idfcounter] = 1;
   $idfsign[$idfcounter]=1;	
   $idfcounter++;
   }
   else if($idfsn == 1){
   $idfsn = 0;
   continue;}
}   
if(count($idfhead)!=count($idf) && count($idfhead)!=count($idfsign)){
echo "anlysis error";}

//detect error
if(count($head)!=count($tf)){
echo "anlysis error";}

//idfsign
for($i=0;$i<count($idfsign);$i++){
$idfsign[$i]=0;}

//save tf to file
for($i=0;$i<count($head);$i++){
 $a = $head[$i]." ".$tf[$i]."\r\n";
fwrite($fp,"$a");}
fclose($fp);
$counter++;
}

// save idf to file
for($i=0;$i<count($idfhead);$i++){
 $a = $idfhead[$i]."\r\n";
fwrite($idffile,"$a");}
fclose($idffile);
//calculete total time 
$end_time = cal_time();
$total_time = $end_time - $begin_time;
echo "共執行".$total_time."秒"."IDF個數".count($idfhead);

?>