<button @click="darkMode = !darkMode" type="button" class="w-10 h-10 flex items-center justify-center rounded-3xl hover:bg-neutral transition">
    <template x-if="!darkMode">
        <x-ri-sun-fill class="size-4" />
    </template>
    <template x-if="darkMode">
        <x-ri-moon-fill class="size-4" />
    </template>
</button>
