@if($announcements->count() > 0) 
<div>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="bg-base-100 border border-base-300 p-2 rounded-3xl">
                <x-ri-megaphone-fill class="size-5" />
            </div>
            <h2 class="text-xl font-semibold">{{ __('Announcements') }}</h2>
        </div>
    </div>
    <div class="space-y-4">
        <div class="space-y-4">
            @foreach($announcements as $announcement)
            <a href="{{ route('announcements.show', $announcement) }}" wire:navigate>
                <div class="bg-base-100 hover:bg-base-100/80 border border-base-300 p-4 rounded-3xl mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="bg-secondary/10 p-2 rounded-3xl">
                                <x-ri-newspaper-line class="size-5 fill-secondary" />
                            </div>
                            <span class="font-medium">{{ $announcement->title }}</span>
                        </div>
                        <div class="prose dark:prose-invert text-sm">
                            {{ $announcement->published_at->diffForHumans() }}
                        </div>
                    </div>
                    <p class="text-sm text-base/70">{{ $announcement->description }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <x-navigation.link class="bg-base-100 hover:bg-base-100/80 bg-base-100 hover:bg-base-100/80 border border-base-300 flex items-center justify-center rounded-3xl flex items-center justify-center rounded-3xl"
        :href="route('announcements.index')">
        {{ __('dashboard.view_all') }}
        <x-ri-arrow-right-fill class="size-5" />
    </x-navigation.link>
</div>
@endif