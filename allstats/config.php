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

/*************************************
 *	EDITABLE CONFIGURATION SETTINGS  *
 *************************************/

// language for AllStats, please change this to "rus.php" if you want russian version
require_once("rus.php");


$bots = Array();
$bots[] = Array('name'=>'bot1', 'ip_in'=>'127.0.0.1', 'ip_out'=>'127.0.0.1', 'port_in'=>'6973', 'port_out'=>'6969', 'password'=>'');
//$bots[] = Array('name'=>'bot2', 'ip_in'=>'127.0.0.1', 'ip_out'=>'127.0.0.1', 'port_in'=>'7979', 'port_out'=>'6969', 'password'=>'');


//Database type:
//Enter sqlite to use a SQLite database.
//Enter mysql to use a MySQL database.
//Configure your selected database below. 
$dbType = 'mysql';
 
//SQLite Database Connection information (Optional):
//dbLocation must point to your SQLite Database.
$dbLocation = './ghost.dbs';

//MySQL Database Connection information (Optional):
//Must correspond to the settings in your MySQL Database.
$host = 'localhost';
$username = 'ghost';
$password = 'ghost';
$databasename = 'ghost';

// do __NOT__ enable this option on public (free) sql servers as this will
// query shared tables (information_schema.tables)
$verifytables = false;

//If you save your replays to a folder that AllStats can access, more information, the ability to download a replay, and a chat log will be displayed on the game info page.
//If replays cannot be found, this info will be automatically omitted.

//Replay Location:
//OMIT THE ENDING /. DO NOT END WITH A /
//Must be a relative path.  IE: Cannot use C:/... Use repeated ../ to move up directory chain.
$replayLocation = "replays";

//GHost++ bot user name:
$botName = 'bot';

//GHost++ root administrator name:
$rootAdmin = 'dev';

//Settings for Top Players page

//Default minimum number of games played in order to be displayed on Top Players page:
$minGamesPlayed = 2;

//Minimal ratio (lefttime/duration) that a player/hero has to complete a game to be counted as win/loss. otherwise game is ignored.
$minPlayedRatio = 0.8;
//string to be shown instead of WIN/LOSS if a game is not counted due to ratio (lefttime/duration)
$notCompleted = 'LEAVER';

//show bans from table imported_bans (requires this table to be present!)
$includeImportedBans = false;

//-------------Monthly/Weekly options----------------

// Default view (Month / Week)
$monthlyDefaultView = 'Month';

// determine which rows to be shown
$monthlyRow1 = true;
$monthlyRow2 = true;
$monthlyRow3 = true;
$monthlyRow4 = true;
$monthlyRow5 = true;

// min games played for monthly tops (only for overall stats -> row 3/4)
$montlyMinGames = 3;

//The number of entries in each highscore list
$monthlyTopsListSize = 5;

//hide banned players on monthly / alltime tops
$hideBannedPlayersOnTops = true;

//---------------------------------------------------
//-------------User history options----------------

// Default view (Month / Week)
$historyDefaultView = 'Month';

// min games played for monthly tops (only for overall stats -> row 3/4)
$historyMinGames = 3;

//---------------------------------------------------

//Pre-Calculate score
//If true:  Player scores will be taken from the score table in your MySQL database. You must populate this table through your own methods.
//		    One easy way to populate the score is to run the update_dota_elo.exe program in your GHost++ folder periodically. This will automatically populate
//          your scores table through an ELO method. Personally, I have modified my GHost++ to run update_dota_elo after every game automatically.
//If false: Player scores will be dynamically calculated on page load through a formula that takes into account kills, deaths, assists, wins, losses, etc...
//			This is less ideal and will slow your top players page load slightly. As of yet, I have not found a numeric scoring system that I believe 
//   		accurately reflects skill level.
$scoreFromDB = true;

//Score Formula: (Only used if $scoreFromDB = false)
//Must follow SQL formatting conventions.
//Allowed variables: totgames, kills, deaths, assists, creepkills, creepdenies, neutralkills, towerkills, raxkills, courierkills, wins, losses
//Backup of default formula in case of error: '((((kills-deaths+assists*0.5+towerkills*0.5+raxkills*0.2+(courierkills+creepdenies)*0.1+neutralkills*0.03+creepkills*0.03) * .2)+(wins-losses)))'
$scoreFormula = '((((kills-deaths+assists*0.5+towerkills*0.5+raxkills*0.2+(courierkills+creepdenies)*0.1+neutralkills*0.03+creepkills*0.03) * .2)+(wins-losses)))'; 
 
//Ignore public or private games on statistics pages
//Will only affect scores if you do not pre-calculate ($scoreFromDB = false).  
//If you do pre-calculate, you are expected to filter out public or private games on your own.
//IgnorePubs will override ignorePrivs if both are set to true.
$ignorePubs = false;
$ignorePrivs = false;

//Show all results at once or show the first page of results by default.
//$displayStyle='all' shows all data at once by default.
//$displayStyle='page' shows a single page of data by default.
$displayStyle='page';

//The number of results returned in a page on the top players page
$topResultSize = 50;
//The number of results returned in a page on the player statistics page
$allPlayerResultSize = 100;
//The number of results returned in a page on the hero statistics page
$allHeroResultSize = 20;
//The number of results returned in a page on the game history page
$gameResultSize = 40;
//The number of results returned in a page on the bans page
$banResultSize = 50;
//The number of results returned in a page on the admins page
$adminResultSize = 30;
//The number of results returned in a page on a hero's page
$heroResultSize = 15;
//The number of results returned in a page on a user's page
$userResultSize = 20;
//The number of results returned in a page on the monthly tops page
$monthlyTopsResultSize = 1;
//The number of results returned in a page on the monthly tops page
$userHistoryResultSize = 20;


//configure which pages to be shown
$showTops=true;
$showMonthlyTops=true;
$showPlayerStats=true;
$showHeroStats=true;
$showGameHistoy=true;
$showBans=true;
$showAdmins=true;

/**********************************
 *	DO NOT EDIT BELOW THIS POINT. *
 **********************************/ 
//SQLite
if($dbType == 'sqlite')
{
	try{

	$dbHandle = new PDO('sqlite:'.$dbLocation);

	}catch( PDOException $exception ){

	die($exception->getMessage());

	}
}
else
{ 
	//MySQL

	$link = mysql_connect($host,$username,$password);
	if (!$link) {
		die('Not connected : ' . mysql_error());
	}

	// make the current db
	$db_selected = mysql_select_db($databasename, $link);
	if (!$db_selected) {
		die ('Can\'t use current db : ' . mysql_error());
	}
}
?>
