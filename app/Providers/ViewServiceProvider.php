<?php

namespace App\Providers;

use App\Models\Referentiel\Categorie;
use App\Models\PageSection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        View::composer('*', function ($view) {

            /*
            |--------------------------------------------------------------------------
            | Catégories globales du front
            |--------------------------------------------------------------------------
            */
            try {

                $frontCategories = Categorie::withCount('offres')
                    ->orderBy('nom')
                    ->get();

            } catch (\Throwable $e) {

                $frontCategories = collect();

            }


            /*
            |--------------------------------------------------------------------------
            | Contenus globaux du footer
            |--------------------------------------------------------------------------
            */
            try {

                $pageContent = PageSection::where('page', 'home')
                    ->where('is_active', true)
                    ->get()
                    ->groupBy('section')
                    ->map(fn ($items) => $items->pluck('value', 'key'));

            } catch (\Throwable $e) {

                $pageContent = collect();

            }


            /*
            |--------------------------------------------------------------------------
            | Variables disponibles dans toutes les vues
            |--------------------------------------------------------------------------
            */
            $view->with([
                'frontCategories' => $frontCategories,
                'pageContent'     => $pageContent,
            ]);

        });
    }
}
