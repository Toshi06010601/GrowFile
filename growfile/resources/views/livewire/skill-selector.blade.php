<div x-data="{
    skills: @js($skills),
    id: @entangle('skill_id'),
    selectedCategory: '',
    distinctCategories: [],

    getDistinctCategories() {
        this.distinctCategories = ['Choose category', ...new Set(this.skills.map(skill => skill.category))];
    },

    initializeCategory() {
        selectedSkill = this.skills.find(skill => skill.id == this.id);
        this.selectedCategory = selectedSkill ? selectedSkill.category : null;
    },

    //Update skill names to show by currently selected category
    filteredByCategory() {
        return this.skills.filter(skill => skill.category == this.selectedCategory);
    },
}" 
    x-init="getDistinctCategories"
    x-effect="initializeCategory"
    >

    <x-input-label for="category" value="Skill Category" class="text-lg mt-4" />

    {{-- Select skill category --}}
    <select id="category"
        x-model="selectedCategory"
        class="flex flex-col gap-1 border-1 border-gray-300 rounded-md max-h-20 w-full overflow-y-auto">
        <template x-for="category in distinctCategories" :key="category">
            <option :value="category" x-text="category" :selected="category == selectedCategory"></option>
        </template>
    </select>

    <x-input-label for="name" value="Skill Name" class="text-lg mt-4" />

    {{-- Select skill name --}}
    <select id="name"
        x-model="id"
        class="flex flex-col gap-1 border-1 border-gray-300 rounded-md max-h-20 w-full overflow-y-auto">
        <template x-for="skill in filteredByCategory()" :key="skill.id">
            <option :value="skill.id" x-text="skill.name" :selected="skill.id == id"></option>
        </template>
    </select>

</div>
