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
require_once("config.php");

function millisecondsToTime($milliseconds)//returns the time like 5.2 (5 seconds, 200 milliseconds)
{
	$return="";
	$return2="";
     // get the seconds
	$seconds = floor($milliseconds / 1000) ;
	$milliseconds = $milliseconds % 1000;
	$milliseconds = round($milliseconds/100,0);
	
	// get the minutes
	$minutes = floor($seconds / 60) ;
	$seconds_left = $seconds % 60 ;

	// get the hours
	$hours = floor($minutes / 60) ;
	$minutes_left = $minutes % 60 ;
// A little unneccasary with minutes and hours,,  but HEY  everythings possible
	if($hours)
	{
		$return ="$hours".":";
	}
	if($minutes_left)
	{
		$return2 ="$minutes_left".":";
	}
return $return.$return2.$seconds_left.".".$milliseconds;
}  

function secondsToTime($seconds)//Returns the time like 1:43:32
{
	$hours = floor($seconds/3600);
	$secondsRemaining = $seconds % 3600;
	
	$minutes = floor($secondsRemaining/60);
	$seconds_left = $secondsRemaining % 60;
	
	if($hours != 0)
	{
		if(strlen($minutes) == 1)
		{
		$minutes = "0".$minutes;
		}
		if(strlen($seconds_left) == 1)
		{
		$seconds_left = "0".$seconds_left;
		}
		return $hours.":".$minutes.":".$seconds_left;
	}
	else
	{
		if(strlen($seconds_left) == 1)
		{
		$seconds_left = "0".$seconds_left;
		}
		return $minutes.":".$seconds_left;
	}
}

function replayDuration($seconds)
{
	$minutes = floor($seconds/60);
	$seconds_left = $seconds % 60;
	
	if(strlen($seconds_left) == 1)
	{
	$seconds_left = "0".$seconds_left;
	}
	return $minutes."m".$seconds_left."s";
}

function getWins($username) {
	global $dbType, $databasename, $dbHandle;
	$sql = "SELECT COUNT(*) FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid WHERE name='$username' AND ((winner=1 AND dotaplayers.newcolour>=1 AND dotaplayers.newcolour<=5) OR (winner=2 AND dotaplayers.newcolour>=7 AND dotaplayers.newcolour<=11)) AND gameplayers.`left`/games.duration >= 0.8";

	if($dbType == 'sqlite')
	{
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$inwins=$row["COUNT(*)"];
		}
	}
	else
	{
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$inwins=$row["COUNT(*)"];
		mysql_free_result($result);
	}
	return $inwins;
}

function getLosses($username) {
	global $dbType, $databasename, $dbHandle;
	$sql = "SELECT COUNT(*) FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid WHERE name='$username' AND ((winner=2 AND dotaplayers.newcolour>=1 AND dotaplayers.newcolour<=5) OR (winner=1 AND dotaplayers.newcolour>=7 AND dotaplayers.newcolour<=11)) AND gameplayers.`left`/games.duration >= 0.8";

	if($dbType == 'sqlite')
	{
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$inlosses=$row["COUNT(*)"];
		}
	}
	else
	{
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$inlosses=$row["COUNT(*)"];
		mysql_free_result($result);
	}
	return $inlosses;
}

function getTeam($color)
{
	switch ($color) {
		case 'red': return 0;
		case 'blue': return 1;
		case 'teal': return 1;
		case 'purple': return 1;
		case 'yellow': return 1;
		case 'orange': return 1;
		case 'green': return 0;
		case 'pink': return 2;
		case 'gray': return 2;
		case 'light-blue': return 2;
		case 'dark-green': return 2;
		case 'brown': return 2;
		case 'observer': return 0;
	}
}

function getRatio($nom, $denom) 
{
	if($nom == 0) {
		return 0;
	}
	else if($denom == 0) {
		return 1000;
	}
	else {
		return round((($nom*1.0)/($denom*1.0)),2);
	}
}

function getUserParam($username)
{
	if($username == '') 
	{
		return '';
	}
	else
	{
		return "&u=".$username;
	}
}

function printStatsRowType($rowdata) {
	global $displayStyle;
	
	if(isset($rowdata["topHero"])) {
		$topHero = $rowdata["topHero"];
	} else { 
		$topHero = ''; 
	}
	
	if(isset($rowdata["topHeroName"])) {
		$topHeroName = $rowdata["topHeroName"];
	} else {
		$topHeroName = '';
	}
	
	if(isset($rowdata["topGame"])) {
		$topGame = $rowdata["topGame"];
	} else {
		$topGame = '';
	}
	
	if(isset($rowdata["topDate"])) {
		$topDate = substr($rowdata["topDate"],0,10);
	} else {
		$topDate = '';
	}
	
	if(isset($rowdata["topUser"])) {
		$topUser = $rowdata["topUser"];
	} else {
		$topUser = '';
	}
	
	if(isset($rowdata["topValueUnit"])) {
		$topValueUnit = $rowdata["topValueUnit"];
	} else {
		$topValueUnit = '';
	}
	
	if ($topValueUnit <> '') {
		$topValue = ROUND($rowdata["topValue"],1);
	} else {
		$topValue = ROUND($rowdata["topValue"],2);				
	}
	
	if($topValue != "")
	{
?>
					<tr> 
<?php
		if($topHero != "" && $topGame != '')
		{
?>						<td align=right width=15%>
							<a  href="?p=hero&hid=<?php print $topHero;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img src="img/heroes/<?php print $topHero; ?>.gif" title="<?php print $topHeroName; ?>" width="16" height="16"></a>
						</td>
						<td align=center width=60px>
							<a href="?p=gameinfo&gid=<?php print $topGame;?>">(<?php print $topValue;?>)</a> 
						</td>
<?php
		}
		else
		{
?>	
						<td align=center width=80px height=22px colspan=2>
							(<?php print $topValue.$topValueUnit;?>)
						</td>
<?php
	}
?>				


<?php
		if($topUser != "")
		{
?>
						<td align=left>
							<a href="?p=user&u=<?php print $topUser;?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $topUser;?></a>
						</td>
<?php
		}
		else if($topDate != "")
		{
?>				
						<td align=left>
							<?php print $topDate; ?>
						</td>
<?php
		}
		else
		{
?>				
						<td align=left>
							ERR
						</td>
<?php
		}
?>				
					</tr>
<?php
		return 1;
	}
	else
	{
		//no data available
		return 0;
	}
}

function fillEmptyStatsRows1($rowCount) {
	$idx = 0;
	while($idx < $rowCount) // fill empty rows
	{ 
		$idx = $idx + 1;	
?>
					<tr> 
						<td align=right width=15%>
							<img src="img/heroes/blank.gif" title="N/A" width="16" height="16"></a>
						</td>
						<td align=center width=60px>
							(---)
						</td>
						<td align=left>
							N/A
						</td>
					</tr>
<?php	
	}
	return 0;
}


function fillEmptyStatsRows2($rowCount) {
	$idx = 0;
	while($idx < $rowCount) // fill empty rows
	{ 
		$idx = $idx + 1;	
?>
					<tr> 
						<td align=center width=80px height=22px colspan=2>
							(---)
						</td>
						<td align=left>
							N/A
						</td>
					</tr>
<?php	
	}
	return 0;
}


function checkDBTable($tablename) {
	global $dbType, $databasename, $dbHandle;
	if($dbType == 'sqlite')
	{
		$sql = "select count(*) as count from sqlite_master WHERE tbl_name = '$tablename' and type = 'table'";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$count=$row["count"];
		}
	}
	else
	{ 
		$sql = "SELECT count(*) as count FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME='$tablename' and TABLE_SCHEMA='$databasename'";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$count=$row["count"];
		}
		mysql_free_result($result);
	}
	return $count;
}

?>
