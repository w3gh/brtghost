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

$sql = "SELECT COUNT( DISTINCT id ) as totgames, MAX(duration), MIN(duration), AVG(duration), SUM(duration) from games where map LIKE '%dota%'";

if($dbType == 'sqlite')
{
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$count=$row["totgames"];
                $maxDuration=secondsToTime($row["MAX(duration)"]);
                $minDuration=secondsToTime($row["MIN(duration)"]);
                $avgDuration=secondsToTime($row["AVG(duration)"]);
                $totalDuration=secondsToTime($row["SUM(duration)"]);
	}
}
else
{
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$count=$row["totgames"];
                $maxDuration=secondsToTime($row["MAX(duration)"]);
                $minDuration=secondsToTime($row["MIN(duration)"]);
                $avgDuration=secondsToTime($row["AVG(duration)"]);
 		$totalDuration=secondsToTime($row["SUM(duration)"]);
	}
	mysql_free_result($result);
}
$pages = ceil($count/$gameResultSize);
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
							print $phrase81;
						}
						else
						{
							print "<a href=\"?p=games&s=".$sortcat."&o=".$order."&n=all\">".$phrase82."</a>";
						}
						?>
						</td>
					</tr>
					</h4>
				</table>
			</td>
			<td width=50%>
				<h2><?php print $phrase83;?>:</h2>
			</td>
			<td width=25% class="rowuh">
				<table class="rowuh" width = 235px style="float:right">
				<h4>
				<tr>
					<td colspan=7>
					<?php
					if($offset == 'all')
					{
						print $phrase164.":";
					}
					else
					{
						$min = $offset*$gameResultSize+1;
						$max = $offset*$gameResultSize+$gameResultSize;
						if($max > $count)
						{
							$max = $count;
						}
						print $phrase84.": ".$min." - ".$max;
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
						print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
						}
					}
					print "<td width=35px><span class=\"ddd\">></span></td>";
				}
				else
				{
					if($offset > 0)
					{
						print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($offset-1)."\"><</a>";
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
									print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
						}
						if($offset == 1)
						{
							print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=0\">1</a></td>";
							print "<td width=35px><span class=\"ddd\">2</span></td>";
							for($counter = 3; $counter < 6; $counter++)
							{
								if($counter-1 < $pages)
								{
								print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								
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
								print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
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
									print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
							print "<td width=35px><span class=\"ddd\">".($offset+1)."</span>";
							print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($offset+1)."\">".($offset+2)."</a></td>";
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
								print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
							}
						}
					}
					if(($offset+1)*$gameResultSize < $count)
					{
						print "<td width=35px><a href=\"?p=games&s=".$sortcat."&o=".$order."&n=".($offset+1)."\">></a></td>";
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

//Time
if($sortcat == "datetime")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=150px><a href=\"?p=games&s=datetime&o=desc&n=".$sortoffset."\">".$phrase85."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=150px><a href=\"?p=games&s=datetime&o=asc&n=".$sortoffset."\">".$phrase85."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=150px><a href=\"?p=games&s=datetime&o=desc&n=".$sortoffset."\">".$phrase85."</a></td>");
}
//Map
if($sortcat == "map")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=200px><a href=\"?p=games&s=map&o=desc&n=".$sortoffset."\">".$phrase86."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=200px><a href=\"?p=games&s=map&o=asc&n=".$sortoffset."\">".$phrase86."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=200px><a href=\"?p=games&s=map&o=asc&n=".$sortoffset."\">".$phrase86."</a></td>");
}
//Game Type
if($sortcat == "type")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=50px><a href=\"?p=games&s=type&o=desc&n=".$sortoffset."\">".$phrase39."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=50px><a href=\"?p=games&s=type&o=asc&n=".$sortoffset."\">".$phrase39."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=50px><a href=\"?p=games&s=type&o=desc&n=".$sortoffset."\">".$phrase39."</a></td>");
}	
//Game
if($sortcat == "gamename")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=375px><a href=\"?p=games&s=gamename&o=desc&n=".$sortoffset."\">".$phrase2."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=375px><a href=\"?p=games&s=gamename&o=asc&n=".$sortoffset."\">".$phrase2."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=375px><a href=\"?p=games&s=gamename&o=asc&n=".$sortoffset."\">".$phrase2."</a></td>");
}

//Duration
if($sortcat == "duration")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=games&s=duration&o=desc&n=".$sortoffset."\">".$phrase5."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=75px><a href=\"?p=games&s=duration&o=asc&n=".$sortoffset."\">".$phrase5."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=75px><a href=\"?p=games&s=duration&o=desc&n=".$sortoffset."\">".$phrase5."</a></td>");
}

//Creator
if($sortcat == "creatorname")
{
	if($order == "asc")
	{
		print("<td class=\"headercell\" width=150px><a href=\"?p=games&s=creatorname&o=desc&n=".$sortoffset."\">".$phrase4."</a></td>");
	}
	else
	{
		print("<td class=\"headercell\" width=150px><a href=\"?p=games&s=creatorname&o=asc&n=".$sortoffset."\">".$phrase4."</a></td>");
	}
}
else
{
	print("<td class=\"headercell\" width=150px><a href=\"?p=games&s=creatorname&o=asc&n=".$sortoffset."\">".$phrase4."</a></td>");
}

?> 
			<td class="headercell" width=16px></td>
			</tr>
		</table>
	</div>
	<div id="datawrapper">
		<table class="table" id="data">
 <?php 
 
$sql = "SELECT g.id, map, datetime, gamename, ownername, duration, creatorname, dg.winner, CASE when(gamestate = '17') then 'PRIV' else 'PUB' end as type FROM games as g LEFT JOIN dotagames as dg ON g.id = dg.gameid where map LIKE '%dota%' ORDER BY $sortcat $order, datetime desc";

if($offset!='all')
{
$sql = $sql." LIMIT ".$gameResultSize*$offset.", $gameResultSize";
}

if($dbType == 'sqlite')
{
	foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
		$gameid=$row["id"]; 
		$map=substr($row["map"], strripos($row["map"], 0));
		$type=$row["type"];
		$gametime=$row["datetime"];
		$gamename=$row["gamename"];
		$ownername=$row["ownername"];
		$duration=$row["duration"];
		$creator=$row["creatorname"];
		$winner=$row["winner"];
 ?> 
	<tr class="row">
		<td width=150px align=center><?php print $gametime;?></td>   
		<td width=200px align=center><?php print $map;?></td>
		<td width=50px align=center><?php print $type;?></td>
		<td width=375px align=center><a href="?p=gameinfo&gid=<?php print $gameid; ?>" target="_self" <?php if($winner==1){print 'class="sentinel"';}elseif($winner==2){print 'class="scourge"';}?>><?php print $gamename;?></a></td>
		<td width=75px align=center><?php print secondsToTime($duration);?></td>
		<td width=150px align=center><a href="?p=user&u=<?php print $creator; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>" target="_self"><?php print $creator;?></a></td>
	</tr>
		<?php
	}
}
else
{
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$gameid=$row["id"]; 
		$map=substr($row["map"], strripos($row["map"], '\\')+1);
		$type=$row["type"];
		$gametime=$row["datetime"];
		$gamename=$row["gamename"];
		$ownername=$row["ownername"];
		$duration=$row["duration"];
		$creator=$row["creatorname"];
		$winner=$row["winner"];
 ?> 
	 <tr class="row">
		<td width=150px align=center><?php print $gametime;?></td>   
		<td width=200px align=center><?php print $map;?></td>
		<td width=50px align=center><?php print $type;?></td>
		<td width=375px align=center><a href="?p=gameinfo&gid=<?php print $gameid; ?>" target="_self" <?php if($winner==1){print 'class="sentinel"';}elseif($winner==2){print 'class="scourge"';}?>><?php print $gamename;?></a></td>
		<td width=75px align=center><?php print secondsToTime($duration);?></td>
		<td width=150px align=center><a href="?p=user&u=<?php print $creator; ?>&s=datetime&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>" target="_self"><?php print $creator;?></a></td>
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
	<h5><?php print $phrase87.": ".$count; ?>
	~~~~~~ <?php print $phrase5;?>(hh:mm:ss):
	<?php print $phrase88;?>: <?php print $avgDuration;?> | <?php print $phrase89;?>: <?php print $totalDuration;?></h5>


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
