function preload(){
 var today = new Date();
 var year = today.getFullYear();
 var month = today.getMonth();
 month++;
 var day = today.getDate();
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
 var maxyear = document.query.maxyear.value || 2010;
 var maxmonth = document.query.maxmonth.value || 1;
 maxmonth--;
 var maxday = document.query.maxday.value || 1;
 var maxhour = document.query.maxhour.value || 1;
 var maxminute = document.query.maxminute.value || 0;
 var maxDate = new Date(parseInt(maxyear),parseInt(maxmonth),parseInt(maxday),parseInt(maxhour),parseInt(maxminute));
 var maxtime = maxDate.toISOString();

 var minyear = document.query.minyear.value || 2010;
 var minmonth = document.query.minmonth.value || 1;
 minmonth--;
 var minday = document.query.minday.value || 1;
 var minhour = document.query.minhour.value || 0;
 var minminute = document.query.minminute.value || 0;
 var minDate = new Date(parseInt(minyear),parseInt(minmonth),parseInt(minday),parseInt(minhour),parseInt(minminute));
 var mintime = minDate.toISOString();
 
 var url = "chalog.php?"
 var query_array = [];
 if(document.query.searcharea.checked){
  if(mintime){
  query_array.push("starttime=" + mintime);
  }
  if(maxtime){
  query_array.push("endtime=" + maxtime);
  }
 }
 
 if(document.query.searchtype[0].checked){
  if(document.query.nameorip[0].checked){
  query_array.push("name="+encodeURIComponent(document.query.name_ip.value));
  }
  if(document.query.nameorip[1].checked){
  query_array.push("ip="+escape(document.query.name_ip.value));
  }
 }
 
 if((document.query.searchtype[1].checked==true)&&(document.query.comment.value)){
 query_array.push("comment="+encodeURIComponent(document.query.comment.value));
 }
 
 if(document.query.latest.value){
  if(parseInt(document.query.latest.value)>5000){
  query_array.push("value=5000&page=0");
  }else{
  query_array.push("value="+document.query.latest.value+"&page=0");
  }
 }else{
 query_array.push("value=500&page=0");
 }
 
 var query_string = query_array.join('&');
 location.href = url + query_string;
 return false;
}