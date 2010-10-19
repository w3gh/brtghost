/*

   Copyright [2010] [Grigoriy Orekhov <gpm@ukr.net>]

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

*/

#include "items.h"
#include "util.h"

//
// CDotaAllItems
//

CDotaAllItems::CDotaAllItems( )
{
	add(1227900983, "Recipe Magic Wand", 1);
	add(1227900994, "Magic Wand", 1);
	add(1227900739, "Magic stick", 1);
	add(1227895879, "Ironwood branch", 1);
	add(1227896152, "Recipe Null of talisman", 1);
	add(1227896396, "Null of talisman", 1);
	add(1227895385, "Circlet of Nobility", 1);
	add(1227895882, "Mante of intelligence", 1);
	add(1227896151, "Recipe Wraith band", 1);
	add(1227896394, "Wraith band", 1);
	add(1227895897, "Slippers of Agility", 1);
	add(1227896150, "Recipe Bracer", 1);
	add(1227896392, "Bracer", 1);
	add(1227895875, "Gauntlets of Strength", 1);
	add(1227901766, "Poor Man's Shield", 1);
	add(1227896113, "Stout Shield", 1);
	add(1227896370, "Perseverance", 1);
	add(1227896116, "Void Stone", 1);
	add(1227895892, "Ring of Health", 1);
	add(1227896390, "Oblivion staff", 1);
	add(1227895891, "Quarterstaff", 1);
	add(1227895895, "Robe of Magi", 1);
	add(1227895898, "Sobi Mask", 1);
	add(1227896149, "Recipe Hand of Midas", 1);
	add(1227896388, "Hand of Midas", 1);
	add(1227895376, "Gloves of haste", 1);
	add(1227902030, "Recipe Soul Ring", 1);
	add(1227902028, "Soul Ring", 1);
	add(1227895894, "Ring of Regeneration", 1);
	add(1227895380, "Power Threads of Agility ", 1);
	add(1227895375, "Boots Of Speed", 1);
	add(1227895376, "Gloves of haste", 1);
	add(1227895378, "Boots of Elvenskin", 1);
	add(1227896153, "Power Threads of Strength", 1);
	add(1227895859, "Belt of Giant Strength", 1);
	add(1227896154, "Power Threads of Magic", 1);
	add(1227900746, "Phase Boots ", 1);
	add(1227895861, "Blades of Attack", 1);
	add(1227896146, "Recipe Headdress of Rejuvenation", 1);
	add(1227896371, "Headdress of Rejuvenation", 1);
	add(1227901782, "Recipe Urn of Shadows", 1);
	add(1227901785, "Urn of Shadows", 1);
	add(1227901018, "Recipe Khadgar's Pipe of Insight", 1);
	add(1227901750, "Khadgar's Pipe of Insight", 1);
	add(1227899469, "Hood of Defiance", 1);
	add(1227896375, "Ring of Basilius", 1);
	add(1227895893, "Ring of protection", 1);
	add(1227896147, "Recipe Nathrezim Buckler", 1);
	add(1227896374, "Nathrezim Buckler", 1);
	add(1227895863, "Chainmail", 1);
	add(1227902281, "Arcane boots", 1);
	add(1227895874, "Energy Booster", 1);
	add(1227896898, "Recipe Vladmir's Offering", 1);
	add(1227899463, "Vladmir's Offering", 1);
	add(1227895883, "Mask of Death", 1);
	add(1227896627, "Recipe Mekansm", 1);
	add(1227897139, "Mekansm", 1);
	add(1227896888, "Recipe Refresher orb", 1);
	add(1227899210, "Refresher orb", 1);
	add(1227901236, "Recipe Aghanim's Scepter", 1);
	add(1227894833, "Aghanim's Scepter", 1);
	add(1227895890, "Point Booster", 1);
	add(1227896112, "Staff of Wizardry", 1);
	add(1227895860, "Blade of Alacrity", 1);
	add(1227895887, "Ogre Axe", 1);
	add(1227896881, "Recipe Necromicon", 1);
	add(1227897172, "Necromicon 1", 1);
	add(1227897176, "Necromicon 2", 1);
	add(1227897177, "Necromicon 3", 1);
	add(1227896880, "Recipe Dagon", 1);
	add(1227897165, "Dagon 1", 1);
	add(1227897168, "Dagon 2", 1);
	add(1227897166, "Dagon 3", 1);
	add(1227897167, "Dagon 4", 1);
	add(1227897164, "Dagon 5", 1);
	add(1227900998, "Recipe Force Staff", 1);
	add(1227901001, "Force Staff", 1);
	add(1227896626, "Recipe Eul's Scepter of Divinity", 1);
	add(1227896922, "Eul's Scepter of Divinity", 1);
	add(1227895090, "Orchid Malevolence", 1);
	add(1227899212, "Guinsoo's Scythe of Vyse", 1);
	add(1227896114, "Ultimate Orb", 1);
	add(1227895886, "Mystic Staff", 1);
	add(1227895888, "Planeswalker's Cloak", 1);
	add(1227895877, "Helm of Iron Will", 1);
	add(0, "", 1);
	add(0, "", 1);
	add(0, "", 1);
	add(0, "", 1);
	add(0, "", 1);
};

//
// CDotaItemRecipe
//

CDotaItemRecipe::CDotaItemRecipe (uint32_t nItem)
{
	m_Count = 0;
	m_Counter = 0;
	m_ReturnedItem = nItem;
};

CDotaItemRecipe::~CDotaItemRecipe ()
{
	m_Items.clear();
};


vector<uint32_t> CDotaItemRecipe::PickUpItem (uint32_t nItem)
{
	vector<uint32_t> ret;
	
	for (multimap<uint32_t, bool>::iterator it = m_Items.begin(); it != m_Items.end(); it++)
	{
		if ( (*it).first == nItem && !(*it).second)
		{
			(*it).second = true;
			m_Counter++;
		}
	}
	
	if (m_Counter == m_Count)
	{	
		//create vector with an items that we need to drop, and the last item is an item we need to pick up.
		for (multimap<uint32_t, bool>::iterator it = m_Items.begin(); it != m_Items.end(); it++)
			ret.push_back((*it).first);
		
		ret.push_back(m_ReturnedItem);
		return ret;
	}
	return ret;
};

void CDotaItemRecipe::DropItem (uint32_t nItem)
{
	for (multimap<uint32_t, bool>::iterator it = m_Items.begin(); it != m_Items.end(); it++)
	{
		if ( (*it).first == nItem && (*it).second)
		{
			(*it).second = false;
			m_Counter--;
		}
	}
};

void CDotaItemRecipe::AddItem (uint32_t nItem)
{
	m_Items.insert( pair<uint32_t, bool>(nItem, false) );
	m_Count++;
};

//
// CDotaItems
//

CDotaItems::CDotaItems(CDotaAllItems* nAllItems)
{
	m_AllItems = nAllItems;
	
	m_Items[0] = CDotaItem();
	m_Items[1] = CDotaItem();
	m_Items[2] = CDotaItem();
	m_Items[3] = CDotaItem();
	m_Items[4] = CDotaItem();
	m_Items[5] = CDotaItem();
	
	// Recipes definition
	CDotaItemRecipe *recipe;
	// Magic Wand
	recipe = new CDotaItemRecipe(1227900994);
	recipe->AddItem(1227900739);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227900983);
	m_ItemRecipes.push_back(recipe);
	// Null of talisman
	recipe = new CDotaItemRecipe(1227896396);
	recipe->AddItem(1227896152);
	recipe->AddItem(1227895385);
	recipe->AddItem(1227895882);
	m_ItemRecipes.push_back(recipe);
	// Wraith band
	recipe = new CDotaItemRecipe(1227896394);
	recipe->AddItem(1227896151);
	recipe->AddItem(1227895385);
	recipe->AddItem(1227895897);
	m_ItemRecipes.push_back(recipe);
	// Bracer
	recipe = new CDotaItemRecipe(1227896392);
	recipe->AddItem(1227896150);
	recipe->AddItem(1227895385);
	recipe->AddItem(1227895875);
	m_ItemRecipes.push_back(recipe);
	// Poor Man's Shield
	recipe = new CDotaItemRecipe(1227901766);
	recipe->AddItem(1227896113);
	recipe->AddItem(1227895897);
	recipe->AddItem(1227895897);
	m_ItemRecipes.push_back(recipe);
	// Perseverance
	recipe = new CDotaItemRecipe(1227896370);
	recipe->AddItem(1227896116);
	recipe->AddItem(1227895892);
	m_ItemRecipes.push_back(recipe);
	// Oblivion staff
	recipe = new CDotaItemRecipe(1227896370);
	recipe->AddItem(1227895891);
	recipe->AddItem(1227895895);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Hand of Midas
	recipe = new CDotaItemRecipe(1227896388);
	recipe->AddItem(1227896149);
	recipe->AddItem(1227895376);
	m_ItemRecipes.push_back(recipe);
	// Soul Ring
	recipe = new CDotaItemRecipe(1227902028);
	recipe->AddItem(1227902030);
	recipe->AddItem(1227895894);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Power Threads of Strength 
	recipe = new CDotaItemRecipe(1227896153);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895376);
	recipe->AddItem(1227895859);
	m_ItemRecipes.push_back(recipe);
	// Power Threads of Agility 
	recipe = new CDotaItemRecipe(1227895380);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895376);
	recipe->AddItem(1227895378);
	m_ItemRecipes.push_back(recipe);
	// Power Threads of Magic
	recipe = new CDotaItemRecipe(1227896154);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895376);
	recipe->AddItem(1227895895);
	m_ItemRecipes.push_back(recipe);
	// Phase Boots 
	recipe = new CDotaItemRecipe(1227900746);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895861);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	// Headdress of Rejuvenation
	recipe = new CDotaItemRecipe(1227896371);
	recipe->AddItem(1227895894);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227896146);
	m_ItemRecipes.push_back(recipe);
	// Urn of Shadows 
	recipe = new CDotaItemRecipe(1227901785);
	recipe->AddItem(1227901782);
	recipe->AddItem(1227895898);
	recipe->AddItem(1227895875);
	recipe->AddItem(1227895875);
	m_ItemRecipes.push_back(recipe);
	// Khadgar's Pipe of Insight
	recipe = new CDotaItemRecipe(1227901750);
	recipe->AddItem(1227901018);
	recipe->AddItem(1227896371);
	recipe->AddItem(1227899469);
	m_ItemRecipes.push_back(recipe);
	// Ring of Basilius 
	recipe = new CDotaItemRecipe(1227896375);
	recipe->AddItem(1227895893);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Nathrezim Buckler
	recipe = new CDotaItemRecipe(1227896374);
	recipe->AddItem(1227896147);
	recipe->AddItem(1227895863);
	recipe->AddItem(1227895879);
	m_ItemRecipes.push_back(recipe);
	// Arcane boots
	recipe = new CDotaItemRecipe(1227902281);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895874);
	m_ItemRecipes.push_back(recipe);
	// Vladmir's Offering
	recipe = new CDotaItemRecipe(1227899463);
	recipe->AddItem(1227896375);
	recipe->AddItem(1227896898);
	recipe->AddItem(1227895883);
	recipe->AddItem(1227895894);
	m_ItemRecipes.push_back(recipe);
	// Mekansm
	recipe = new CDotaItemRecipe(1227897139);
	recipe->AddItem(1227896627);
	recipe->AddItem(1227896371);
	recipe->AddItem(1227896374);
	m_ItemRecipes.push_back(recipe);
	// Refresher orb
	recipe = new CDotaItemRecipe(1227899210);
	recipe->AddItem(1227896888);
	recipe->AddItem(1227896390);
	recipe->AddItem(1227896370);
	m_ItemRecipes.push_back(recipe);
	// Aghanim's Scepter 1
	recipe = new CDotaItemRecipe(1227894833);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227895860);
	// Aghanim's Scepter 2
	recipe = new CDotaItemRecipe(1227894833);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227895887);
	recipe->AddItem(1227895860);
	// Aghanim's Scepter 3
	recipe = new CDotaItemRecipe(1227894833);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227895887);
	recipe->AddItem(1227896112);
	m_ItemRecipes.push_back(recipe);
	// Necromicon 1
	recipe = new CDotaItemRecipe(1227897172);
	recipe->AddItem(1227896881);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227895859);
	m_ItemRecipes.push_back(recipe);
	// Necromicon 2
	recipe = new CDotaItemRecipe(1227897176);
	recipe->AddItem(1227896881);
	recipe->AddItem(1227897172);
	m_ItemRecipes.push_back(recipe);
	// Necromicon 3
	recipe = new CDotaItemRecipe(1227897177);
	recipe->AddItem(1227896881);
	recipe->AddItem(1227897176);
	m_ItemRecipes.push_back(recipe);
	// Dagon 1
	recipe = new CDotaItemRecipe(1227897165);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	// Dagon 2
	recipe = new CDotaItemRecipe(1227897168);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897165);
	// Dagon 3
	recipe = new CDotaItemRecipe(1227897166);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897168);
	// Dagon 4
	recipe = new CDotaItemRecipe(1227897167);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897166);
	// Dagon 5
	recipe = new CDotaItemRecipe(1227897164);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897167);
	m_ItemRecipes.push_back(recipe);
	// Force Staff
	recipe = new CDotaItemRecipe(1227901001);
	recipe->AddItem(1227900998);
	recipe->AddItem(1227895891);
	recipe->AddItem(1227896112);
	m_ItemRecipes.push_back(recipe);
	// Eul's Scepter of Divinity
	recipe = new CDotaItemRecipe(1227896922);
	recipe->AddItem(1227896626);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227896116);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Orchid Malevolence
	recipe = new CDotaItemRecipe(1227895090);
	recipe->AddItem(1227896390);
	recipe->AddItem(1227896390);
	recipe->AddItem(1227896390);
	m_ItemRecipes.push_back(recipe);
	// Guinsoo's Scythe of Vyse
	recipe = new CDotaItemRecipe(1227899212);
	recipe->AddItem(1227895886);
	recipe->AddItem(1227896114);
	recipe->AddItem(1227896116);
	m_ItemRecipes.push_back(recipe);
	// Hood of Defiance /1
	recipe = new CDotaItemRecipe(1227899469);
	recipe->AddItem(1227895888);
	recipe->AddItem(1227895877);
	recipe->AddItem(1227895892);
	m_ItemRecipes.push_back(recipe);
	// Hood of Defiance /2
	recipe = new CDotaItemRecipe(1227899469);
	recipe->AddItem(1227895888);
	recipe->AddItem(1227895877);
	recipe->AddItem(1227895894);
	recipe->AddItem(1227895894);
	m_ItemRecipes.push_back(recipe);
	// Phase Boots
	recipe = new CDotaItemRecipe(1227900746);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895861);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	// Phase Boots
	recipe = new CDotaItemRecipe(1227900746);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895861);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	
};

CDotaItems::~CDotaItems ()
{
	while(!m_ItemRecipes.empty())
	{
		delete m_ItemRecipes.back();
		m_ItemRecipes.pop_back();
	}
};

bool CDotaItems::PickUpItem (uint32_t nItem)
{
	// update recipe list info and check for a building of a new item.
	vector<uint32_t> items;
	for (vector<CDotaItemRecipe*>::iterator it = m_ItemRecipes.begin(); it != m_ItemRecipes.end(); it++)
	{
		items = (*it)->PickUpItem(nItem);
		if (!items.empty()) // we have a new item
		{
			for (vector<uint32_t>::iterator it = items.begin(); it < items.end(); it++)
			{
				if((*it)==nItem)
				{
					items.erase(it);
					break;
				}
			}
			uint32_t nItem = items.back();
			items.pop_back();
			// drop all items that in recipe
			while(!items.empty())
			{
				DropPItem(items.back());
				items.pop_back();
			}
			PickUpPItem(nItem);
			return true;
		}
	}
	// Pick up a new item
	return PickUpPItem(nItem);
};

bool CDotaItems::PickUpPItem (uint32_t nItem)
{
	for (int i = 0; i < 6; i++)
	{
		// if we already have this item and it count less than max value.
		if (m_Items[i].value == nItem && m_Items[i].max_count > m_Items[i].count)
		{
			m_Items[i].count++;
			return true;
		}
	}
	for (int i = 0; i < 6; i++)
	{
		if (m_Items[i].value == 0)
		{
			m_Items[i] = m_AllItems->find(nItem);
			return false;
		}
	}
	return false;
};

bool CDotaItems::DropItem (uint32_t nItem)
{
	for (vector<CDotaItemRecipe*>::iterator it = m_ItemRecipes.begin(); it != m_ItemRecipes.end(); it++)
	{
		(*it)->DropItem(nItem);
	}
	return DropPItem(nItem);
};

bool CDotaItems::DropPItem (uint32_t nItem)
{
	for (int i = 0; i < 6; i++)
	{
		if (m_Items[i].value == nItem)
		{
			if (m_Items[i].count > 1)
			{
				m_Items[i].count--;
				return true;
			}
			else
			{
				m_Items[i] = CDotaItem();
				return false;
			}
		}
	}
	return false;
};

vector<string> CDotaItems::GetItems( )
{
	vector<string> ret;
	for (int i = 0; i < 6; i++)
	{
		if (m_Items[i].value > 0)
			ret.push_back(UTIL_ToString(m_Items[i].value));
		else
			ret.push_back(string( ));
	}
	return ret;
};