<div class="mx-auto px-4 py-12 sm:px-6 container lg:px-8">
    <div class="flex flex-col lg:grid lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="space-y-8">
            <div class="space-y-4">
                <h1 class="text-4xl font-black text-base-content tracking-tight">{{ $category->name }}</h1>
                @if($category->description)
                <div class="prose prose-md dark:prose-invert text-base-content/70">
                    {!! $category->description !!}
                </div>
                @endif
            </div>
            
            <div class="bg-base-200 border border-base-300 rounded-3xl p-4 overflow-hidden">
                <div class="py-3 text-md text-base-content/40">Categories</div>
                <div class="flex flex-col">
                    @foreach ($categories as $ccategory)
                    <a href="{{ route('category.show', ['category' => $ccategory->slug]) }}" wire:navigate
                        class="px-4 py-3 mb-2 rounded-2xl transition-all border border-base-300 bg-base-300/50 duration-200 flex items-center justify-between group {{ $category->id == $ccategory->id ? 'bg-primary text-primary-content' : 'hover:bg-base-300 text-base-content/70 hover:text-base-content' }}">
                        <span>{{ $ccategory->name }}</span>
                        @if($category->id == $ccategory->id)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-12">
            @if (count($childCategories) >= 1)
            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($childCategories as $childCategory)
                <a href="{{ route('category.show', ['category' => $childCategory->slug]) }}" wire:navigate 
                    class="group flex flex-col bg-base-200/50 hover:bg-base-200 border border-base-300 p-6 rounded-3xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    @if ($childCategory->image)
                    <img src="{{ Storage::url($childCategory->image) }}" alt="{{ $childCategory->name }}"
                        class="aspect-video w-full object-cover rounded-2xl mb-6 shadow-md group-hover:shadow-lg transition-all">
                    @endif
                    <h2 class="text-xl font-black text-base-content group-hover:text-primary transition-colors">{{ $childCategory->name }}</h2>
                    @if(theme('show_category_description', true) && $childCategory->description)
                    <div class="mt-3 prose prose-sm dark:prose-invert text-base-content/60 line-clamp-2">
                        {!! strip_tags($childCategory->description) !!}
                    </div>
                    @endif
                    <div class="mt-6 flex items-center text-primary font-black text-xs">
                        Explore Category
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($products as $product)
                <div class="group flex flex-col bg-base-200 border border-base-300 p-4 rounded-3xl">
                    @if ($product->image)
                    <div class="relative aspect-4/3 w-full mb-6 overflow-hidden rounded-2xl bg-base-300 shadow-md">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            class="h-full w-full object-contain p-4">
                    </div>
                    @endif
                    
                    <div class="flex-1 flex flex-col">
                        <h2 class="text-2xl font-black text-base-content line-clamp-1">{{ $product->name }}</h2>
                        
                        @if(theme('direct_checkout', false) && $product->description)
                        <div class="mt-3 prose prose-sm dark:prose-invert text-base-content/60 line-clamp-2">
                            {!! strip_tags($product->description) !!}
                        </div>
                        @endif
                        
                        <div class="mt-4 flex items-baseline gap-1">
                            <span class="text-2xl font-black text-primary tracking-tighter">{{ $product->price()->formatted->price }}</span>
                            @if($product->price()->has_setup_fee)
                            <span class="text-[12px] font-bold text-base-content/40">+ setup fee</span>
                            @endif
                        </div>
                        
                        <div class="mt-6 flex items-center gap-2">
                            @if($product->stock !== 0 && $product->price()->available && theme('direct_checkout', false))
                            <a href="{{ route('products.checkout', ['category' => $product->category, 'product' => $product->slug]) }}"
                                wire:navigate class="flex-grow">
                                <button class="btn btn-primary w-full">
                                    {{ __('product.add_to_cart') }}
                                </button>
                            </a>
                            @else
                            <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}"
                                wire:navigate class="flex-grow">
                                <button class="btn btn-primary w-full">
                                    {{ __('common.button.view') }}
                                </button>
                            </a>
                            @if ($product->stock !== 0 && $product->price()->available)
                            <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}"
                                wire:navigate>
                                <button class="btn btn-ghost btn-square border border-base-300 hover:bg-primary hover:text-primary-content hover:border-primary transition-all">
                                    <x-ri-shopping-bag-4-fill class="size-5" />
                                </button>
                            </a>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>