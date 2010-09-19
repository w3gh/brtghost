/*

   Copyright [2008] [Trevor Hogan]

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

   CODE PORTED FROM THE ORIGINAL GHOST PROJECT: http://ghost.pwner.org/

*/

#ifndef LANGUAGE_H
#define LANGUAGE_H

//
// CLanguage
//
// brtGhost team, freed, avon.dn.ua@gmail.com

class CLanguage
{
private:
	CConfig *m_CFG;

public:
	CLanguage( string nCFGFile );
	~CLanguage( );

    string GetLang(string lang_id) { return m_CFG -> GetString(lang_id,"Error find "+lang_id+" in language config."); }; // Get Lang string from config

    string GetLang(string lang_id, string v1);

    string GetLang(string lang_id, string v1, string s1,
                                    string v2 = "", string s2 = "",
                                    string v3 = "", string s3 = "",
                                    string v4 = "", string s4 = "",
                                    string v5 = "", string s5 = "",
                                    string v6 = "", string s6 = "",
                                    string v7 = "", string s7 = "",
                                    string v8 = "", string s8 = "",
                                    string v9 = "", string s9 = "",
                                    string v10 = "", string s10 = "",
                                    string v11 = "", string s11 = "",
                                    string v12 = "", string s12 = "",
                                    string v13 = "", string s13 = "",
                                    string v14 = "", string s14 = "",
                                    string v15 = "", string s15 = "",
                                    string v16 = "", string s16 = "",
                                    string v17 = "", string s17 = "",
                                    string v18 = "", string s18 = "",
                                    string v19 = "", string s19 = "");
};

#endif
