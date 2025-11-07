<div x-data="{
    skills: @js($skills),
    id: @entangle('skill_id'),
    category: '',
    distinctCategories: [],

    getDistinctCategories() {
        this.distinctCategories = ['Choose category', ...new Set(this.skills.map(skill => skill.category))];
    },

    //Update skill names to show by currently selected category
    filteredByCategory() {
        return this.skills.filter(skill => skill.category == this.category);
    },
}" 
    x-init="getDistinctCategories"
    >

    <x-input-label for="category" value="Skill Category" class="text-lg mt-4" />

    {{-- Select skill category --}}
    <select id="category"
        x-model="category"
        class="flex flex-col gap-1 border-1 border-gray-300 rounded-md max-h-20 w-full overflow-y-auto">
        <template x-for="category in distinctCategories" :key="category">
            <option :value="category" x-text="category"></option>
        </template>
    </select>

    <x-input-label for="name" value="Skill Name" class="text-lg mt-4" />

    {{-- Select skill name --}}
    <select id="name"
        x-model="id"
        class="flex flex-col gap-1 border-1 border-gray-300 rounded-md max-h-20 w-full overflow-y-auto">
        <template x-for="skill in filteredByCategory()" :key="skill.id">
            <option :value="skill.id" x-text="skill.name"></option>
        </template>
    </select>

</div>
