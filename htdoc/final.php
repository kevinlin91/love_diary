<?php
     //input
     header("Content-type: application/json");
     $input = $_POST['mydiary'];

     //to-do

header("Content-type: application/json");
$input = $_POST['mydiary'];
include("./spider/LIB_parse.php");
include("./spider/LIB_http.php");
//caculate time
function cal_time(){ 
$time = explode( " ", microtime()); 
$usec = (double)$time[0]; 
$sec = (double)$time[1]; 
return $sec + $usec; 
}

//remove_stopword
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
$begin_time = cal_time();

set_time_limit(0);

//load stopword.txt
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
$fileidf = fopen("./idf.txt","r");
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
$str_test = $input;


$str_test = str_replace(" ", "",$str_test);
$str_test = str_replace("　", "",$str_test);
$str_test = str_replace("，", "",$str_test);
$str_test = str_replace(",", "",$str_test);
$str_test = str_replace("。", "",$str_test);
$str_test = str_replace(".", "",$str_test);


if($ckip_client_obj){
$raw_text = $str_test;}

$return_text = $ckip_client_obj->send($raw_text);

$return_sentence = $ckip_client_obj->getSentence();
$return_term = $ckip_client_obj->getTerm();




$data = array();
for($i=0;$i<count($return_sentence);$i++){
array_push($data,$return_sentence[$i]);
}

//string token
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

//calculate keyword
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
$out = "";
if (count($tfcontent)<20){
for($i=0;$i<count($tfcontent);$i++){
    if($i == (count($tfcontent) - 1) ){
    $out = $out.$tfcontent[$i];}
    else{
    $out = $out.$tfcontent[$i]." ";
    }
}
}
else{
for ($i=0;$i<20;$i++){
    if($i == 19){
    $out = $out.$tfcontent[19];}
    else{
    $out = $out.$tfcontent[$i]." ";
    }
  }  
}

//$out must change to unicode to save in $uni

$uni = json_encode($out);
$uni = str_replace("\"","",$uni);
//$uni = "\ufeff\ufeff\ufeff\ufeff\u61c7\u5207(Vi) \u51fa\u904a(Nv) \u8b9a\u7f8e(N) \u4e0d\u6642(ADV) \u5a5a\u59fb(N) \u8a08\u756b(N) \u539f\u4f86(A) \u66f4\u52a0(ADV) \u5b8c(Vi) \u64c1\u62b1(Vt) \u5929(N) \u7576\u7136(ADV) \u6200\u611b(Vi) \u79ae\u7269(N) \u751c\u871c(Vi) \u804a(Vt) \u9001(Vt) \u5c0f(Vi) \u6c92(Vt) \u4e2d(POST)";



$filelsi = fopen("diary.txt",'w');
fwrite($filelsi,$uni);
fclose($filelsi);

exec("python lyric.py");

$recommend = array();
$lyrics_id = array();
$filerecommend = fopen("recommend.txt",'r');
while(!feof($filerecommend)){
$recommend[] = fgets($filerecommend);
}
for($i=0;$i<count($recommend);$i++){
$s_1 = trim($recommend[$i],"(");
$s_2 = strtok($s_1,",");
if($s_2<300){
array_push($lyrics_id,($s_2+1));
}
}

//No.1
$rank_1 = $lyrics_id[0];
$rank_1_name;
$f1 = fopen("./lyrics/$rank_1.txt",'r');
$p1 = fopen("./lyricscontent/$rank_1.txt",'r');
$rank_1_name = @iconv('Big5','UTF-8',fgets($f1));
$rank_1_lyrics = "";
$lydata = array();
while(!feof($p1)){
$lydata[] = @iconv('Big5','UTF-8',fgets($p1));
}
for($i=0;$i<count($lydata);$i++){ $rank_1_lyrics = $rank_1_lyrics.$lydata[$i];}
fclose($f1);
fclose($p1);
//No.2
$rank_2 = $lyrics_id[1];
$tank_2_name;
$f2 = fopen("./lyrics/$rank_2.txt",'r');
$p2 = fopen("./lyricscontent/$rank_2.txt",'r');
$rank_2_name = @iconv('Big5','UTF-8',fgets($f2));
$rank_2_lyrics = "";
fclose($f2);
$lydata = array();
while(!feof($p2)){
$lydata[] = @iconv('Big5','UTF-8',fgets($p2));
}
for($i=0;$i<count($lydata);$i++){ $rank_2_lyrics = $rank_2_lyrics.$lydata[$i];}
//No.3
$rank_3 = $lyrics_id[2];
$rank_3_name;
$f3 = fopen("./lyrics/$rank_3.txt",'r');
$rank_3_name = @iconv('Big5','UTF-8',fgets($f3));
$p3 = fopen("./lyricscontent/$rank_3.txt",'r');
$rank_3_lyrics = "";
fclose($f3);
$lydata = array();
while(!feof($p3)){
$lydata[] = @iconv('Big5','UTF-8',fgets($p3));
}
for($i=0;$i<count($lydata);$i++){ $rank_3_lyrics = $rank_3_lyrics.$lydata[$i];}
//echo "No.1:".$rank_1_name.'<br>';
//echo "No.2:".$rank_2_name.'<br>';
//echo "No.3:".$rank_3_name.'<br>';

$url_rank1 = "https://www.youtube.com/results?search_query=$rank_1_name";
$url_rank2 = "https://www.youtube.com/results?search_query=$rank_2_name";
$url_rank3 = "https://www.youtube.com/results?search_query=$rank_3_name";

$web_page_1 = http_get($url_rank1, $referer="");
$lyric_1 = parse_array($web_page_1['FILE'], '<h3 class="yt-lockup-title">', " </a>");

// __url__ is to remove ad link
for($i=0;$i<count($lyric_1);$i++){
$link_1 = explode("href=\"",$lyric_1[$i]);
if ( false !== ($rst = strpos($link_1[1],"__url__")) ){
continue;}
else{
$link_1 = explode("=",$link_1[1]);
$id_1 = strtok($link_1[1],"\"");
break;}
}

$web_page_2 = http_get($url_rank2, $referer="");
$lyric_2 = parse_array($web_page_2['FILE'], '<h3 class="yt-lockup-title">', " </a>");

// __url__ is to remove ad link
for($i=0;$i<count($lyric_2);$i++){
$link_2 = explode("href=\"",$lyric_2[$i]);
if ( false !== ($rst = strpos($link_2[1],"__url__")) ){
continue;}
else{
$link_2 = explode("=",$link_2[1]);
$id_2 = strtok($link_2[1],"\"");break;}
}

$web_page_3 = http_get($url_rank3, $referer="");
$lyric_3 = parse_array($web_page_3['FILE'], '<h3 class="yt-lockup-title">', " </a>");

// __url__ is to remove ad link
for($i=0;$i<count($lyric_3);$i++){
$link_3 = explode("href=\"",$lyric_3[$i]);
if ( false !== ($rst = strpos($link_3[1],"__url__")) ){
continue;}
else{
$link_3 = explode("=",$link_3[1]);
$id_3 = strtok($link_3[1],"\"");break;}
}



     //ouput
     $output = array();
     $output["0"] = array("song"=>$rank_1_name,"id"=>$id_1,"lyrics"=>$rank_1_lyrics);
     $output["1"] = array("song"=>$rank_2_name,"id"=>$id_2,"lyrics"=>$rank_2_lyrics);
     $output["2"] = array("song"=>$rank_3_name,"id"=>$id_3,"lyrics"=>$rank_3_lyrics);
     echo json_encode($output,JSON_UNESCAPED_UNICODE);
?>
