<div x-data="{
    skills: @js($this->skills),
    id: @entangle('skill_id'),
    distinctCategories: [],
    selectedCategory: '',

    getDistinctCategories() {
        this.distinctCategories = ['Choose category', ...new Set(this.skills.map(skill => skill.category))];
    },

    //Set the current userSkill record's category
    initializeCategory(skillId) {
        const selectedSkill = this.skills.find(skill => skill.id == skillId);
        this.selectedCategory = selectedSkill ? selectedSkill.category : 'Choose category';
    },

    //Update skill name options by currently selected category
    filteredByCategory() {
        const filtered = this.skills.filter(skill => skill.category == this.selectedCategory);
        return [{ id: 0, name: 'Choose Skill Name', category: 'Choose category' }, ...filtered];
    },
}" {{-- Get distinct categories of all skills --}} x-init="getDistinctCategories" {{-- Set the current category when user click a particular user skill item --}}
    @trigger-category-init.window="initializeCategory($event.detail[0].skillId)" {{-- Initialize id to 0 whenever category has been changed --}}
    x-effect="if (selectedCategory !== '') id = 0">

    {{-- Error State --}}
    @if ($hasError)
        <x-loading-error>Failed to load skills. Please try again.</x-loading-error>
    @endif

    @if (!$hasError)
        {{-- skill category --}}
        <div>
            <x-input-label for="category" value="Skill Category" class="text-lg mt-4" />

            {{-- Select skill category --}}
            <select id="category" x-model="selectedCategory"
                class="flex flex-col gap-1 border-1 border-brand-secondary-300 rounded-md max-h-20 w-full overflow-y-auto">
                {{-- Show category options --}}
                <template x-for="category in distinctCategories" :key="category">
                    <option :value="category" x-text="category" :selected="category == selectedCategory"></option>
                </template>
            </select>
        </div>


        {{-- skill name --}}
        <div>
            <x-input-label for="name" value="Skill Name" class="text-lg mt-4" />

            {{-- Select skill name --}}
            <select id="name" x-model="id"
                class="flex flex-col gap-1 border-1 border-brand-secondary-300 rounded-md max-h-20 w-full overflow-y-auto">
                {{-- Show skill options that belong to the selected category --}}
                <template x-for="skill in filteredByCategory()" :key="skill.id">
                    <option :value="skill.id" x-text="skill.name" :selected="skill.id == id"></option>
                </template>
            </select>
        </div>
    @endif

</div>
