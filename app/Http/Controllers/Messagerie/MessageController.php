<?php

namespace App\Http\Controllers\Messagerie;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messagerie\MessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Afficher la messagerie (liste des conversations)
     */
    public function index()
    {
        $user = Auth::user();
        // Messages reçus et envoyés
        $messagesRecus = Message::with('sender')->where('receiver_id', $user->id)->latest()->get();
        $messagesEnvoyes = Message::with('receiver')->where('sender_id', $user->id)->latest()->get();

        return view('messagerie.index', compact('messagesRecus', 'messagesEnvoyes'));
    }

    /**
     * Stocker un nouveau message
     */
    public function store(MessageRequest $request)
    {
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->destinataire_id,
            'contenu' => $request->contenu,
        ]);

        return redirect()->route('messagerie.index')
                         ->with('success', 'Message envoyé avec succès.');
    }

    /**
     * Afficher un message spécifique (détail)
     */
    public function show(Message $message)
    {
        // Vérifier que l'utilisateur est concerné (émetteur ou destinataire)
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Vous n’avez pas accès à ce message.');
        }

        return view('messagerie.show', compact('message'));
    }

    /**
     * Mettre à jour un message (uniquement le contenu, et seulement si l'utilisateur est l'émetteur)
     */
    public function update(MessageRequest $request, Message $message)
    {
        if ($message->sender_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres messages.');
        }

        // Si le message est déjà trop ancien (optionnel)
        // if ($message->created_at->diffInMinutes(now()) > 30) {
        //     return back()->with('error', 'Modification non autorisée après 30 minutes.');
        // }

        $message->update([
            'contenu' => $request->contenu,
        ]);

        return redirect()->route('messagerie.show', $message)
                         ->with('success', 'Message modifié avec succès.');
    }

    /**
     * Supprimer un message (uniquement si l'utilisateur est l'émetteur ou le destinataire)
     */
    public function destroy(Message $message)
    {
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres messages ou ceux que vous avez reçus.');
        }

        $message->delete();

        return redirect()->route('messagerie.index')
                         ->with('success', 'Message supprimé.');
    }
}
