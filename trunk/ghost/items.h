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
// CDotaItemRecipe
//

class CDotaItemRecipe 
{
	private:
		multimap<uint32_t, bool> m_Items;
		uint32_t m_ReturnedItem;
		uint32_t m_Count;
		uint32_t n_Counter;
		
	public:
		CDotaItemRecipe(uint32_t nItem);
		~CDotaItemRecipe();
		vector<uint32_t> PickUpItem (uint32_t nItem);
		void DropItem (uint32_t nItem);
		void AddItem (uint32_t nItem);
};

//
// CDotaItems
//

class CDotaItems
{
	private:
		struct CItem {
			CItem(uint32_t nVal, string nName, int nMax): value=nVal, name=nName, max_count=nMax, count=0;
			uint32_t value;
			string name;
			int max_count;
			int count;
		};
		vector<CDotaItemRecipe*> m_ItemRecipes;
		map<uint32_t, CItem> m_AllItems;
		CItem m_Items[6];
		
		bool PickUpPItem (uint32_t nItem);
		bool DropPItem (uint32_t nItem);
		
	public:
		CDotaItems();
		~CDotaItems();
		bool PickUpItem (uint32_t nItem);
		bool DropItem (uint32_t nItem);
		vector<string> GetItems();
};
