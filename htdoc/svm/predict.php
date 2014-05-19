﻿<?php

function remove_stopword($a,$b){
$counter = 0;
$have=0;

while($counter < count($b)){
if( $a==trim($b[$counter]) ){
$have = 1;
}
$counter++;
}
}

$filesw = fopen("stopwords.txt",'r');
$stopword = array();
while (!feof($filesw)){
$stopword[] = @iconv('Big5','UTF-8',fgets($filesw));
}
fclose($filesw);


$str_test = $input;
@$str_test = htmlspecialchars(trim($str_test))."\n";
@$str_test = str_replace(" ", "",$str_test);
@$str_test = str_replace("　", "",$str_test);
@$str_test = str_replace("，", "",$str_test);
@$str_test = str_replace(",", "",$str_test);
@$str_test = str_replace("。", "",$str_test);
@$str_test = str_replace(".", "",$str_test);

require_once "CKIPClient.php";

$CKIP_SERVER = '140.109.19.104';
$CKIP_PORT = 1501;
$CKIP_USERNAME = 'kevinlin91';
$CKIP_PASSWORD = 'kevin601';

$ckip_client_obj = new CKIPClient(
   @$CKIP_SERVER,
   @$CKIP_PORT,
   @$CKIP_USERNAME,
   @$CKIP_PASSWORD
);

if($ckip_client_obj){
$raw_text = $str_test;}
$return_text = $ckip_client_obj->send($raw_text);
$return_sentence = $ckip_client_obj->getSentence();
$return_term = $ckip_client_obj->getTerm();


$data = array();
for($i=0;$i<count($return_sentence);$i++){
array_push($data,$return_sentence[$i]);
}


$str = array();
for ($j=0;$j<count($data);$j++){
$arr = explode("　",$data[$j]);
for ($i=1;$i<count($arr);$i++){

$a=remove_stopword($arr[$i],$stopword);
if($a==0){
$s =trim("$arr[$i]");
array_push($str,$s);
}
}
}
$vi = array();
for($i=0;$i<count($str);$i++){
if( strpos ($str[$i],$term)){
array_push($vi,$str[$i]);
}
}









//exec("python easy.py finaldata vidata", $output);
//print_r($output);


?>