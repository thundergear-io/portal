<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Slider;

class Home extends Component
{
    public function render()
    {
        return view('home', [
            'sliders' => Slider::where('active', true)->orderBy('sort')->get(),
            // Categories which have NO parent and at least one child
            'categories' => Category::whereNull('parent_id')
                ->where(function ($query) {
                    $query->whereHas('children')
                        ->orWhereHas('products', function ($query) {
                            $query->where('hidden', false);
                        });
                })
                ->with(['products.plans.prices'])
                ->orderBy('sort')
                ->get(),
            'title' => 'Home',
        ]);
    }
}
