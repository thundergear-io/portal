<div class="container mt-14">
    <div class="bg-base-100 hover:bg-base-100/80 border border-base-300 p-4 rounded-3xl">
        <div class="flex flex-row justify-between mb-6">
            <h2 class="text-xl font-bold">{{ $announcement->title }}</h2>
            <p class="text-sm text-base">{{ $announcement->published_at->diffForHumans() }}</p>
        </div>
        <article class="prose dark:prose-invert mb-2 max-w-full">
            {!! $announcement->content !!}
        </article>
    </div>
</div>