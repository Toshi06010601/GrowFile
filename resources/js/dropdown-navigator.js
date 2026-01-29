export default () => ({
    selectedIndex: -1,

    navigateDown() {
        const items = this.getItems();
        this.selectedIndex = Math.min(this.selectedIndex + 1, items.length - 1);
        this.scrollToSelected();
    },

    navigateUp() {
        this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
        this.scrollToSelected();
    },

    selectCurrent() {
        if (this.selectedIndex >= 0) {
            const items = this.getItems();
            if (items[this.selectedIndex]) {
                items[this.selectedIndex].click();
                this.reset();
            }
        }
    },

    scrollToSelected() {
        if (this.selectedIndex >= 0) {
            const items = this.getItems();
            items[this.selectedIndex]?.scrollIntoView({
                block: 'nearest',
                behavior: 'smooth'
            });
        }
    },

    getItems() {
        return this.$el.querySelectorAll('[data-suggestion-item]');
    },

    reset() {
        this.selectedIndex = -1;
    },

    isSelected(index) {
        return this.selectedIndex === index;
    }
});