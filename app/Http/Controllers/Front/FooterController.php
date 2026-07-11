<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;

class FooterController extends Controller
{
    /**
     * Conditions Générales d'Utilisation
     */
    public function cgu()
    {
        $page = LegalPage::where('slug', 'cgu')
            ->where('status', true)
            ->firstOrFail();

        return view('pages.legal.cgu', compact('page'));
    }

    /**
     * Politique de Confidentialité
     */
    public function pdc()
    {
        $page = LegalPage::where('slug', 'pdc')
            ->where('status', true)
            ->firstOrFail();

        return view('pages.legal.pdc', compact('page'));
    }

    /**
     * Support
     */
    public function support()
    {
        $page = LegalPage::where('slug', 'support')
            ->where('status', true)
            ->firstOrFail();

        return view('pages.legal.support', compact('page'));
    }
}
