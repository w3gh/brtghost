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

#include "ghost.h"
#include "util.h"
#include "config.h"
#include "language.h"

#include <cstdarg>
#include <stdio.h>

//
// CLanguage
//

CLanguage :: CLanguage( string nCFGFile )
{
	m_CFG = new CConfig( );
	m_CFG->Read( nCFGFile );

}

CLanguage :: ~CLanguage( )
{
	delete m_CFG;
}


string CLanguage :: GetLang(string lang_id, string v1, string s1,
                                             string v2, string s2,
                                             string v3, string s3,
                                             string v4, string s4,
                                             string v5, string s5,
                                             string v6, string s6,
                                             string v7, string s7,
                                             string v8, string s8,
                                             string v9, string s9,
                                             string v10, string s10,
                                             string v11, string s11,
                                             string v12, string s12,
                                             string v13, string s13,
                                             string v14, string s14,
                                             string v15, string s15,
                                             string v16, string s16,
                                             string v17, string s17,
                                             string v18, string s18,
                                             string v19, string s19)
{

    int pos;
    string out = GetLang(lang_id);

    if (!v1.empty())
    {
		if ((pos = out.find(v1)) != -1)
            out.replace(pos, v1.size(), s1);
    } else return out;

    if (!v2.empty())
    {
        if ((pos = out.find(v2)) != -1)
            out.replace(pos, v2.size(), s2);
    } else return out;

    if (!v3.empty())
    {
        if ((pos = out.find(v3)) != -1)
            out.replace(pos, v3.size(), s3);
    } else return out;

    if (!v4.empty())
    {
        if ((pos = out.find(v4)) != -1)
            out.replace(pos, v4.size(), s4);
    } else return out;


    if (!v5.empty())
    {
        if ((pos = out.find(v5)) != -1)
            out.replace(pos, v5.size(), s5);
    } else return out;

    if (!v6.empty())
    {
        if ((pos = out.find(v6)) != -1)
            out.replace(pos, v6.size(), s6);
    } else return out;

    if (!v7.empty())
    {
        if ((pos = out.find(v7)) != -1)
            out.replace(pos, v7.size(), s7);
    } else return out;

    if (!v8.empty())
    {
        if ((pos = out.find(v8)) != -1)
            out.replace(pos, v8.size(), s8);
    } else return out;

    if (!v9.empty())
    {
        if ((pos = out.find(v9)) != -1)
            out.replace(pos, v9.size(), s9);
    } else return out;

    if (!v10.empty())
    {
        if ((pos = out.find(v10)) != -1)
            out.replace(pos, v10.size(), s10);
    } else return out;

    if (!v11.empty())
    {
        if ((pos = out.find(v11)) != -1)
            out.replace(pos, v11.size(), s11);
    } else return out;

    if (!v12.empty())
    {
        if ((pos = out.find(v12)) != -1)
            out.replace(pos, v12.size(), s12);
    } else return out;

    if (!v13.empty())
    {
        if ((pos = out.find(v13)) != -1)
            out.replace(pos, v13.size(), s13);
    } else return out;


    if (!v14.empty())
    {
        if ((pos = out.find(v14)) != -1)
            out.replace(pos, v14.size(), s14);
    } else return out;


    if (!v15.empty())
    {
        if ((pos = out.find(v15)) != -1)
            out.replace(pos, v15.size(), s15);
    } else return out;


    if (!v16.empty())
    {
        if ((pos = out.find(v16)) != -1)
            out.replace(pos, v16.size(), s16);
    } else return out;

    if (!v17.empty())
    {
        if ((pos = out.find(v17)) != -1)
            out.replace(pos, v17.size(), s17);
    } else return out;

    if (!v18.empty())
    {
        if ((pos = out.find(v18)) != -1)
            out.replace(pos, v18.size(), s18);
    } else return out;

    if (!v19.empty())
    {
        if ((pos = out.find(v19)) != -1)
            out.replace(pos, v19.size(), s19);
    } else return out;


    return out;
}

string CLanguage :: GetLang(string lang_id, string v1)
{
    string out = GetLang(lang_id);

    if (v1.empty()) return out;

    int pos_start, pos_end;

    if ( (pos_start = out.find("$") ) != string :: npos)
    if ( (pos_end = out.find("$", pos_start +1 ) ) != string :: npos)
        out.replace(pos_start, pos_end - pos_start + 1, v1);

    return out;
}
