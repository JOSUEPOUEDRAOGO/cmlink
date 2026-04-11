<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Communication\MessageRequest;
use App\Models\Academique\Etudiant;
use App\Models\Communication\Message;
use App\Models\Entreprise\Entreprise;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('etudiant', 'entreprise')
            ->latest()
            ->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function create()
    {
        $etudiants = Etudiant::orderBy('prenom')->orderBy('nom')->get();
        $entreprises = Entreprise::orderBy('nom')->get();

        return view('admin.messages.create', compact('etudiants', 'entreprises'));
    }

    public function store(MessageRequest $request)
    {
        Message::create($request->validated());

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Message créé avec succès.');
    }

    public function show(Message $message)
    {
        $message->load('etudiant', 'entreprise');

        return view('admin.messages.show', compact('message'));
    }

    public function edit(Message $message)
    {
        $etudiants = Etudiant::orderBy('prenom')->orderBy('nom')->get();
        $entreprises = Entreprise::orderBy('nom')->get();

        return view('admin.messages.edit', compact('message', 'etudiants', 'entreprises'));
    }

    public function update(MessageRequest $request, Message $message)
    {
        $message->update($request->validated());

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Message mis à jour avec succès.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }
}