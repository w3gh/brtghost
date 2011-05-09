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

require_once("functions.php");
require_once("config.php");

if($dbType == 'sqlite')
{
	$sortcat=sqlite_escape_string($_GET["s"]);
	$order=sqlite_escape_string($_GET["o"]);
	$offset=sqlite_escape_string($_GET["n"]);
	$interval=sqlite_escape_string($_GET["i"]);
	$username=sqlite_escape_string($_GET["u"]);

	if($interval == 'week' || $interval == 'Week')
	{
		$interval="week";
		$intervalname=$phrase104;
		$sqlGroupBy1="strftime('%Y', datetime)";
		$sqlGroupBy2="strftime('%W', datetime)";
		$sqlGroupBy3="strftime('%W', datetime)";
	}
	else
	{
		$interval="month";
		$intervalname=$phrase105;
		$sqlGroupBy1="strftime('%Y', datetime)";
		$sqlGroupBy2="strftime('%m', datetime)";
		$sqlGroupBy3="strftime('%m', datetime)";
	}
}
else
{
	$sortcat=mysql_real_escape_string($_GET["s"]);
	$order=mysql_real_escape_string($_GET["o"]);
	$offset=mysql_real_escape_string($_GET["n"]);
	$interval=mysql_real_escape_string($_GET["i"]);
	$username=mysql_real_escape_string($_GET["u"]);

	if($interval == 'week' || $interval == 'Week')
	{
		$interval="week";
		$intervalname=$phrase104;
		$sqlGroupBy1="YEAR(datetime)";
		$sqlGroupBy2="WEEK(datetime,3)";
		$sqlGroupBy3="WEEK(datetime,3)";
	}
	else
	{
		$interval="month";
		$intervalname=$phrase105;
		$sqlGroupBy1="YEAR(datetime)";
		$sqlGroupBy2="MONTH(datetime)";
		$sqlGroupBy3="MONTHNAME(datetime)";
	}
}

$sql = "select count(*) as count from( select name from gameplayers as gp, dotagames as dg, games as ga,dotaplayers as dp where dg.winner <> 0 and dp.gameid = gp.gameid 
and dg.gameid = dp.gameid and dp.gameid = ga.id and gp.gameid = dg.gameid and gp.colour = dp.colour and gp.name = '$username'";

if($ignorePubs)
{
$sql = $sql." and gamestate = '17'";
}
else if($ignorePrivs)
{
$sql = $sql." and gamestate = '16'";
}

$sql = $sql." group by ".$sqlGroupBy1.", ".$sqlGroupBy2." having count(*) >= $historyMinGames) as h";

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

	$pages = ceil($count/$userHistoryResultSize);

?>
<div class="header" id="header">
	<table width=1016px>
		<tr>
			<td width=25%>
				<table class="rowuh" width = 235px style="float:left">
					<h4>
					<tr>
						<td>
						<?php
						if($offset == 'all')
						{
							print $phrase126." ".$intervalname.$phrase127;
						}
						else
						{
							print "<a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&i=".$interval."&u=".$username."&n=all\">".$phrase128." ".$intervalname.$phrase127;
						}
						print "<br/><br/>";
						if($interval == 'week')
						{
							print "<a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&n=".$offset."&i=month\">".$phrase129."</a>";
						}
						else
						{
							print "<a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&n=".$offset."&i=week\">".$phrase129."</a>";
						}						
						?>
						</td>
					</tr>
					</h4>
				</table>
			</td>
			<td width=50%>
				<h2><?php print $intervalname.$phrase145; ?>: <a href="?p=user&u=<?php print $username; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $username; ?></a></h2>
			</td>
			<td width=25% class="rowuh">
				<table class="rowuh" width = 235px style="float:right">
				<h4>
				<tr>
					<td colspan=7>
					<?php
					if($offset == 'all')
					{
						print $phrase170." ".$intervalname.$phrase127." ".$phrase131.":";
					}
					else
					{
						$min = $offset*$userHistoryResultSize+1;
						$max = $offset*$userHistoryResultSize+$userHistoryResultSize;
						if($max > $count)
						{
							$max = $count;
						}
						print $phrase169." ".$intervalname.$phrase127.": ".$min." - ".$max;
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
						print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($counter-1)."\">".$counter."</a></td>";
						}
					}
					print "<td width=35px><span class=\"ddd\">></span></td>";
				}
				else
				{
					if($offset > 0)
					{
						print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($offset-1)."\"><</a>";
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
									print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
						}
						if($offset == 1)
						{
							print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=0\">1</a></td>";
							print "<td width=35px><span class=\"ddd\">2</span></td>";
							for($counter = 3; $counter < 6; $counter++)
							{
								if($counter-1 < $pages)
								{
								print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($counter-1)."\">".$counter."</a></td>";
								
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
								print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($counter-1)."\">".$counter."</a></td>";
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
									print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
							print "<td width=35px><span class=\"ddd\">".($offset+1)."</span>";
							print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($offset+1)."\">".($offset+2)."</a></td>";
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
								print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($counter-1)."\">".$counter."</a></td>";
							}
						}
					}
					if(($offset+1)*$userHistoryResultSize < $count)
					{
						print "<td width=35px><a href=\"?p=userhistory&s=".$sortcat."&o=".$order."&u=".$username."&i=".$interval."&n=".($offset+1)."\">></a></td>";
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

//User Name
if($sortcat == "datetime")
{
	if($order == "asc")
	{
		print("<td width=160px><a href=\"?p=userhistory&s=datetime&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$interval."</a></td>");
	}
	else
	{
		print("<td width=160px><a href=\"?p=userhistory&s=datetime&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$interval."</a></td>");
	}
}
else
{
	print("<td width=160px><a href=\"?p=userhistory&s=datetime&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$interval."</a></td>");
}
//Games
if($sortcat == "totgames")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=totgames&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase26."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=totgames&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase26."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=totgames&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase26."</a></td>");
}
//Wins
if($sortcat == "wins")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=wins&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase28."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=wins&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase28."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=wins&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase28."</a></td>");
}
//Losses
if($sortcat == "losses")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=losses&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase29."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=losses&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase29."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=losses&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase29."</a></td>");
}
//WinPercent
if($sortcat == "winpercent")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=winpercent&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase175."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=winpercent&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase175."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=winpercent&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase175."</a></td>");
}	//Kills
if($sortcat == "kills")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=kills&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=kills&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=kills&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase9."</a></td>");
}
//CreepKills
if($sortcat == "deaths")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=deaths&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=deaths&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=deaths&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase10."</a></td>");
}
//Assists
if($sortcat == "assists")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=assists&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=assists&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=assists&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase11."</a></td>");
}
//KDRatio
if($sortcat == "killdeathratio")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=killdeathratio&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase45."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=killdeathratio&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase45."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=killdeathratio&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase45."</a></td>");
}
//Creep Kills
if($sortcat == "creepkills")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=creepkills&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=creepkills&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=creepkills&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase42."</a></td>");
}
//Denies
if($sortcat == "creepdenies")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=creepdenies&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=creepdenies&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=creepdenies&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase43."</a></td>");
}
//Neutral Kills
if($sortcat == "neutralkills")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=neutralkills&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=neutralkills&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=neutralkills&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase44."</a></td>");
}
//Time Played
if($sortcat == "timeplayed")
{
	if($order == "asc")
	{
		print("<td width=70px><a href=\"?p=userhistory&s=timeplayed&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase146."</a></td>");
	}
	else
	{
		print("<td width=70px><a href=\"?p=userhistory&s=timeplayed&o=asc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase146."</a></td>");
	}
}
else
{
	print("<td width=70px><a href=\"?p=userhistory&s=timeplayed&o=desc&u=".$username."&i=".$interval."&n=".$sortoffset."\">".$phrase146."</a></td>");
}
?>
				<td width=16px></td>
			</tr>
		</table>
	</div>
	<div id="datawrapper">
		<table class="table" id="data">
<?php

$sql = "select *,(kills/deaths) as killdeathratio, (wins+0.000001)/(losses+0.000001) as winpercent from (
select ".$sqlGroupBy1." as y, ".$sqlGroupBy2." as m, ".$sqlGroupBy3." as mn, MIN(datetime) as datetime, avg(dp.courierkills) as courierkills, avg(dp.raxkills) as raxkills,
avg(dp.towerkills) as towerkills, avg(dp.assists) as assists, avg(dp.creepdenies) as creepdenies, avg(dp.creepkills) as creepkills,
avg(dp.neutralkills) as neutralkills, avg(dp.deaths) as deaths, avg(dp.kills) as kills, SUM(`left`) as timeplayed,
count(*) as totgames, 
SUM(case when(((dg.winner = 1 and dp.newcolour < 6) or (dg.winner = 2 and dp.newcolour > 6)) AND gp.`left`/ga.duration >= $minPlayedRatio) then 1 else 0 end) as wins, 
SUM(case when(((dg.winner = 2 and dp.newcolour < 6) or (dg.winner = 1 and dp.newcolour > 6)) AND gp.`left`/ga.duration >= $minPlayedRatio) then 1 else 0 end) as losses
from gameplayers as gp LEFT JOIN dotagames as dg ON gp.gameid = dg.gameid LEFT JOIN dotaplayers as dp ON dg.gameid = dp.gameid and gp.colour = dp.colour and dp.newcolour <> 12 and dp.newcolour <> 6
LEFT JOIN games as ga ON dp.gameid = ga.id 
where dg.winner <> 0 and gp.name = '$username'";

if($ignorePubs)
{
$sql = $sql." and gamestate = '17'";
}
else if($ignorePrivs)
{
$sql = $sql." and gamestate = '16'";
}

$sql = $sql." group by ".$sqlGroupBy1.", ".$sqlGroupBy2." having totgames >= $historyMinGames) as h ORDER BY $sortcat $order";


if($offset!='all')
{
$sql = $sql." LIMIT ".$userHistoryResultSize*$offset.", $userHistoryResultSize";
}

if($dbType == 'sqlite')
{
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$year=$row["y"];
		$month=$row["m"];
		$monthname=$row["mn"];
		$totgames=$row["totgames"];
		$kills=$row["kills"];
		$death=$row["deaths"];
		$assists=$row["assists"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$courierkills=$row["courierkills"];
		$wins=$row["wins"];
		$losses=$row["losses"];
		$timeplayed=secondsToTime($row["timeplayed"]);
		if($wins == 0)
		{ 
			$winpercent = 0;
		} 
		else 
		{
			$winpercent = round($wins/($wins+$losses), 4)*100;
		}
		$killdeathratio=ROUND($row["killdeathratio"],2);

	?>
	<tr class="row">
    <td width=160px><?php print $monthname; ?> <?php print $year; ?></td>
	<td width=70px><?php print $totgames;?></td>
	<td width=70px><?php print $wins; ?></td>
	<td width=70px><?php print $losses; ?></td>
	<td width=70px><?php print $winpercent; ?> %</td>
	<td width=70px><?php print ROUND($kills,1); ?></td>
	<td width=70px><?php print ROUND($death,1); ?></td>
	<td width=70px><?php print ROUND($assists,1); ?></td>
	<td width=70px><?php print $killdeathratio; ?></td>

	<td width=70px><?php print ROUND($creepkills,1) ?></td>
	<td width=70px><?php print ROUND($creepdenies,1); ?></td>
	<td width=70px><?php print ROUND($neutralkills,1); ?></td>
	<td width=70px><?php print $timeplayed; ?></td>


	</tr>

	<?php
	}
}
else
{
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$year=$row["y"];
		$month=$row["m"];
		$monthname=$row["mn"];
		$totgames=$row["totgames"];
		$kills=$row["kills"];
		$death=$row["deaths"];
		$assists=$row["assists"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$courierkills=$row["courierkills"];
		$wins=$row["wins"];
		$losses=$row["losses"];
		$timeplayed=secondsToTime($row["timeplayed"]);
		if($wins == 0)
		{ 
			$winpercent = 0;
		} 
		else 
		{
			$winpercent = round($wins/($wins+$losses), 4)*100;
		}
		$killdeathratio=ROUND($row["killdeathratio"],2);

	?>
	<tr class="row">
    <td width=160px><?php print $monthname; ?> <?php print $year; ?></td>
	<td width=70px><?php print $totgames;?></td>
	<td width=70px><?php print $wins; ?></td>
	<td width=70px><?php print $losses; ?></td>
	<td width=70px><?php print $winpercent; ?> %</td>
	<td width=70px><?php print ROUND($kills,1); ?></td>
	<td width=70px><?php print ROUND($death,1); ?></td>
	<td width=70px><?php print ROUND($assists,1); ?></td>
	<td width=70px><?php print $killdeathratio; ?></td>

	<td width=70px><?php print ROUND($creepkills,1) ?></td>
	<td width=70px><?php print ROUND($creepdenies,1); ?></td>
	<td width=70px><?php print ROUND($neutralkills,1); ?></td>
	<td width=70px><?php print $timeplayed; ?></td>


	</tr>

	<?php
	}
	mysql_free_result($result);
}
?>
		</table>
	</div>
</div>

<div id="footerdata" class="footerdata">
	<table class="table" width=1016px>
		<tr>
			<td colspan=5>
				<h3><?php print $username.$phrase176." ".$phrase54; ?></h3>
			</td>
		</tr>
		<tr>


<?php // #################################################### Footer Stats #########################################################


$arrStatRow = array(
	$phrase55 => "SELECT original as topHero, description as topHeroName, kills as topValue, datetime as topDate, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id
		LEFT JOIN heroes as d on hero = heroid",
	$phrase56 => "SELECT original as topHero, description as topHeroName, assists as topValue, datetime as topDate, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id
		LEFT JOIN heroes as d on hero = heroid",
	$phrase57 => "SELECT original as topHero, description as topHeroName, deaths as topValue, datetime as topDate, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id
		LEFT JOIN heroes as d on hero = heroid",
	$phrase58 => "SELECT original as topHero, description as topHeroName, creepkills as topValue, datetime as topDate, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id
		LEFT JOIN heroes as d on hero = heroid",
	$phrase59 => "SELECT original as topHero, description as topHeroName, creepdenies as topValue, datetime as topDate, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id
		LEFT JOIN heroes as d on hero = heroid");


if($dbType == 'sqlite') // #################################################### SQLITE #########################################################
{
	foreach($arrStatRow as $title => $sql)
	{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="footerheadercell"><?php print $title; ?></td>
					</tr>

<?php
		$sql = $sql." WHERE name = '$username'";
		if($ignorePubs)
		{
			$sql = $sql." AND gamestate = '17'";
		}
		else if($ignorePrivs)
		{
			$sql = $sql." AND gamestate = '16'";
		}
		$sql = $sql." ORDER BY topValue DESC, a.id ASC LIMIT ".$monthlyTopsListSize;	
		
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			printStatsRowType($row);
		}
?>
				</table>
			</td>
			
<?php
	}
}
else  // #################################################### MYSQL #########################################################
{
	foreach($arrStatRow as $title => $sql)
	{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="footerheadercell"><?php print $title; ?></td>
					</tr>

<?php
		$sql = $sql." WHERE name = '$username'";
		if($ignorePubs)
		{
			$sql = $sql." AND gamestate = '17'";
		}
		else if($ignorePrivs)
		{
			$sql = $sql." AND gamestate = '16'";
		}
		$sql = $sql." ORDER BY topValue DESC, a.id ASC LIMIT ".$monthlyTopsListSize;	
		
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
			printStatsRowType($row);
		}
		mysql_free_result($result);
?>

				</table>
			</td>
			
<?php
	}
}
?>			

		</tr>
	</table>
</div>
<div id="footer" class="footer">
		<h5><?php print $phrase46;?>: <?php print $count; ?></h5>
</div>