@props([
    'name',
    'value' => '',
    'placeholder' => 'Select...',
    'options' => [],
])

<div
    x-data="{
        open: false,
        selected: @js((string) $value),
        options: @js($options),
        get selectedLabel() {
            const found = this.options.find(option => option.value == this.selected)
            return found ? found.label : @js($placeholder)
        }
    }"
    class="relative"
>
    <input type="hidden" name="{{ $name }}" x-model="selected">

    <button
        type="button"
        @click="open = !open"
        class="w-full mt-1 rounded-xl bg-white/5 border border-white/10 text-slate-100 px-4 py-3 flex items-center justify-between focus:border-white/20 focus:outline-none"
    >
        <span x-text="selectedLabel" :class="selected ? 'text-slate-100' : 'text-slate-400'"></span>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
        </svg>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.outside="open = false"
        class="absolute z-50 mt-2 w-full rounded-2xl"
        style="display: none;"
    >
        <div class="rounded-2xl border border-white/15 shadow-2xl ring-1 ring-black/20 py-2 bg-slate-950/90 backdrop-blur-xl">
            <template x-for="option in options" :key="option.value">
                <button
                    type="button"
                    @click="selected = option.value; open = false"
                    class="block w-full rounded-xl px-4 py-3 text-start text-sm leading-5 transition duration-150 ease-in-out"
                    :class="selected == option.value
                        ? 'bg-white/10 text-slate-100'
                        : 'text-slate-300 hover:bg-white/10 hover:text-slate-100'"
                    x-text="option.label"
                ></button>
            </template>
        </div>
    </div>
</div>