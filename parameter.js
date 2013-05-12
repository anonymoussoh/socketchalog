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