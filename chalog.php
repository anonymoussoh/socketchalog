<?php
//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

class html{
 private $parameter = array();
 private $check_searcharea = "";
 private $date = array("start"=>array(),"end"=>array());
 
 function __construct(){
 $this->parameter = $_GET;
 }
 //searchtypeのchecked属性検査
 function check_searchtype_name_ip(){
  if((isset($this->parameter['name']))||(isset($this->parameter['ip']))){
  return "checked";
  }
 return "";
 }
 //searchtypeのnameかipかのcheck属性検査
 function check_nameorip(){
  if(isset($this->parameter['ip'])){
  return array("","checked");
  }else{
  return array("checked","");
  }
 }
 //name_ipに代入されるのはnameかipか
 function name_ip(){
  if(isset($this->parameter['name'])){
  return $this->parameter['name'];
  }else if(isset($this->parameter['ip'])){
  return $this->parameter['ip'];
  }else{
  return "";
  }
 }
 //commentのchecked属性検査
 function check_comment(){
  if(isset($this->parameter['comment'])){
  return "checked";
  }
 return "";
 }
 //commentに代入される文字
 function comment(){
  if(isset($this->parameter['comment'])){
  return $this->parameter['comment'];
  }
 return "";
 }
 //valueの大きさ
 function value(){
  if(isset($this->parameter['value'])){
  return $this->parameter['value'];
  }
 return "500";
 }
 //getdateで連想配列として日時が出てくるのでそれをあらかじめ用意した配列に代入
 //1000で割ってるのはミリ秒→秒
 function calc_date(){
  if(isset($this->parameter['starttime'])){
  $start_date = new DateTime($this->parameter['starttime']);
  $start_timestamp = $start_date->getTimestamp();
  $this->date['start'] = getdate($start_timestamp);
  $this->check_searcharea = "checked";
  }
  if(isset($this->parameter['endtime'])){
  $end_date = new DateTime($this->parameter['endtime']);
  $end_timestamp = $end_date->getTimestamp();
  $this->date['end'] = getdate($end_timestamp);
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
<script type='text/javascript' src='parameter.js'></script>
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
<p><a href='chalog.php'>chalog.php</a></p>
<form name='query' action='#' onsubmit="return send_query();">
<fieldset><legend>取得範囲</legend>
<p><label><input type="checkbox" name="searcharea" value="time"  {$this->check_searcharea}>発言時間で検索</label>：
始点時間<input type="text" name="minyear" value="{$this->date['start']['year']}" size="6">年
<input type="text" name="minmonth" value="{$this->date['start']['mon']}" size="4">月
<input type="text" name="minday" value="{$this->date['start']['mday']}" size="4">日
<input type="text" name="minhour" value="{$this->date['start']['hours']}" size="4">時
<input type="text" name="minminute" value="{$this->date['start']['minutes']}" size="4">分

終点時間<input type="text" name="maxyear" value="{$this->date['end']['year']}" size="6">年
<input type="text" name="maxmonth" value="{$this->date['end']['mon']}" size="4">月
<input type="text" name="maxday" value="{$this->date['end']['mday']}" size="4">日
<input type="text" name="maxhour" value="{$this->date['end']['hours']}" size="4">時
<input type="text" name="maxminute" value="{$this->date['end']['minutes']}" size="4">分<br>
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
<p><label><input type="checkbox" name="searchtype">タグで検索</label>：<input type="text" name="channel" value="" size="30"></p>
<p>上の「名前で検索」と併用すると「特定人物の特定内容の発言」が抜き出されます。</p>
<p>ここでいずれも指定しない場合、上記範囲の全文が表示されます。</p>
</fieldset>
<fieldset><legend>ページあたりの表示件数</legend>
<p><input type="text" name="latest" value="{$value}" size="8">件<br>
空欄だと500件を表示します。最大で5000行までです。</p>
</fieldset>
<input type="submit" value="検索">
</form>
END;
}

 function logview(){
 //表示部
 echo "<table>";
 echo "<caption>検索条件</caption>";
 if(isset($this->parameter['name'])){
 echo "<tr><th>名前</th><td>".htmlspecialchars($this->parameter['name'],ENT_QUOTES,"UTF-8")."</td></tr>";
 }
 if(isset($this->parameter['ip'])){
 echo "<tr><th>IPアドレス</th><td>".htmlspecialchars($this->parameter['ip'],ENT_QUOTES,"UTF-8")."</td></tr>";
 }
 if(isset($this->parameter['comment'])){
 echo "<tr><th>コメント</th><td>".htmlspecialchars($this->parameter['comment'],ENT_QUOTES,"UTF-8")."</td></tr>";
 }
 if(isset($this->parameter['starttime'])){
  $start_date = new DateTime($this->parameter['starttime']);
  $start_timestamp = $start_date->getTimestamp();
 echo "<tr><th>始点時刻</th><td>".date('Y-m-d H:i:s',$start_timestamp)."</td></tr>";
 }
 if(isset($this->parameter['endtime'])){
  $end_date = new DateTime($this->parameter['endtime']);
  $end_timestamp = $end_date->getTimestamp();
 echo "<tr><th>終点時刻</th><td>".date('Y-m-d H:i:s',$end_timestamp)."</td></tr>";
 }

  if(count($this->parameter)===2 && array_keys($this->parameter) === array('value','page')){
  echo "<tr><td style='text-align:center;'>条件なし</td></tr>";
  }
 
 echo "</table>";
 
 //クエリ組み立てインスタンス
 $query = new query($this->parameter);
 $data = $query->fetch_data();
 $query_url_without_page = $query->get_query();
// var_dump($query_url_without_page);

 echo "<p style='text-align:center;'>";
  if((isset($this->parameter['page']))&&((int)$this->parameter['page']!==0)){
  echo "<a href='chalog.php?".$query_url_without_page."&page=".($this->parameter['page']-1)."'>前へ</a>";
  }else{
  echo "前へ";
  }
 echo "■";
  if(count($data['logs'])<$this->parameter['value']){
  echo "次へ";
  }else{
   if(!isset($this->parameter['page'])){
   $this->parameter['page'] = 0;
   }
  echo "<a href='chalog.php?".$query_url_without_page."&page=".($this->parameter['page']+1)."'>次へ</a>";
  }
 echo "</p>";
 echo "<p style='line-height:1.2;letter-spacing:0.5px;'>";
 $n = 1;
 foreach($data['logs'] as $log){
 $record_date = new DateTime($log['time']);
 $record_unixtime = $record_date->getTimestamp();
 $line_number = sprintf("%04d",$n);
 $r = 0; $g = 0; $b = 0;
  if(!empty($log['ip'])){
  $color = explode(".",$log['ip']);
  $r = intval($color[0]/1.33);
  $g = intval($color[1]/1.33);
  $b = intval($color[2]/1.33);
  }
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

 $range_start = date("Y-m-d\TH:i:s\Z",$record_unixtime - 30*60 - 60 * 60 * 9);
 $range_end = date("Y-m-d\TH:i:s\Z",$record_unixtime + 30*60 - 60 * 60 * 9);
 $detail_query = "chalog.php?starttime=".$range_start."&endtime=".$range_end."&value=500";
 echo "<a href='".$detail_query."' target='_blank'>".$line_number."</a>：";
 echo "<span style='color:rgb(".$r.",".$g.",".$b.");'><b>".$log['name']."</b>>&nbsp;";
 echo $comment;
 echo "</span>&nbsp;<span style='color:silver;font-size:small;'>(".date("Y-m-d H:i:s",$record_unixtime).",".$log['ip'].")</span><br>\n";
 $n++;
 }
 echo "</p>";
 }

}

//クエリ組立

class query{
 private $query_url = "";
 private $query_url_without_page = "";
 private $query_url_array = array();
 private $parameter;
 
 function __construct($parameter){
 $this->parameter = $parameter;
 }
 
 function interprete_time(){
  if(isset($this->parameter['starttime'])){
  $this->query_url_array[] = "starttime=".$this->parameter['starttime'];
  }
  if(isset($this->parameter['endtime'])){
  $this->query_url_array[] = "endtime=".$this->parameter['endtime'];
  }
 }
 
 private function interprete_parameter($key){
 $this->query_url_array[] = $key."=".rawurlencode($this->parameter[$key]);
 }
 
 private function build_query(){
 $this->interprete_time();
 $key_list = array('name','ip','comment','value');
  foreach($key_list as $key){
   if(isset($this->parameter[$key])){
   $this->interprete_parameter($key);
   }
  }
 
 $this->query_url_without_page = implode("&",$this->query_url_array);
  if(isset($this->parameter['page'])){
  $this->query_url = $this->query_url_without_page."&page=".$this->parameter['page'];
  }else{
  $this->query_url = $this->query_url_without_page;
  }
 }
 
 function get_query(){
 return $this->query_url_without_page;
 }
 
 function fetch_data(){
 $this->build_query();
 $raw_data = file_get_contents("http://chat.81.la/chalog?".$this->query_url);
 $data = json_decode($raw_data,true);
 return $data;
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