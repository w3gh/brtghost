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
	$offset=sqlite_escape_string($_GET["n"]);
	$interval=sqlite_escape_string($_GET["i"]);

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
	$offset=mysql_real_escape_string($_GET["n"]);
	$interval=mysql_real_escape_string($_GET["i"]);

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


$sql = "select count(*) as count from( SELECT ".$sqlGroupBy1." as y, ".$sqlGroupBy2." as m, ".$sqlGroupBy3." as mn FROM games";
if($ignorePubs)
{
	$sql = $sql." WHERE gamestate = '17'";
}
else if($ignorePrivs)
{
	$sql = $sql." WHERE gamestate = '16'";
}
$sql = $sql." group by ".$sqlGroupBy1.", ".$sqlGroupBy2." 
	order by ".$sqlGroupBy1." desc, ".$sqlGroupBy2." desc) as h";	

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

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		$count=$row["count"];
	}
	mysql_free_result($result);
}

$pages = ceil($count/$monthlyTopsResultSize);


$arrStatRow1 = array(
	$phrase55 => "SELECT original as topHero, description as topHeroName, kills as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase56 => "SELECT original as topHero, description as topHeroName, assists as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase57 => "SELECT original as topHero, description as topHeroName, deaths as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase58 => "SELECT original as topHero, description as topHeroName, creepkills as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase59 => "SELECT original as topHero, description as topHeroName, creepdenies as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid");

$arrStatRow2 = array(
	$phrase106 => "SELECT original as topHero, description as topHeroName, gold as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase107 => "SELECT original as topHero, description as topHeroName, neutralkills as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase108 => "SELECT original as topHero, description as topHeroName, towerkills as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase109 => "SELECT original as topHero, description as topHeroName, raxkills as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid",
	$phrase110 => "SELECT original as topHero, description as topHeroName, courierkills as topValue, b.name as topUser, a.gameid as topGame
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		JOIN heroes as d on hero = heroid");
		
$arrStatRow3 = array(
	$phrase111 => "SELECT name as topUser, case when (totKills = 0) then 0 when (totDeaths = 0) then 1000 else ((totKills*1.0)/(totDeaths*1.0)) end as topValue from (Select b.name as name, MAX(a.id) as id,
		SUM(kills) as totKills,
		SUM(deaths) as totDeaths 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0",
	$phrase112 => "SELECT name as topUser, case when (totAssists = 0) then 0 when (totDeaths = 0) then 1000 else ((totAssists*1.0)/(totDeaths*1.0)) end as topValue from (Select b.name as name, MAX(a.id) as id,
		SUM(assists) as totAssists,
		SUM(deaths) as totDeaths 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0",
	$phrase113 => "SELECT name as topUser, totGames as topValue from (Select b.name as name, MAX(a.id) as id,
		COUNT(*) as totGames,
		SUM(deaths) as totDeaths 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where name is not null",
	$phrase114 => "SELECT name as topUser, 100*wins*1.0/(totgames*1.0) as topValue, ' %' as topValueUnit from (Select b.name as name, MAX(a.id) as id,
		count(*) as totgames,
		SUM(case when((d.winner = 1 and a.newcolour < 6) or (d.winner = 2 and a.newcolour > 6)) then 1 else 0 end) as wins, 
		SUM(case when((d.winner = 2 and a.newcolour < 6) or (d.winner = 1 and a.newcolour > 6)) then 1 else 0 end) as losses
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0 AND b.`left`*1.0/c.duration*1.0 >= $minPlayedRatio",
	$phrase115 => "SELECT name as topUser, 100*playedTime*1.0/gameDuration*1.0 as topValue, ' %' as topValueUnit from (Select b.name as name, MAX(a.id) as id,
		SUM(`left`) as playedTime,
		SUM(duration) as gameDuration 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 1000");
		
$arrStatRow4 = array(
	$phrase116 => "SELECT name as topUser, sumKills as topValue from (Select b.name as name, MAX(a.id) as id,
		SUM(kills) as sumKills 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id",
	$phrase117 => "SELECT name as topUser, sumAssists as topValue from (Select b.name as name, MAX(a.id) as id,
		SUM(assists) as sumAssists 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id",
	$phrase118 => "SELECT name as topUser, sumDeaths as topValue from (Select b.name as name, MAX(a.id) as id,
		SUM(deaths) as sumDeaths 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id",
	$phrase119 => "SELECT name as topUser, sumCreepKills as topValue from (Select b.name as name, MAX(a.id) as id,
		SUM(creepkills) as sumCreepKills 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id",
	$phrase120 => "SELECT name as topUser, sumCreepDenies as topValue from (Select b.name as name, MAX(a.id) as id,
		SUM(creepdenies) as sumCreepDenies 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id");
		
$arrStatRow5 = array(
	$phrase121 => "SELECT name as topUser, sumKills*1.0/totGames*1.0 as topValue from (Select b.name as name, MAX(a.id) as id,
		COUNT(*) as totGames,
		SUM(kills) as sumKills 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0",
	$phrase122 => "SELECT name as topUser, sumAssists*1.0/totGames*1.0 as topValue from (Select b.name as name, MAX(a.id) as id,
		COUNT(*) as totGames,
		SUM(assists) as sumAssists 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0",			
	$phrase123 => "SELECT name as topUser, sumDeaths*1.0/totGames*1.0 as topValue from (Select b.name as name, MAX(a.id) as id,
		COUNT(*) as totGames,
		SUM(deaths) as sumDeaths 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0",			
	$phrase124 => "SELECT name as topUser, sumCreepKills*1.0/totGames*1.0 as topValue from (Select b.name as name, MAX(a.id) as id,
		COUNT(*) as totGames,
		SUM(creepkills) as sumCreepKills 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0",			
	$phrase125 => "SELECT name as topUser, sumCreepDenies*1.0/totGames*1.0 as topValue from (Select b.name as name, MAX(a.id) as id,
		COUNT(*) as totGames,
		SUM(creepdenies) as sumCreepDenies 
		FROM dotaplayers AS a 
		LEFT JOIN gameplayers AS b ON a.gameid = b.gameid and a.colour = b.colour 
		LEFT JOIN games as c on a.gameid = c.id 
		LEFT JOIN dotagames as d on d.gameid = c.id
		where winner <> 0");		
		

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
							print "<a href=\"?p=monthlytop&n=all&i=".$interval."\">".$phrase128." ".$intervalname.$phrase127."</a>";
						}
						print "<br/><br/>";
						if($interval == 'week')
						{
							print "<a href=\"?p=monthlytop&n=".$offset."&i=month\">".$phrase129."</a>";
						}
						else
						{
							print "<a href=\"?p=monthlytop&n=".$offset."&i=week\">".$phrase129."</a>";
						}
						?>
						</td>
					</tr>
					</h4>
				</table>
			</td>
			<td width=50%>
				<h2><?php print $intervalname.$phrase130." "; if($ignorePubs){ print $phrase48;} else if($ignorePrivs){ print $phrase49;} else { print $phrase50;} ?></h2>
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
						$min = $offset*$monthlyTopsResultSize+1;
						$max = $offset*$monthlyTopsResultSize+$monthlyTopsResultSize;
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
						print "<td width=35px><a href=\"?p=monthlytop&n=".($counter-1)."&i=".$interval."\">".$counter."</a></td>";
						}
					}
					print "<td width=35px><span class=\"ddd\">></span></td>";
				}
				else
				{
					if($offset > 0)
					{
						print "<td width=35px><a href=\"?p=monthlytop&n=".($offset-1)."&i=".$interval."\"><</a>";
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
									print "<td width=35px><a href=\"?p=monthlytop&n=".($counter-1)."&i=".$interval."\">".$counter."</a></td>";
								}
							}
						}
						if($offset == 1)
						{
							print "<td width=35px><a href=\"?p=monthlytop&n=0&i=".$interval."\">1</a></td>";
							print "<td width=35px><span class=\"ddd\">2</span></td>";
							for($counter = 3; $counter < 6; $counter++)
							{
								if($counter-1 < $pages)
								{
								print "<td width=35px><a href=\"?p=monthlytop&n=".($counter-1)."&i=".$interval."\">".$counter."</a></td>";
								
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
								print "<td width=35px><a href=\"?p=monthlytop&n=".($counter-1)."&i=".$interval."\">".$counter."</a></td>";
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
									print "<td width=35px><a href=\"?p=monthlytop&n=".($counter-1)."&i=".$interval."\">".$counter."</a></td>";
								}
							}
							print "<td width=35px><span class=\"ddd\">".($offset+1)."</span>";
							print "<td width=35px><a href=\"?p=monthlytop&n=".($offset+1)."&i=".$interval."\">".($offset+2)."</a></td>";
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
								print "<td width=35px><a href=\"?p=monthlytop&n=".($counter-1)."&i=".$interval."\">".$counter."</a></td>";
							}
						}
					}
					if(($offset+1)*$monthlyTopsResultSize < $count)
					{
						print "<td width=35px><a href=\"?p=monthlytop&n=".($offset+1)."&i=".$interval."\">></a></td>";
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

	</div>

	<div id="datawrapper">
		


<?php
if($dbType == 'sqlite')
{
	$sql0 = "SELECT ".$sqlGroupBy1." as y, ".$sqlGroupBy2." as m, ".$sqlGroupBy3." as mn FROM games";
	if($ignorePubs)
	{
		$sql0 = $sql0." WHERE gamestate = '17'";
	}
	else if($ignorePrivs)
	{
		$sql0 = $sql0." WHERE gamestate = '16'";
	}
	$sql0 = $sql0." group by ".$sqlGroupBy1.", ".$sqlGroupBy2." 
		order by ".$sqlGroupBy1." desc, ".$sqlGroupBy2." desc";
	if($offset!='all')
	{
		$sql0 = $sql0." LIMIT ".$monthlyTopsResultSize*$offset.", $monthlyTopsResultSize";
	}

	foreach ($dbHandle->query($sql0, PDO::FETCH_ASSOC) as $row0)
	{

		$year=$row0["y"];
		$month=$row0["m"];
		$monthname=$row0["mn"];

	?>

	<table class="table" width=1000px>
		<tr>
			<td colspan=5 class="contentspanheadercell">
				<h3><?php print $monthname; ?> <?php print $year; ?></h3>
			</td>
		</tr>

<?php
		if($monthlyRow1) // ############################################ SQLITE Stats Row 1 #####################################################
		{
?>
		<tr>
		
<?php
			foreach($arrStatRow1 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>

<?php
		
				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." LEFT JOIN bans on b.name = bans.name";
				}

				$sql = $sql." where ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}

				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." AND bans.name is null";
				}

				$sql = $sql." ORDER BY topValue DESC, a.id ASC LIMIT ".$monthlyTopsListSize;
		
				$rows = 0;
				foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows1($monthlyTopsListSize - $rows);
?>

					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>			
			
		</tr>			
	
<?php
		}
		if($monthlyRow2) // ############################################ SQLITE Stats Row 2 #####################################################
		{
?>		


		<tr>
		
<?php
			foreach($arrStatRow2 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>

<?php

				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." LEFT JOIN bans on b.name = bans.name";
				}

				$sql = $sql." where ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}

				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." AND bans.name is null";
				}
				$sql = $sql." ORDER BY topValue DESC, a.id ASC LIMIT ".$monthlyTopsListSize;
		
				$rows = 0;
				foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows1($monthlyTopsListSize - $rows);
?>

					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>			
			
		</tr>	
		
<?php
		}
		if($monthlyRow3) // ############################################ SQLITE Stats Row 3 #####################################################
		{
?>		

<?php
			foreach($arrStatRow3 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>
<?php

				$sql = $sql." AND ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}
				$sql = $sql." group by b.name having count(*) >= ".$montlyMinGames.") as subsel ORDER BY topValue DESC, id ASC LIMIT ".$monthlyTopsListSize;

				$rows = 0;
				foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows2($monthlyTopsListSize - $rows);
?>
					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>
		</tr>
		
<?php
		}
		if($monthlyRow4) // ############################################ SQLITE Stats Row 4 #####################################################
		{
?>		
		
		<tr>
		
<?php
			foreach($arrStatRow4 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>
<?php

				$sql = $sql." where ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}
				$sql = $sql." group by b.name having count(*) >= ".$montlyMinGames.") as subsel ORDER BY topValue DESC, id ASC LIMIT ".$monthlyTopsListSize;

				$rows = 0;
				foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows2($monthlyTopsListSize - $rows);
?>
					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>
		</tr>
		
		
<?php
		}
		if($monthlyRow5) // ############################################ SQLITE Stats Row 5 #####################################################
		{
?>		

		<tr>
		
<?php
			foreach($arrStatRow5 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>
<?php

				$sql = $sql." AND ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}
				$sql = $sql." group by b.name having count(*) >= ".$montlyMinGames.") as subsel ORDER BY topValue DESC, id ASC LIMIT ".$monthlyTopsListSize;

				$rows = 0;
				foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows2($monthlyTopsListSize - $rows);
?>
					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>
		</tr>		
		
		
<?php
		} // ############################################ __END__ SQLITE Stats Row 5 #####################################################
?>
	</table>

<?php
	}
}
else  // #################################################### MYSQL #########################################################
{
	$sql0 = "SELECT ".$sqlGroupBy1." as y, ".$sqlGroupBy2." as m, ".$sqlGroupBy3." as mn FROM games";
	if($ignorePubs)
	{
		$sql0 = $sql0." WHERE gamestate = '17'";
	}
	else if($ignorePrivs)
	{
		$sql0 = $sql0." WHERE gamestate = '16'";
	}
	$sql0 = $sql0." group by ".$sqlGroupBy1.", ".$sqlGroupBy2.", ".$sqlGroupBy3." 
		order by ".$sqlGroupBy1." desc, ".$sqlGroupBy2." desc";
	if($offset!='all')
	{
		$sql0 = $sql0." LIMIT ".$monthlyTopsResultSize*$offset.", $monthlyTopsResultSize";
	}

	$result0 = mysql_query($sql0);
	while ($row0 = mysql_fetch_array($result0, MYSQL_ASSOC)) 
	{

		$year=$row0["y"];
		$month=$row0["m"];
		$monthname=$row0["mn"];


	?>

	<table class="table" width=1000px>
		<tr>
			<td colspan=5 class="contentspanheadercell">
				<h3><?php print $monthname; ?> <?php print $year; ?></h3>
			</td>
		</tr>

<?php
		if($monthlyRow1) // ############################################ MYSQL Stats Row 1 #####################################################
		{
?>
		<tr>
		
<?php
			foreach($arrStatRow1 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>

<?php
				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." LEFT JOIN bans on b.name = bans.name";
				}

				$sql = $sql." where ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}

				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." AND bans.name is null";
				}
				$sql = $sql." ORDER BY topValue DESC, a.id ASC LIMIT ".$monthlyTopsListSize;
		
				$rows = 0;
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows1($monthlyTopsListSize - $rows);
				mysql_free_result($result);
?>

					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>			
			
		</tr>	

<?php
		}
		if($monthlyRow2) // ############################################ MYSQL Stats Row 2 #####################################################
		{
?>
		<tr>
		
<?php
			foreach($arrStatRow2 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>

<?php
				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." LEFT JOIN bans on b.name = bans.name";
				}

				$sql = $sql." where ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}

				if($hideBannedPlayersOnTops)
				{
					$sql = $sql." AND bans.name is null";
				}
				$sql = $sql." ORDER BY topValue DESC, a.id ASC LIMIT ".$monthlyTopsListSize;
		
				$rows = 0;
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows1($monthlyTopsListSize - $rows);
				mysql_free_result($result);
?>

					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>			
			
		</tr>	
		
<?php
		}
		if($monthlyRow3) // ############################################ MYSQL Stats Row 3 #####################################################
		{
?>

		<tr>
		
<?php
			foreach($arrStatRow3 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>
<?php

				$sql = $sql." AND ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}
				$sql = $sql." group by b.name having count(*) >= ".$montlyMinGames.") as subsel ORDER BY topValue DESC, id ASC LIMIT ".$monthlyTopsListSize;

				$rows = 0;
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows2($monthlyTopsListSize - $rows);
				mysql_free_result($result);
?>
					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>
		</tr>

<?php
		}
		if($monthlyRow4) // ############################################ MYSQL Stats Row 4 #####################################################
		{
?>

		<tr>
		
<?php
			foreach($arrStatRow4 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>
<?php

				$sql = $sql." where ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}
				$sql = $sql." group by b.name having count(*) >= ".$montlyMinGames.") as subsel ORDER BY topValue DESC, id ASC LIMIT ".$monthlyTopsListSize;

				$rows = 0;
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows2($monthlyTopsListSize - $rows);
				mysql_free_result($result);
?>
					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>
		</tr>

<?php
		}
		if($monthlyRow5) // ############################################ MYSQL Stats Row 5 #####################################################
		{
?>

		<tr>
		
<?php
			foreach($arrStatRow5 as $title => $sql)
			{
?>

			<td width=20%>
				<table width=100%>
					<tr>
						<td align=center colspan=3 class="contentheadercell"><?php print $title; ?></td>
					</tr>
<?php

				$sql = $sql." AND ".$sqlGroupBy1." = '$year' AND ".$sqlGroupBy2." = '$month'";
				if($ignorePubs)
				{
					$sql = $sql." AND gamestate = '17'";
				}
				else if($ignorePrivs)
				{
					$sql = $sql." AND gamestate = '16'";
				}
				$sql = $sql." group by b.name having count(*) >= ".$montlyMinGames.") as subsel ORDER BY topValue DESC, id ASC LIMIT ".$monthlyTopsListSize;

				$rows = 0;
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
				{
					$rows = $rows + printStatsRowType($row);
				}
				fillEmptyStatsRows2($monthlyTopsListSize - $rows);
				mysql_free_result($result);
?>
					<tr>
						<td colspan=3 class="contentemptyspacer"></td>
					<tr>
				</table>
			</td>
			
<?php
			}
?>
		</tr>


<?php
		} // ############################################ __END__ MYSQL Stats Row 5 #####################################################

?>
	</table>
<?php
	}
	mysql_free_result($result0);
}
?>


	</div>
</div>

<div id="footer" class="footer">
		<h5><?php print $phrase89." ".$intervalname.$phrase127; ?>: <?php print $count; ?></h5>
</div>
