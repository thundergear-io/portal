<div>
    <div class="flex flex-col gap-12">
        <!-- Swiper Slider -->
        <div class="mx-auto px-4 sm:px-6 container lg:px-8 mt-8">
            <div class="swiper h-[400px] sm:h-[500px] rounded-[2.5rem] overflow-hidden shadow-2xl border border-base-300 group" id="heroSwiper" style="--swiper-theme-color: var(--color-primary); --swiper-pagination-bullet-inactive-color: rgba(255,255,255,0.5); --swiper-navigation-size: 16px;">
                <div class="swiper-wrapper">
                    @forelse ($sliders as $slider)
                    <div class="swiper-slide relative group/slide">
                        <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title ?? 'Slide' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/slide:scale-105">
                        @if ($slider->link)
                        <a href="{{ $slider->link }}" class="absolute inset-0 z-10"></a>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>
                    @empty
                    @for ($i = 1; $i <= 3; $i++)
                    <div class="swiper-slide relative group/slide">
                        <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1200&h=600&fit=crop" alt="Slide {{ $i }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/slide:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>
                    @endfor
                    @endforelse
                </div>
                <div class="swiper-pagination !bottom-8"></div>
                <div class="swiper-button-prev !text-white !bg-black/20 !backdrop-blur-md !w-10 !h-10 !rounded-full hover:!bg-primary hover:!text-black transition-all shadow-lg border border-white/10"></div>
                <div class="swiper-button-next !text-white !bg-black/20 !backdrop-blur-md !w-10 !h-10 !rounded-full hover:!bg-primary hover:!text-black transition-all shadow-lg border border-white/10"></div>
            </div>
        </div>

        <div class="mx-auto px-4 sm:px-6 container lg:px-8 mb-16">
            <div class="flex flex-col gap-8">
                <div class="flex items-end justify-between">
                    <div class="space-y-2">
                        {{-- <span class="text-sm font-black text-primary">Our Services</span> --}}
                        <h2 class="text-4xl font-black text-base-content tracking-tight">Our Products & Services</h2>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($categories as $category)
                    <div class="group flex flex-col bg-base-200 border border-base-300 p-4 rounded-3xl">
                        @if ($category->image)
                        <div class="relative aspect-video w-full mb-6 overflow-hidden rounded-2xl bg-base-300 shadow-md group-hover:shadow-lg transition-all">
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @endif
                        
                        <div class="flex-1 flex flex-col">
                            <h3 class="text-2xl font-black text-base-content">{{ $category->name }}</h3>
                            
                            @if(theme('show_category_description', true) && $category->description)
                            <div class="mt-2 prose prose-md dark:prose-invert text-base-content/60 line-clamp-3">
                                {!! strip_tags($category->description) !!}
                            </div>
                            @endif
                            
                            <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate class="mt-8">
                                <button class="btn btn-primary w-full font-black shadow-lg transition-all">
                                    {{ __('common.button.view_all') }}
                                    <x-ri-arrow-right-fill class="size-4 ml-2 group-hover:translate-x-1 transition-transform" />
                                </button>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {!! hook('pages.home') !!}
</div>
