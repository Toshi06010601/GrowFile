<div x-data="{
    show: false,
    message: '',
    type: 'success',
    timeout: null,
    scrollToTop() {
        const container = this.$el.closest('.overflow-y-auto');

        if (container) {
            container.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}"
    @flash-message.window="
        clearTimeout(timeout);
        message = $event.detail.message;
        type = $event.detail.type;
        show = true;
        timeout = setTimeout(() => show = false, 4000);
        $nextTick(() => setTimeout(() => scrollToTop(), 200));
    "
    x-show="show" x-cloak x-transition:enter="transition ease-out duration-1000"
    x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4" :class="type === 'success' ? 'bg-brand-primary-900' : 'bg-red-600'"
    class="fixed top-2 left-1/2 -translate-x-1/2 z-50 text-white px-6 py-4 rounded-lg shadow-xl flex items-center gap-1 sm:gap-4 w-[90vw] sm:max-w-md">

    <template x-if="type === 'success'">
        <img src={{ asset('images/icons/check.svg') }} alt="check icon" class="size-6">
        </img>
    </template>
    <template x-if="type === 'error'">
        <img src={{ asset('images/icons/warning.svg') }} alt="warning icon" class="size-6">
        </img>
    </template>

    <span class="flex-1" x-text="message"></span>


    <button @click="show = false" class="text-white hover:text-gray-200 flex-shrink-0">
        <img src={{ asset('images/icons/close-white.svg') }} alt="close icon" class="size-5">
        </img>
    </button>
</div>
