@props(['trigger', 'button'])

<div x-data="{ openModal: null }" x-cloak>
    <button @click="openModal = {{ $trigger }}"
        class="rounded-md mt-[8px] bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">
        {{ $button }}
    </button>

    <div x-show="openModal !== null" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-100" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-100"
        class="fixed inset-0 bg-black/50 flex justify-center items-center z-50 p-8"
        :class="{ 'hidden': openModal === null }" style="display: none;">

        <div class="w-full max-w-5xl bg-lighter shadow-lg rounded-lg overflow-hidden my-4 relative">
            <button @click="openModal = null" class="absolute top-4 right-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>

            <div class="py-4 px-6 h-[70vh] overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
