<?php 
/*********************************************
<!-- 
*   	DOTA ALLSTATS
*   
*	Developers: Reinert, Dag Morten, Netbrain, Billbabong, Boltergeist.
*	Contact: developer@miq.no - Reinert
*
*	
*	Please see http://www.codelain.com/forum/index.php?topic=4752.0
*	and post your webpage there, so I know who's using it.
*
*	Files downloaded from http://code.google.com/p/allstats/
*
*	Copyright (C) 2009-2010  Reinert, Dag Morten , Netbrain, Billbabong, Boltergeist
*
*	
* Replay Parser:
* - Modified for GHost++ Replays by googlexx
* -------------------------------------------------------------------------------
* Based on:
* - RESHINE parser - http://reshine.bunglon.net
* - Warcraft III Replay Parser By Julas
* - DOTA Replay Parser By Rush4Hire 
*
*
*	This file is part of DOTA ALLSTATS.
*
* 
*	 DOTA ALLSTATS is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    DOTA ALLSTATS is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with DOTA ALLSTATS.  If not, see <http://www.gnu.org/licenses/>
*
-->
**********************************************/
if($dbType == 'sqlite')
{
	$gid=sqlite_escape_string($_GET["gid"]);
}
else
{
	$gid=mysql_real_escape_string($_GET["gid"]);
}
require_once("functions.php");
require_once("config.php");

$scourge=true;
$sentinel=true;
$sql = "SELECT winner, creatorname, duration, datetime, gamename
FROM dotagames AS c LEFT JOIN games AS d ON d.id = c.gameid where c.gameid='$gid'";

if($dbType == 'sqlite')
{
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$creatorname=$row["creatorname"];
		$duration=$row["duration"];
		$gametime=$row["datetime"];
		$gamename=$row["gamename"];
		$win=$row["winner"];
	}
}
else
{
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$creatorname=$row["creatorname"];
		$duration=$row["duration"];
		$gametime=$row["datetime"];
		$gamename=$row["gamename"];
		$win=$row["winner"];
	}
}
	
$gametimenew = substr(str_ireplace(":","-",$gametime),0,16);


//REPLAY NAME HANDLING CODE
$replaygamename=str_ireplace("|","_",str_ireplace(">","_",str_ireplace("<","_",str_ireplace("?","_",str_ireplace("*","_",str_ireplace(":","_",str_ireplace("/","_",str_ireplace("\\","_",$gamename))))))));
$replayloc="GHost++ ".$gametimenew." ".$replaygamename." (".replayDuration($duration).").w3g";

if(!file_exists($replayLocation.'/'.$replayloc))
{													//Time handling isn't perfect. Check time + 1 and time - 1
	$replayloc="GHost++ ".$gametimenew." ".$replaygamename." (".replayDuration($duration-1).").w3g";
	if(!file_exists($replayLocation.'/'.$replayloc))
	{
		$replayloc="GHost++ ".$gametimenew." ".$replaygamename." (".replayDuration($duration+1).").w3g";
		if(!file_exists($replayLocation.'/'.$replayloc))
		{
			$replayloc="GHost++ ".$gametimenew." ".$replaygamename.".w3g";
		}
	}
}
$replayurl = $replayLocation.'/'.str_ireplace("#","%23", str_ireplace("\\","_",str_ireplace("/","_",str_ireplace(" ","%20",$replayloc))));
$replayloc = $replayLocation.'/'.str_ireplace("\\","_",str_ireplace("/","_",$replayloc));
?>

<div class="header" id="header">
	<table width=1016px>
	<tr>
	<td colspan=6>
	<table class="rowuh" width=100%>
		<tr>
			<td width=25%>
			<?php
			if(file_exists($replayloc))
			{
				print '<a href="javascript:displayIds(\'gameInfo\',\'blank\')">Toggle Game Recap</a>';
			}
			?>
			</td>
			<td width=50%>
				<h2><?php print $phrase1.": ".$gamename; ?></h2>
			</td>
			<td width=25%>
			<?php
			if(file_exists($replayloc))
			{
				print '<a href="javascript:displayhid(\'chat\')">Toggle Game Log</a>';
			}
				?>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	<tr class="rowuh" style="border-top: 1px solid #EBEBEB;">
		<td>
		  <?php print $phrase2.":&nbsp; ".$gamename; ?>
		</td>
		<td>
		  <?php print $phrase3.":&nbsp;".$gametime; ?> 
		<td>
		<td>
		  <?php print $phrase4.":&nbsp;".$creatorname; ?>
		</td>
		<td>
		  <?php print $phrase5.":&nbsp;".secondsToTime($duration); ?>
		</td>
		
		  <?php 
		  //only show the link if the replay feature is enabled in config.php and it actually exists
		  if(file_exists($replayloc)){ ?>
		  <td><a href=<?php print $replayurl;?>><?php print $phrase6;?></a></td>
		  <?php } //end of enablefeature ?> 

	</tr>
</table>
</div>
<div class="pageholder" id="pageholder">
	<div id="theader">	
	</div>
	<div id="datawrapper">
		<div id="gameInfo" class="shown">
			<table class="tableheader" id="tableheader">
				<tr>
					<td class="headercell" width=150px><?php print $phrase7;?></td>
					<td class="headercell" width=40px><?php print $phrase8;?></td>
					<td class="headercell" width=60px><?php print $phrase9;?></td>
					<td class="headercell" width=60px><?php print $phrase10;?></td>
					<td class="headercell" width=60px><?php print $phrase11;?></td>
					<td class="headercell" width=60px><?php print $phrase12;?></td>
					<td class="headercell" width=60px><?php print $phrase13;?></td>
					<td class="headercell" width=60px><?php print $phrase14;?></td>
					<td class="headercell" width=60px><?php print $phrase15;?></td> 
					<td class="headercell" width=60px><?php print $phrase16;?></td>
					<td class="headercell" width=170x><?php print $phrase17;?></td>
					<td class="headercell" width=60px><?php print $phrase18;?></td>
					<td class="headercell" width=100px><?php print $phrase19;?></td>	
				</tr>
			</table>
			<table class="table" id="data">
	
<?php
$sql = "SELECT winner, a.gameid, b.colour, newcolour, 
original as hero, description, kills, deaths, assists, creepkills, creepdenies, neutralkills, towerkills, gold, 
item1, item2, item3, item4, item5, item6, 
it1.icon as itemicon1, it2.icon as itemicon2, it3.icon as itemicon3, it4.icon as itemicon4, it5.icon as itemicon5, it6.icon as itemicon6, 
it1.name as itemname1, it2.name as itemname2, it3.name as itemname3, it4.name as itemname4, it5.name as itemname5, it6.name as itemname6, 
a.elopoint, b.left, b.name as name, e.name as banname
FROM dotaplayers AS a 
LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
LEFT JOIN dotagames AS c ON c.gameid = a.gameid 
LEFT JOIN games AS d ON d.id = a.gameid 
LEFT JOIN bans as e ON b.name = e.name
LEFT JOIN heroes as f ON hero = heroid
LEFT JOIN items as it1 ON it1.itemid = item1
LEFT JOIN items as it2 ON it2.itemid = item2
LEFT JOIN items as it3 ON it3.itemid = item3
LEFT JOIN items as it4 ON it4.itemid = item4
LEFT JOIN items as it5 ON it5.itemid = item5
LEFT JOIN items as it6 ON it6.itemid = item6
where a.gameid='$gid' order by newcolour";

if($dbType == 'sqlite')
{
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$kills=$row["kills"];
		$deaths=$row["deaths"];
		$assists=$row["assists"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$towerkills=$row["towerkills"];
		$gold=$row["gold"];
		$item1=$row["item1"];
		$item2=$row["item2"];
		$item3=$row["item3"];
		$item4=$row["item4"];
		$item5=$row["item5"];
		$item6=$row["item6"];
		if(empty($item1) || $item1=="\0\0\0\0") 
		{
			$item1="empty";
			$itemname1="empty";
			$itemicon1="empty.gif";
		}
		else
		{
			$itemname1=$row["itemname1"];
			$itemicon1=$row["itemicon1"];
			if($itemicon1 == '')
			{
				$itemname1 = $item1;
				$itemicon1 = "blue_star2.gif";
			}
			
		}
		if(empty($item2) || $item2=="\0\0\0\0") 
		{
			$item2="empty";
			$itemname2="empty";
			$itemicon2="empty.gif";
		}
		else
		{
			$itemname2=$row["itemname2"];
			$itemicon2=$row["itemicon2"];
			if($itemicon2 == '')
			{
				$itemname2 = $item2;
				$itemicon2 = "blue_star2.gif";
			}
		}
		if(empty($item3) || $item3=="\0\0\0\0") 
		{
			$item3="empty";
			$itemname3="empty";
			$itemicon3="empty.gif";
		}
		else
		{
			$itemname3=$row["itemname3"];
			$itemicon3=$row["itemicon3"];
			if($itemicon3 == '')
			{
				$itemname3 = $item3;
				$itemicon3 = "blue_star2.gif";
			}
		}
		if(empty($item4) || $item4=="\0\0\0\0") 
		{
			$item4="empty";
			$itemname4="empty";
			$itemicon4="empty.gif";
		}
		else
		{
			$itemname4=$row["itemname4"];
			$itemicon4=$row["itemicon4"];
			if($itemicon4 == '')
			{
				$itemname4 = $item4;
				$itemicon4 = "blue_star2.gif";
			}
		}
		if(empty($item5) || $item5=="\0\0\0\0") 
		{
			$item5="empty";
			$itemname5="empty";
			$itemicon5="empty.gif";
		}
		else
		{
			$itemname5=$row["itemname5"];
			$itemicon5=$row["itemicon5"];
			if($itemicon5 == '')
			{
				$itemname5 = item5;
				$itemicon5 = "blue_star2.gif";
			}
		}
		if(empty($item6) || $item6=="\0\0\0\0") 
		{
			$item6="empty";
			$itemname6="empty";
			$itemicon6="empty.gif";
		}
		else
		{
			$itemname6=$row["itemname6"];
			$itemicon6=$row["itemicon6"];
			if($itemicon6 == '')
			{
				$itemname6 = item6;
				$itemicon6 = "blue_star2.gif";
			}
		}
		$left=$row["left"];
		$leftreason="";
		$elopoint = $row["elopoint"];
		$hero=$row["hero"];	
		$heroname=$row["description"];	
		$name=$row["name"];
		$newcolour=$row["newcolour"];
		$gameid=$row["gameid"]; 
		$banname=$row["banname"];
		
		//Trim down the leftreason
//		$leftreason = str_ireplace("has", "", $leftreason);
//		$leftreason = str_ireplace("was", "", $leftreason);
//		$leftreason = ucfirst(trim($leftreason));
//		$substring = strchr($leftreason, "(");
//		$leftreason = str_replace($substring, "", $leftreason);
		if($sentinel)
		{
		$sentinel = false;
		?>
		<tr>
			<td colspan=13 class="sentinelheader">
				<?php print $phrase20; if($win==1) print $phrase21; else print $phrase22;?>
			</td>
		</tr>
		<?php
		}
		if($scourge&&$newcolour>5){
			$scourge=false;
		?>
		<tr>
			<td colspan=13 class="scourgeheader">
			<?php print $phrase23; if($win==2) print $phrase21; else print $phrase22;?> 
			</td>
		</tr>
		<?php
		}
		if($name != ""){
		?>		
				
				
		<tr class="row">
			<td width=150px>
			<a <?php if($banname<>'') { print 'class="banned"'; } ?> href="?p=user&u=<?php print $name; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>" target="_self"><b><?php print $name; ?></b></a>
			</td>
			<td width=40px>
			<?php
			if(empty($hero))
			{
				print "<img width=\"24px\" height=\"24px\" src=./img/heroes/blank.gif>";
			}
			else
			{
				if($displayStyle == 'all')
				{
					print "<a  href=\"?p=hero&hid=".$hero."&s=kdratio&o=desc&n=all\"><img width=\"24px\" height=\"24px\" src=./img/heroes/".$hero.".gif title=\"".$heroname."\"></a>";
				}
				else
				{
					print "<a  href=\"?p=hero&hid=".$hero."&s=kdratio&o=desc&n=0\"><img width=\"24px\" height=\"24px\" src=./img/heroes/".$hero.".gif title=\"".$heroname."\"></a>";
				}
			}
			?>
			</td>
			<td width=60px><?php print $kills; ?></td>
			<td width=60px><?php print $deaths; ?></td>
			<td width=60px><?php print $assists; ?></td>
			<td width=60px><?php print $creepkills; ?></td>
			<td width=60px><?php print $creepdenies; ?></td>	
			<td width=60px><?php print $neutralkills; ?></td>
			<td width=60px><?php print $towerkills; ?></td>
			<td width=60px><?php print $gold; ?></td>		
			<td align="center" width=170px> 
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon1; ?> alt="XX" title="<?php print $itemname1; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon2; ?> alt="XX" title="<?php print $itemname2; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon3; ?> alt="XX" title="<?php print $itemname3; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon4; ?> alt="XX" title="<?php print $itemname4; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon5; ?> alt="XX" title="<?php print $itemname5; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon6; ?> alt="XX" title="<?php print $itemname6; ?>">
			</td>
			<td width=60px><?php print secondsToTime($left); ?></td>
			<td width=100px><?php print $elopoint; ?></td>
		</tr>
		<?php
		}
	}
}
else
{
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$kills=$row["kills"];
		$deaths=$row["deaths"];
		$assists=$row["assists"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$towerkills=$row["towerkills"];
		$gold=$row["gold"];
		$item1=$row["item1"];
		$item2=$row["item2"];
		$item3=$row["item3"];
		$item4=$row["item4"];
		$item5=$row["item5"];
		$item6=$row["item6"];
		if(empty($item1) || $item1=="\0\0\0\0") 
		{
			$item1="empty";
			$itemname1="empty";
			$itemicon1="empty.gif";
		}
		else
		{
			$itemname1=$row["itemname1"];
			$itemicon1=$row["itemicon1"];
			if($itemicon1 == '')
			{
				$itemname1 = $item1;
				$itemicon1 = "blue_star2.gif";
			}
			
		}
		if(empty($item2) || $item2=="\0\0\0\0") 
		{
			$item2="empty";
			$itemname2="empty";
			$itemicon2="empty.gif";
		}
		else
		{
			$itemname2=$row["itemname2"];
			$itemicon2=$row["itemicon2"];
			if($itemicon2 == '')
			{
				$itemname2 = $item2;
				$itemicon2 = "blue_star2.gif";
			}
		}
		if(empty($item3) || $item3=="\0\0\0\0") 
		{
			$item3="empty";
			$itemname3="empty";
			$itemicon3="empty.gif";
		}
		else
		{
			$itemname3=$row["itemname3"];
			$itemicon3=$row["itemicon3"];
			if($itemicon3 == '')
			{
				$itemname3 = $item3;
				$itemicon3 = "blue_star2.gif";
			}
		}
		if(empty($item4) || $item4=="\0\0\0\0") 
		{
			$item4="empty";
			$itemname4="empty";
			$itemicon4="empty.gif";
		}
		else
		{
			$itemname4=$row["itemname4"];
			$itemicon4=$row["itemicon4"];
			if($itemicon4 == '')
			{
				$itemname4 = $item4;
				$itemicon4 = "blue_star2.gif";
			}
		}
		if(empty($item5) || $item5=="\0\0\0\0") 
		{
			$item5="empty";
			$itemname5="empty";
			$itemicon5="empty.gif";
		}
		else
		{
			$itemname5=$row["itemname5"];
			$itemicon5=$row["itemicon5"];
			if($itemicon5 == '')
			{
				$itemname5 = item5;
				$itemicon5 = "blue_star2.gif";
			}
		}
		if(empty($item6) || $item6=="\0\0\0\0") 
		{
			$item6="empty";
			$itemname6="empty";
			$itemicon6="empty.gif";
		}
		else
		{
			$itemname6=$row["itemname6"];
			$itemicon6=$row["itemicon6"];
			if($itemicon6 == '')
			{
				$itemname6 = item6;
				$itemicon6 = "blue_star2.gif";
			}
		}
		$left=$row["left"];
		$leftreason="";
		$elopoint=$row["elopoint"];
		$hero=$row["hero"];	
		$heroname=$row["description"];	
		$name=$row["name"];
		$newcolour=$row["newcolour"];
		$gameid=$row["gameid"]; 
		$banname=$row["banname"];

		//Trim down the leftreason
	//	$leftreason = str_ireplace("has", "", $leftreason);
	//	$leftreason = str_ireplace("was", "", $leftreason);
	//	$leftreason = ucfirst(trim($leftreason));
	//	$substring = strchr($leftreason, "(");
	//	$leftreason = str_replace($substring, "", $leftreason);
		if($sentinel)
		{
		$sentinel = false;
		?>
		<tr>
			<td colspan=13 class="sentinelheader">
				SENTINEL - <?php if($win==1) print "Winner!"; else print "Loser!";?>
			</td>
		</tr>
		<?php
		}
		if($scourge&&$newcolour>5){
			$scourge=false;
		?>
		<tr>
			<td colspan=13 class="scourgeheader">
			SCOURGE - <?php if($win==2) print "Winner!"; else print "Loser!";?> 
			</td>
		</tr>
		<?php
		}
		if($name != ""){
		?>		
				
				
		<tr class="row">
			<td width=150px>
			<a <?php if($banname<>'') { print 'class="banned"'; } ?> href="?p=user&u=<?php print $name; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>" target="_self"><b><?php print $name; ?></b></a>
			</td>
			<td width=40px>
			<?php
			if(empty($hero))
			{
				print "<img width=\"24px\" height=\"24px\" src=./img/heroes/blank.gif>";
			}
			else
			{
				if($displayStyle == 'all')
				{
					print "<a  href=\"?p=hero&hid=".$hero."&s=kdratio&o=desc&n=all\"><img width=\"24px\" height=\"24px\" src=./img/heroes/".$hero.".gif title=\"".$heroname."\"></a>";
				}
				else
				{
					print "<a  href=\"?p=hero&hid=".$hero."&s=kdratio&o=desc&n=0\"><img width=\"24px\" height=\"24px\" src=./img/heroes/".$hero.".gif title=\"".$heroname."\"></a>";
				}
			}
			?>
			</td>
			<td width=60px><?php print $kills; ?></td>
			<td width=60px><?php print $deaths; ?></td>
			<td width=60px><?php print $assists; ?></td>
			<td width=60px><?php print $creepkills; ?></td>
			<td width=60px><?php print $creepdenies; ?></td>	
			<td width=60px><?php print $neutralkills; ?></td>
			<td width=60px><?php print $towerkills; ?></td>
			<td width=60px><?php print $gold; ?></td>		
			<td align="center" width=170px> 
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon1; ?> alt="XX" title="<?php print $itemname1; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon2; ?> alt="XX" title="<?php print $itemname2; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon3; ?> alt="XX" title="<?php print $itemname3; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon4; ?> alt="XX" title="<?php print $itemname4; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon5; ?> alt="XX" title="<?php print $itemname5; ?>">
				<img width="24px" height="24px" src=./img/items/<?php print $itemicon6; ?> alt="XX" title="<?php print $itemname6; ?>">
			</td>
			<td width=60px><?php print secondsToTime($left); ?></td>
			<td width=100px><?php print $elopoint; ?></td>
		</tr>
		<?php
		}
	}
	mysql_free_result($result);
}
?>
<tr height=10px>
</tr>
</table>
</div>

<?php

if(file_exists($replayloc))
{
?>
<div class="hidden" id="chat">
<table class="table" id="data2">
<tr class="footerheadercell">
	<td colspan=13>
		 
		 <h3>Game Log:</h3>
	</td>
</tr>
<tr>
	<td colspan=13>
	<center>
			<table width=1000px>
<?php
	require('chat.php');
	$replay = new replay($replayloc);
	if (!isset($error)) {
		
		$firstBlood = true;
		$i = 1;
		foreach ($replay->teams as $team=>$players) {
			if ($team != 12) {	
				foreach ($players as $player) {          
					// remember there's no color in tournament replays from battle.net website
					if ($player['color']) {
						//echo('<span class="'.$player['color'].'">'.$player['color'].'</span>');
						// since version 2.0 of the parser there's no players array so
						// we have to gather colors and names earlier as it will be harder later ;)
						$colors[$player['player_id']] = $player['color'];
						$names[$player['player_id']] = $player['name'];
					}
				}
				$i++;
			}
		}
		for($i = 0; $i <= 14; $i++)
		{
			switch($i) {
			
			case 0:
				$slotname[$i] = 'The Sentinel';
				$slotcolor[$i] = 'sentinel';
				break;
			case 1:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'blue')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 2:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'teal')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 3:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'purple')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 4:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'yellow')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 5:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'orange')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 6:
				$slotname[$i] = 'The Scourge';
				$slotcolor[$i] = 'scourge';
				break;
			case 7:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'pink')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 8:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'gray')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 9:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'light-blue')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 10:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'dark-green')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 11:
				for($n = 0; $n < 12; $n++)
				{
					if(isset($colors[$n]))
					{
						if($colors[$n] == 'brown')
						{
							$playerID = $n;
						}
					}
				}				
				$slotname[$i] = $names[$playerID];
				$slotcolor[$i] = $colors[$playerID];
				break;
			case 12:		
				$slotname[$i] = 'Neutral Creeps';
				$slotcolor[$i] = 'system';
				break;	
			case 13:		
				$slotname[$i] = 'The Sentinel';
				$slotcolor[$i] = 'sentinel';
				break;
			case 14:
				$slotname[$i] = 'The Scourge';
				$slotcolor[$i] = 'scourge';
				break;
			}
		}
		$colors[''] = 'system';
		$names[''] = 'System';
		if ($replay->chat) {
			foreach ($replay->chat as $content) {
				$time = $content['time'];
				$mode = $content['mode'];
				$playerID = $content['player_id'];
				$playerName = $names[$playerID];
				$playerColor = $colors[$playerID];
				$text = htmlspecialchars($content['text'], ENT_COMPAT, 'UTF-8');
				?>
				<tr>
					<td width=250px class="rowuh" style="text-align:right">
					<?php
						if($mode == 'All' || getTeam($playerColor) == 1)
						{
						?>
							<a href="?p=user&u=<?php print $playerName; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><span class="<?php print $playerColor; ?>"><?php print $playerName;?></span></a>				
						<?php
						}
						?>
					</td>
					<td width=50px class="rowuh" style="text-align:center">
						<?php print secondsToTime($time/1000); ?>
					<td>
					
					<?php
						if($mode == 'All')
						{
							print '<td width=500px class="all">'.$text.'</td>';
						}
						else if($mode == 'System')
						{
							if($content['type'] == 'Start')
							{
								print '<td width=500px class="system">'.$text.'</td>';
							}
							else if($content['type'] == 'Hero')
							{
								$victim = trim($content['victim']);
								$killer = $content['killer'];
								if($firstBlood)
								{
									if($content['killer'] < 12)
									{
									print '<td width=500px class="system">'.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.
									$text.'<span class="'.$slotcolor[$victim].'">'.$slotname[$victim].'</span> for first blood'.'</td>';
									$firstBlood = false;
									}
									else
									{
										print '<td width=500px class="system">'.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.
										$text.'<span class="'.$slotcolor[$victim].'">'.$slotname[$victim].'</span>'.'</td>';
									}
								}
								else
								{
									if($victim == $killer)
									{
										print '<td width=500px class="system">'.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.' has killed himself!'.'</td>';
									}
									else if(($victim < 6 && $killer < 6) || ($victim > 6 && $killer > 6) && $killer <= 11)
									{
										print '<td width=500px class="system">'.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.
										' denied his teammate '.'<span class="'.$slotcolor[$victim].'">'.$slotname[$victim].'</span>'.'</td>';
									}
									else
									{
										print '<td width=500px class="system">'.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.
										$text.'<span class="'.$slotcolor[$victim].'">'.$slotname[$victim].'</span>'.'</td>';
									}
								}
							}
							else if($content['type'] == 'Courier')
							{
								$victim = trim($content['victim']);
								$killer = $content['killer'];
								
								print '<td width=500px class="system">'.'<span class="'.$slotcolor[$victim].'">'.$slotname[$victim].'</span>'.
								$text.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.'</td>';
								
							}
							else if($content['type'] == 'Tower')
							{
								
								$killer = $content['killer'];
								
								print '<td width=500px class="system">'.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.
								$text.$content['side'].' level '.$content['level'].' <span class="'.strtolower($content['team']).'">'.$content['team'].'</span> tower</td>';
								
							}
							else if($content['type'] == 'Rax')
							{
								
								$killer = $content['killer'];
								
								print '<td width=500px class="system">'.'<span class="'.$slotcolor[$killer].'">'.$slotname[$killer].'</span>'.
								$text.$content['side'].' '.$content['raxtype'].' <span class="'.strtolower($content['team']).'">'.$content['team'].'</span> barracks</td>';
								
							}
							else if($content['type'] == 'Throne')
							{
								print '<td width=500px class="system">'.$text.'</td>';					
							}
							else if($content['type'] == 'Tree')
							{
								print '<td width=500px class="system">'.$text.'</td>';					
							}
						}
						else
						{
							if(getTeam($playerColor) == 1)
							{
								print '<td width=500px class="sentinel">'.$text.'</td>';
							}
							else
							{
								print '<td width=500px class="scourge">'.$text.'</td>';
							}
						}
					?>
					<td width=50px class="rowuh" style="text-align:center">
						<?php print secondsToTime($time/1000); ?>
					<td>
					<td width=250px class="rowuh" style="text-align:left">
						<?php
						if($mode == 'All' || getTeam($playerColor) == 2)
						{
						?>
							<a href="?p=user&u=<?php print $playerName; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><span class="<?php print $playerColor; ?>"><?php print $playerName; ?></span></a>				
						<?php
						}
						?>
					</td>
				</tr>
				<?php
			}
		}	
	}
	?>
					</table>
			</center>
		</td>
	</tr>
</table>
</div>
	<?php
}
?>			
</div>
</div>
<div id="footer" class="footer">


<!--Rating@Mail.ru counter-->
<script language="javascript"><!--
d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
<script language="javascript1.1"><!--
a+=';j='+navigator.javaEnabled();js=11;//--></script>
<script language="javascript1.2"><!--
s=screen;a+=';s='+s.width+'*'+s.height;
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
<script language="javascript1.3"><!--
js=13;//--></script><script language="javascript" type="text/javascript"><!--
d.write('<a href="http://top.mail.ru/jump?from=1824871" target="_top">'+
'<img src="http://d8.cd.bb.a1.top.mail.ru/counter?id=1824871;t=130;js='+js+
a+';rand='+Math.random()+'" alt="Рейтинг@Mail.ru" border="0" '+
'height="40" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_top" href="http://top.mail.ru/jump?from=1824871">
<img src="http://d8.cd.bb.a1.top.mail.ru/counter?js=na;id=1824871;t=130" 
height="40" width="88" border="0" alt="Рейтинг@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script>
<!--// Rating@Mail.ru counter-->


</div>
