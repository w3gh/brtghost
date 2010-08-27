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
}
else
{
	$sortcat=mysql_real_escape_string($_GET["s"]);
	$order=mysql_real_escape_string($_GET["o"]);
	$offset=mysql_real_escape_string($_GET["n"]);
}

$sql = "SELECT COUNT( DISTINCT name ) as players from gameplayers as gp LEFT JOIN games as g ON gp.gameid = g.id, dotaplayers as dp where dp.gameid = gp.gameid and dp.colour = gp.colour";
if($ignorePubs)
{
$sql = $sql." and g.gamestate = '17'";
}
else if($ignorePrivs)
{
$sql = $sql." and g.gamestate = '16'";
}

if($dbType == 'sqlite')
{
foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$count=$row["players"];
	}	
}
else
{
	$result = mysql_query($sql);

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$count=$row["players"];
		}
	mysql_free_result($result);
}

	$pages = ceil($count/$allPlayerResultSize);
	?>
<div class="header" id="header">
	<table width=1016px>
	<tr>
		<td width=25%>
			<table class="rowuh" width = 235px style="float:left">
				<tr>
					<td>
					<?php
					if($offset == 'all')
					{
						print $phrase159;
					}
					else
					{
						print "<a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=all\"><strong>".$phrase160."</strong></a>";
					}
					?>
					</td>
				</tr>
			</table>
			</td>
			<td width=50%>
				<h2><?php print $phrase144." "; if($ignorePubs){ print $phrase48;} else if($ignorePrivs){ print $phrase49;} else { print $phrase50;} ?>:</h2>
			</td>
			<td width=25% class="rowuh">
				<table class="rowuh" width = 235px style="float:right">
				<h4>
				<tr>
					<td colspan=7>
					<?php
					if($offset == 'all')
					{
						print $phrase161.":";
					}
					else
					{
						$min = $offset*$allPlayerResultSize+1;
						$max = $offset*$allPlayerResultSize+$allPlayerResultSize;
						if($max > $count)
						{
							$max = $count;
						}
						print $phrase162.": ".$min." - ".$max;
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
						print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
						}
					}
					print "<td width=35px><span class=\"ddd\">></span></td>";
				}
				else
				{
					if($offset > 0)
					{
						print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($offset-1)."\"><strong><</strong></a>";
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
									print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
						}
						if($offset == 1)
						{
							print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=0\">1</a></td>";
							print "<td width=35px><span class=\"ddd\">2</span></td>";
							for($counter = 3; $counter < 6; $counter++)
							{
								if($counter-1 < $pages)
								{
								print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								
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
								print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
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
									print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
							print "<td width=35px><span class=\"ddd\">".($offset+1)."</span>";
							print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($offset+1)."\">".($offset+2)."</a></td>";
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
								print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
							}
						}
					}
					if(($offset+1)*$allPlayerResultSize < $count)
					{
						print "<td width=35px><a href=\"?p=allusers&s=".$sortcat."&o=".$order."&n=".($offset+1)."\"><strong>></strong></a></td>";
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
			<tr>
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
if($sortcat == "name")
{
			$sortcat = "b.name";
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=200px><a href=\"?p=allusers&s=name&o=desc&n=".$sortoffset."\">".$phrase7."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=200px><a href=\"?p=allusers&s=name&o=asc&n=".$sortoffset."\">".$phrase7."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=200px><a href=\"?p=allusers&s=name&o=asc&n=".$sortoffset."\">".$phrase7."</a></td>");
}

//Games
if($sortcat == "totgames")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=totgames&o=desc&n=".$sortoffset."\">".$phrase26."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=totgames&o=asc&n=".$sortoffset."\">".$phrase26."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=totgames&o=desc&n=".$sortoffset."\">".$phrase26."</a></td>");
}

//Kills
if($sortcat == "kills")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=kills&o=desc&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=kills&o=asc&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=kills&o=desc&n=".$sortoffset."\">".$phrase9."</a></td>");
}

//Deaths
if($sortcat == "deaths")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=deaths&o=desc&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=deaths&o=asc&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=deaths&o=desc&n=".$sortoffset."\">".$phrase10."</a></td>");
}

//Assists
if($sortcat == "assists")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=assists&o=desc&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=assists&o=asc&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=assists&o=desc&n=".$sortoffset."\">".$phrase11."</a></td>");
}

//Creep Kills
if($sortcat == "creepkills")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=creepkills&o=desc&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=creepkills&o=asc&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=creepkills&o=desc&n=".$sortoffset."\">".$phrase42."</a></td>");
}

//Creep Denies
if($sortcat == "creepdenies")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=creepdenies&o=desc&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=creepdenies&o=asc&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=creepdenies&o=desc&n=".$sortoffset."\">".$phrase43."</a></td>");
}

//Neutral Kills
if($sortcat == "neutralkills")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=neutralkills&o=desc&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=neutralkills&o=asc&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=neutralkills&o=desc&n=".$sortoffset."\">".$phrase44."</a></td>");
}

//Tower Kills
if($sortcat == "towerkills")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=towerkills&o=desc&n=".$sortoffset."\">".$phrase31."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=towerkills&o=asc&n=".$sortoffset."\">".$phrase31."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=allusers&s=towerkills&o=desc&n=".$sortoffset."\">".$phrase31."</a></td>");
}

//First Played
if($sortcat == "firstplayed")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=100px><a href=\"?p=allusers&s=firstplayed&o=desc&n=".$sortoffset."\">".$phrase90."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=100px><a href=\"?p=allusers&s=firstplayed&o=asc&n=".$sortoffset."\">".$phrase90."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=100px><a href=\"?p=allusers&s=firstplayed&o=desc&n=".$sortoffset."\">".$phrase90."</a></td>");
}

//Last Played
if($sortcat == "lastplayed")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=100px><a href=\"?p=allusers&s=lastplayed&o=desc&n=".$sortoffset."\">".$phrase91."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=100px><a href=\"?p=allusers&s=lastplayed&o=asc&n=".$sortoffset."\">".$phrase91."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=100px><a href=\"?p=allusers&s=lastplayed&o=desc&n=".$sortoffset."\">".$phrase91."</a></td>");
}

?>					
			<td class="headercell" width=16px></td>
			</tr>
	 </table>
	</div>
	<div id="datawrapper">
		<table class="table" id="data">
<?php
 
$sql = "SELECT COUNT(a.id) as totgames, AVG(kills) as kills, AVG(deaths) as deaths, AVG(assists) as assists,
AVG(creepkills) as creepkills, AVG(creepdenies) as creepdenies,  AVG(neutralkills) as neutralkills, AVG(towerkills) as towerkills, 
MAX(datetime) as lastplayed, MIN(datetime) as firstplayed, b.name as name, e.name as banname 
FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
LEFT JOIN dotagames AS c ON c.gameid = a.gameid LEFT JOIN games as d ON d.id = c.gameid 
LEFT JOIN bans AS e on b.name = e.name
where b.name <> '' and winner <> 0";
if($ignorePubs)
{
$sql = $sql." and d.gamestate = '17'";
}
else if($ignorePrivs)
{
$sql = $sql." and d.gamestate = '16'";
}
$sql = $sql." group by b.name ORDER BY $sortcat $order, b.name asc";
if($offset!='all')
{
$sql = $sql." LIMIT ".$allPlayerResultSize*$offset.", $allPlayerResultSize";
}

if($dbType == 'sqlite')
{ 
foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$totgames=$row["totgames"];
		$kills=$row["kills"];
		$death=$row["deaths"];
		$assists=$row["assists"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$towerkills=$row["towerkills"];
		$firstplayed=substr($row["firstplayed"],0,10);
		$lastplayed=substr($row["lastplayed"],0,10);
		$name=$row["name"];
        $banname=$row["banname"];
	?>

	<tr class="row">
		<td width=200px><a <?php if($banname<>'') { print 'class="banned"'; } ?> href="?p=user&u=<?php print $name; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $name; ?></a></td>
		<td width=75px><?php print $totgames; ?></td>
		<td width=75px><?php print ROUND($kills, 1); ?></td>
		<td width=75px><?php print ROUND($death, 1); ?></td>
		<td width=75px><?php print ROUND($assists, 1); ?></td>
		<td width=75px><?php print ROUND($creepkills, 1); ?></td>
		<td width=75px><?php print ROUND($creepdenies, 1); ?></td>
		<td width=75px><?php print ROUND($neutralkills, 1); ?></td>
		<td width=75px><?php print ROUND($towerkills, 1); ?></td>
		<td width=100px><?php print $firstplayed; ?></td>
		<td width=100px><?php print $lastplayed; ?></td>
	</tr>

	<?php
	}
}
else
{
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$totgames=$row["totgames"];
		$kills=$row["kills"];
		$death=$row["deaths"];
		$assists=$row["assists"];
		$creepkills=$row["creepkills"];
		$creepdenies=$row["creepdenies"];
		$neutralkills=$row["neutralkills"];
		$towerkills=$row["towerkills"];
		$firstplayed=substr($row["firstplayed"],0,10);
		$lastplayed=substr($row["lastplayed"],0,10);
		$name=$row["name"];
		$banname=$row["banname"];

	?>

	<tr class="row">
		<td width=200px><a <?php if($banname<>'') { print 'class="banned"'; } ?> href="?p=user&u=<?php print $name; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $name; ?></a></td>
		<td width=75px><?php print $totgames; ?></td>
		<td width=75px><?php print ROUND($kills, 1); ?></td>
		<td width=75px><?php print ROUND($death, 1); ?></td>
		<td width=75px><?php print ROUND($assists, 1); ?></td>
		<td width=75px><?php print ROUND($creepkills, 1); ?></td>
		<td width=75px><?php print ROUND($creepdenies, 1); ?></td>
		<td width=75px><?php print ROUND($neutralkills, 1); ?></td>
		<td width=75px><?php print ROUND($towerkills, 1); ?></td>
		<td width=100px><?php print $firstplayed; ?></td>
		<td width=100px><?php print $lastplayed; ?></td>
	</tr>

	<?php

	}
	mysql_free_result($result);
}
?>
</table>
</div>
</div>
<div id="footer" class="footer">
		<h5><?php print $phrase46;?>: <?php print $count; ?></h5>
</div>
