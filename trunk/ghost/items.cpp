/*

   Copyright [2010] [Grigoriy Orekhov]

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

#include "util.h"

//
// CDotaItem
//

CDotaItemRecipe::CDotaItemRecipe (uint32_t nItem)
{
	m_Count = 0;
	m_Counter = 0;
	m_ReturnedItem = nItem;
}

CDotaItemRecipe::~CDotaItemRecipe ()
{
	m_Items.clear();
}


CDotaItemRecipe::PickUpItem (uint32_t nItem)
{
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
		vector<uint32_t> ret;
		
		for (multimap<uint32_t, bool>::iterator it = m_Items.begin(); it != m_Items.end(); it++)
			ret.push_back((*it).first);
		
		ret.push_back(m_ReturnedItem);
		return ret;
	}
	return 0;
}

CDotaItemRecipe::DropItem (uint32_t nItem)
{
	for (multimap<uint32_t, bool>::iterator it = m_Items.begin(); it != m_Items.end(); it++)
	{
		if ( (*it).first == nItem && (*it).second)
		{
			(*it).second = false;
			m_Counter--;
		}
	}
}

CDotaItemRecipe::AddItem (uint32_t nItem)
{
	m_Items[nItem] = false;
	m_Count++;
}

//
// CDotaItems
//

CDotaItems::CDotaItems()
{
	m_Items[0] = CItem();
	m_Items[1] = CItem();
	m_Items[2] = CItem();
	m_Items[3] = CItem();
	m_Items[4] = CItem();
	m_Items[5] = CItem();
	
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
	
	// All items definition
	m_AllItems.insert(pair<uint32_t, CItem>(1227900983, CItem(1227900983, "Recipe Magic Wand", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227900994, CItem(1227900994, "Magic Wand", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227900739, CItem(1227900739, "Magic stick", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895879, CItem(1227895879, "Ironwood branch", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896152, CItem(1227896152, "Recipe Null of talisman", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896396, CItem(1227896396, "Null of talisman", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895385, CItem(1227895385, "Circlet of Nobility", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895882, CItem(1227895882, "Mante of intelligence", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896151, CItem(1227896151, "Recipe Wraith band", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896394, CItem(1227896394, "Wraith band", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895897, CItem(1227895897, "Slippers of Agility", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896150, CItem(1227896150, "Recipe Bracer", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896392, CItem(1227896392, "Bracer", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895875, CItem(1227895875, "Gauntlets of Strength", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227901766, CItem(1227901766, "Poor Man's Shield", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896113, CItem(1227896113, "Stout Shield", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896370, CItem(1227896370, "Perseverance", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896116, CItem(1227896116, "Void Stone", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895892, CItem(1227895892, "Ring of Health", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896390, CItem(1227896390, "Oblivion staff", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895891, CItem(1227895891, "Quarterstaff", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895895, CItem(1227895895, "Robe of Magi", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895898, CItem(1227895898, "Sobi Mask", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896149, CItem(1227896149, "Recipe Hand of Midas", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896388, CItem(1227896388, "Hand of Midas", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895376, CItem(1227895376, "Gloves of haste", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227902030, CItem(1227902030, "Recipe Soul Ring", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227902028, CItem(1227902028, "Soul Ring", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895894, CItem(1227895894, "Ring of Regeneration", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895380, CItem(1227895380, "Power Threads of Agility ", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895375, CItem(1227895375, "Boots Of Speed", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895376, CItem(1227895376, "Gloves of haste", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895378, CItem(1227895378, "Boots of Elvenskin", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896153, CItem(1227896153, "Power Threads of Strength", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895859, CItem(1227895859, "Belt of Giant Strength", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227896154, CItem(1227896154, "Power Threads of Magic", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227900746, CItem(1227900746, "Phase Boots ", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(1227895861, CItem(1227895861, "Blades of Attack", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(, CItem(0, "", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(, CItem(0, "", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(, CItem(0, "", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(, CItem(0, "", 1) );
	m_AllItems.insert(pair<uint32_t, CItem>(, CItem(0, "", 1) );

}

CDotaItems::~CDotaItems ()
{
	m_AllItems.clear();
	while(!m_ItemRecipes.empty())
	{
		delete m_ItemRecipes.back();
		m_ItemRecipes.pop_back();
	}
}

CDotaItems::PickUpItem (uint32_t nItem)
{
	// update recipe list info and check for a building of a new item.
	vector<uint32_t> items;
	for (vector<CDotaItemRecipe*>::iterator it = m_ItemRecipes.begin(); it != m_ItemRecipes.end(); it++)
	{
		items = (*it)->PickUpItem(nItem);
		if (items) // we have a new item
		{
			items->erase(items->find(nItem));
			uint32_t nItem = items->back();
			items->pop_back();
			// drop all items that in recipe
			while(!items->empty())
			{
				DropPItem(items.back());
				items.pop_back();
			}
			PickUpPitem(nItem)
			return true;
		}
	}
	// Pick up a new item
	return PickUpPitem(nItem);
}

CDotaItems::PickUpPItem (uint32_t nItem)
{
	for (int i = 0; i < 6; i++)
	{
		// if we already have this item and it count less than max value.
		if (m_Items[i].value == nItem && m_Item[i].max_count > m_Item[i].count)
		{
			m_Items[i].count++;
			return true;
		}
	}
	for (int i = 0; i < 6; i++)
	{
		if (m_Items[i].value == 0)
		{
			m_Items[i] = m_AllItems.find(nItem)->second;
			return false;
		}
	}
	return false;
}

CDotaItems::DropItem (uint32_t nItem)
{
	for (vector<CDotaItemRecipe*>::iterator it = m_ItemRecipes.begin(); it != m_ItemRecipes.end(); it++)
	{
		items = (*it)->DropItem(nItem);
	}
	return DropPItem(nItem);
}

CDotaItems::DropPItem (uint32_t nItem)
{
	for (int i = 0; i < 6; i++)
	{
		if (m_Items[i].value == nItem)
		{
			if (m_Item[i].count > 1)
			{
				m_Items[i].count--;
				return true;
			}
			else
			{
				m_Items[i] = CItem();
				return false;
			}
		}
	}
	return false;
}

CDotaItems::GetItems( )
{
	vector<string> ret;
	for (int i = 0; i < 6; i++)
		ret.push_back(UTIL_ToString(m_Items[i].value));
	return ret;
}