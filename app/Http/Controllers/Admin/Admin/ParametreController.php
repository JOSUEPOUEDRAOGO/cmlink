<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\ParametreRequest;
use App\Models\Admin\Parametre;

class ParametreController extends Controller
{
    public function index()
    {
        $parametres = Parametre::latest()->paginate(15);

        return view('admin.parametres.index', compact('parametres'));
    }

    public function create()
    {
        return view('admin.parametres.create');
    }

    public function store(ParametreRequest $request)
    {
        Parametre::create($request->validated());

        return redirect()
            ->route('admin.parametres.index')
            ->with('success', 'Paramètre créé avec succès.');
    }

    public function show(Parametre $parametre)
    {
        return view('admin.parametres.show', compact('parametre'));
    }

    public function edit(Parametre $parametre)
    {
        return view('admin.parametres.edit', compact('parametre'));
    }

    public function update(ParametreRequest $request, Parametre $parametre)
    {
        $parametre->update($request->validated());

        return redirect()
            ->route('admin.parametres.index')
            ->with('success', 'Paramètre mis à jour avec succès.');
    }

    public function destroy(Parametre $parametre)
    {
        $parametre->delete();

        return redirect()
            ->route('admin.parametres.index')
            ->with('success', 'Paramètre supprimé avec succès.');
    }
}