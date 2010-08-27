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

if($dbType == 'sqlite')
{
	$heroid=sqlite_escape_string($_GET["hid"]);
	$sortcat=sqlite_escape_string($_GET["s"]);
	$order=sqlite_escape_string($_GET["o"]);
	$offset=sqlite_escape_string($_GET["n"]);
}
else
{
	$heroid=mysql_real_escape_string($_GET["hid"]);
	$sortcat=mysql_real_escape_string($_GET["s"]);
	$order=mysql_real_escape_string($_GET["o"]);
	$offset=mysql_real_escape_string($_GET["n"]);
}
require_once("functions.php");
require_once("config.php");

$heroName = "";
$heroDescription = "";

//Check If alias
if($dbType == 'sqlite')
{
	$sql = "SELECT heroid, original FROM heroes where heroid='$heroid'";
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$heroid=$row["original"];
	}
}
else
{
	$sql = "SELECT heroid, original FROM heroes where heroid='$heroid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$heroid=$row["original"];
	mysql_free_result($result);
}

//Get hero name and description
$sql = "select description, summary from heroes where heroid='$heroid'";
if($dbType == 'sqlite')
{
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$heroName = $row["description"];
		$heroDescription = $row["summary"];
	}
}
else
{
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		$heroName = $row["description"];
		$heroDescription = $row["summary"];
	}
}

//Get overall hero stats
$sql ="Select *, (kills*1.0/deaths) as kdratio, (wins*1.0/losses) as winratio, summary, skills, stats From 
	(SELECT count(*) as totgames, original,
	SUM(case when(((c.winner = 1 and a.newcolour < 6) or (c.winner = 2 and a.newcolour > 6)) AND d.`left`/e.duration >= $minPlayedRatio) then 1 else 0 end) as wins, 
	SUM(case when(((c.winner = 2 and a.newcolour < 6) or (c.winner = 1 and a.newcolour > 6)) AND d.`left`/e.duration >= $minPlayedRatio) then 1 else 0 end) as losses, 
	SUM(kills) as kills, SUM(deaths) as deaths, SUM(assists) as assists, SUM(creepkills) as creepkills, SUM(creepdenies) as creepdenies, SUM(neutralkills) as neutralkills, SUM(towerkills) as towerkills, SUM(raxkills) as raxkills, SUM(courierkills) as courierkills
	FROM dotaplayers AS a LEFT JOIN heroes as b ON hero = heroid LEFT JOIN dotagames as c ON c.gameid = a.gameid
	LEFT JOIN gameplayers as d ON d.gameid = a.gameid and a.colour = d.colour LEFT JOIN games as e ON d.gameid = e.id where original='$heroid' group by original) as y 
	LEFT JOIN heroes as z ON y.original = z.heroid";
	if($dbType == 'sqlite')
{
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$totgames=$row["totgames"];
		$wins=$row["wins"];
		$losses=$row["losses"];
		$winratio=$row["winratio"];
		$kills=$row["kills"];
		$deaths=$row["deaths"];
		$assists=$row["assists"];
		$kdratio=$row["kdratio"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$towerkills=$row["towerkills"];
		$raxkills=$row["raxkills"];
		$courierkills=$row["courierkills"];
		$summary=$row["summary"];
		$stats=$row["stats"];
		$skills=$row["skills"];
	}
}
else
{	
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$totgames=$row["totgames"];
		$wins=$row["wins"];
		$losses=$row["losses"];
		$winratio=$row["winratio"];
		$kills=$row["kills"];
		$deaths=$row["deaths"];
		$assists=$row["assists"];
		$kdratio=$row["kdratio"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$towerkills=$row["towerkills"];
		$raxkills=$row["raxkills"];
		$courierkills=$row["courierkills"];
		$summary=$row["summary"];
		$stats=$row["stats"];
		$skills=$row["skills"];
	}
	mysql_free_result($result);
}
	?>
<div class="header" id="header">
<table width=1016px>
	<tr class="rowuh"> 
	<td colspan=12 align="center" >
	<table class="rowuh" width=100%>
	<tr>
		<td width=64px align="left" class="rowuh"> <img src=./img/heroes/<?php print $heroid ?>.gif alt="" width=64px height=64px></td>
		<td width=99%><h2><?php print $heroName; ?></h2></td>
		<td width=64px align="left" class="rowuh"> <img src=./img/heroes/<?php print $heroid ?>.gif alt="" width=64px height=64px></td>
	</tr>
	</table>
    </td>
  </tr>
  <tr>
	<td class="footerheadercell"colspan=1 width=33%><?php print $phrase24.":";?></td>
	<td class="footerheadercell" colspan=1><?php print $heroName." ".$phrase25.":"; ?></td>
  </tr>
  <tr>
	<td>
	<table class="rowuh" width=100%>
		  <tr class="rowuh">
			<td><?php print $phrase26.":"; ?></td>
			<td><?php print $totgames; ?></td>
			<td><?php print $phrase27.":"; ?></td>
			<td ><?php print ROUND($winratio,2); ?></td>
		  </tr>
		  <tr class="rowuh">
			<td><?php print $phrase28.":"; ?></td>
			<td ><?php print $wins; ?></td>
			<td><?php print $phrase29.":"; ?></td>
			<td ><?php print $losses; ?></td>
		  </tr>
		  <tr class="rowuh" height=10px>
		  </tr>
		  <tr class="rowuh">
			<td><?php print $phrase9.":"; ?></td>
			<td ><?php print ROUND($kills,2); ?></td>
			<td><?php print $phrase10.":"; ?></td>
			<td ><?php print ROUND($deaths,2); ?></td>
		  </tr>
		  <tr class="rowuh">
			<td><?php print $phrase11.":"; ?></td>
			<td ><?php print ROUND($assists,2); ?></td>
			<td><?php print $phrase30.":"; ?></td>
			<td ><?php print ROUND($kdratio,2); ?></td>
		  </tr>
		  <tr class="rowuh" height=10px>
		  </tr>
		  <tr class="rowuh">
			<td><?php print $phrase12.":"; ?></td>
			<td ><?php print ROUND($creepkills,2); ?></td>
			<td><?php print $phrase13.":"; ?></td>
			<td ><?php print ROUND($creepdenies,2);  ?></td>
		  </tr>
		  <tr class="rowuh">
			<td><?php print $phrase14.":"; ?></td>
			<td ><?php print ROUND($neutralkills,2); ?></td>
			<td><?php print $phrase31.":"; ?></td>
			<td ><?php print ROUND($towerkills,2); ?></td>
		  </tr>
		  <tr class="rowuh">
			<td><?php print $phrase32.":"; ?></td>
			<td ><?php print ROUND($raxkills,2); ?></td>
			<td><?php print $phrase33.":"; ?></td>
			<td ><?php print ROUND($courierkills,2); ?></td>
		  </tr>
		</td>
		</table>
	</td>
	<td>
	<table class="rowuh">
	<tr>
	<td colspan=2><?php print $summary; ?></td>
	</tr>
	<tr class="rowuh" height=10px>
	</tr>
	<tr>
		<td width=33%><?php print $stats; ?></td>
		<td><?php print $skills; ?></td>
	</tr>
	</table
	</td>
  </tr>
</table>
<?php
//Beginning of game history table
$sql = "Select Count(*) as  count FROM (SELECT name FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
 LEFT JOIN dotagames AS c ON c.gameid = a.gameid LEFT JOIN games AS d ON d.id = a.gameid LEFT JOIN heroes as e ON a.hero = heroid 
 where heroid = '$heroid')as t";
 
if($dbType == 'sqlite')
{
foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$count=$row["count"];
	}	
}
else
{
	$result = mysql_query($sql);

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$count=$row["count"];
		}
	mysql_free_result($result);
}

$pages = ceil($count/$heroResultSize);
?>
<table width=1016px style="border-top: 1px solid #EBEBEB;">
		<tr>
			<td width=25%>
				<table class="rowuh" width = 235px style="float:left">
					<tr>
						<td>
						<?php
						if($offset == 'all')
						{
							print $phrase34;
						}
						else
						{
							print "<a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=all\">$phrase35</a>";
						}
						?>
						</td>
					</tr>
				</table>
			</td>
			<td width=50%>
				<h3><?php print $phrase36.":";?></h3>
			</td>
			<td width=25% class="rowuh">
				<table class="rowuh" width = 235px style="float:right">
				<h4>
				<tr>
					<td colspan=7>
					<?php
					if($offset == 'all')
					{
						print "$phrase37:";
					}
					else
					{
						$min = $offset*$heroResultSize+1;
						$max = $offset*$heroResultSize+$heroResultSize;
						if($max > $count)
						{
							$max = $count;
						}
						print $phrase38.": ".$min." - ".$max;
					}
					?>
					</td>
				</tr>
				<tr>
				<?php
				if($offset == 'all')
				{
					print "<td width=35px><span class=\"ddd\"><</span></td>";
					for($counter = 1; $counter < 6; $counter++)
					{
						if($counter <= $pages)
						{
						print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
						}
					}
					print "<td width=35px><span class=\"ddd\">></span></td>";
				}
				else
				{
					if($offset > 0)
					{
						print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($offset-1)."\"><</a>";
					}
					else
					{
						print "<td width=35px><span class=\"ddd\"><</span></td>";
					}
					
					if($offset < 2)		//Close to start
					{
						if($offset == 0)
						{
							print "<td width=35px><span class=\"ddd\">1</span></td>";
							for($counter = 2; $counter < 6; $counter++)
							{
								if($counter-1 < $pages)
								{
									print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
						}
						if($offset == 1)
						{
							print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=0\">1</a></td>";
							print "<td width=35px><span class=\"ddd\">2</span></td>";
							for($counter = 3; $counter < 6; $counter++)
							{
								if($counter-1 < $pages)
								{
								print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								
								}
							}
						}
					}
					else if ($pages-$offset < 3) //Close to end
					{
						if($offset == $pages-1)
						{
							for($counter = $offset-3; $counter < $offset+1; $counter++)
							{
								if($counter >= 1)
								{
								print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
							print "<td width=35px><span class=\"ddd\">".$counter."</span></td>";
						}
						else
						{
							
							for($counter = $offset-2; $counter < $offset+1; $counter++)
							{
								if($counter >= 1)
								{
									print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
							print "<td width=35px><span class=\"ddd\">".($offset+1)."</span>";
							print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($offset+1)."\">".($offset+2)."</a></td>";
						}
					}
					else
					{
						for($counter = ($offset-1); $counter < ($offset+4); $counter++)
							{
							if($counter == ($offset+1))
							{
								print "<td width=35px><span class=\"ddd\">".$counter."</span></td>";
							}
							else
							{
								print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
							}
						}
					}
					if(($offset+1)*$heroResultSize < $count)
					{
						print "<td width=35px><a href=\"?p=hero&hid=".$heroid."&s=".$sortcat."&o=".$order."&n=".($offset+1)."\">></a></td>";
					}
					else
					{
						print "<td width=35px><span class=\"ddd\">></span></td>";
					}
				}
				?>
				</tr>
				</h4>
				</table>
			</td>			
		</tr>
	</table>
</div>
<div class="pageholder" id="pageholder">
	<div id="theader">
		<table class="tableheader" id="tableheader">
			<tr class="headercell">
<?php
if($offset == 'all')
{
	$sortoffset = $offset;
}
else
{
	$sortoffset = 0;
}

//Player Name
if($sortcat == "name")
{
	$sortcat = "b.name";
	if($order == "asc")
	{
		print("<td width=150px><a href=\"?p=hero&hid=$heroid&s=name&o=desc&n=".$sortoffset."\">".$phrase7."</a></td>");
	}
	else
	{
		print("<td width=150px><a href=\"?p=hero&hid=$heroid&s=name&o=asc&n=".$sortoffset."\">".$phrase7."</a></td>");
	}
}
else
{
	print("<td width=150px><a href=\"?p=hero&hid=$heroid&s=name&o=desc&n=".$sortoffset."\">".$phrase7."</a></td>");
}
//Game Name
if($sortcat == "gamename")
{
			$sortcat = "d.gamename";
	if($order == "asc")
	{
		print("<td width=220px><a href=\"?p=hero&hid=$heroid&s=gamename&o=desc&n=".$sortoffset."\">".$phrase2."</a></td>");
	}
	else
	{
		print("<td width=220px><a href=\"?p=hero&hid=$heroid&s=gamename&o=asc&n=".$sortoffset."\">".$phrase2."</a></td>");
	}
}
else
{
	print("<td width=220px><a href=\"?p=hero&hid=$heroid&s=gamename&o=asc&n=".$sortoffset."\">".$phrase2."</a></td>");
}
//Game Type
if($sortcat == "type")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=type&o=desc&n=".$sortoffset."\">".$phrase39."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=type&o=asc&n=".$sortoffset."\">".$phrase39."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=type&o=desc&n=".$sortoffset."\">".$phrase39."</a></td>");
}
//result
if($sortcat == "result")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=result&o=desc&n=".$sortoffset."\">".$phrase40."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=result&o=asc&n=".$sortoffset."\">".$phrase40."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=result&o=desc&n=".$sortoffset."\">".$phrase40."</a></td>");
}
//Kills
if($sortcat == "kills")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=kills&o=desc&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=kills&o=asc&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=kills&o=desc&n=".$sortoffset."\">".$phrase9."</a></td>");
}

//Deaths
if($sortcat == "deaths")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=deaths&o=desc&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=deaths&o=asc&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=deaths&o=desc&n=".$sortoffset."\">".$phrase10."</a></td>");
}

//Assists
if($sortcat == "assists")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=assists&o=desc&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=assists&o=asc&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=assists&o=desc&n=".$sortoffset."\">".$phrase11."</a></td>");
}
//KDRatio
if($sortcat == "kdratio")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=kdratio&o=desc&n=".$sortoffset."\">".$phrase41."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=kdratio&o=asc&n=".$sortoffset."\">".$phrase41."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=kdratio&o=desc&n=".$sortoffset."\">".$phrase41."</a></td>");
}
//Creep Kills
if($sortcat == "creepkills")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=creepkills&o=desc&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=creepkills&o=asc&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=creepkills&o=desc&n=".$sortoffset."\">".$phrase42."</a></td>");
}
//Creep Denies
if($sortcat == "creepdenies")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=creepdenies&o=desc&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=creepdenies&o=asc&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=creepdenies&o=desc&n=".$sortoffset."\">".$phrase43."</a></td>");
}
//Neutral Kills
if($sortcat == "neutralkills")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=neutralkills&o=desc&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=neutralkills&o=asc&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=hero&hid=$heroid&s=neutralkills&o=desc&n=".$sortoffset."\">".$phrase44."</a></td>");
}
?>
				<td width=16px></td>
			</tr>
	 </table>
	</div>
	<div id="datawrapper">
		<table class="table" id="data">
 <?php 
  $sql = "Select CASE WHEN (kills = 0) THEN 0 WHEN (deaths = 0) then 1000 ELSE (kills*1.0/deaths*1.0) end as kdratio, a.gameid as gameid, d.gamename, kills, deaths, assists, creepkills, neutralkills, creepdenies, towerkills, raxkills, courierkills, b.name as name, f.name as banname, CASE when(gamestate = '17') then 'PRIV' else 'PUB' end as type, 
  CASE when ((winner=1 and newcolour < 6) or (winner=2 and newcolour > 5)) AND b.`left`/d.duration >= $minPlayedRatio  then 'WON' when ((winner=2 and newcolour < 6) or (winner=1 and newcolour > 5)) AND b.`left`/d.duration >= $minPlayedRatio  then 'LOST' when  winner=0 then 'DRAW' else '$notCompleted' end as result
 FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
 LEFT JOIN dotagames AS c ON c.gameid = a.gameid 
 LEFT JOIN games AS d ON d.id = a.gameid 
 LEFT JOIN heroes as e ON a.hero = heroid 
 LEFT JOIN bans as f ON b.name = f.name
 where original = '$heroid' 
 ORDER BY $sortcat $order, b.name DESC";

 if($offset!='all')
{
$sql = $sql." LIMIT ".$heroResultSize*$offset.", $heroResultSize";
}

 if($dbType == 'sqlite')
{
foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
	$gameid = $row["gameid"];
	$kills=$row["kills"];
	$death=$row["deaths"];
    $assists=$row["assists"];
	$kdratio=$row["kdratio"];
	$gamename=$row["gamename"];
	$name=$row["name"];
    $banname=$row["banname"];
	$winner=$row["result"];
	$type=$row["type"];
	$creepkills=$row["creepkills"];
	$creepdenies=$row["creepdenies"];
	$neutralkills=$row["neutralkills"];
 ?> 
 <tr class="row">
    <td width=150px><a <?php if($banname<>'') { print 'class="banned"'; } ?> href="?p=user&u=<?php print $name; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $name;?></a></td>
    <td width=220px><a href="?p=gameinfo&gid=<?php print $gameid; ?>" target="_self"><?php print $gamename;?></a></td>
    <td width=70px><?php print $type;?></td>
	<td width=70px> <span <?php if($winner == 'LOST'){print 'class="lost"';}elseif($winner == 'WON'){print 'class="won"';} else{print 'class="draw"';} ?>><?php print $winner;?></span></td>
    <td width=70px><?php print $kills;?></td>
    <td width=70px><?php print $death;?></td>
    <td width=70px><?php print $assists;?></td>
	<td width=70px><?php print ROUND($kdratio,2);?></td>
	<td width=70px><?php print $creepkills;?></td>
    <td width=70px><?php print $creepdenies;?></td>
	<td width=70px><?php print $neutralkills;?></td>
 </tr>	
	<?php
	}
}
else
{
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
$gameid = $row["gameid"];
	$kills=$row["kills"];
	$death=$row["deaths"];
    $assists=$row["assists"];
	$kdratio=$row["kdratio"];
	$gamename=$row["gamename"];
        $banname=$row["banname"];
	$name=$row["name"];
	$winner=$row["result"];
	$type=$row["type"];
	$creepkills=$row["creepkills"];
	$creepdenies=$row["creepdenies"];
	$neutralkills=$row["neutralkills"];
	$towerkills=$row["towerkills"];
	$raxkills=$row["raxkills"];

 ?> 
 <tr class="row">
    <td width=150px><a <?php if($banname<>'') { print 'class="banned"'; } ?> href="?p=user&u=<?php print $name; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $name;?></a></td>
    <td width=220px><a href="?p=gameinfo&gid=<?php print $gameid; ?>" target="_self"><?php print $gamename;?></a></td>
    <td width=70px><?php print $type;?></td>
	<td width=70px> <span <?php if($winner == 'LOST'){print 'class="lost"';}elseif($winner == 'WON'){print 'class="won"';} else{print 'class="draw"';} ?>><?php print $winner;?></span></td>
    <td width=70px><?php print $kills;?></td>
    <td width=70px><?php print $death;?></td>
    <td width=70px><?php print $assists;?></td>
	<td width=70px><?php print ROUND($kdratio,2);?></td>
	<td width=70px><?php print $creepkills;?></td>
    <td width=70px><?php print $creepdenies;?></td>
	<td width=70px><?php print $neutralkills;?></td>
 </tr>	
	<?php
	}
}
	?>
</table>
</div>
</div>
<div id="footer" class="footer">
</div>
