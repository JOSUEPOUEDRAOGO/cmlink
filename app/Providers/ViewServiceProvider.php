<?php

namespace App\Providers;

use App\Models\Referentiel\Categorie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            try {
                $frontCategories = Categorie::withCount('offres')
                    ->orderBy('nom')
                    ->get();
            } catch (\Throwable $e) {
                $frontCategories = collect();
            }

            $view->with('frontCategories', $frontCategories);
        });
    }
}