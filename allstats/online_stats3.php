<?php


require_once("config.php");

function get_info($bot)
{

   global $socketD;

   if($socketD === FALSE) return "";
  
   if(!socket_bind($socketD,$bot['ip_in'], $bot['port_in'])) {
       socket_close($socketD);
       return "err";
   }
  
	$fp = fsockopen('udp://'.$bot['ip_out'], $bot['port_out']);  // todo ВЫНЕСТИ В КОНФИГ настройки командного адреса

	if($fp)
	{
                fputs($fp, "||".$bot['ip_in']." connect ".$bot['password']);
  		fputs($fp, "||".$bot['ip_in']." sendgamesstatus");

   		fclose($fp);

		socket_set_nonblock($socketD);
		$timeout = time() + (2);  // wait for 2 sec

		while (time() <= $timeout)
		{
		   $buf = "";

		   socket_recv($socketD, $buf, 65535, 0);
		   socket_recv($socketD, $buf, 65535, 0);

     		   if ($buf != "") break;

		   usleep(1000);
		}

		socket_set_block($socketD);



	}

   if($buf === FALSE) return "";
    elseif(strlen($buf) === 0)
       return "";





  return $buf;
}


/* Получаем статы от бота. */
function get_stats($bot)
{
	$games = Array();
	$i = 10;
	while($i){	
		$games_arr = explode("|--|", get_info($bot));
		if($games_arr[0] == "|gamesinfo") break;
		$i--;
	}
	if(!$i) return False;
	
	foreach(array_slice($games_arr, 1) as $g=>$v)
	{
		if($v == "") continue;
		$games[] = explode(",", $v);    //  $games[] = array_merge($buf, explode(",", substr($v, 33)));
		//print_r($games);
	}
	return $games;
}

/* Формируем результат в HTML. */
function print_stats($stats, $bot_name){
	global $stats_counter;
	$out = "<tr>";
	foreach($stats as $g=>$v)
	{
		
		$stats_counter++;

		if ($stats_counter%2 != 0) $out .= "</tr><tr>"; 
		
		$out .= "<th><font color=white>";
		$out .= "Game name: ".trim($v[0])." <br />";
		$out .= "Game time: ".(floor((int)trim($v[2]) / 60))." min ".((int)trim($v[2]) % 60)." sec <br />";
		$out .= "Bot: ".$bot_name." Creator: ".trim($v[3])."<br />";
		$out .= "<img src='map_img.php?kt=".trim($v[1])."' /></font></th>";

		

	}
	$out .= "</tr>";

	return $out;
}


/* Проверяем работает ли бот. */
function isBotAlive($bot)
{

   $socketD = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP); 

   if($socketD === FALSE)  return false;

   if(!socket_bind($socketD,$bot['ip_in'], $bot['port_in'])) {
       socket_close($socketD);
       return false;
   }
  
	$fp = fsockopen('udp://'.$bot['ip_out'], $bot['port_out']);  


	if($fp)
	{
		fputs($fp,"||".$bot['ip_in']." connect ".$bot['password']);
		fputs($fp,"||".$bot['ip_in']." ping");

   		fclose($fp);

		socket_set_nonblock($socketD);
		$timeout = time() + (2);  // wait for 0.5 sec

		while (time() <= $timeout)
		{
		   $buf = "";

		   socket_recv($socketD, $buf, 65535, 0);
		   socket_recv($socketD, $buf, 65535, 0);

     		   if ($buf != "") break;

		   usleep(1000); // 100ms delay keeps the doctor away
		}

		socket_set_block($socketD);

	}

   if($buf === FALSE)  return false;
    elseif(strlen($buf) === 0) 
       return false;


   if(!socket_connect($socketD, $clientIP, $clientPort)) {
           socket_close($socketD);
    //   return false;
   }

  return true;

}

/************************************ Start here ***************************************/
//require_once('conf.php');

$create_cache = 1;
$read_cache = 0;
$cache_time = 60; //seconds
$out = "";
$stats_counter = 0;
$socketD = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

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
	foreach($bots as $b=>$bot)
	{

			$stats = get_stats($bot);
			if($stats)
			{
				echo print_stats($stats, $bot['name']);
				flush();

			}


	}
	
	/*
	if(create_cache)
	{
		mysql_query("UPDATE cache SET cache=".$out.", time=".(time())." WHERE name='mainstat'"); 
		mysql_close($db);
	}
	*/
}

if ($socketD) socket_close($socketD);

echo $out;
?>
