<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Referentiel\Categorie;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $frontCategories = Categorie::withCount('offres')
                ->orderBy('nom')
                ->get();

            $view->with('frontCategories', $frontCategories);
        });
    }
}