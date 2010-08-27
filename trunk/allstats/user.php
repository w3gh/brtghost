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

$avgDuration = "N/A";
$minDuration = "N/A";
$maxDuration = "N/A";
$totalDuration = "N/A";

if($dbType == 'sqlite')
{
	$username=strtolower(sqlite_escape_string($_GET["u"]));
	$sortcat=sqlite_escape_string($_GET["s"]);
	$order=sqlite_escape_string($_GET["o"]);
	$offset=sqlite_escape_string($_GET["n"]);
}
else
{
	$username=strtolower(mysql_real_escape_string($_GET["u"]));
	$sortcat=mysql_real_escape_string($_GET["s"]);
	$order=mysql_real_escape_string($_GET["o"]);
	$offset=mysql_real_escape_string($_GET["n"]);
}

//Determine if user exists
$count = 0;

$sql = "SELECT count(*) as count FROM gameplayers, dotaplayers where name = '$username' and dotaplayers.colour = gameplayers.colour and dotaplayers.gameid = gameplayers.gameid";
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
}
if($count == 0)
{
	//Shows a list of usernames that contains the word searched for
	$sql = "SELECT gp.name as name, bans.name as banname, count(1) as counttimes FROM gameplayers gp
		JOIN dotaplayers dp ON dp.colour = gp.colour and dp.gameid = gp.gameid
		LEFT JOIN bans ON bans.name = gp.name
		where gp.name like '%$username%' group by gp.name order by counttimes desc, gp.name asc";
		$foundCount = 0;
		if($dbType == 'sqlite')
		{
			//Check if there is only one result:
			foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
			{
				$founduser=$row["name"];
				$foundCount = $foundCount+1;
			}
			if($foundCount == 1)
			{
				$headerString = "?p=user&u=".$founduser."&s=datetime&o=desc&n=";
				if($displayStyle == 'all')
				{ 
				$headerString = $headerString.'all';
				} 
				else 
				{
				$headerString = $headerString.'0';
				}
?>
				<script language="javascript" type="text/javascript">
				<!--
				window.setTimeout('window.location = "<?php print $headerString; ?>"',2000);
				// –>
				</script>			
<?php			
			}
?>
			<div class="header" id="header">
				<table width=1016px>
				<tr>
				  <td align="center" >
					<h2><?php print " ".$phrase132." ".$username." ".$phrase133." ".$botName;?>:</h2>
				  </td>
				</tr>
				<tr height=25px></tr>
			</table>
			</div>
			<div class="pageholder" id="pageholder">
				<div id="theader">
				</div>
				<div id="datawrapper">
					<table class="table" id="data" width=1016px>
			<?php
			    $counttimes = false;
				foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
				{
					$counttimes=$row["counttimes"];
					$founduser=$row["name"];
                                        $banname=$row["banname"];
                                        $output = "<tr class=\"row\"> <td><a ";
                                        if($banname<>'')
                                        {
                                        $output = $output.'class="banned"';
                                        }
                                        $output = $output."href=\"?p=user&u=$founduser&s=datetime&o=desc&n=";
					if($displayStyle == 'all')
					{ 
					$output = $output.'all';
					} 
					else 
					{
					$output = $output.'0';
					}
					$output = $output."\">$founduser : $counttimes games.</a></td></tr>";
					print $output;
				}
				if($counttimes==false){ print "<tr class=\"rowuh\"> <td>Sorry no users named ".$username." have played any DotA games on ".$botName."</td></tr>";}
		}
		else
		{
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
			{
				$founduser=$row["name"];
				$foundCount = $foundCount+1;
			}
			if($foundCount == 1)
			{
				$headerString = "?p=user&u=".$founduser."&s=datetime&o=desc&n=";
				if($displayStyle == 'all')
				{ 
				$headerString = $headerString.'all';
				} 
				else 
				{
				$headerString = $headerString.'0';
				}
?>
				<script language="javascript" type="text/javascript">
				<!--
				window.setTimeout('window.location = "<?php print $headerString; ?>"',2000);
				// –>
				</script>			
<?php			
			}
?>
				<div class="header" id="header">
					<table width=1016px>
						<tr>
							<td align="center" >
								<h2><?php print " ".$phrase132." ".$username." ".$phrase133." ".$botName;?>:</h2>
							</td>
						</tr>
						<tr height=25px></tr>
					</table>
				</div>
				<div class="pageholder" id="pageholder">
					<div id="theader">
					</div>
					<div id="datawrapper">
						<table class="table" id="data" width=1016px>
				<?php
				$counttimes = false;
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
				{
					$founduser=$row["name"];
					$counttimes=$row["counttimes"];
                                        $banname=$row["banname"];
                                        $output = "<tr class=\"row\"> <td><a ";
                                        if($banname<>'')
                                        {
                                        $output = $output.'class="banned"';
                                        }
                                        $output = $output."href=\"?p=user&u=$founduser&s=datetime&o=desc&n=";
					if($displayStyle == 'all')
					{ 
					$output = $output.'all';
					} 
					else 
					{
					$output = $output.'0';
					}
					$output = $output."\">$founduser : $counttimes games.</a></td></tr>";
					print $output;
					
				}
				if($counttimes==false){ print "<tr class=\"rowuh\"> <td> Sorry no users found matching that criteria.</td></tr>";}
		
		}
		
		?>
					</table>
				</div>
			</div>
			<div id="footer" class="footer">
				<h5><?php print $phrase134." ".$foundCount." ".$phrase135; ?></h5>
			</div>
<?php
}
else
{
	$mostkillscount="0";
	$mostkillshero="blank";
	$mostdeathscount="0";
	$mostdeathshero="blank";
	$mostassistscount="0";
	$mostassistshero="blank";
	$mostwinscount="0";
	$mostwinshero="blank";
	$mostlossescount="0";
	$mostlosseshero="blank";
	$mostplayedcount="0";
	$mostplayedhero="blank";
	$kills="0";
	$death="0";
	$assists="0";
	$creepkills="0";
	$creepdenies="0";
	$neutralkills="0";
	$towerkills="0";
	$raxkills="0";
	$courierkills="0";
	$name="0";
	$totgames="0";
	if($dbType == 'sqlite')
	{
		//Find top heroes for this dude!
		//find hero with most kills
		$sql = "SELECT original, description, max(kills) as topValue FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour LEFT JOIN heroes on hero = heroid where name= '$username' group by original ORDER BY topValue DESC LIMIT 1 ";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$mostkillshero=$row["original"];
			$mostkillsheroname=$row["description"];
			$mostkillscount=$row["topValue"];
			//put an blank if you haven't scored yet
			if($mostkillscount==0){ $mostkillshero="blank";}
		}
		//find hero with most deaths
		$sql = "SELECT original, description, max(deaths) as topValue FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour LEFT JOIN heroes on hero = heroid where name= '$username' group by original ORDER BY topValue DESC LIMIT 1 ";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$mostdeathshero=$row["original"];
			$mostdeathsheroname=$row["description"];
			$mostdeathscount=$row["topValue"];
			//put an blank if you haven't scored yet
			if($mostdeathscount==0){ $mostdeathshero="blank";}
		}
		//find hero with most assists
		$sql = "SELECT original, description, max(assists) as topValue FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour LEFT JOIN heroes on hero = heroid where name= '$username' group by original ORDER BY topValue DESC LIMIT 1 ";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$mostassistshero=$row["original"];
			$mostassistsheroname=$row["description"];
			$mostassistscount=$row["topValue"];
			//put an blank if you haven't scored yet
			if($mostassistscount==0){ $mostassistshero="blank";}
		}
		//get hero with most wins
		$sql = "SELECT original, description, COUNT(*) as wins FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid LEFT JOIN heroes on hero = heroid WHERE name='$username' AND((winner=1 AND dotaplayers.newcolour>=1 AND dotaplayers.newcolour<=5) OR (winner=2 AND dotaplayers.newcolour>=7 AND dotaplayers.newcolour<=11)) group by original order by wins desc limit 1";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$mostwinshero=$row["original"];
			$mostwinsheroname=$row["description"];
			$mostwinscount=$row["wins"];
			//put an blank if you haven't won
			if(!isset($mostwinscount)){ $mostwinshero="blank"; $mostwinscount="0";}
		}
		//get hero with most losses
		$sql = "SELECT original, description, COUNT(*) as losses FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid LEFT JOIN heroes on hero = heroid WHERE name='$username' AND((winner=2 AND dotaplayers.newcolour>=1 AND dotaplayers.newcolour<=5) OR (winner=1 AND dotaplayers.newcolour>=7 AND dotaplayers.newcolour<=11)) group by original order by losses desc limit 1";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$mostlosseshero=$row["original"];
			$mostlossesheroname=$row["description"];
			$mostlossescount=$row["losses"];
			//put an x if you haven't lost
			if($mostlossescount==""){ $mostlosseshero="blank"; $mostlossescount="0";}
		}
		//get hero you have played most with
		$sql = "SELECT SUM(`left`) as timeplayed, original, description, COUNT(*) as played FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid JOIN heroes on hero = heroid WHERE name='$username' group by original order by played desc";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$mostplayedhero=$row["original"];
			$mostplayedheroname=$row["description"];
			$mostplayedcount=$row["played"];
			$mostplayedtime=secondsToTime($row["timeplayed"]);
			//put an blank if you haven't played
			if($mostplayedcount==""){ $mostplayedhero="blank"; $mostplayedcount="0";}
		}
	//get avg loadingtimes
		$sql = "SELECT MIN(datetime), MIN(loadingtime), MAX(loadingtime), AVG(loadingtime), MIN(`left`), MAX(`left`), AVG(`left`), SUM(`left`) FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid WHERE name='$username' AND winner!=0";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$firstgame=$row["MIN(datetime)"];
			$minLoading=millisecondsToTime($row["MIN(loadingtime)"]);
			$maxLoading=millisecondsToTime($row["MAX(loadingtime)"]);
			$avgLoading=millisecondsToTime($row["AVG(loadingtime)"]);
			$minDuration=secondsToTime($row["MIN(`left`)"]);
			$maxDuration=secondsToTime($row["MAX(`left`)"]);
			$avgDuration=secondsToTime($row["AVG(`left`)"]);
			$totalDuration=secondsToTime($row["SUM(`left`)"]);
		}

	//get lastgame played
		$sql = "SELECT dotagames.gameid, datetime FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid WHERE name='$username' AND winner!=0 order by dotagames.gameid desc";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$lastgame=$row["datetime"];
		}
		
		$score = "";
		//get score
		if($scoreFromDB)	//Using score table
		{
			$sql = "SELECT dota_elo_scores.score where name = '$username'";
		}
		else
		{
			$sql = "select ($scoreFormula) as score from(select *, (kills/deaths) as killdeathratio from (select gp.name as name,gp.gameid as gameid, gp.colour as colour, avg(dp.courierkills) as courierkills, avg(dp.raxkills) as raxkills,
			avg(dp.towerkills) as towerkills, avg(dp.assists) as assists, avg(dp.creepdenies) as creepdenies, avg(dp.creepkills) as creepkills,
			avg(dp.neutralkills) as neutralkills, avg(dp.deaths) as deaths, avg(dp.kills) as kills,
			count(*) as totgames, SUM(case when(((dg.winner = 1 and dp.newcolour < 6) or (dg.winner = 2 and dp.newcolour > 6)) AND gp.`left`/ga.duration >= 0.8) then 1 else 0 end) as wins, SUM(case when(((dg.winner = 2 and dp.newcolour < 6) or (dg.winner = 1 and dp.newcolour > 6)) AND gp.`left`/ga.duration >= 0.8) then 1 else 0 end) as losses
			from gameplayers as gp LEFT JOIN dotagames as dg ON gp.gameid = dg.gameid LEFT JOIN games as ga ON ga.id = dg.gameid LEFT JOIN 
			dotaplayers as dp on dp.gameid = dg.gameid and gp.colour = dp.colour where dg.winner <> 0 and gp.name = '$username') as h) as i";
		}
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$score=$row["score"];
		}

		$sql = "SELECT COUNT(a.id) as totGames, SUM(kills) as sumKills, SUM(deaths) as sumDeaths, SUM(creepkills) as sumCreepkills, SUM(creepdenies) as sumCreepdenies, SUM(assists) as sumAssists, SUM(neutralkills) as sumNeutralkills, SUM(towerkills) as sumTowerkills, SUM(raxkills) as sumRaxkills, SUM(courierkills) as sumCourierkills, name FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour where name= '$username' group by name ORDER BY sumKills desc ";
		foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
		{
			$kills=$row["sumKills"];
			$death=$row["sumDeaths"];
			$assists=$row["sumAssists"];
			$creepkills=$row["sumCreepkills"];
			$creepdenies=$row["sumCreepdenies"];
			$neutralkills=$row["sumNeutralkills"];
			$towerkills=$row["sumTowerkills"];
			$raxkills=$row["sumRaxkills"];
			$courierkills=$row["sumCourierkills"];
			$name=$row["name"];
			$totgames=$row["totGames"];
		}
	}
	else
	{
		//Find top heroes for this dude!
		//find hero with most kills
		$result = mysql_query("SELECT original, description, max(kills) as topValue FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour LEFT JOIN heroes on hero = heroid where name= '$username' group by original ORDER BY topValue DESC LIMIT 1 ");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$mostkillshero=$row["original"];
		$mostkillsheroname=$row["description"];
		$mostkillscount=$row["topValue"];
		//put an blank if you haven't scored yet
		if($mostkillscount==0){ $mostkillshero="blank";}
		
		//find hero with most deaths
		$result = mysql_query("SELECT original, description, max(deaths) as topValue FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour LEFT JOIN heroes on hero = heroid where name= '$username' group by original ORDER BY topValue DESC LIMIT 1 ");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$mostdeathshero=$row["original"];
		$mostdeathsheroname=$row["description"];
		$mostdeathscount=$row["topValue"];
		//put an blank if you haven't scored yet
		if($mostdeathscount==0){ $mostdeathshero="blank";}
		
		//find hero with most assists
		$result = mysql_query("SELECT original, description, max(assists) as topValue FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour LEFT JOIN heroes on hero = heroid where name= '$username' group by original ORDER BY topValue DESC LIMIT 1 ");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$mostassistshero=$row["original"];
		$mostassistsheroname=$row["description"];
		$mostassistscount=$row["topValue"];
		//put an blank if you haven't scored yet
		if($mostassistscount==0){ $mostassistshero="blank";}
		
		//get hero with most wins
		$result = mysql_query("SELECT original, description, COUNT(*) as wins FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid LEFT JOIN heroes on hero = heroid WHERE name='$username' AND((winner=1 AND dotaplayers.newcolour>=1 AND dotaplayers.newcolour<=5) OR (winner=2 AND dotaplayers.newcolour>=7 AND dotaplayers.newcolour<=11)) group by original order by wins desc limit 1");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$mostwinshero=$row["original"];
		$mostwinsheroname=$row["description"];
		$mostwinscount=$row["wins"];
		//put an blank if you haven't won
		if($mostwinscount==""){ $mostwinshero="blank"; $mostwinscount="0";}

		//get hero with most losses
		$result = mysql_query("SELECT original, description, COUNT(*) as losses FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid LEFT JOIN heroes on hero = heroid WHERE name='$username' AND((winner=2 AND dotaplayers.newcolour>=1 AND dotaplayers.newcolour<=5) OR (winner=1 AND dotaplayers.newcolour>=7 AND dotaplayers.newcolour<=11)) group by original order by losses desc limit 1");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$mostlosseshero=$row["original"];
		$mostlossesheroname=$row["description"];
		$mostlossescount=$row["losses"];
		//put an x if you haven't lost
		if($mostlossescount==""){ $mostlosseshero="blank"; $mostlossescount="0";}

		//get hero you have played most with
		$result = mysql_query("SELECT SUM(`left`) as timeplayed, original, description, COUNT(*) as played FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid JOIN heroes on hero = heroid WHERE name='$username' group by original order by played desc");	
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$mostplayedhero=$row["original"];
		$mostplayedheroname=$row["description"];
		$mostplayedcount=$row["played"];
		$mostplayedtime=secondsToTime($row["timeplayed"]);
		//put an blank if you haven't played
		if($mostplayedcount==""){ $mostplayedhero="blank"; $mostplayedcount="0";}

		//get avg loadingtimes
		$sql = "SELECT MIN(datetime), MIN(loadingtime), MAX(loadingtime), AVG(loadingtime), MIN(`left`), MAX(`left`), AVG(`left`), SUM(`left`) FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid WHERE name='$username'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$firstgame=$row["MIN(datetime)"];
		$minLoading=millisecondsToTime($row["MIN(loadingtime)"]);
		$maxLoading=millisecondsToTime($row["MAX(loadingtime)"]);
		$avgLoading=millisecondsToTime($row["AVG(loadingtime)"]);
		$minDuration=secondsToTime($row["MIN(`left`)"]);
		$maxDuration=secondsToTime($row["MAX(`left`)"]);
		$avgDuration=secondsToTime($row["AVG(`left`)"]);
		$totalDuration=secondsToTime($row["SUM(`left`)"]);

		//get lastgame played
		$result = mysql_query("SELECT dotagames.gameid, datetime FROM gameplayers LEFT JOIN games ON games.id=gameplayers.gameid LEFT JOIN dotaplayers ON dotaplayers.gameid=games.id AND dotaplayers.colour=gameplayers.colour LEFT JOIN dotagames ON games.id=dotagames.gameid WHERE name='$username' AND winner!=0 order by dotagames.gameid desc");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$lastgame=$row["datetime"];
	
		if($scoreFromDB)	//Using score table
		{
			$sql = "SELECT scores.score from scores where name = '$username'";
		}
		else
		{ 
			$sql = "select ($scoreFormula) as score from(select *, (kills/deaths) as killdeathratio from (select avg(dp.courierkills) as courierkills, avg(dp.raxkills) as raxkills,
				avg(dp.towerkills) as towerkills, avg(dp.assists) as assists, avg(dp.creepdenies) as creepdenies, avg(dp.creepkills) as creepkills,
				avg(dp.neutralkills) as neutralkills, avg(dp.deaths) as deaths, avg(dp.kills) as kills,
				count(*) as totgames, SUM(case when(((dg.winner = 1 and dp.newcolour < 6) or (dg.winner = 2 and dp.newcolour > 6)) AND gp.`left`/ga.duration >= 0.8) then 1 else 0 end) as wins, SUM(case when(((dg.winner = 2 and dp.newcolour < 6) or (dg.winner = 1 and dp.newcolour > 6)) AND gp.`left`/ga.duration >= 0.8) then 1 else 0 end) as losses
				from gameplayers as gp LEFT JOIN dotagames as dg ON gp.gameid = dg.gameid LEFT JOIN games as ga ON ga.id = dg.gameid LEFT JOIN 
				dotaplayers as dp on dp.gameid = dg.gameid and gp.colour = dp.colour where dg.winner <> 0 and gp.name = '$username') as h) as i";
		} 
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$score=$row["score"];
			
		$result = mysql_query("SELECT COUNT(a.id) as totGames, SUM(kills) as sumKills, SUM(deaths) as sumDeaths, SUM(creepkills) as sumCreepkills, SUM(creepdenies) as sumCreepdenies, SUM(assists) as sumAssists, SUM(neutralkills) as sumNeutralkills, SUM(towerkills) as sumTowerkills, SUM(raxkills) as sumRaxkills, SUM(courierkills) as sumCourierkills, name FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour where name= '$username' group by name ORDER BY sumKills desc ");
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$kills=$row["sumKills"];
			$death=$row["sumDeaths"];
			$assists=$row["sumAssists"];
			$creepkills=$row["sumCreepkills"];
			$creepdenies=$row["sumCreepdenies"];
			$neutralkills=$row["sumNeutralkills"];
			$towerkills=$row["sumTowerkills"];
			$raxkills=$row["sumRaxkills"];
			$courierkills=$row["sumCourierkills"];
			$name=$row["name"];
			$totgames=$row["totGames"];
			}
		}

		//calculate wins
		$wins=getWins($username);
		//calculate losses
		$losses=getLosses($username);
?>

<div class="header" id="header">
	<table width=1016px>
  		<tr class="rowuh" style="border-bottom: 1px solid #EBEBEB;">
			<td width=25%>
				<table class="rowuh" width = 235px style="float:left">
					<tr>
						<td>
						<?php
							if($displayStyle == 'all')
							{ 
							print "<a href=\"?p=heroall&u=".$username."&s=description&o=asc&n=all\">".$phrase136." ".$username."</a>";
							} 
							else 
							{
							print "<a href=\"?p=heroall&u=".$username."&s=description&o=asc&n=0\">".$phrase136." ".$username."</a>";
							}
						?>
						</td>
					</tr>
				</table>
			</td>

			<td width=50%>
				<h2><?php print $phrase137.": ".$username;?></h2>
			</td>
			<td width=25%>
				<table class="rowuh" width = 235px style="float:right">
					<tr>
						<td>
						<?php
							if($displayStyle == 'all')
							{ 
							print "<a href=\"?p=userhistory&u=".$username."&i=".$historyDefaultView."&s=datetime&o=desc&n=all\">".$phrase138." ".$username."</a>";
							} 
							else 
							{
							print "<a href=\"?p=userhistory&u=".$username."&i=".$historyDefaultView."&s=datetime&o=desc&n=0\">".$phrase138." ".$username."</a>";
							}
						?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width=1016px>
  <tr class="rowuh"> 
    <td colspan=2 align="left"><b><?php print $phrase139;?>:</b>
      MAX: <?php print $maxLoading;?> | MIN: <?php print $minLoading;?> | <?php print $phrase88;?>: <?php print $avgLoading;?>
    </td>
  </tr>
  <tr class="footerheadercell">
	<td align="center" width=34%><?php print $phrase24;?>:</td>
	<td  align="center" width = 66%><?php print $phrase140;?>:</td>
  </tr>
  <tr> 
    <td> <table class="rowuh" width="100%">
        <tr> 
          <td><?php print $phrase9;?>:</td>
          <td><?php print $kills;?></td>
		  <td><?php print $phrase10;?>: </td>
          <td><?php print $death;?></td>
		  
        </tr>
        <tr> 
          <td><?php print $phrase11;?>:</td>
          <td><?php print $assists;?></td>
		  <td><?php print $phrase171;?>:</td>
          <td><?php print getRatio($kills, $death); ?></td>
		  
        </tr>
		<tr height=10px>
		</tr>
        <tr>
			<td><?php print $phrase26.":";?></td>
          <td><?php print $totgames;?></td>		
		  <td><?php print $phrase172;?>:</td>
          <td><?php print $wins;?>/<?php print $losses;?></td>
		  
        </tr>
		<tr>
		  <td><?php print $phrase53;?>:</td>
          <td><?php print ROUND($score, 2); ?></td>
		  <td><?php print $phrase173;?>:</td>
          <td><?php if($wins == 0){ print '0';} else {print round($wins/($wins+$losses), 4)*100;}?></td>
		</tr>
		<tr height=10px>
		</tr>
        <tr> 
          <td><?php print $phrase12;?>:</td>
          <td><?php print $creepkills;?></td>
		  <td><?php print $phrase13;?>:</td>
          <td><?php print $creepdenies;?></td>
        </tr>
		<tr> 
          <td><?php print $phrase31;?>:</td>
          <td><?php print $towerkills;?></td>
		  <td><?php print $phrase32;?>:</td>
          <td><?php print $raxkills;?></td>
        </tr>
        <tr> 
		  <td><?php print $phrase33;?>:</td>
          <td><?php print $courierkills;?></td>
        </tr>
      </table></td>
    <td align='center'  scope=col rowspan="2"> 
	<table class="rowuh">
        <tr> 
          <td align=center><?php print $phrase9;?></td>
          <td align=center ><?php print $phrase10;?></td>
          <td align=center ><?php print $phrase11;?></td>
          <td align=center><?php print $phrase28;?></td>
          <td align=center><?php print $phrase29;?></td>
          <td align=center><?php print $phrase174;?></td>
        </tr>
        <tr> 
          <td align='center' width=10% scope=col ><a  href="?p=hero&hid=<?php print $mostkillshero;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img src="img/heroes/<?php print $mostkillshero; ?>.gif" title="<?php print $mostkillsheroname; ?>" width="64" height="64"></a></td>
          <td align='center' width=10% scope=col ><a  href="?p=hero&hid=<?php print $mostdeathshero;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img src="img/heroes/<?php print $mostdeathshero; ?>.gif" title="<?php print $mostdeathsheroname; ?>" width="64" height="64"></a></td>
          <td align='center' width=10% scope=col ><a  href="?p=hero&hid=<?php print $mostassistshero;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img src="img/heroes/<?php print $mostassistshero; ?>.gif" title="<?php print $mostassistsheroname; ?>" width="64" height="64"></a></td>
          <td align='center' width=10% scope=col ><a  href="?p=hero&hid=<?php print $mostwinshero;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img src="img/heroes/<?php print $mostwinshero; ?>.gif" title="<?php print $mostwinsheroname; ?>" width="64" height="64"></a></td>
          <td align='center' width=10% scope=col ><a  href="?p=hero&hid=<?php print $mostlosseshero;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img src="img/heroes/<?php print $mostlosseshero; ?>.gif" title="<?php print $mostlossesheroname; ?>" width="64" height="64"></a></td>
          <td align='center' width=10% scope=col ><a  href="?p=hero&hid=<?php print $mostplayedhero;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img src="img/heroes/<?php print $mostplayedhero; ?>.gif" title="<?php print $mostplayedheroname; ?>" width="64" height="64"></a></td>
        </tr>
        <tr> 
          <td align=center >(<?php print $mostkillscount;?>)</td>
          <td align=center >(<?php print $mostdeathscount;?>)</td>
          <td align=center >(<?php print $mostassistscount;?>)</td>
          <td align=center >(<?php print $mostwinscount;?>)</td>
          <td align=center >(<?php print $mostlossescount;?>)</td>
          <td align=center >(<?php print $mostplayedcount;?>)</td>
        </tr>
      </table></td>
  </tr>
</table>


<?php
 $sql = "SELECT count(*) as count FROM( select a.hero
 FROM dotaplayers AS a LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour LEFT JOIN dotagames AS c ON c.gameid = a.gameid 
 LEFT JOIN games AS d ON d.id = a.gameid LEFT JOIN heroes as e ON a.hero = heroid where name= '$username' and description <> 'NULL') as t";

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

$pages = ceil($count/$userResultSize);
?>

	<table width=1016px>
		<tr class="rowuh" style="border-top: 1px solid #EBEBEB;">
			<td width=25%>
				<table class="rowuh" width = 235px style="float:left">
					<tr>
						<td>
						<?php
						if($offset == 'all')
						{
							print $phrase81;
						}
						else
						{
							print "<a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=all\">".$phrase82."</a>";
						}
						?>
						</td>
					</tr>
				</table>
			</td>
			<td width=50%>
				<h3><?php print $phrase142;?>:</h3>
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
						$min = $offset*$userResultSize+1;
						$max = $offset*$userResultSize+$userResultSize;
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
						print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
						}
					}
					print "<td width=35px><span class=\"ddd\">></span></td>";
				}
				else
				{
					if($offset > 0)
					{
						print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($offset-1)."\"><</a>";
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
									print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
						}
						if($offset == 1)
						{
							print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=0\">1</a></td>";
							print "<td width=35px><span class=\"ddd\">2</span></td>";
							for($counter = 3; $counter < 6; $counter++)
							{
								if($counter-1 < $pages)
								{
								print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								
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
								print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
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
									print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
								}
							}
							print "<td width=35px><span class=\"ddd\">".($offset+1)."</span>";
							print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($offset+1)."\">".($offset+2)."</a></td>";
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
								print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($counter-1)."\">".$counter."</a></td>";
							}
						}
					}
					if(($offset+1)*$userResultSize < $count)
					{
						print "<td width=35px><a href=\"?p=user&u=".$username."&s=".$sortcat."&o=".$order."&n=".($offset+1)."\">></a></td>";
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

//Date and Time
if($sortcat == "datetime")
{
	if($order == "asc")
	{
		print("<td width=150px><a href=\"?p=user&u=$username&s=datetime&o=desc&n=".$sortoffset."\">".$phrase85."</a></td>");
	}
	else
	{
		print("<td width=150px><a href=\"?p=user&u=$username&s=datetime&o=asc&n=".$sortoffset."\">".$phrase85."</a></td>");
	}
}
else
{
	print("<td width=150px><a href=\"?p=user&u=$username&s=datetime&o=desc&n=".$sortoffset."\">".$phrase85."</a></td>");
}
//Game Name
if($sortcat == "gamename")
{
	if($order == "asc")
	{
		print("<td width=175px><a href=\"?p=user&u=$username&s=gamename&o=desc&n=".$sortoffset."\">".$phrase2."</a></td>");
	}
	else
	{
		print("<td width=175px><a href=\"?p=user&u=$username&s=gamename&o=asc&n=".$sortoffset."\">".$phrase2."</a></td>");
	}
}
else
{
	print("<td width=175px><a href=\"?p=user&u=$username&s=gamename&o=asc&n=".$sortoffset."\">".$phrase2."</a></td>");
}
//Game Type
if($sortcat == "type")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=type&o=desc&n=".$sortoffset."\">".$phrase39."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=type&o=asc&n=".$sortoffset."\">".$phrase39."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=type&o=desc&n=".$sortoffset."\">".$phrase39."</a></td>");
}
//Hero
if($sortcat == "description")
{
	if($order == "asc")
	{
		print("<td width=180px><a href=\"?p=user&u=$username&s=description&o=desc&n=".$sortoffset."\">".$phrase8."</a></td>");
	}
	else
	{
		print("<td width=180px><a href=\"?p=user&u=$username&s=description&o=asc&n=".$sortoffset."\">".$phrase8."</a></td>");
	}
}
else
{
	print("<td width=180px><a href=\"?p=user&u=$username&s=description&o=asc&n=".$sortoffset."\">".$phrase8."</a></td>");
}
//Kills
if($sortcat == "kills")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=kills&o=desc&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=kills&o=asc&n=".$sortoffset."\">".$phrase9."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=kills&o=desc&n=".$sortoffset."\">".$phrase9."</a></td>");
}

//Deaths
if($sortcat == "deaths")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=deaths&o=desc&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=deaths&o=asc&n=".$sortoffset."\">".$phrase10."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=deaths&o=desc&n=".$sortoffset."\">".$phrase10."</a></td>");
}

//Assists
if($sortcat == "assists")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=assists&o=desc&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=assists&o=asc&n=".$sortoffset."\">".$phrase11."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=assists&o=desc&n=".$sortoffset."\">".$phrase11."</a></td>");
}
//KDRatio
if($sortcat == "kdratio")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=kdratio&o=desc&n=".$sortoffset."\">".$phrase41."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=kdratio&o=asc&n=".$sortoffset."\">".$phrase41."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=kdratio&o=desc&n=".$sortoffset."\">".$phrase41."</a></td>");
}
//Creep Kills
if($sortcat == "creepkills")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=creepkills&o=desc&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=creepkills&o=asc&n=".$sortoffset."\">".$phrase42."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=creepkills&o=desc&n=".$sortoffset."\">".$phrase42."</a></td>");
}
//Creep Denies
if($sortcat == "creepdenies")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=creepdenies&o=desc&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=creepdenies&o=asc&n=".$sortoffset."\">".$phrase43."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=creepdenies&o=desc&n=".$sortoffset."\">".$phrase43."</a></td>");
}
//Neutral Kills
if($sortcat == "neutralkills")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=neutralkills&o=desc&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=neutralkills&o=asc&n=".$sortoffset."\">".$phrase44."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=neutralkills&o=desc&n=".$sortoffset."\">".$phrase44."</a></td>");
}
//Outcome
if($sortcat == "outcome")
{
	if($order == "asc")
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=outcome&o=desc&n=".$sortoffset."\">".$phrase40."</a></td>");
	}
	else
	{
		print("<td width=55px><a href=\"?p=user&u=$username&s=outcome&o=asc&n=".$sortoffset."\">".$phrase40."</a></td>");
	}
}
else
{
	print("<td width=55px><a href=\"?p=user&u=$username&s=outcome&o=desc&n=".$sortoffset."\">".$phrase40."</a></td>");
}
?>
				<td width=16px></td>
			</tr>
	 </table>
	</div>
	<div id="datawrapper">
		<table class="table" id="data">
 <?php 

 $sql = "SELECT winner, a.gameid as id, newcolour, datetime, gamename, original, description, kills, deaths, assists, creepkills, creepdenies, neutralkills, name, 
 CASE when(gamestate = '17') then 'PRIV' else 'PUB' end as type,
 CASE WHEN (kills = 0) THEN 0 WHEN (deaths = 0) then 1000 ELSE (kills*1.0/deaths) end as kdratio,
 CASE when ((winner=1 and newcolour < 6) or (winner=2 and newcolour > 5)) AND b.`left`/d.duration >= 0.8  then 'WON' when ((winner=2 and newcolour < 6) or (winner=1 and newcolour > 5)) AND b.`left`/d.duration >= 0.8  then 'LOST' when  winner=0 then 'DRAW' else '$notCompleted' end as outcome 
 FROM dotaplayers AS a 
 LEFT JOIN gameplayers AS b ON b.gameid = a.gameid and a.colour = b.colour 
 LEFT JOIN dotagames AS c ON c.gameid = a.gameid 
 LEFT JOIN games AS d ON d.id = a.gameid 
 LEFT JOIN heroes as e ON a.hero = heroid 
 where name= '$username' and original <> 'NULL' ORDER BY $sortcat $order, d.id DESC";

	if($offset!='all')
	{
	$sql = $sql." LIMIT ".$userResultSize*$offset.", $userResultSize";
	}
 if($dbType == 'sqlite')
 {
 foreach ($dbHandle->query($sql, PDO::FETCH_ASSOC) as $row)
	{
    $gametime=$row["datetime"];
	$kills=$row["kills"];
	$death=$row["deaths"];
    $assists=$row["assists"];
	$gamename=$row["gamename"];
	$hid=$row["original"];
	$hero=$row["description"];
	$name=$row["name"];
	$colour=$row["newcolour"];
	$winner=$row["winner"];
	$gameid=$row["id"]; 
	$type=$row["type"];
	$outcome=$row["outcome"];
	$kdratio = $row["kdratio"];
	$creepkills=$row["creepkills"];
	$creepdenies=$row["creepdenies"];
	$neutralkills=$row["neutralkills"];
 ?> 
 <tr class="row">
	<td width=150px><?php print $gametime;?></td>
    <td width=175px><a href="?p=gameinfo&gid=<?php print $gameid; ?>" target="_self"><?php print $gamename;?></a></td>
    <td width=55px><?php print $type;?></td>
	<td width=30px><a  href="?p=hero&hid=<?php print$hid;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img width="28px" height="28px" src=./img/heroes/<?php print $hid; ?>.gif></a></td>
	<td width=150px><a  href="?p=hero&hid=<?php print $hid;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $hero;?></a></td>
    <td width=55px><?php print $kills;?></td>
    <td width=55px><?php print $death;?></td>
    <td width=55px><?php print $assists;?></td>
    <td width=55px><?php print round($kdratio, 2);?></td>
	<td width=55px><?php print $creepkills;?></td>
    <td width=55px><?php print $creepdenies;?></td>
	<td width=55px><?php print $neutralkills;?></td>
	<td width=55px> <span <?php if($outcome == 'LOST'){print 'class="lost"';}elseif($outcome == 'WON'){print 'class="won"';} else{print 'class="draw"';} ?>><?php print $outcome;?></span></td>
</tr>	
	
 <?php 
	}
}
else
{
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $gametime=$row["datetime"];
	$kills=$row["kills"];
	$death=$row["deaths"];
    $assists=$row["assists"];
	$gamename=$row["gamename"];
	$hid=$row["original"];
	$hero=$row["description"];
	$name=$row["name"];
	$colour=$row["newcolour"];
	$winner=$row["winner"];
	$gameid=$row["id"]; 
	$type=$row["type"];
	$outcome=$row["outcome"];
	$kdratio = $row["kdratio"];
	$creepkills=$row["creepkills"];
	$creepdenies=$row["creepdenies"];
	$neutralkills=$row["neutralkills"];
 ?> 
 <tr class="row">
	<td width=150px><?php print $gametime;?></td>
    <td width=175px><a href="?p=gameinfo&gid=<?php print $gameid; ?>" target="_self"><?php print $gamename;?></a></td>
    <td width=55px><?php print $type;?></td>
	<td width=30px><a  href="?p=hero&hid=<?php print$hid;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><img width="28px" height="28px" src=./img/heroes/<?php print $hid; ?>.gif></a></td>
	<td width=150px><a  href="?p=hero&hid=<?php print $hid;?>&s=kdratio&o=desc&n=<?php if($displayStyle=='all'){ print 'all'; } else { print '0'; } ?>"><?php print $hero;?></a></td>
    <td width=55px><?php print $kills;?></td>
    <td width=55px><?php print $death;?></td>
    <td width=55px><?php print $assists;?></td>
    <td width=55px><?php print round($kdratio, 2);?></td>
	<td width=55px><?php print $creepkills;?></td>
    <td width=55px><?php print $creepdenies;?></td>
	<td width=55px><?php print $neutralkills;?></td>
	<td width=55px> <span <?php if($outcome == 'LOST'){print 'class="lost"';}elseif($outcome == 'WON'){print 'class="won"';} else{print 'class="draw"';} ?>><?php print $outcome;?></span></td>
</tr>	
	
	<?php
	}
}
}
	?>
</table>
</div>
</div>
<div id="footer" class="footer">
  <h5> <?php print $phrase143;?>(hh:mm:ss):
    MAX: <?php print $maxDuration;?> | MIN: <?php print $minDuration;?> | <?php print $phrase88;?>: <?php print $avgDuration;?> | <?php print $phrase89;?>: <?php print $totalDuration;?>
  </h5>
</div>
