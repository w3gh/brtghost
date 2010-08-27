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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noodp" />
<title><?php print $botName." ".$phrase151; ?></title>
<link rel="stylesheet" href="styles.css" type="text/css">
<script type="text/javascript">
	function displayvis(id) {
		if (document.layers) {
		  document.layers[id].display = (document.layers[id].display != 'none') ? 'none' : 'block';
		} else if (document.all) {
		  document.all[id].style.display = (document.all[id].style.display != 'none') ? 'none'	: 'block';
		} else if (document.getElementById) {
		  document.getElementById(id).style.display = (document.getElementById(id).style.display != 'none') ? 'none' : 'block';
		}
	}
	function displayhid(id) {
		if (document.layers) {
		  document.layers[id].display = (document.layers[id].display != 'block') ? 'block' : 'none';
		} else if (document.all) {
		  document.all[id].style.display = (document.all[id].style.display != 'block') ? 'block'	: 'none';
		} else if (document.getElementById) {
		  document.getElementById(id).style.display = (document.getElementById(id).style.display != 'block') ? 'block' : 'none';
		}
	}
	function displayIds(id1, id2)
	{
		displayvis(id1);
		displayvis(id2);
		setWrapperDimensions();
	}
	function isIE(){
		var browser=navigator.appName;
		if(browser =="Microsoft Internet Explorer")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function getClientWidth() {
	  return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.body.clientWidth;
	}

	function getClientHeight() {
	  return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.body.clientHeight;
	}
	function setWrapperDimensions()
	{
		setWrapperHeight();
		
	}
	function setWrapperHeight()
	{
		var windowheight = getClientHeight();
		var menuheight = document.getElementById('menu').offsetHeight;
		var footerheight = document.getElementById('footer').offsetHeight;
		
		var headerheight = document.getElementById('header').offsetHeight;
		var theaderheight = document.getElementById('theader').offsetHeight;
		if(isIE())
		{
		var pageholderheight = windowheight-menuheight-footerheight;
		}
		else
		{
		var pageholderheight = windowheight-menuheight-headerheight-footerheight;
		}
		
		if(document.getElementById('footerdata') != null)
		{
		var footerdataheight = document.getElementById('footerdata').offsetHeight;
		pageholderheight = pageholderheight - footerdataheight;
		}
		
		document.getElementById('pageholder').style.height = pageholderheight+'px';
		document.getElementById('datawrapper').style.height = pageholderheight-theaderheight+'px';
	}
	
	function checkRange(numValue,numLow,numHigh){
		 if(isNaN(numValue)){
			  //alert("Please enter a valid number");
			  return false;
		 }else{
			  if(parseFloat(numValue)< numLow || parseFloat(numValue)>numHigh){
				   alert("Please enter a value between " + numLow + " and " + numHigh);
				   return false;
			  }
		 }
		 return true;
	}
	
	function gamesPlayed(numValue, offset)
	{
		if(checkRange(numValue, 0, 5000))
		{
			var url = '?p=top&s=totalscore&o=desc&g='+numValue+'&n=0';
			location.href = url;
		}
	}
</script>

</head>

<body onload="setWrapperHeight()" onresize="setWrapperHeight()">

<div class="menu" id="menu">
		<div class="nav" id="nav">
			<ul>
				<!-- MENU -->
				 <li>
<?php 
if($monthlyDefaultView == 'week' || $monthlyDefaultView == 'Week') { 
	$interval = "week"; 
	$intervalname = $phrase104; 
} else { 
	$interval = "month"; 
	$intervalname = $phrase105; 
}
if($displayStyle == 'all') { $pageStyle = 'all'; } else { $pageStyle = '0'; }
?>
						  <a href="./"><?php print $phrase152;?></a></li> 
							<?php if ($showTops) { ?>
								<li><a href="?p=top&s=totalscore&o=desc&g=<?php print $minGamesPlayed; ?>&n=<?php print $pageStyle; ?>"><?php print $phrase153;?></a></li>
							<?php } if ($showMonthlyTops) { ?>
								<li><a href="?p=monthlytop&i=<?php print $interval;?>&n=<?php print $pageStyle; ?>"><?php print $intervalname.$phrase130;?></a></li> 
							<?php } if ($showPlayerStats) { ?>
								<li><a href="?p=allusers&s=totgames&o=desc&n=<?php print $pageStyle; ?>"><?php print $phrase144;?></a></li> 
							<?php } if ($showHeroStats) { ?>
								<li><a href="?p=heroall&s=description&o=asc&n=<?php print $pageStyle; ?>"><?php print $phrase101;?></a></li> 
							<?php } if ($showGameHistoy) { ?>
								<li><a href="?p=games&s=datetime&o=desc&n=<?php print $pageStyle; ?>"><?php print $phrase142;?></a></li> 
							<?php } if ($showBans) { ?>
								<li><a href="?p=bans&s=date&o=desc&n=<?php print $pageStyle; ?>"><?php print $phrase155;?></a></li>
							<?php } if ($showAdmins) { ?>
								<li><a href="?p=admins&n=<?php print $pageStyle; ?>"><?php print $phrase167;?></a></li> 
							<?php } 


?>

<li><a href="../forum"> <?php print $phrase177;?> </a></li>



						  <li>
							<form name="testForm" method=GET action="">
								<input type="text" 
								class="searchBox" 
								name="u" 
								onfocus="if(this.value=='<?php print $phrase156;?>') {this.value='';this.style.color='white';} else this.select();" 
								onblur="if(this.value==''){this.value='<?php print $phrase156;?>';this.style.color='black';}" 
								value="<?php print $phrase156;?>"
								/>
								<input type="hidden" value="datetime" name="s" />
								<input type="hidden" value="desc" name="o" />
								<input type="hidden" value="user" name="p" />
								<?php
								if($displayStyle=='all')
								{ 
								print '<input type="hidden" value="all" name="n" />'; 
								} 
								else 
								{ 
								print '<input type="hidden" value="0" name="n" />'; 
								}
								?>
							</form> 
						</li>
				<!-- END MENU -->
			</ul>	
		</div>
		
	
</div>
		<?php 		
		$valid_pages = array('intro', 
							'bans', 
							'games', 
							'allusers', 
							'user',
							'userhistory',
							'heroall',							
							'gameinfo',
							'hero', 
							'top',
							'monthlytop', 
							'admins');

		if(!empty($_GET['p']))
		{
			if(in_array($_GET['p'], $valid_pages) && is_readable($_GET['p'] . '.php'))
			{
				include($_GET['p'] . '.php');
			}
			else if($_GET['p']=='')
			{
				include('intro.php');
			}
			else
			{
				echo 'Requested resource doesn\'t exist.';
			}
		}
		else
		{
			echo '<center><font color=white>';

			print('

                         <font color=white>

                         <table border=0>

                         <caption><font color="white">Информация о ботах и играх</font></caption>

                        ');

			flush();


			include('online_stats.php');

			echo '</font></center></table></font>';
		}
		?>

<center>
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
a+';rand='+Math.random()+'" alt="ѥ골Mail.ru" border="0" '+
'height="40" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_top" href="http://top.mail.ru/jump?from=1824871">
<img src="http://d8.cd.bb.a1.top.mail.ru/counter?js=na;id=1824871;t=130" 
height="40" width="88" border="0" alt="ѥ골Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script>
<!--// Rating@Mail.ru counter--> 
</center>
</body>
</html>
