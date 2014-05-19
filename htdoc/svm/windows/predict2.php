﻿﻿﻿﻿﻿﻿﻿﻿<?php
set_time_limit(0);
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

$input = $_POST['mydiary'];
function search($a,$vi){
$index=-1;
for($i=0;$i<count($vi)-1;$i++){

if (trim($vi[$i]) == trim($a)){
$index = $i;}
}
return $index;
}

$filesw = fopen("stopwords.txt",'r');
$stopword = array();
while (!feof($filesw)){
$stopword[] = @iconv('Big5','UTF-8',fgets($filesw));
}
fclose($filesw);

$idfdata = array();
$idfcontent = array();
$idf = array();
//load idf.txt
$fileidf = fopen("idf.txt","r");
while(!feof($fileidf)){
$idfdata[] = fgets($fileidf);
}
fclose($fileidf);
for($i=0;$i<count($idfdata);$i++){
$str = $idfdata[$i];
$tok_str = strtok($str," ");
array_push($idfcontent,$tok_str);
$tok_str = strtok("");
array_push($idf,$tok_str);
}




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

//count tf
$tfcontent = array();
$tf = array();
$tfcounter = 0;
$sign = 0;
for ($i=0;$i<count($str);$i++){
   for($j=0;$j<count($tfcontent);$j++){
   if($str[$i]==$tfcontent[$j]){
   $tf[$j]++;
   $sign = 1;
   break;}
   }
   if($sign == 0){
   
   $tfcontent[$tfcounter] = $str[$i];
   $tf[$tfcounter] = 1;
   $tfcounter++;
   }
   else if($sign ==1){
   $sign =0;
   continue;}
}



//count idf   idfcontent = content ,  idf = fequency
$idfsn = 0;
$idfsign = array();
$idfcounter = count($idfcontent);
for ($i=0;$i<count($str);$i++){
   for($j=0;$j<count($idfcontent);$j++){
   if($str[$i] == $idfcontent[$j] && @$idfsign[$j]==0){
   $idf[$j]++;
   $idfsign[$j] = 1;
   $idfsn = 1;
   break;
   }
   else if($str[$i]==$idfcontent[$j] && $idfsign[$j]==1){
   $idfsn = 1;
   break;
   }
   }
   if($idfsn == 0){ 
   $idfcontent[$idfcounter] = $str[$i];
   $idf[$idfcounter] = 1;
   $idfsign[$idfcounter]=1;	
   $idfcounter++;
   }
   else if($idfsn == 1){
   $idfsn = 0;
   continue;}
}



$tfidf = array();
//count tfidf
for($i=0;$i<count($tfcontent);$i++){
  for($j=0;$j<count($idfcontent);$j++){
   if($tfcontent[$i] == $idfcontent[$j]){
   @$num = $tf[$i]/$idf[$j]; 
   array_push($tfidf,$num);
   break;
   }
}
}





$vicontent = array();
$vivalue = array();
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
    $tmp2  =  $tfcontent[$i];
	$tfcontent[$i] = $tfcontent[$max];
    $tfcontent[$max] = $tmp2;
}
for($i=0;$i<count($tfcontent);$i++){
array_push($vicontent,$tfcontent[$i]);
array_push($vivalue,$tfidf[$i]);
}
/*for($i=0;$i<count($tfcontent);$i++){
if( strpos ($tfcontent[$i],"Vi")){
array_push($vicontent,$tfcontent[$i]);
array_push($vivalue,$tfidf[$i]);
}
}*/


$vi = array();
$filevi = fopen("./svmterm.txt","r");
while(!feof($filevi)){
$vi[] = fgets($filevi);
}
fclose($filevi);



$value = array();
for($i=0;$i<count($vi);$i++){
$value[$i]=0;}

for($i=0;$i<count($vicontent)-1;$i++){
$a = search($vicontent[$i],$vi);
if($a != -1){
   $value[$a] = $vivalue[$i];
}
}

$str_vi="";
for($i=0;$i<count($value);$i++){
$str_vi = $str_vi.($i+1).":".$value[$i]." ";
}

$fp = fopen("vidata","w");
fwrite($fp,$str_vi);
fclose($fp);


exec("python easy.py data2 vidata");
//exec("svm-scale -s scale vidata > vidata.scale");
//exec("svm-predict vidata.scale testdata.scale.model vidata.out");

$f = fopen("vidata.predict","r");
$predict = @iconv('Big5','UTF-8',fgets($f));
$predict = trim($predict);
$output = array();
if($predict=="1"){ $output = "love";}
else if($predict=="2"){$output="sweet";}
else if($predict=="3"){$output="complaint";}
else if($predict=="4"){$output="break";}

echo json_encode($output,JSON_UNESCAPED_UNICODE)
?>