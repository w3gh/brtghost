/*
    Copyright [2011] [Igor Bygaev] [http://brt.org.ua]
	
	email: avon.dn.ua@gmail.com
	
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

#include "includes.h"
#include "util.h"
#include "configdata.h"

using boost::property_tree::ptree;

CConfigData::CConfigData(void)
{
}

CConfigData::~CConfigData(void)
{
}

bool CConfigData::Parse( const string& nFileName )
{
    try
    {
        read_info(nFileName, data);

        const boost::property_tree::ptree& ghost = data.get_child("ghost");

		port_host		= ghost.get<uint32_t>("ports.host", 6112);
		port_reconnect	= ghost.get<uint32_t>("ports.reconnect", 6113);
		port_admingame	= ghost.get<uint32_t>("ports.admingame", 6114);
		port_command	= ghost.get<uint32_t>("ports.command", 8100);

		logfile = ghost.get<string>("system.log", "ghost.log");
		logmethod = ghost.get<int>("system.logmethod", 1);

		war3path = UTIL_AddPathSeperator( ghost.get<string>("paths.war3path","") );
		replaypath = UTIL_AddPathSeperator( ghost.get<string>("paths.replaypath","") );
		mappath = UTIL_AddPathSeperator( ghost.get<string>("paths.mappath","") );
		mapcfgpath = UTIL_AddPathSeperator( ghost.get<string>("paths.mapcfgpath","") );
		savegamepath = UTIL_AddPathSeperator( ghost.get<string>("paths.savegamepath","") );

		// system
		tft = ghost.get<bool>("system.isTheFrozenThrone", true);
		m_LANWar3Version = ghost.get<int>("system.lan_war3version", 26);
		m_CommandTrigger = ghost.get<char>("system.commandtrigger", '.');
		m_BindAddress = ghost.get<string>("system.bindaddress","");
		m_LanguageFile = ghost.get<string>("system.language","english.cfg");
		m_VirtualHostName = ghost.get<string>("system.virtualhostname", "|cFF400040bot");
		m_HideIPAddresses = ghost.get<bool>("system.hideipaddresses", false);
		m_CheckMultipleIPUsage = ghost.get<bool>("system.checkmultipleipusage", true);
		m_LCPings = ghost.get<bool>("system.lcpings", true);
		m_Latency = ghost.get<uint32_t>("system.latency", 75);
		m_TCPNoDelay = ghost.get<bool>("system.tcp_nodelay", true);
		m_GameLoadedPrintout = ghost.get<uint32_t>("system.gameloadedprintout", 30);
		m_NoRank = ghost.get<bool>("system.norank", false);
		m_NoStatsDota = ghost.get<bool>("system.nostatsdota", false);
		m_DontShowSDForAdmins = ghost.get<bool>("system.dontshowsdforadmins", false);
		m_WhisperAllMessages = ghost.get<bool>("system.whisperallmessages", false);
		m_ShowRealSlotCount = ghost.get<bool>("system.showrealslotcount", true);
	    m_OwnerAccess = ghost.get<uint32_t>("system.owneraccess", 3965);
	    m_AdminAccess = ghost.get<uint32_t>("system.adminaccess", 1903);
		m_ScoreFormula = ghost.get<string>("system.scoreformula", "(((wins-losses)/totgames)+(kills-deaths+assists/2)+(creepkills/100+creepdenies/10+neutralkills/50)+(raxkills/6)+(towerkills/11))");
		m_ScoreMinGames = ghost.get<uint32_t>("system.scoremingames", 5);
		m_Refresh0Uptime = ghost.get<bool>("system.refresh0uptime", true);
		m_ExternalIP = ghost.get<string>("system.externalip", "127.0.0.1");
		m_bnetpacketdelaymediumpvpgn = ghost.get<uint32_t>("system.bnetpacketdelaymediumpvpgn", 2000);
		m_bnetpacketdelaybigpvpgn = ghost.get<uint32_t>("system.bnetpacketdelaybigpvpgn", 2500);
		m_bnetpacketdelaymedium = ghost.get<uint32_t>("system.bnetpacketdelaymedium", 3200);
		m_bnetpacketdelaybig = ghost.get<uint32_t>("system.bnetpacketdelaybig", 4000);
//		m_patch23 = ghost.get<bool>("system.patch23ornewer", true);
		m_patch21 = ghost.get<bool>("system.patch21", false);
	    m_channeljoingreets = ghost.get<bool>("system.channeljoingreets", true);
	    m_channeljoinmessage = ghost.get<bool>("system.channeljoinmessage", false);

		// dynamic latency
		m_UseDynamicLatency = ghost.get<bool>("dynamic_latency.usedynamiclatency", false);
		m_DynamicLatency2xPingMax = ghost.get<bool>("dynamic_latency.dynamiclatency2.2xhighestpingmax", true);
		m_DynamicLatencyMaxToAdd = ghost.get<uint32_t>("dynamic_latency.dynamiclatencymaxtoadd", 30);
		m_DynamicLatencyAddedToPing = ghost.get<uint32_t>("dynamic_latency.dynamiclatencyaddedtoping", 25);
		m_DynamicLatencyIncreasewhenLobby = ghost.get<bool>("dynamic_latency.dynamiclatencyincreasewhenlobby", true);

		// games
		forceloadingame = ghost.get<bool>("games.forceloadingame", false);
		m_MaxGames = ghost.get<bool>("games.maxgames", 1); 
		m_ReconnectWaitTime = ghost.get<uint32_t>("games.reconnectwaittime", 3);
		m_SpoofChecks = ghost.get<uint32_t>("games.spoofchecks", 2);
		m_RequireSpoofChecks = ghost.get<bool>("games.requirespoofchecks", true);
		m_RefreshMessages = ghost.get<bool>("games.refreshmessages", false);
		m_AutoLock = ghost.get<bool>("games.autolock", false);
		m_AutoSave = ghost.get<bool>("games.autosave", false);
		m_DropVoteTime = ghost.get<uint32_t>("games.dropvotetime", 30);
		m_AutoKickPing = ghost.get<uint32_t>("games.autokickping", 250);
		m_SyncLimit = ghost.get<uint32_t>("games.synclimit", 90);
		m_VoteKickAllowed = ghost.get<bool>("games.votekickallowed", true);
		m_VoteKickPercentage = ghost.get<uint32_t>("games.votekickpercentage", 60);
		m_DefaultMap = ghost.get<string>("games.default_map", "map.cfg");
		m_GameNameContainString = ghost.get<string>("games.gamenamecontainstring","");
		m_MatchMakingMethod = ghost.get<uint32_t>("games.matchmakingmethod", 0);
		m_ForceAutoBalanceTeams = ghost.get<bool>("games.forceautobalanceteams", false);
		m_Verbose = ghost.get<bool>("games.verbose", false);
		m_RelayChatCommands = ghost.get<bool>("games.relaychatcommands", true);
		m_forceautohclindota = ghost.get<bool>("games.forceautohclindota", true);
		m_AutoStartDotaGames = ghost.get<bool>("games.autostartdotagames", false);
		m_BlueIsOwner = ghost.get<bool>("games.blueisowner", false);
		m_BlueCanHCL = ghost.get<bool>("games.bluecanhcl", false);
		m_AllowedScores = ghost.get<double>("games.allowedscores", 0.0);
		m_AllowNullScoredPlayers = ghost.get<bool>("games.allownullscoredplayers", 1);
		m_UpdateDotaEloAfterGame = ghost.get<bool>("games.updatedotaeloaftergame", false);
		m_UpdateDotaScoreAfterGame = ghost.get<bool>("games.updatedotascoreaftergame", false);
		m_minFFtime = ghost.get<uint32_t>("games.minFFtime", 0);
		m_AddCreatorAsFriendOnHost = ghost.get<bool>("games.addcreatorasfriendonhost", false);
		m_AutoHclFromGameName = ghost.get<bool>("games.autohclfromgamename", true);
//		m_UsersCanHost = ghost.get<bool>("games.userscanhost", false);
//		m_SafeCanHost = ghost.get<bool>("games.safecanhost", false);
		m_NormalCountdown = ghost.get<bool>("games.normalcountdown", false);
		m_gameoverbasefallen = ghost.get<uint32_t>("games.gameoverbasefallen", 5);
		m_gameoverminpercent = ghost.get<uint32_t>("games.gameoverminpercent", 0);
		m_gameoverminplayers = ghost.get<uint32_t>("games.gameoverminplayers", 2);
		m_gameovermaxteamdifference = ghost.get<uint32_t>("games.gameovermaxteamdifference", 0);
		m_ShuffleSlotsOnStart = ghost.get<bool>("games.shuffleslotsonstart", false);
		m_ShowCountryNotAllowed = ghost.get<bool>("games.showcountrynotallowed", true);
		m_ShowScoresOnJoin = ghost.get<bool>("games.showscoresonjoin", true);
		m_ShowNotesOnJoin = ghost.get<bool>("games.shownotesonjoin", true);
		m_AutoRehostDelay = ghost.get<uint32_t>("games.autorehostdelay", 50);
		m_RehostIfNameTaken = ghost.get<bool>("games.rehostifnametaken", true);

		// autohost
		m_AutoHostAllowedScores = ghost.get<double>("autohost.autohostallowedscores", 0.0);
		m_AutoHostGameName = ghost.get<string>("autohost.gamename", "ghost");
		m_AutoHostMapCFG = ghost.get<string>("autohost.mapcfg", "default.cfg");
		m_AutoHostOwner = ghost.get<string>("autohost.owner", "bot");
		m_AutoHostServer = ghost.get<string>("autohost.gamename", "ghost");
		m_AutoHostMaximumGames = ghost.get<uint32_t>("autohost.maximumgames", 5);
		m_AutoHostLocal = ghost.get<bool>("autohost.local", false);
	    m_AutoHostAllowStart = ghost.get<bool>("autohost.allowstart", false);

		// replays
		m_ReplayWar3Version = ghost.get<uint32_t>("replay.war3version", 26);
		m_ReplayBuildNumber = ghost.get<uint32_t>("replay.buildnumber", 6059);
		m_ReplayTimeShift = ghost.get<int32_t>("replay.timeshift", 0);

		// map_download
		m_AllowDownloads = ghost.get<uint32_t>("games.map_download.allowdownloads", 1);
		m_PingDuringDownloads = ghost.get<bool>("games.map_download.pingduringdownloads", false);
		m_ShowDownloadsInfo = ghost.get<bool>("games.map_download.showdownloadsinfo", true);
		m_totaldownloadspeed = ghost.get<uint32_t>("games.map_download.totaldownloadspeed", 1024);
		m_clientdownloadspeed = ghost.get<uint32_t>("games.map_download.clientdownloadspeed", 1024);
		m_maxdownloaders = ghost.get<uint32_t>("games.map_download.maxdownloaders", 0);
		m_AdminsAndSafeCanDownload = ghost.get<bool>("games.map_download.adminsandsafecandownload", true);

		// replays
		issavereplays = ghost.get<bool>("replay.savereplays", true);

		// features
		gproxy_enable = ghost.get<bool>("features.gproxy_enable", true);
		m_EnableBnetCommandInChannel = ghost.get<bool>("features.enable_bnet_command_in_channel", true);

		// admins
		m_LocalAdminMessages = ghost.get<bool>("admins.localadminmessages", false);
		m_AdminMessages = ghost.get<bool>("admins.adminmessages", false);
		m_PlaceAdminsHigherOnlyInDota = ghost.get<bool>("admins.placeadminshigheronlyindota", false);
		m_LanAdmins = ghost.get<bool>("admins.lanadmins", false);
		m_LanRootAdmins = ghost.get<bool>("admins.lanrootadmins", false);
		m_LocalAdmins = ghost.get<bool>("admins.localadmins", false);
		m_NonAdminCommands = ghost.get<bool>("admins.nonadmincommands", true);
	    m_DetourAllMessagesToAdmins = ghost.get<bool>("admins.detourallmessagestoadmins", true);
		m_RootAdmins = ghost.get<string>("system.rootadmins", "");

		// admin game
		m_AdminGameCreate = ghost.get<bool>("admingame.create", false);
		m_AdminGamePassword = ghost.get<string>("admingame.map", "" );
		m_AdminGameMap = ghost.get<string>("admingame.create", "admingame.cfg");

		// ban_and_warn
		m_ReplaceBanWithWarn = ghost.get<bool>("ban_and_warn.replacebanwithwarn", false);
		m_IPBanning = ghost.get<uint32_t>("ban_and_warn.ipbanning", 0);
		m_Banning = ghost.get<uint32_t>("ban_and_warn.banning", 1);
		m_BanTheWarnedPlayerQuota = ghost.get<uint32_t>("ban_and_warn.banthewarnedplayerquota", 3);
		m_BanTimeOfWarnedPlayer = ghost.get<uint32_t>("ban_and_warn.bantimeofwarnedplayer", 7);
		m_AutoWarnEarlyLeavers = ghost.get<bool>("ban_and_warn.autowarnearlyleavers", false);
		m_SafelistedBanImmunity = ghost.get<bool>("ban_and_warn.safelistedbanimmunity", false);
		m_KickUnknownFromChannel = ghost.get<bool>("ban_and_warn.kickunknownfromchannel", false);
		m_KickBannedFromChannel = ghost.get<bool>("ban_and_warn.kickbannedfromchannel", false);
		m_BanBannedFromChannel = ghost.get<bool>("ban_and_warn.banbannedfromchannel", false);
		m_NotifyBannedPlayers = ghost.get<bool>("ban_and_warn.notifybannedplayers", true);
		m_RootAdminsSpoofCheck = ghost.get<bool>("ban_and_warn.rootadminsspoofcheck", true);
		m_AdminsSpoofCheck = ghost.get<bool>("ban_and_warn.adminsspoofcheck", true);
		m_TwoLinesBanAnnouncement = ghost.get<bool>("ban_and_warn.twolinesbanannouncement", true);
		m_UnbanRemovesChannelBans = ghost.get<bool>("ban_and_warn.unbanremoveschannelban", false);
		m_AutoBan = ghost.get<bool>("ban_and_warn.autoban", false);
	    m_AutoBanTeamDiffMax = ghost.get<uint32_t>("ban_and_warn.autobanteamdiffmax", 0);
		m_AutoBanTimer = ghost.get<uint32_t>("ban_and_warn.autobantimer", 0);
	    m_AutoBanAll = ghost.get<bool>("ban_and_warn.autobanall", 0);
	    m_AutoBanFirstXLeavers = ghost.get<uint32_t>("ban_and_warn.autobanfirstxleavers", 0);
	    m_AutoBanGameLoading = ghost.get<uint32_t>("ban_and_warn.autobangameloading", 0);
	    m_AutoBanCountDown = ghost.get<uint32_t>("ban_and_warn.autobancountdown", 0);
	    m_AutoBanGameEndMins = ghost.get<uint32_t>("ban_and_warn.autobangameendmins", 3);
		m_AdminsLimitedUnban = ghost.get<bool>("ban_and_warn.adminslimitedunban", false);
		m_AdminsCantUnbanRootadminBans = ghost.get<bool>("ban_and_warn.adminscantunbanrootadminbans", true);
		m_InformAboutWarnsPrintout = ghost.get<uint32_t>("ban_and_warn.informaboutwarnsprintout", 60);

		if ( m_AutoBanGameEndMins < 1 )
			m_AutoBanGameEndMins = 1;

		// auto censor
		string m_CensorWords = ghost.get<string>("games.autocensor.censorwords", "xxx");
		m_CensorMute = ghost.get<bool>("games.autocensor.censorwords.enabled", true);
		m_CensorMuteAdmins = ghost.get<bool>("games.autocensor.censormuteadmins", false);
		m_CensorMuteFirstSeconds = ghost.get<uint32_t>("games.autocensor.censormutefirstseconds", 60);
		m_CensorMuteSecondSeconds = ghost.get<uint32_t>("games.autocensor.censormutesecondseconds", 180);
		m_CensorMuteExcessiveSeconds = ghost.get<uint32_t>("games.autocensor.censormuteexcessiveseconds", 360);

		/*
		const boost::property_tree::ptree& battlenet = data.get_child("server.battle_net");
		
		connect_to_battle_net = battlenet.get<bool>("enable", false);
		war3path = battlenet.get<string>("war3path", "");
		cdkeyroc = battlenet.get<string>("cdkeyroc", "");
		cdkeytft = battlenet.get<string>("cdkeytft", "");
		bnet_server   = battlenet.get<string>("server", "");
		username = battlenet.get<string>("username", "");
		password = battlenet.get<string>("password", "");
		channel  = battlenet.get<string>("channel", "");
		exeversion		= battlenet.get<string>("exeversion", "");
		exeversionhash	= battlenet.get<string>("exeversionhash", "");
		passwordhashtype = battlenet.get<string>("passwordhashtype", "");
		war3path = battlenet.get<string>("war3path", "");

		bnls_server = battlenet.get<string>("bnls_server", "");
		bnls_port = battlenet.get<uint32_t>("bnls_port", 0);
		bnls_wardercookie = battlenet.get<uint32_t>("bnls_wardercookie", 0); 

		war3version = battlenet.get<uint16_t>("war3version", 26);
		port = battlenet.get<uint32_t>("port", 6112);

        BOOST_FOREACH (const boost::property_tree::ptree::value_type& base,
            data.get_child("server.databases"))
        {
            const boost::property_tree::ptree& values = base.second;

            if (const boost::optional<std::string> optionalComment =
                    values.get_optional<std::string>("comment"))
            {
                std::cout << optionalComment.get() << endl;
            } else
            {
                if ( static_cast<string>(base.first.data()) == "mysql" )
                {
                    dbServer = values.get<string>("host", "localhost");
                    dbDatabase = values.get<string>("database", "");
                    dbUser = values.get<string>("user", "");
                    dbPassword = values.get<string>("password", "");
                    Port = values.get<int>("port", 0);
                }
 //               else if ( static_cast<string>(base.first.data()) == "redis" )
 //               {
//                    redis_password = values.get<string>("password", "");
//                    redis_host = values.get<string>("host", "localhost");
//                    redis_port = values.get<int>("port", 6378 );
//                }

                std::cout << "[CONFIG] " << base.first.data() << " database config succesfully parsed. " << endl;
            }
        }

        BOOST_FOREACH (const boost::property_tree::ptree::value_type& bot,
            data.get_child("server.bots"))
        {
            const boost::property_tree::ptree& values = bot.second;

            if (const boost::optional<std::string> optionalComment =
                    values.get_optional<std::string>("comment"))
            {
                std::cout << optionalComment.get() << endl;
            } else
            {
                if ( values.get<bool>("enabled", false) )
                {
                    CBotData botdata;

                    botdata.bot_channel = values.get<string>("channel", "");
                    botdata.bot_command_port = values.get<int>("command_port", 8200);
                    botdata.bot_gameport = values.get<int>("gameport", 6112);
                    botdata.bot_ip = values.get<string>("ip", "127.0.0.1");
                    botdata.can_create_game = values.get<bool>("can_create_game", false);
                    botdata.SetSocket( NULL );

                    nBotList.push_back(botdata);
          
					cout << "[CONFIG] Bot " << bot.first.data() << " config data succesfully parsed." << endl;
                }
            }
        }
		*/
    }
	catch (boost::property_tree::info_parser_error& error)
	{
		CONSOLE_Print( "[CONFIG] " + error.message() + " " + error.filename() + " at line " + UTIL_ToString(error.line()) );
		CONSOLE_Print( "[GHOST] shutdown due the invalid config file" );

		return true;
	}

	return false;
}

bool CConfigData::Save( const string& nFileName )
{
   // Create an empty property tree object

   /*
   ptree pt;

   // Put log filename in property tree
   pt.put("debug.filename", m_file);

   // Put debug level in property tree
   pt.put("debug.level", m_level);

   // Iterate over the modules in the set and put them in the
   // property tree. Note that the put function places the new
   // key at the end of the list of keys. This is fine most of
   // the time. If you want to place an item at some other place
   // (i.e. at the front or somewhere in the middle), this can
   // be achieved using a combination of the insert and put_own
   // functions.
   BOOST_FOREACH(const std::string &name, m_modules)
      pt.put("debug.modules.module", name, true);

   // Write the property tree to the XML file.
   */
   write_info(nFileName, data);

   return true;
}