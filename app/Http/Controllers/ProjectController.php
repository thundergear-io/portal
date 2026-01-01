<?php

namespace App\Http\Controllers;

use App\Models\ProjectItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = ProjectItem::with(['order', 'quote'])
            ->whereHas('order', fn ($q) => $q->where('user_id', Auth::id()))
            ->latest()
            ->paginate(10);

        return view('projects.index', [
            'projects' => $projects,
            'title' => 'Projects',
        ]);
    }
}
