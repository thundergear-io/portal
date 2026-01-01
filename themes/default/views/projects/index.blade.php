<x-app-layout :title="$title ?? 'Projects'" :sidebar="true">
    <div class="container mt-14">
        {{-- <x-navigation.breadcrumb /> --}}
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-base-content">Projects</h1>
                <p class="text-base-content/70">Track progress for your approved quotes.</p>
            </div>
        </div>

        <div class="space-y-6">
            @forelse ($projects as $project)
                @php
                    $steps = [
                        ['key' => 'pending', 'label' => 'Received'],
                        ['key' => 'in_progress', 'label' => 'In Progress'],
                        ['key' => 'review', 'label' => 'In Review'],
                        ['key' => 'completed', 'label' => 'Completed'],
                    ];
                    $activeIndex = collect($steps)->search(fn ($step) => $step['key'] === $project->status) ?? 0;
                @endphp

                <div class="card bg-base-200 border border-base-300 shadow-sm">
                    <div class="card-body p-6 space-y-5">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h2 class="text-lg font-semibold">{{ $project->title }}</h2>
                                    <span class="badge {{ $project->status === 'completed' ? 'badge-success' : ($project->status === 'in_progress' ? 'badge-primary' : ($project->status === 'review' ? 'badge-warning' : 'badge-outline')) }}">
                                        {{ \Illuminate\Support\Str::headline($project->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-base-content/70">Quote: {{ $project->quote?->title ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-base-content/70">Total</div>
                                <div class="text-xl font-semibold">${{ number_format($project->amount, 2) }}</div>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-4">
                            @foreach ($steps as $index => $step)
                                @php
                                    $active = $index <= $activeIndex;
                                @endphp
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full border-2 {{ $active ? 'border-primary bg-primary/10 text-primary' : 'border-base-300 text-base-content/60' }} flex items-center justify-center font-semibold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $step['label'] }}</div>
                                            <div class="text-xs text-base-content/60">
                                                {{ $active ? 'Updated' : 'Pending' }}
                                            </div>
                                        </div>
                                    </div>
                                    @if ($index < count($steps))
                                        <div class="h-1 rounded-full {{ ($index < $activeIndex) || ($index === count($steps) - 1 && $project->status === 'completed') ? 'bg-primary' : 'bg-base-300' }}"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-sm text-base-content/70">
                            <span>Created {{ $project->created_at->diffForHumans() }}</span>
                            <span class="hidden sm:inline">•</span>
                            <a class="link" href="{{ route('quotes.show', ['quote' => $project->quote?->public_id]) }}">View quote</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert">
                    <div>
                        <span class="font-semibold">No projects yet.</span>
                        <p class="text-base-content/70">Approve a quote to start tracking a project.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>
