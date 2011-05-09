<?php
/*********************************************
<!--
*           DOTA ALLSTATS
*
*        Developers: Reinert, Dag Morten, Netbrain, Billbabong, Boltergeist.
*        Contact: developer@miq.no - Reinert
*
*
*        Please see http://www.codelain.com/forum/index.php?topic=4752.0
*        and post your webpage there, so I know who's using it.
*
*        Files downloaded from http://code.google.com/p/allstats/
*
*        Copyright (C) 2009-2010  Reinert, Dag Morten , Netbrain, Billbabong, Boltergeist
*
*
*        This file is part of DOTA ALLSTATS.
*
*
*         DOTA ALLSTATS is free software: you can redistribute it and/or modify
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
require_once("version.php");
?>
<div class="header" id="header">
</div>
<div class="pageholder" id="pageholder">
<center>
        <div id="theader">
        <table class="tableheader" id="tableheader">
  <tr>
        <td class="rowuh">
                        <br>
                        <br>
                        <br>
                        <h4>



                        <!-- <?php print $phrase147." ".$botName." ".$phrase148; ?><br>  -->



                        </h4>
                        <br>
                        <br>
                        <br>
        </td>
  </tr>
  </table>
        </div>
        <div id="datawrapper">
                <table class="table" id="data">
        <tr class="rowuh">
                <td>
                        <br>
                        <br>
                        <br>

                        
                        <?php


                        $result = mysql_query('SELECT * FROM dota_elo_scores ORDER by score DESC;');// ‰ÂÎ‡ÂÏ ‚˚·ÓÍÛ ËÁ Ú‡·ÎËˆ˚


                        print('

                         <font color="black">

                         <table border="2">

                         <caption><font color="black">–†–µ–π—Ç–∏–Ω–≥ –∏–≥—Ä–æ–∫–æ–≤</font></caption>

                         <colgroup span="1" style="color:red"></colgroup>

                         <colgroup span="2">

                         <tr>

                          <th><font color="black"> –ú–µ—Å—Ç–æ</font></th>
                          <th><font color="black"> –ù–∏–∫</font></th>
                          <th><font color="black"> –†–µ–π—Ç–∏–Ω–≥</font></th>

                         </tr>


                        ');

			$inc = 0;
			
                        while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
                        {

                            print '<tr><font color="black">';
                            
                            $inc = $inc + 1;

                                   print '<td width=35%><font color="black">'.$inc.'</font></td>';
                                   print '<td><font color="black">'.$row["name"].'</font></td>';
                                   print '<td><font color="black">'.$row["score"].'</font></td>';

                            print '</font></tr>';

                        }

			    print '</table>';


                        ?>





                            
                     <!--   <?php print $phrase149." ".$botName; ?> -->

                        <br>
                        <br>
                        <br>

                      <!--  <?php print $phrase150; ?> -->
<?php

if ($verifytables)
{
        if (checkDBTable("heroes") == 0)
        {
?>
                        <br>
                        <br>
                        <br>
                        <div style="color:red">WARNING: "heroes" table not found. Please run allstats sql setup script first!</div>
<?php
        }

        if (checkDBTable("items") == 0)
        {
?>
                        <br>
                        <br>
                        <br>
                        <div style="color:red">WARNING: "items" table not found. Please run allstats sql setup script first!</div>
<?php
        }

        if (checkDBTable("games") == 0 || checkDBTable("gameplayers") == 0 || checkDBTable("dotagames") == 0 || checkDBTable("dotaplayers") == 0 || checkDBTable("bans") == 0 || checkDBTable("admins") == 0)
        {
?>
                        <br>
                        <br>
                        <br>
                        <div style="color:red">ERROR: ghost tables not found. Please check your configuration</div>
<?php
        }

        if ($includeImportedBans && checkDBTable("imported_bans") == 0)
        {
?>
                        <br>
                        <br>
                        <br>
                        <div style="color:red">WARNING: "imported_bans" table not found. Please run allstats sql setup script first!</div>
<?php
        }
}
?>


                </td>
        </tr>
</table>
</div>
</center>
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
a+';rand='+Math.random()+'" alt="–†–µ–π—Ç–∏–Ω–≥@Mail.ru" border="0" '+
'height="40" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_top" href="http://top.mail.ru/jump?from=1824871">
<img src="http://d8.cd.bb.a1.top.mail.ru/counter?js=na;id=1824871;t=130"
height="40" width="88" border="0" alt="–†–µ–π—Ç–∏–Ω–≥@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script>
<!--// Rating@Mail.ru counter-->


</div>