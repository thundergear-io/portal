<div
    x-data="{
        selectOpen: false,
        selectedValue: @entangle($attributes->wire('model')),
        selectableItems: {{ json_encode($options) }},
        selectableItemActive: null,
        selectId: $id('select'),
        selectDropdownPosition: 'bottom',

        init() {
            this.$watch('selectOpen', () => {
                if (this.selectOpen) {
                    this.selectableItemActive = this.selectableItems.find(item => item.value === this.selectedValue) 
                        || this.selectableItems[0];
                    this.$nextTick(() => this.selectScrollToActiveItem());
                }
                this.selectPositionUpdate();
            });

            window.addEventListener('resize', this.resizeHandler = () => this.selectPositionUpdate());
            this.$el.addEventListener('alpine:destroyed', () => window.removeEventListener('resize', this.resizeHandler));
        },

        selectableItemIsActive(item) {
            return this.selectableItemActive && this.selectableItemActive.value === item.value;
        },

        selectableItemActiveNext() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index < this.selectableItems.length - 1) {
                this.selectableItemActive = this.selectableItems[index + 1];
                this.selectScrollToActiveItem();
            }
        },

        selectableItemActivePrevious() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index > 0) {
                this.selectableItemActive = this.selectableItems[index - 1];
                this.selectScrollToActiveItem();
            }
        },

        selectScrollToActiveItem() {
            if (this.selectableItemActive) {
                const activeElement = document.getElementById(this.selectableItemActive.value + '-' + this.selectId);
                if (activeElement) {
                    activeElement.scrollIntoView({ block: 'nearest' });
                }
            }
        },

        selectPositionUpdate() {
            if (!this.$refs.selectButton || !this.$refs.selectableItemsList) return;
            
            const selectDropdownBottomPos = this.$refs.selectButton.getBoundingClientRect().top + 
                this.$refs.selectButton.offsetHeight + 
                this.$refs.selectableItemsList.offsetHeight;
            
            this.selectDropdownPosition = window.innerHeight < selectDropdownBottomPos ? 'top' : 'bottom';
        }
    }"
    @keydown.escape="selectOpen = false"
    @keydown.down.prevent="if(selectOpen) { selectableItemActiveNext() } else { selectOpen = true }"
    @keydown.up.prevent="if(selectOpen) { selectableItemActivePrevious() } else { selectOpen = true }"
    @keydown.enter.prevent="selectedValue = selectableItemActive.value; selectOpen = false"
    class="relative w-full"
>
    <button 
        x-ref="selectButton"
        @click="selectOpen = !selectOpen"
        :class="{ 'ring-2 ring-offset-2 ring-primary': selectOpen }"
        class="relative w-full h-12 px-4 text-left bg-base-300 border border-base-200 rounded-2xl shadow-sm cursor-pointer text-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300"
        type="button"
    >
        <span x-text="selectableItems.find(item => item.value === selectedValue)?.label ?? '{{ $placeholder ?? 'Select option' }}'" class="block truncate text-base-content"></span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <x-ri-expand-up-down-line class="size-4" />
        </span>
    </button>

    <ul
        x-show="selectOpen"
        x-ref="selectableItemsList"
        @click.away="selectOpen = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        :class="{ 'bottom-full mb-2': selectDropdownPosition === 'top', 'top-full mt-2': selectDropdownPosition === 'bottom' }"
        class="absolute z-50 w-full py-2 overflow-auto bg-base-300 border border-base-200 rounded-2xl shadow-2xl max-h-64 focus:outline-none text-md"
        x-cloak
    >
        <template x-for="item in selectableItems" :key="item.value">
            <li
                :id="item.value + '-' + selectId"
                @click="selectedValue = item.value; selectOpen = false"
                @mousemove="selectableItemActive = item"
                :class="{ 'bg-primary/10 text-primary': selectableItemIsActive(item), 'text-base-content': !selectableItemIsActive(item) }"
                class="relative py-3 pl-10 pr-4 cursor-pointer select-none hover:bg-primary/5 hover:text-primary transition-colors duration-200"
            >
                <span 
                    class="block truncate"
                    :class="{ 'font-black': item.value === selectedValue, 'font-medium': item.value !== selectedValue }"
                    x-text="item.label"
                ></span>
                <span
                    x-show="item.value === selectedValue"
                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-primary"
                >
                    <x-ri-check-fill class="size-5" />
                </span>
            </li>
        </template>
    </ul>
</div>