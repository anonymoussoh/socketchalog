<?php
//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

class html{
 private $get = array();
 private $startdate = array("year"=>"","month"=>"","day"=>"","hour"=>"","minute"=>"");
 private $enddate = array("year"=>"","month"=>"","day"=>"","hour"=>"","minute"=>"");
 private $check_searcharea = "";
 
 function __construct(){
 $this->get = $_GET;
 }
 //searchtypeのchecked属性検査
 function check_searchtype_name_ip(){
  if((isset($this->get['name']))||(isset($this->get['ip']))){
  return "checked";
  }else{
  return "";
  }
 }
 //searchtypeのnameかipかのcheck属性検査
 function check_nameorip(){
  if(isset($this->get['ip'])){
  return array("","checked");
  }else{
  return array("checked","");
  }
 }
 //name_ipに代入されるのはnameかipか
 function name_ip(){
  if(isset($this->get['name'])){
  return $this->get['name'];
  }else if(isset($this->get['ip'])){
  return $this->get['ip'];
  }else{
  return "";
  }
 }
 //commentのchecked属性検査
 function check_comment(){
  if(isset($this->get['comment'])){
  return "checked";
  }else{
  return "";
  }
 }
 //commentに代入される文字
 function comment(){
  if(isset($this->get['comment'])){
  return $this->get['comment'];
  }else{
  return "";
  }
 }
 //valueの大きさ
 function value(){
  if(isset($this->get['value'])){
  return $this->get['value'];
  }else{
  return "500";
  }
 }
 //getdateで連想配列として日時が出てくるのでそれをあらかじめ用意した配列に代入
 //1000で割ってるのはミリ秒→秒
 function calc_date(){
  if(isset($this->get['starttime'])){
  $temp_starttime = getdate($this->get['starttime']);
  $this->startdate['minute'] = $temp_starttime['minutes'];
  $this->startdate['hour'] = $temp_starttime['hours'];
  $this->startdate['day'] = $temp_starttime['mday'];
  $this->startdate['month'] = $temp_starttime['mon'];
  $this->startdate['year'] = $temp_starttime['year'];
  $this->check_searcharea = "checked";
  }
  if(isset($this->get['endtime'])){
  $temp_endtime = getdate($this->get['endtime']);
  $this->enddate['minute'] = $temp_endtime['minutes'];
  $this->enddate['hour'] = $temp_endtime['hours'];
  $this->enddate['day'] = $temp_endtime['mday'];
  $this->enddate['month'] = $temp_endtime['mon'];
  $this->enddate['year'] = $temp_endtime['year'];
  $this->check_searcharea = "checked";
  }
 }


function header(){
 print <<<END
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
 <link rel="STYLESHEET" href="design.css" type="text/css">
<title>Lograhack NEO(Beta) LHN-1</title>
<script type='text/javascript'>
function preload(){
today = new Date();
year = today.getFullYear();
month = today.getMonth();
month++;
day = today.getDate();
if(document.query.maxyear.value==""){
document.query.maxyear.value = year;
}
if(document.query.maxmonth.value==""){
document.query.maxmonth.value = month;
}
if(document.query.maxday.value==""){
document.query.maxday.value = day;
}
if(document.query.minyear.value==""){
document.query.minyear.value = year;
}
if(document.query.minmonth.value==""){
document.query.minmonth.value = month;
}
if(document.query.minday.value==""){
document.query.minday.value = day;
}
}

function send_query(){
maxyear = document.query.maxyear.value;
maxmonth = document.query.maxmonth.value;
maxmonth--;
maxday = document.query.maxday.value;
maxhour = document.query.maxhour.value;
maxminute = document.query.maxminute.value;
maxDate = new Date(parseInt(maxyear),parseInt(maxmonth),parseInt(maxday),parseInt(maxhour),parseInt(maxminute));
maxtime = maxDate.getTime();

minyear = document.query.minyear.value;
minmonth = document.query.minmonth.value;
minmonth--;
minday = document.query.minday.value;
minhour = document.query.minhour.value;
minminute = document.query.minminute.value;
minDate = new Date(parseInt(minyear),parseInt(minmonth),parseInt(minday),parseInt(minhour),parseInt(minminute));
mintime = minDate.getTime();

 var url = "chalog.php?"
 if(document.query.searcharea.checked){
  if(mintime){
  url += "starttime=" + mintime;
  }
  if((mintime)&&(maxtime)){
  url += "&";
  }
  if(maxtime){
  url += "endtime=" + maxtime;
  }
 url += "&";
 }
 if(document.query.searchtype[0].checked){
  if(document.query.nameorip[0].checked){
  url += "name="+encodeURIComponent(document.query.name_ip.value);
  }
  if((document.query.nameorip[0].checked==true)&&(document.query.nameorip[1].checked==true)){
  url += "&";
  }
  if(document.query.nameorip[1].checked){
  url += "ip="+escape(document.query.name_ip.value);
  }
 url += "&";
 }
 if((document.query.searchtype[1].checked==true)&&(document.query.comment.value)){
 url += "comment="+encodeURIComponent(document.query.comment.value)+"&";
 }
 if(document.query.latest.value){
  if(parseInt(document.query.latest.value)>5000){
  url += "value=5000&page=0";
  }else{
  url += "value="+document.query.latest.value+"&page=0";
  }
 }else{
 url += "value=500&page=0";
 }
 location.href = url;
 return false;
}
</script>
<!--(form要素).addEventListener("submit", function(e){処理; e.preventDefault();})-->
</head>
<body onload="preload();">
<h1>Lograhack NEO(Beta) LHN-1</h1>
END;
}

function footer(){
 print <<<END

</body>
</html>

END;

}

function top(){
//冒頭のfunctionで検査したものの返り値をここで代入したりとかですね
$check_searchtype_name_ip =  $this->check_searchtype_name_ip();
list($check_name,$check_ip) =  $this->check_nameorip();
$name_ip = $this->name_ip();
$check_comment = $this->check_comment();
$comment = $this->comment();
$value = $this->value();
$this->calc_date();
 print <<<END
<p>Javascriptが使用できることが必要動作条件です。</p>
<form name='query' action='#' onsubmit="return send_query();">
<fieldset><legend>取得範囲</legend>
<p><label><input type="checkbox" name="searcharea" value="time"  {$this->check_searcharea}>発言時間で検索</label>：
始点時間<input type="text" name="minyear" value="{$this->startdate['year']}" size="6">年
<input type="text" name="minmonth" value="{$this->startdate['month']}" size="4">月
<input type="text" name="minday" value="{$this->startdate['day']}" size="4">日
<input type="text" name="minhour" value="{$this->startdate['hour']}" size="4">時
<input type="text" name="minminute" value="{$this->startdate['minute']}" size="4">分
終点時間<input type="text" name="maxyear" value="{$this->enddate['year']}" size="6">年
<input type="text" name="maxmonth" value="{$this->enddate['month']}" size="4">月
<input type="text" name="maxday" value="{$this->enddate['day']}" size="4">日
<input type="text" name="maxhour" value="{$this->enddate['hour']}" size="4">時
<input type="text" name="maxminute" value="{$this->enddate['minute']}" size="4">分<br>
<ul>
<li>am/pmの12時間制ではなく24時間制で入力をお願いします。</li>
<li>最小に空白の欄があると最大までの24時間分を取得します</li>
<li>最大に空白の欄があると最小からの24時間分を取得します。</li>
<li>両方空白の欄があると最新24時間分を取得します。</li>
<li>チェックがなされない場合は新しいほうから取得します。</li></ul>
</fieldset>
<fieldset><legend>検索条件</legend>
<p><input type="checkbox" name="searchtype" {$check_searchtype_name_ip}><label><input type="radio" name="nameorip" value="name" {$check_name}>名前</label>or<label><input type="radio" name="nameorip" value="ip" {$check_ip}>IPアドレス</label>で検索：<input type="text" name="name_ip" value="{$name_ip}" size="15"></p>
<p><label><input type="checkbox" name="searchtype" {$check_comment}>コメントで検索</label>：<input type="text" name="comment" value="{$comment}" size="30"></p>
<p>上の「名前で検索」と併用すると「特定人物の特定内容の発言」が抜き出されます。</p>
<p>ここでいずれも指定しない場合、上記範囲の全文が表示されます。</p>
</fieldset>
<fieldset><legend>ページあたりの表示件数</legend>
<p><input type="text" name="latest" value="{$value}" size="8">件<br>
空欄だと500件を表示します。最大で5000行までです。</p>
</fieldset>
<input type="submit" value="送信">
</form>
END;
}

function logview(){
//クエリ組立
$query_url = "";
$query_url_array = array();
$flag = false;
 if((isset($this->get['starttime']))&&(is_numeric($this->get['starttime']))){
 $query_url_array[] = "starttime=".$this->get['starttime']*1000;
 $flag = true;
 }
 if((isset($this->get['endtime']))&&(is_numeric($this->get['endtime']))){
 $query_url_array[] = "endtime=".$this->get['endtime']*1000;
 $flag = true;
 }
 if(isset($this->get['name'])){
 $query_url_array[] = "name=".rawurlencode($this->get['name']);
 $flag = true;
 }
 if(isset($this->get['ip'])){
 $query_url_array[] = "ip=".$this->get['ip'];
 $flag = true;
 }
 if(isset($this->get['comment'])){
 $query_url_array[] = "comment=".rawurlencode($this->get['comment']);
 $flag = true;
 }
 if(isset($this->get['value'])){
 $query_url_array[] = "value=".$this->get['value'];
 }
 $query_url_without_page = implode("&",$query_url_array);
 if(isset($this->get['page'])){
 $query_url = $query_url_without_page."&page=".$this->get['page'];
 }else{
 $query_url = $query_url_without_page;
 }
$raw_data = file_get_contents("http://81.la:8001/chalog?".$query_url);
$data = json_decode($raw_data,true);
//表示部
echo "<table>";
echo "<caption>検索条件</caption>";
if(isset($this->get['name'])){
echo "<tr><th>名前</th><td>".htmlspecialchars($this->get['name'],ENT_QUOTES,"UTF-8")."</td></tr>";
}
if(isset($this->get['ip'])){
echo "<tr><th>IPアドレス</th><td>".htmlspecialchars($this->get['ip'],ENT_QUOTES,"UTF-8")."</td></tr>";
}
if(isset($this->get['comment'])){
echo "<tr><th>コメント</th><td>".htmlspecialchars($this->get['comment'],ENT_QUOTES,"UTF-8")."</td></tr>";
}
if(isset($this->get['starttime'])){
echo "<tr><th>始点時刻</th><td>".date("Y-m-d H:i:s",$this->get['starttime'])."</td></tr>";
}
if(isset($this->get['endtime'])){
echo "<tr><th>終点時刻</th><td>".date("Y-m-d H:i:s",$this->get['endtime'])."</td></tr>";
}
 if(!$flag){
 echo "<tr><td style='text-align:center;'>条件なし</td></tr>";
 }
echo "</table>";
 echo "<p style='text-align:center;'>";
 if((isset($this->get['page']))&&((int)$this->get['page']!==0)){
 echo "<a href='chalog.php?".$query_url_without_page."&page=".($this->get['page']-1)."'>前へ</a>";
 }else{
 echo "前へ";
 }
 echo "■";
 if(count($data['logs'])<$this->get['value']){
 echo "次へ";
 }else{
  if(!isset($this->get['page'])){
  $this->get['page'] = 0;
  }
 echo "<a href='chalog.php?".$query_url_without_page."&page=".($this->get['page']+1)."'>次へ</a>";
 }
 echo "</p>";
 echo "<p style='line-height:1.2;letter-spacing:0.5px;'>";
 $n = 1;
 foreach($data['logs'] as $log){
  try{
  $date = new DateTime($log['time']);
  }catch (Exception $e){
  echo $e->getMessage();
  die(1);
  }
 $unixtime = $date->getTimestamp();
 $line_number = sprintf("%04d",$n);
 $color = explode(".",$log['ip']);
 $r = intval($color[0]/1.33);
 $g = intval($color[1]/1.33);
 $b = intval($color[2]/1.33);
 $date = date("Y-m-d H:i:s",$unixtime);
  if(is_array($log['comment'])){
  $comment = htmlspecialchars($log['comment'][0],ENT_QUOTES,"UTF-8");
  }else{
  $comment = htmlspecialchars($log['comment'],ENT_QUOTES,"UTF-8");
  }
  //開きタグを本物に変換する作業
  $fake_tag = array("[small]","[s]","[/s]","[code]","[/code]");
  $real_tag = array("<small>","<s>","</s>","<code>","</code>");
  $comment = str_replace($fake_tag,$real_tag,$comment);
  //URLをリンクにする作業
//  $comment = preg_replace("/(https?:\/\/[\w\.\/#!\?\-=%&:\+\~]*)/ui","<a href='$1'>$1</a>",$comment);
  $comment = preg_replace("/^https?:\/\/\S+/u","<a href='$1'>$1</a>",$comment);
  $comment = preg_replace("/<a href='(http:\/\/myazo\.net\/\w+(.png)?)'>.+<\/a>/ui","<a href='$1'>[Myazo]</a>",$comment);
  $comment = preg_replace("/<a href='(http:\/\/gyazo\.com\/\w+(.png)?)'>.+<\/a>/ui","<a href='$1'>[Gyazo]</a>",$comment);
  //閉じタグを開きタグの数に合わせて文末にセットする作業
  $small_tag_count = substr_count($comment,"<small>");
   while($small_tag_count){
    $comment .= "</small>";
   $small_tag_count--;
   }
  $strike_tag_count = substr_count($comment,"<s>");
   while($strike_tag_count){
    $comment .= "</s>";
   $strike_tag_count--;
   }
  $code_tag_count = substr_count($comment,"<code>");
   while($code_tag_count){
    $comment .= "</code>";
   $code_tag_count--;
   }
 $before_term = $unixtime - 30*60;
 $after_term = $unixtime + 30*60;
 $detail_query = "chalog.php?starttime=".$before_term."&endtime=".$after_term."&value=500";
 echo "<a href='".$detail_query."' target='_blank'>".$line_number."</a>：";
 echo "<span style='color:rgb(".$r.",".$g.",".$b.");'><b>".$log['name']."</b>>&nbsp;";
 echo $comment;
 echo "</span>&nbsp;<span style='color:silver;font-size:small;'>(".$date.",".$log['ip'].")</span><br>\n";
 $n++;
 }
 echo "</p>";
}

}

class main{

 function execute(){
 $html = new html();
  if(isset($_GET['value'])){
  $html->header();
  $html->top();
  $html->logview();
  $html->footer();
  }else{
  $html->header();
  $html->top();
  $html->footer();
  }
 }
}

$main = new main();
$main->execute();