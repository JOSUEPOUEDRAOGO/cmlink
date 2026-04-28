<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageSection;

class PageController extends Controller
{
    public function home()
    {
        $sections = PageSection::where('page', 'home')
            ->get()
            ->groupBy('section')
            ->map(fn ($items) => $items->pluck('value', 'key'));

        return view('admin.pages.home', compact('sections'));
    }

    public function updateHome(Request $request)
    {
        foreach ($request->input('sections', []) as $section => $items) {
            foreach ($items as $key => $value) {
                PageSection::updateOrCreate(
                    [
                        'page' => 'home',
                        'section' => $section,
                        'key' => $key,
                    ],
                    [
                        'value' => $value,
                        'is_active' => true,
                    ]
                );
            }
        }

        return back()->with('success', 'Page d’accueil mise à jour avec succès.');
    }
}

