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
#include <algorithm>

//
// CDotaItem
//

void CDotaItem::addRecipe(CDotaItemRecipe* recipe) 
{ 
	if ( find(recipes.begin(), recipes.end(), recipe) == recipes.end() ) 
		recipes.push_back(recipe);
};

//
// CDotaAllItems
//

CDotaAllItems::CDotaAllItems( )
{
	CONSOLE_Print( "[CDotaAllItems : Construcotr] Start.");
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
	add(1227896115, "Vitality Booster", 1);
	add(1227897137, "Soul Booster", 1);
	add(1227895862, "Broadsword", 1);
	add(1227896911, "Blade Mail", 1);
	add(1227902019, "Vanguard", 1);
	add(1227896882, "Linken's Sphere Recipe", 1);
	add(1227897178, "Linken's Sphere", 1);
	add(1227899467, "Bloodstone", 1);
	add(1227896901, "Shiva's Guard Recipe", 1);
	add(1227895889, "Plate Mail", 1);
	add(1227894874, "Shiva's Guard", 1);
	add(1227896664, "Black King Bar Recipe", 1);
	add(1227895885, "Mathril Mahher", 1);
	add(1227900506, "Black King Bar", 1);
	add(1227896884, "Heart of Tarrasque Recipe", 1);
	add(1227895884, "Messerschmidt's Reaver", 1);
	add(1227899193, "Heart of Tarrasque", 1);
	add(1227896899, "Assault Cuirass Recipe", 1);
	add(1227899466, "Assault Cuirass", 1);
	add(1227895878, "Hyperstone", 1);
	add(1227896409, "Diffusal Blade Recipe", 1);
	add(1227896914, "Diffusal Blade", 1);
	add(1227896410, "Mask Of Madness Recipe", 1);
	add(1227896921, "Mask Of Madness", 1);
	add(1227896399, "Yasha Recipe", 1);
	add(1227896903, "Yasha", 1);
	add(1227896662, "Stygian Desolator Recipe", 1);
	add(1227897143, "Stygian Desolator", 1);
	add(1227896406, "Maelstorm Recipe", 1);
	add(1227896912, "Maelstorm", 1);
	add(1227896916, "Helm of the Dominator", 1);
	add(1227896400, "Sange Recipe", 1);
	add(1227896904, "Sange", 1);
	add(1227899205, "Eye of Skadi", 1);
	add(1227902265, "Orb of Venom", 1);
	add(1227901774, "Mjollnir Recipe", 1);
	add(1227899461, "Mjollnir", 1);
	add(1227896885, "Satanic Recipe", 1);
	add(1227899202, "Satanic", 1);
	add(1227897141, "Sange and Yasha", 1);
	add(1227902036, "Ethereal Blade", 1);
	add(1227895873, "Eaglehorn", 1);
	add(1227901513, "Ghost Scepter", 1);
	add(1227896666, "Lothar's Edge Recipe", 1);
	add(1227895864, "Claymore", 1);
	add(1227897160, "Lothar's Edge", 1);
	add(1227896900, "Armlet of Mordiggian Recipe", 1);
	add(1227894865, "Armlet of Mordiggian", 1);
	add(1227896663, "Crystalys Recipe", 1);
	add(1227897155, "Crystalys", 1);
	add(1227896665, "Manta Style Recipe", 1);
	add(1227897158, "Manta Style", 1);
	add(1227897145, "Battle Fury", 1);
	add(1227896403, "Cranium Basher Recipe", 1);
	add(1227896907, "Cranium Basher", 1);
	add(1227896117, "Javelin", 1);
	add(1227896883, "Buriza-do Kyanon Recipe", 1);
	add(1227899187, "Buriza-do Kyanon", 1);
	add(1227895865, "Demon Edge", 1);
	add(1227899209, "The Butterfly", 1);
	add(1227901494, "Talisman of Avansion", 1);
	add(1227896646, "Radiance Recipe", 1);
	add(1227899192, "Radiance", 1);
	add(1227895896, "Sacred Relic", 1);
	add(1227899189, "Monkey King Bar", 1);
	add(1227899185, "Divine Rapier", 1);
	add(1227895876, "Gem of True Sight", 1);
	add(1227895880, "Kelen's Dagger", 1);
	add(1227896132, "Clarity Potion", 100);
	add(1227896134, "Healing Salve", 100);
	add(1227896131, "Ancient Tango of Essifation", 100);
	add(1227899222, "Empty Bottle", 1);
	add(1227896135, "Observer Wards", 100);
	add(1227896136, "Sentry Wards", 100);
	add(1227900744, "Dust of Appearance", 2);
	add(1227896138, "Animal Courier", 1);
	add(1227896137, "Scroll of Town Portal", 100);
	add(1227901010, "Quelling Blade", 1);
	CONSOLE_Print( "[CDotaAllItems : Construcotr] End.");
};

CDotaItem* CDotaAllItems::find(uint32_t nItem)
{ 
	CONSOLE_Print( "[CDotaAllItems : find] Start.");
	map<uint32_t, CDotaItem>::iterator it;
	for (it = m_AllItems.begin(); it != m_AllItems.end(); it++)
		CONSOLE_Print( "[CDotaAllItems : find] "+it->second.name);
	it =  m_AllItems.find(nItem);
	if(it == m_AllItems.end())
		CONSOLE_Print( "[DEATH COMES FOR AS ALL]");
	CDotaItem* dotaItem = &(it->second);
	CONSOLE_Print( "[CDotaAllItems : find] End.");
	return dotaItem; 
};


//
// CDotaItemRecipe
//

CDotaItemRecipe::CDotaItemRecipe (uint32_t nItem, CDotaAllItems* nAllItems)
{
	m_Count = 0;
	m_Counter = 0;
	m_ReturnedItem = nItem;
	nAllItems->find(nItem)->addRecipe(this);
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
			break;
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
			break;
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
	recipe = new CDotaItemRecipe(1227900994, nAllItems);
	recipe->AddItem(1227900739);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227900983);
	m_ItemRecipes.push_back(recipe);
	// Null of talisman
	recipe = new CDotaItemRecipe(1227896396, nAllItems);
	recipe->AddItem(1227896152);
	recipe->AddItem(1227895385);
	recipe->AddItem(1227895882);
	m_ItemRecipes.push_back(recipe);
	// Wraith band
	recipe = new CDotaItemRecipe(1227896394, nAllItems);
	recipe->AddItem(1227896151);
	recipe->AddItem(1227895385);
	recipe->AddItem(1227895897);
	m_ItemRecipes.push_back(recipe);
	// Bracer
	recipe = new CDotaItemRecipe(1227896392, nAllItems);
	recipe->AddItem(1227896150);
	recipe->AddItem(1227895385);
	recipe->AddItem(1227895875);
	m_ItemRecipes.push_back(recipe);
	// Poor Man's Shield
	recipe = new CDotaItemRecipe(1227901766, nAllItems);
	recipe->AddItem(1227896113);
	recipe->AddItem(1227895897);
	recipe->AddItem(1227895897);
	m_ItemRecipes.push_back(recipe);
	// Perseverance
	recipe = new CDotaItemRecipe(1227896370, nAllItems);
	recipe->AddItem(1227896116);
	recipe->AddItem(1227895892);
	m_ItemRecipes.push_back(recipe);
	// Oblivion staff
	recipe = new CDotaItemRecipe(1227896370, nAllItems);
	recipe->AddItem(1227895891);
	recipe->AddItem(1227895895);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Hand of Midas
	recipe = new CDotaItemRecipe(1227896388, nAllItems);
	recipe->AddItem(1227896149);
	recipe->AddItem(1227895376);
	m_ItemRecipes.push_back(recipe);
	// Soul Ring
	recipe = new CDotaItemRecipe(1227902028, nAllItems);
	recipe->AddItem(1227902030);
	recipe->AddItem(1227895894);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Power Threads of Strength 
	recipe = new CDotaItemRecipe(1227896153, nAllItems);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895376);
	recipe->AddItem(1227895859);
	m_ItemRecipes.push_back(recipe);
	// Power Threads of Agility 
	recipe = new CDotaItemRecipe(1227895380, nAllItems);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895376);
	recipe->AddItem(1227895378);
	m_ItemRecipes.push_back(recipe);
	// Power Threads of Magic
	recipe = new CDotaItemRecipe(1227896154, nAllItems);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895376);
	recipe->AddItem(1227895895);
	m_ItemRecipes.push_back(recipe);
	// Phase Boots 
	recipe = new CDotaItemRecipe(1227900746, nAllItems);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895861);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	// Headdress of Rejuvenation
	recipe = new CDotaItemRecipe(1227896371, nAllItems);
	recipe->AddItem(1227895894);
	recipe->AddItem(1227895879);
	recipe->AddItem(1227896146);
	m_ItemRecipes.push_back(recipe);
	// Urn of Shadows 
	recipe = new CDotaItemRecipe(1227901785, nAllItems);
	recipe->AddItem(1227901782);
	recipe->AddItem(1227895898);
	recipe->AddItem(1227895875);
	recipe->AddItem(1227895875);
	m_ItemRecipes.push_back(recipe);
	// Khadgar's Pipe of Insight
	recipe = new CDotaItemRecipe(1227901750, nAllItems);
	recipe->AddItem(1227901018);
	recipe->AddItem(1227896371);
	recipe->AddItem(1227899469);
	m_ItemRecipes.push_back(recipe);
	// Ring of Basilius 
	recipe = new CDotaItemRecipe(1227896375, nAllItems);
	recipe->AddItem(1227895893);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Nathrezim Buckler
	recipe = new CDotaItemRecipe(1227896374, nAllItems);
	recipe->AddItem(1227896147);
	recipe->AddItem(1227895863);
	recipe->AddItem(1227895879);
	m_ItemRecipes.push_back(recipe);
	// Arcane boots
	recipe = new CDotaItemRecipe(1227902281, nAllItems);
	recipe->AddItem(1227895375);
	recipe->AddItem(1227895874);
	m_ItemRecipes.push_back(recipe);
	// Vladmir's Offering
	recipe = new CDotaItemRecipe(1227899463, nAllItems);
	recipe->AddItem(1227896375);
	recipe->AddItem(1227896898);
	recipe->AddItem(1227895883);
	recipe->AddItem(1227895894);
	m_ItemRecipes.push_back(recipe);
	// Mekansm
	recipe = new CDotaItemRecipe(1227897139, nAllItems);
	recipe->AddItem(1227896627);
	recipe->AddItem(1227896371);
	recipe->AddItem(1227896374);
	m_ItemRecipes.push_back(recipe);
	// Refresher orb
	recipe = new CDotaItemRecipe(1227899210, nAllItems);
	recipe->AddItem(1227896888);
	recipe->AddItem(1227896390);
	recipe->AddItem(1227896370);
	m_ItemRecipes.push_back(recipe);
	// Aghanim's Scepter 1
	recipe = new CDotaItemRecipe(1227894833, nAllItems);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227895860);
	// Aghanim's Scepter 2
	recipe = new CDotaItemRecipe(1227894833, nAllItems);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227895887);
	recipe->AddItem(1227895860);
	// Aghanim's Scepter 3
	recipe = new CDotaItemRecipe(1227894833, nAllItems);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227895887);
	recipe->AddItem(1227896112);
	m_ItemRecipes.push_back(recipe);
	// Necromicon 1
	recipe = new CDotaItemRecipe(1227897172, nAllItems);
	recipe->AddItem(1227896881);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227895859);
	m_ItemRecipes.push_back(recipe);
	// Necromicon 2
	recipe = new CDotaItemRecipe(1227897176, nAllItems);
	recipe->AddItem(1227896881);
	recipe->AddItem(1227897172);
	m_ItemRecipes.push_back(recipe);
	// Necromicon 3
	recipe = new CDotaItemRecipe(1227897177, nAllItems);
	recipe->AddItem(1227896881);
	recipe->AddItem(1227897176);
	m_ItemRecipes.push_back(recipe);
	// Dagon 1
	recipe = new CDotaItemRecipe(1227897165, nAllItems);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	// Dagon 2
	recipe = new CDotaItemRecipe(1227897168, nAllItems);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897165);
	m_ItemRecipes.push_back(recipe);
	// Dagon 3
	recipe = new CDotaItemRecipe(1227897166, nAllItems);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897168);
	m_ItemRecipes.push_back(recipe);
	// Dagon 4
	recipe = new CDotaItemRecipe(1227897167, nAllItems);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897166);
	m_ItemRecipes.push_back(recipe);
	// Dagon 5
	recipe = new CDotaItemRecipe(1227897164, nAllItems);
	recipe->AddItem(1227896880);
	recipe->AddItem(1227897167);
	m_ItemRecipes.push_back(recipe);
	// Force Staff
	recipe = new CDotaItemRecipe(1227901001, nAllItems);
	recipe->AddItem(1227900998);
	recipe->AddItem(1227895891);
	recipe->AddItem(1227896112);
	m_ItemRecipes.push_back(recipe);
	// Eul's Scepter of Divinity
	recipe = new CDotaItemRecipe(1227896922, nAllItems);
	recipe->AddItem(1227896626);
	recipe->AddItem(1227896112);
	recipe->AddItem(1227896116);
	recipe->AddItem(1227895898);
	m_ItemRecipes.push_back(recipe);
	// Orchid Malevolence
	recipe = new CDotaItemRecipe(1227895090, nAllItems);
	recipe->AddItem(1227896390);
	recipe->AddItem(1227896390);
	recipe->AddItem(1227896390);
	m_ItemRecipes.push_back(recipe);
	// Guinsoo's Scythe of Vyse
	recipe = new CDotaItemRecipe(1227899212, nAllItems);
	recipe->AddItem(1227895886);
	recipe->AddItem(1227896114);
	recipe->AddItem(1227896116);
	m_ItemRecipes.push_back(recipe);
	// Hood of Defiance /1
	recipe = new CDotaItemRecipe(1227899469, nAllItems);
	recipe->AddItem(1227895888);
	recipe->AddItem(1227895877);
	recipe->AddItem(1227895892);
	m_ItemRecipes.push_back(recipe);
	// Hood of Defiance /2
	recipe = new CDotaItemRecipe(1227899469, nAllItems);
	recipe->AddItem(1227895888);
	recipe->AddItem(1227895877);
	recipe->AddItem(1227895894);
	recipe->AddItem(1227895894);
	m_ItemRecipes.push_back(recipe);
	// Soul Booster
	recipe = new CDotaItemRecipe(1227897137, nAllItems);
	recipe->AddItem(1227896115);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227895874);
	m_ItemRecipes.push_back(recipe);
	// Blade Mail 
	recipe = new CDotaItemRecipe(1227896911, nAllItems);
	recipe->AddItem(1227895862);
	recipe->AddItem(1227895863);
	recipe->AddItem(1227895895);
	m_ItemRecipes.push_back(recipe);
	// Vanguard
	recipe = new CDotaItemRecipe(1227902019, nAllItems);
	recipe->AddItem(1227896113);
	recipe->AddItem(1227895892);
	recipe->AddItem(1227896115);
	m_ItemRecipes.push_back(recipe);
	// Linken's Sphere
	recipe = new CDotaItemRecipe(1227897178, nAllItems);
	recipe->AddItem(1227896882);
	recipe->AddItem(1227896370);
	recipe->AddItem(1227896114);
	m_ItemRecipes.push_back(recipe);
	// Bloodstone
	recipe = new CDotaItemRecipe(1227899467, nAllItems);
	recipe->AddItem(1227896370);
	recipe->AddItem(1227897137);
	m_ItemRecipes.push_back(recipe);
	// Shiva's Guard
	recipe = new CDotaItemRecipe(1227894874, nAllItems);
	recipe->AddItem(1227896901);
	recipe->AddItem(1227895889);
	recipe->AddItem(1227895886);
	m_ItemRecipes.push_back(recipe);
	// Black King Bar
	recipe = new CDotaItemRecipe(1227900506, nAllItems);
	recipe->AddItem(1227896664);
	recipe->AddItem(1227895887);
	recipe->AddItem(1227895885);
	m_ItemRecipes.push_back(recipe);
	// Heart of Tarrasque
	recipe = new CDotaItemRecipe(1227899193, nAllItems);
	recipe->AddItem(1227896884);
	recipe->AddItem(1227895884);
	recipe->AddItem(1227896115);
	m_ItemRecipes.push_back(recipe);
	// Assault Cuirass
	recipe = new CDotaItemRecipe(1227899466, nAllItems);
	recipe->AddItem(1227896899);
	recipe->AddItem(1227895889);
	recipe->AddItem(1227895878);
	recipe->AddItem(1227895863);
	m_ItemRecipes.push_back(recipe);
	// Diffusal Blade
	recipe = new CDotaItemRecipe(1227896914, nAllItems);
	recipe->AddItem(1227896409);
	recipe->AddItem(1227895860);
	recipe->AddItem(1227895860);
	recipe->AddItem(1227895895);
	m_ItemRecipes.push_back(recipe);
	// Mask Of Madness
	recipe = new CDotaItemRecipe(1227896921, nAllItems);
	recipe->AddItem(1227896410);
	recipe->AddItem(1227895883);
	m_ItemRecipes.push_back(recipe);
	// Yasha
	recipe = new CDotaItemRecipe(1227896903, nAllItems);
	recipe->AddItem(1227896399);
	recipe->AddItem(1227895860);
	recipe->AddItem(1227895378);
	m_ItemRecipes.push_back(recipe);
	// Stygian Desolator
	recipe = new CDotaItemRecipe(1227897143, nAllItems);
	recipe->AddItem(1227896662);
	recipe->AddItem(1227895885);
	recipe->AddItem(1227895885);
	m_ItemRecipes.push_back(recipe);
	// Maelstorm
	recipe = new CDotaItemRecipe(1227896912, nAllItems);
	recipe->AddItem(1227896406);
	recipe->AddItem(1227895885);
	recipe->AddItem(1227895376);
	m_ItemRecipes.push_back(recipe);
	// Helm of the Dominator 
	recipe = new CDotaItemRecipe(1227896916, nAllItems);
	recipe->AddItem(1227895877);
	recipe->AddItem(1227895883);
	m_ItemRecipes.push_back(recipe);
	// Sange
	recipe = new CDotaItemRecipe(1227896904, nAllItems);
	recipe->AddItem(1227896400);
	recipe->AddItem(1227895887);
	recipe->AddItem(1227895859);
	m_ItemRecipes.push_back(recipe);
	// Eye of Skadi
	recipe = new CDotaItemRecipe(1227899205, nAllItems);
	recipe->AddItem(1227896114);
	recipe->AddItem(1227896114);
	recipe->AddItem(1227895890);
	recipe->AddItem(1227902265);
	m_ItemRecipes.push_back(recipe);
	// Mjollnir
	recipe = new CDotaItemRecipe(1227899461, nAllItems);
	recipe->AddItem(1227901774);
	recipe->AddItem(1227896912);
	recipe->AddItem(1227895878);
	m_ItemRecipes.push_back(recipe);
	// Satanic 
	recipe = new CDotaItemRecipe(1227899202, nAllItems);
	recipe->AddItem(1227896885);
	recipe->AddItem(1227896916);
	recipe->AddItem(1227895884);
	m_ItemRecipes.push_back(recipe);
	// Sange and Yasha 
	recipe = new CDotaItemRecipe(1227897141, nAllItems);
	recipe->AddItem(1227896904);
	recipe->AddItem(1227896903);
	m_ItemRecipes.push_back(recipe);
	// Ethereal Blade 
	recipe = new CDotaItemRecipe(1227902036, nAllItems);
	recipe->AddItem(1227895873);
	recipe->AddItem(1227901513);
	m_ItemRecipes.push_back(recipe);
	// Lothar's Edge
	recipe = new CDotaItemRecipe(1227897160, nAllItems);
	recipe->AddItem(1227896666);
	recipe->AddItem(1227895864);
	recipe->AddItem(1227895891);
	m_ItemRecipes.push_back(recipe);
	// Armlet of Mordiggian
	recipe = new CDotaItemRecipe(1227894865, nAllItems);
	recipe->AddItem(1227896900);
	recipe->AddItem(1227895877);
	recipe->AddItem(1227895376);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	// Crystalys
	recipe = new CDotaItemRecipe(1227897155, nAllItems);
	recipe->AddItem(1227896663);
	recipe->AddItem(1227895862);
	recipe->AddItem(1227895861);
	m_ItemRecipes.push_back(recipe);
	// Manta Style
	recipe = new CDotaItemRecipe(1227897158, nAllItems);
	recipe->AddItem(1227896665);
	recipe->AddItem(1227896903);
	recipe->AddItem(1227896114);
	m_ItemRecipes.push_back(recipe);
	// Battle Fury
	recipe = new CDotaItemRecipe(1227897145, nAllItems);
	recipe->AddItem(1227895864);
	recipe->AddItem(1227895862);
	recipe->AddItem(1227896370);
	m_ItemRecipes.push_back(recipe);
	// Cranium Basher 
	recipe = new CDotaItemRecipe(1227896907, nAllItems);
	recipe->AddItem(1227896403);
	recipe->AddItem(1227896117);
	recipe->AddItem(1227895859);
	m_ItemRecipes.push_back(recipe);
	// Buriza-do Kyanon
	recipe = new CDotaItemRecipe(1227899187, nAllItems);
	recipe->AddItem(1227896883);
	recipe->AddItem(1227895865);
	recipe->AddItem(1227897155);
	m_ItemRecipes.push_back(recipe);
	// The Butterfly
	recipe = new CDotaItemRecipe(1227899209, nAllItems);
	recipe->AddItem(1227895873);
	recipe->AddItem(1227901494);
	recipe->AddItem(1227895891);
	m_ItemRecipes.push_back(recipe);
	// Radiance
	recipe = new CDotaItemRecipe(1227899192, nAllItems);
	recipe->AddItem(1227896646);
	recipe->AddItem(1227895896);
	m_ItemRecipes.push_back(recipe);
	// Monkey King Bar
	recipe = new CDotaItemRecipe(1227899189, nAllItems);
	recipe->AddItem(1227896117);
	recipe->AddItem(1227896117);
	recipe->AddItem(1227895865);
	m_ItemRecipes.push_back(recipe);
	// Divine Rapier
	recipe = new CDotaItemRecipe(1227899185, nAllItems);
	recipe->AddItem(1227895865);
	recipe->AddItem(1227895896);
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
	CONSOLE_Print( "[PickUpItem] Strart.");
	vector<uint32_t> items;
	CONSOLE_Print( "[PickUpItem] Try to find an item.");
	CDotaItem* oItem = m_AllItems->find(nItem);
	CONSOLE_Print( "[PickUpItem] Start for .");
	for (vector<CDotaItemRecipe*>::iterator it1 = oItem->recipes.begin(); it1 != oItem->recipes.end(); it1++)
	{
		items = (*it1)->PickUpItem(nItem);
		if (!items.empty()) // we have a new item
		{
			items.erase(find(items.begin(), items.end(), nItem));
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
			m_Items[i] = CDotaItem(m_AllItems->find(nItem));
			return false;
		}
	}
	return false;
};

bool CDotaItems::DropItem (uint32_t nItem)
{
	CDotaItem* oItem = m_AllItems->find(nItem);
	for (vector<CDotaItemRecipe*>::iterator it = oItem->recipes.begin(); it != oItem->recipes.end(); it++)
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