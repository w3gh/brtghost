<?php


function get_info()
{
	//return "|gamesinfo|--|-ar 1                           ,123,11121314143132515253,,|--|-ar 2                           ,123,1131,,|--|";

   $socketD = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP); 


   if($socketD === FALSE) { 
       echo 'socket_create failed: '.socket_strerror(socket_last_error())."\n";
       return "err";
   }
  
   if(!socket_bind($socketD, "127.0.0.1", 6973)) { // todo ВЫНЕСТИ В КОНФИГ, настройки слушаешего адреса
       socket_close($socketD);
       echo 'socket_bind failed: '.socket_strerror(socket_last_error())."\n";
       return "err";
   }
  
	$fp = fsockopen('udp://127.0.0.1', 6969);  // todo ВЫНЕСТИ В КОНФИГ настройки командного адреса

	if($fp)
	{
  		 fputs($fp, "||127.0.0.1 sendgamesstatus");
   		 fclose($fp);
	}

   socket_recvfrom($socketD, $buf, 65535, 0, $clientIP, $clientPort);

   if($buf === FALSE) { 
       echo 'socket_read() returned false : '.socket_strerror(socket_last_error())."\n";
       return "err";
   } elseif(strlen($buf) === 0) { 
       echo 'socket_read() returned an empty string : '.socket_strerror(socket_last_error())."\n";
       return "err";
   }

   if(!socket_connect($socketD, $clientIP, $clientPort)) {
           socket_close($socketD);
       return "err";
   }

  return $buf;

}

$create_cache = 1;
$read_cache = 0;
$cache_time = 60; //seconds
$out = "";

/*
$db = mysql_connect('localhost', 'mysql_user', 'mysql_password'); //менять тут!
if (!$db)
{ 
	$create_cache = 0;
}else{
	mysql_select_db('YOUR_DB', $db); //менять тут!
	$result = mysql_query("SELECT time, cache FROM cache WHERE name='mainstat'"); 
	$row = mysql_fetch_assoc($result)
	if (mysql_num_rows($result) == 0)
	{
		mysql_query("INSERT INTO cache (name, cache, time) VALUES ('mainstats', '', ".(time()).")");
	}else if($row['time'] < time() - $cache_time){
		$read_cache = 1;
		$out = row['cache'];
		mysql_close($db);
	}
}
	

*/

if(!$read_cache)
{
	$i = 10;
	while($i){	
		$games_arr = explode("|--|", get_info());
		if($games_arr[0] == "|gamesinfo") break;
		$i--;
	}
	if(!$i) die("");
	$games = Array();
	foreach(array_slice($games_arr, 1) as $g=>$v)
	{
		if($v == "") continue;
		$games[] = explode(",", $v);    //  $games[] = array_merge($buf, explode(",", substr($v, 33)));
		//print_r($games);
	}
	foreach($games as $g=>$v)
	{
		$out .= "Game name: ".trim($v[0])."<br />";
		$out .= "Game time: ".trim($v[2])."<br />";
		$out .= "<img src='map_img.php?kt=".trim($v[1])."' /><br /><br />";
	}
	/*
	if(create_cache)
	{
		mysql_query("UPDATE cache SET cache=".$out.", time=".(time())." WHERE name='mainstat'"); 
		mysql_close($db);
	}
	*/
}

echo $out;
?>
