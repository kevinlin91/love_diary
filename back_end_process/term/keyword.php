﻿﻿﻿﻿﻿﻿﻿<?php


$txtDir = './svmtfidf/';
$txtArr = scandir($txtDir);

$countertfidf = 2;
//load every tf 
while ($countertfidf < count($txtArr)){

$dir = $txtArr[$countertfidf];

//total tfidf data
$tfidfdata = array();
//tf frequncy
$tfidf = array();
//tf content
$tfidfcontent = array();

$filetfidf = fopen("./svmtfidf/$dir","r");
$fptfidf = fopen("./svmkeyword/$dir","w");
while(!feof($filetfidf)){
$tfidfdata[] = fgets($filetfidf);
}
fclose($filetfidf);

$j=0;
while($j<count($tfidfdata)){
$str = $tfidfdata[$j];
$tok_str = strtok($str," ");
array_push($tfidfcontent,$tok_str);
$tok_str = strtok("");
array_push($tfidf,trim($tok_str));
$j++;
}


for($i=0 ; $i< (count($tfidf)-1) ;$i++){
    $max = $i ;
    for ( $j=$i+1 ; $j<count($tfidf);$j++){
       if( $tfidf[$j] > $tfidf[$max] )
       {
       $max = $j;
       }
    }
    $tmp  =  $tfidf[$i];
	$tfidf[$i] = $tfidf[$max];
    $tfidf[$max] = $tmp;
    $tmp2  =  $tfidfcontent[$i];
	$tfidfcontent[$i] = $tfidfcontent[$max];
    $tfidfcontent[$max] = $tmp2;
}


for($i=0;$i<5;$i++){
 @$a = $tfidfcontent[$i]." ".$tfidf[$i]."\r\n";
fwrite($fptfidf,"$a");}
fclose($fptfidf);


$countertfidf++;
}








?>