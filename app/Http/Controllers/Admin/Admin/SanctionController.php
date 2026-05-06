<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sanction;
use App\Models\User;
use Illuminate\Http\Request;

class SanctionController extends Controller
{
    public function index()
    {
        $sanctions = Sanction::with(['user', 'creator'])
            ->latest()
            ->paginate(15);

        return view('admin.sanctions.index', compact('sanctions'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();

        return view('admin.sanctions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['required', 'in:avertissement,blocage,suspension,radiation,penalite,alerte'],
            'titre' => ['required', 'string', 'max:255'],
            'motif' => ['nullable', 'string'],
            'montant' => ['nullable', 'numeric', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = true;

        Sanction::create($validated);

        if (in_array($validated['type'], ['blocage', 'suspension', 'radiation'])) {
            User::where('id', $validated['user_id'])->update([
                'status' => 'suspendu',
            ]);
        }

        return redirect()
            ->route('admin.sanctions.index')
            ->with('success', 'Sanction créée avec succès.');
    }

    public function show(Sanction $sanction)
    {
        $sanction->load(['user', 'creator']);

        return view('admin.sanctions.show', compact('sanction'));
    }

    public function destroy(Sanction $sanction)
    {
        $sanction->delete();

        return redirect()
            ->route('admin.sanctions.index')
            ->with('success', 'Sanction supprimée.');
    }
}